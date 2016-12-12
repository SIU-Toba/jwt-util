<?php

namespace SIU\JWT\Encoder;

class SimetricEncoder extends AbstractEncoder
{
    /**
     * Retorna la clave compartida (del método simétrico).
     *
     * @return string la clave
     */
    public function getKey()
    {
        return $this->key;
    }
}
