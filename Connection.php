<?php
/**
 * Date: 14/12/2016
 */

namespace T4\Fann\Topology\Core;


class Connection
{

    /**
     * @var float
     */
    protected $weight;

    /**
     * @var Neuron
     */
    protected $fromNeuron;

    /**
     * @var Neuron
     */
    protected $toNeuron;

    /**
     * @var Topology
     */
    protected $topology;


    protected function __construct()
    {
    }

    static function create(Topology $topology, Neuron $fromNeuron, Neuron $toNeuron, $weight)
    {
        $connection = new Connection();
        $connection->topology = $topology;
        $connection->fromNeuron = $fromNeuron;
        $connection->toNeuron = $toNeuron;
        $connection->weight = $weight;
        return $connection;
    }

    /**
     * Get the Weight
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Get the FromNeuron
     * @return Neuron
     */
    public function getFromNeuron()
    {
        return $this->fromNeuron;
    }

    /**
     * Get the ToNeuron
     * @return Neuron
     */
    public function getToNeuron()
    {
        return $this->toNeuron;
    }

    /**
     * Returns a weight from -1 to 1
     * normalization according to max and min weights in topology
     */
    function getNormalizedWeight() {
        $absMax = max($this->topology->getMinConnectionWeight(), $this->topology->getMaxConnectionWeight());
        $absNormalized = abs($this->weight) / $absMax;
        return $this->weight < 0 ? -$absNormalized : $absNormalized;
    }

    function __toString()
    {
        return 'connect node #' . $this->fromNeuron->getIndex() . ' to ' . $this->toNeuron . ' with weight ' . $this->weight;
    }

}