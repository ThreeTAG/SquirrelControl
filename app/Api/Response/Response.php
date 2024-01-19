<?php

namespace App\Api\Response;

use Illuminate\Contracts\Support\Jsonable;

class Response implements Jsonable
{
    /**
     * @var string
     */
    protected string $_message = '';
    /**
     * @var int
     */
    protected int $_error = 0;
    /**
     * @var array
     */
    protected array $_data = [];

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->_message;
    }

    /**
     * @param string $_message
     * @return $this
     */
    public function setMessage(string $_message): Response
    {
        $this->_message = $_message;

        return $this;
    }

    /**
     * @return int
     */
    public function getError(): int
    {
        return $this->_error;
    }

    /**
     * @param int $_error
     * @return $this
     */
    public function setError(int $_error): Response
    {
        $this->_error = $_error;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->_data;
    }

    /**
     * @param array $_data
     * @return $this
     */
    public function setData(array $_data): Response
    {
        $this->_data = $_data;
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function addData($data): Response
    {
        $this->_data = array_merge($this->_data, (array)$data);

        return $this;
    }

    /**
     * @param int $options
     * @return string
     */
    public function toJson($options = 0): string
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
