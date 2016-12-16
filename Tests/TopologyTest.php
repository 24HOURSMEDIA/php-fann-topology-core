<?php
/**
 * Date: 14/12/2016
 */

namespace T4\Fann\Topology\Core\Tests;

use T4\Fann\Topology\Core\Topology;

/**
 * Class TopologyTest
 * phpunit src/T4/Fann/Topology/Core/
 */
class TopologyTest extends \PHPUnit_Framework_TestCase
{

    function getXORFann() {
        // resource fann_create_standard ( int $num_layers , int $num_neurons1 , int $num_neurons2 [, int $... ] )
        $ann = fann_create_standard(4, 2, 2, 5, 1);
        fann_set_activation_function_hidden($ann, FANN_SIGMOID_SYMMETRIC);
        fann_set_activation_function_output($ann, FANN_SIGMOID_SYMMETRIC);
        $filename = dirname(__FILE__) . "/data/xor.data";
        fann_train_on_file($ann, $filename, 100000, 0, 0.0001);
        return $ann;
    }

    function destroyFann($f) {
        fann_destroy($f);
    }

    function testCreateFromFann() {
        $fann = $this->getXORFann();

        $topology = Topology::createFromFann($fann);

        $this->assertEquals(4, count($topology->getLayers()));
        // output layers have no bias neuron
        $this->assertEquals(13, count($topology->getNeurons()));

        $this->assertEquals(fann_get_total_neurons($fann), count($topology->getNeurons()));
        $this->destroyFann($fann);

    }

}