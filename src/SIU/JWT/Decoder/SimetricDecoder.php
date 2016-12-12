<?php

namespace SIU\JWT\Decoder;

class SimetricDecoder extends AbstractDecoder
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
