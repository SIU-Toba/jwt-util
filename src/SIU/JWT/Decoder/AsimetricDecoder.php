<?php

namespace SIU\JWT\Decoder;

class AsimetricDecoder extends AbstractDecoder
{
    /**
     * Lee el archivo de clave pública y retorna el resource del mismo.
     *
     * @return mixed el resource de la clave pública
     */
    public function getKey()
    {
        return  openssl_get_publickey('file://'.$this->key);
    }
}
