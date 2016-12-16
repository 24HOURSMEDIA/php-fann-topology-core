<?php
/**
 * Date: 14/12/2016
 */

namespace T4\Fann\Topology\Core;


class ActivationFunction
{

    const FANN_AF_NONE = 4294967295;

    const FANN_AF_SIGMOID = 3;
    const FANN_AF_SIGMOID_STEPWISE = 4;
    const FANN_AF_SIGMOID_SYMMETRIC = 5;
    const FANN_AF_SIGMOID_SYMMETRIC_STEPWISE = 6;
    const FANN_AF_GAUSSIAN = 7;
    const FANN_AF_GAUSSIAN_SYMMETRIC = 8;
    const FANN_AF_GAUSSIAN_STEPWISE = 9;
    const FANN_AF_ELLIOT = 10;
    const FANN_AF_ELLIOT_SYMMETRIC = 11;
    const FANN_AF_LINEAR_PIECE = 12;
    const FANN_AF_LINEAR_PIECE_SYMMETRIC = 13;
    const FANN_AF_SIN_SYMMETRIC = 14;
    const FANN_AF_COS_SYMMETRIC = 15;
    const FANN_AF_SIN = 16;
    const FANN_AF_COS = 17;

    protected $type = self::FANN_AF_NONE;

    /**
     * @param $type
     * @return ActivationFunction
     */
    static function create($type) {
        $af = new self();
        $af->type = $type;
        return $af;
    }

    /**
     * Get the Type
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }



}