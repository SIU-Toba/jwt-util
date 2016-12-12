<?php

namespace SIU\JWT\Decoder;

abstract class AbstractDecoder
{
    protected $key;

    /**
     * @param string $key archivo de clave privada
     *
     * @throws \Exception si no existe el archivo $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    abstract public function getKey();
}
