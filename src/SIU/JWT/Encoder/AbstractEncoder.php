<?php

namespace SIU\JWT\Encoder;

use Firebase\JWT\JWT;

abstract class AbstractEncoder
{
    protected $algorithm;
    protected $key;
    protected $token;

    /**
     * @param string $algorithm el algoritmo con el cual codificar/decodificar
     * @param string $key       archivo de clave privada
     * @param mixed  $token     los datos del token
     *
     * @throws \Exception si no se proporciona un algoritmo soportado
     */
    public function __construct($algorithm, $key, $token = null)
    {
        $supportedAlg = array_keys(JWT::$supported_algs);
        if (!in_array($algorithm, $supportedAlg)) {
            $message = sprintf(
                "El algoritmo '%s' no es soportado. Utilizar: %s",
                $algorithm,
                implode(', ', $supportedAlg)
            );
            throw new \Exception($message);
        }

        $this->algorithm = $algorithm;

        $this->key = $key;

        $this->token = $token;
    }

    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    abstract public function getKey();

    /**
     * @return mixed el token a desencriptar
     */
    public function getToken()
    {
        return $this->token;
    }

    public function setToken($data)
    {
        $this->token = $data;
    }
}
