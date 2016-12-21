<?php

namespace SIU\JWT\Encoder;

class AsimetricEncoder extends AbstractEncoder
{
    /**
     * @param string $key   archivo de clave privada
     * @param mixed  $token
     *
     * @throws \Exception si no existe el archivo $keyFile
     */
    public function __construct($algorithm, $key, $token)
    {
        if (!file_exists($key)) {
            throw new \Exception("No se encuentra el archivo de clave privada '$key'");
        }

        parent::__construct($algorithm, $key, $token);
    }

    /**
     * Lee el archivo de clave privada y retorna el resource del mismo.
     *
     * @return mixed el resource de la clave privada
     */
    public function getKey()
    {
        return  openssl_get_privatekey('file://'.$this->key);
    }
}
