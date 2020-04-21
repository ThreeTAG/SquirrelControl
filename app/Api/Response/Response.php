<?php

namespace App\Api\Response;

use Illuminate\Contracts\Support\Jsonable;

class Response implements Jsonable
{
    /**
     * @var string
     */
    protected $_message = '';
    /**
     * @var int
     */
    protected $_error = 0;
    /**
     * @var array
     */
    protected $_data = [];

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * @param $_message
     * @return $this
     */
    public function setMessage($_message)
    {
        $this->_message = $_message;

        return $this;
    }

    /**
     * @return int
     */
    public function getError()
    {
        return $this->_error;
    }

    /**
     * @param $_error
     * @return $this
     */
    public function setError($_error)
    {
        $this->_error = $_error;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @param array $_data
     */
    public function setData($_data)
    {
        $this->_data = $_data;
    }

    /**
     * @param $data
     * @return $this
     */
    public function addData($data)
    {
        $this->_data = array_merge($this->_data, (array)$data);

        return $this;
    }

    /**
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode([
            'error'   => $this->_error,
            'message' => $this->_message,
            'data'    => $this->_data,
        ]);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}