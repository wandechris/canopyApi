<?php
namespace App\Exceptions;

use Exception;
class CanopyException extends Exception {

    protected $data;
    protected $code;

    public static function error($data, $code = 500)
    {
        $e = new self;
        $e->setData($data);
        $e->setStatusCode($code);

        throw $e;
    }

    public function setStatusCode($code)
    {
        $this->code = $code;
    }

    public function setData($data)
    {
        $this->data = $data;
    }


    public function getStatusCode()
    {
        return $this->code;
    }

    public function getData()
    {
        return $this->data;
    }
}