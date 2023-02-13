<?php

namespace Kamil\MerceApi\ApiClient;

use Kamil\MerceApi\Exception\ClientException;

class Response extends \Nyholm\Psr7\Response
{
    /**
     * @return mixed
     */
    public function asObject()
    {
        $data = json_decode($this->getBody()->__toString());
        if (!is_object($data)) {
            throw new ClientException('Response cannot be decoded.');
        }

        return $data;
    }
    /**
     * @return mixed
     */
    public function asArray()
    {
        $data = json_decode($this->getBody()->__toString(), true);
        if (!is_array($data)) {
            throw new ClientException('Response cannot be decoded.');
        }

        return $data;
    }
}