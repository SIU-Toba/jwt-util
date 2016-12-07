<?php

namespace SIU\JWT;

class Decoder
{
    private $keyFile;

    /**
     * @param string $keyFile archivo de clave privada
     *
     * @throws \Exception si no existe el archivo $keyFile
     */
    public function __construct($keyFile)
    {
        if (!file_exists($keyFile)) {
            throw new \Exception("No se encuentra el archivo de clave pública '$keyFile'");
        }

        $this->keyFile = $keyFile;
    }

    /**
     * @return string archivo de clave privada
     */
    public function getKeyFile()
    {
        return $this->keyFile;
    }

    /**
     * Lee el archivo de clave pública y retorna el resource del mismo.
     *
     * @return mixed el resource de la clave pública
     */
    public function readKey()
    {
        return  openssl_get_publickey('file://'.$this->getKeyFile());
    }
}
