<?php

namespace SIU\JWT\Encoder;

abstract class AbstractEncoder
{
    protected $key;
    protected $token;

    /**
     * @param string $key   archivo de clave privada
     * @param mixed  $token *
     */
    public function __construct($key, $token)
    {
        $this->key = $key;

        $this->token = $token;
    }

    abstract public function getKey();

    /**
     * @return mixed el token a desencriptar
     */
    public function getToken()
    {
        return $this->token;
    }
}
