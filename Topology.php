<?php
/**
 * Date: 14/12/2016
 */

namespace T4\Fann\Topology\Core;


use T4\Fann\Topology\Core\Exception\InvalidArgumentException;
use T4\Fann\Topology\Core\Exception\LogicException;

/**
 * Class Topology
 * Mediator for neurons and connections
 */
class Topology
{

    /**
     * @var Neuron[]
     */
    protected $neurons;

    /**
     * @var Layer[]
     */
    protected $layers;


    protected $minConnectionWeight = INF;
    protected $maxConnectionWeight = -INF;

    protected function __construct()
    {
    }

    /**
     * @api
     * @param $fannResource
     * @return Topology
     */
    static public function createFromFann($fannResource) {
        if (!is_resource($fannResource)) {
            throw new InvalidArgumentException('Topology::createFromFann can accept only fann resources');
        }
        $topology = new Topology();

        // create layers
        $flayers = fann_get_layer_array($fannResource);
        $biasNeuronsInLayers = fann_get_bias_array ( $fannResource );
        foreach ($flayers as $layerIndex => $numNeurons) {
            $type = Layer::TYPE_HIDDEN;
            if ($layerIndex === 0) {
                $type = Layer::TYPE_INPUT;
            } elseif ($layerIndex === count($flayers) - 1) {
                $type = Layer::TYPE_OUTPUT;
            }
            $topology->createLayer($type, $numNeurons + $biasNeuronsInLayers[$layerIndex]);
        }
        // now add neurons to the layers and to the index of the topology..
        foreach ($topology->layers as $layerIndex => $layer) {
            for ($layerNeuronIndex = 0; $layerNeuronIndex < $layer->getNumNeurons(); $layerNeuronIndex++) {
                switch ($layer->getType()) {
                    case Layer::TYPE_INPUT:
                        $neuronType = ($layerNeuronIndex < ($layer->getNumNeurons() - $biasNeuronsInLayers[$layerIndex])) ? Neuron::TYPE_INPUT: Neuron::TYPE_BIAS;
                        break;
                    case Layer::TYPE_HIDDEN:
                        $neuronType = ($layerNeuronIndex < ($layer->getNumNeurons() - $biasNeuronsInLayers[$layerIndex])) ? Neuron::TYPE_HIDDEN : Neuron::TYPE_BIAS;
                        break;

                    case Layer::TYPE_OUTPUT:
                        $neuronType = Neuron::TYPE_OUTPUT;
                        break;
                    default:
                        throw new LogicException('unrecognized layer type');
                }
                $activationFunctionType = ($layer->getType() == Layer::TYPE_INPUT) ? ActivationFunction::FANN_AF_NONE : fann_get_activation_function($fannResource, $layerIndex, $layerNeuronIndex);
                $neuron = $topology->createNeuron($neuronType, $activationFunctionType);
                $layer->addNeuron($neuron);
            }


        }
        // process the connections
        $connections = fann_get_connection_array($fannResource);
        foreach ($connections as $c) {
            $topology->neurons[$c->from_neuron]->connectTo($topology->neurons[$c->to_neuron], $c->weight);
            $topology->minConnectionWeight = min($topology->minConnectionWeight, $c->weight);
            $topology->maxConnectionWeight = max($topology->maxConnectionWeight, $c->weight);
        }

        return $topology;
    }

    /**
     * Get the MinConnectionWeight
     * @api
     * @return mixed
     */
    public function getMinConnectionWeight()
    {
        return $this->minConnectionWeight;
    }

    /**
     * Get the MaxConnectionWeight
     * @api
     * @return mixed
     */
    public function getMaxConnectionWeight()
    {
        return $this->maxConnectionWeight;
    }

    protected function createNeuron($type, $activationFunctionType) {
        $neuron = Neuron::create($this, count($this->neurons), $type, ActivationFunction::create($activationFunctionType));
        $this->neurons[] = $neuron;
        return $neuron;
    }

    protected function createLayer($type, $numNeurons) {
        $idx = count($this->layers);
        $layer = Layer::create($this, $idx, $type, $numNeurons);
        $this->layers[] = $layer;
        return $layer;
    }


    public function getNeurons() {
        return $this->neurons;
    }

    public function getLayers() {
        return $this->layers;
    }


}