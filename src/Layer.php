<?php
/**
 * Date: 14/12/2016
 */

namespace T4\Fann\Topology\Core;



class Layer
{


    const TYPE_INPUT = 1;
    const TYPE_HIDDEN = 2;
    const TYPE_OUTPUT = 3;
    const TYPE_UNKNOWN = -1;

    /**
     * @var Neuron[]
     */
    protected $neurons;

    protected $numNeurons = null;

    protected $type = self::TYPE_UNKNOWN;

    protected $topology;

    protected $index;

    protected function __construct()
    {
    }

    static function create(Topology $topology, $index, $type, $numNeurons) {
        $layer = new self();
        $layer->topology = $topology;
        $layer->index = $index;
        $layer->numNeurons = $numNeurons;
        $layer->type = $type;
        return $layer;
    }

    /**
     * Get the NumNeurons
     * @return null
     */
    public function getNumNeurons()
    {
        return $this->numNeurons;
    }

    /**
     * Get the Type
     * @return int
     */
    public function getType()
    {
        return $this->type;
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
     * Get the Index
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }



    /**
     * @param Neuron $neuron
     * @return $this
     */
    public function addNeuron(Neuron $neuron) {
        $neuron->setLayer($this);
        $this->neurons[] = $neuron;
        return $this;
    }

    /**
     * Get the Neurons
     * @return Neuron[]
     */
    public function getNeurons()
    {
        return $this->neurons;
    }

    function __toString()
    {
        return 'layer #' . $this->index;
    }

}