<?php
/**
 * Date: 14/12/2016
 */

namespace T4\Fann\Topology\Core;


interface NeuronVisitorInterface
{


    /**
     * @param Neuron $neuron
     * @return void
     */
    function visitNeuron(Neuron $neuron);

}