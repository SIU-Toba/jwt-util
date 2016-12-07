<?php

namespace SIU\JWT;

class Encoder
{
    private $keyFile;
    private $token;

    /**
     * @param string $keyFile archivo de clave privada
     * @param mixed  $token
     *
     * @throws \Exception si no existe el archivo $keyFile
     */
    public function __construct($keyFile, $token)
    {
        if (!file_exists($keyFile)) {
            throw new \Exception("No se encuentra el archivo de clave privada '$keyFile'");
        }

        $this->keyFile = $keyFile;

        $this->token = $token;
    }

    /**
     * @return string archivo de clave privada
     */
    public function getKeyFile()
    {
        return $this->keyFile;
    }

    /**
     * @return mixed el token a desencriptar
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Lee el archivo de clave privada y retorna el resource del mismo.
     *
     * @return mixed el resource de la clave privada
     */
    public function readKey()
    {
        return  openssl_get_privatekey('file://'.$this->getKeyFile());
    }
}
