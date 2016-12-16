<?php
/**
 * Date: 14/12/2016
 */

namespace T4\Fann\Topology\Core;


use T4\Fann\Topology\Core\Exception\LogicException;

class Neuron
{

    const TYPE_INPUT = 1;
    const TYPE_HIDDEN = 2;
    const TYPE_OUTPUT = 3;
    const TYPE_BIAS = 4;

    /**
     * @var Connection[]
     */
    protected $connections = [];

    /**
     * @var null|Layer
     */
    protected $layer = null;

    protected $index;
    protected $indexInLayer;

    protected $topology;

    /**
     * @var ActivationFunction
     */
    protected $activationFunction;

    protected $type;

    protected function __construct()
    {
    }

    static function create(Topology $topology, $index, $type, $activationFunction) {
        $neuron = new self();
        $neuron->topology = $topology;
        $neuron->index = $index;
        $neuron->type = $type;
        $neuron->activationFunction = $activationFunction;
        return $neuron;
    }


    function setLayer(Layer $layer) {
        if ($this->layer) {
            throw new LogicException('Neuron is already attached to layer. Neuron: ' . (string)$this);
        }
        $this->indexInLayer = count($layer->getNeurons());
        $this->layer = $layer;
        return $this;
    }

    function connectTo(Neuron $to, $weight) {
        $connection = Connection::create($this->topology, $this, $to, $weight);
        $this->connections[] = $connection;
        return $this;
    }

    function accept($visitor) {
        if ($visitor instanceof NeuronVisitorInterface) {
            $visitor->visitNeuron($this);
        }
    }

    /**
     * Get the Layer
     * @return null|Layer
     */
    public function getLayer()
    {
        return $this->layer;
    }

    /**
     * Get the Index
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Get the Topology
     * @return mixed
     */
    public function getTopology()
    {
        return $this->topology;
    }

    /**
     * Get the ActivationFunction
     * @return mixed
     */
    public function getActivationFunction()
    {
        return $this->activationFunction;
    }

    /**
     * Get the Type
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Get the Connections
     * @return Connection[]
     */
    public function getConnections()
    {
        return $this->connections;
    }

    /**
     * Get the IndexInLayer
     * @return mixed
     */
    public function getIndexInLayer()
    {
        return $this->indexInLayer;
    }

    function __toString()
    {
        return 'neuron #' . $this->index . ' in layer ' . $this->layer->getIndex();
    }

}