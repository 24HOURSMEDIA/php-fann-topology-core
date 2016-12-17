# php-fann-topology-core

[![Code Climate](https://codeclimate.com/github/24HOURSMEDIA/php-fann-topology-core/badges/gpa.svg)](https://codeclimate.com/github/24HOURSMEDIA/php-fann-topology-core)
[![Test Coverage](https://codeclimate.com/github/24HOURSMEDIA/php-fann-topology-core/badges/coverage.svg)](https://codeclimate.com/github/24HOURSMEDIA/php-fann-topology-core/coverage)


create a topological representation of the neurons and connections in a FANN network

## Installation

using composer:

    composer require 24hoursmedia/php-fann-topology-core
    
## Example
    
```php
require('vendor/autoload.php');
use T4\Fann\Topology\Core\Topology;
$ann = fann_create_standard(4, 2, 2, 5, 1);
fann_set_activation_function_hidden($ann, FANN_SIGMOID_SYMMETRIC);
fann_set_activation_function_output($ann, FANN_SIGMOID_SYMMETRIC);
$filename = dirname(__FILE__) . "/xor.data";
fann_train_on_file($ann, $filename, 100000, 0, 0.0001);

$topology = Topology::createFromFann($ann);
$inputLayer = $topology->getLayers()[0];
$firstInputNeuron = $inputLayer->getNeurons()[0];
$connections = $firstInputNeuron->getConnections();
foreach ($connections as $conn) {
    echo 'neuron ' . $conn->getFromNeuron()->getIndex() . ' is connected to neuron ' .
        $conn->getToNeuron()->getIndex() . ' with weight ' . $conn->getWeight() .
        PHP_EOL;
}
```
    
Output:
```
neuron 0 is connected to 3 with weight -0.77117919921875
neuron 0 is connected to 4 with weight -3.1356239318848
```
