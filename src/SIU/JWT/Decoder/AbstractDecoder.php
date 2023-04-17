<?php

namespace SIU\JWT\Decoder;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

abstract class AbstractDecoder
{
    protected $algorithm;
    protected $key;

    /**
     * @param string $algorithm el algoritmo con el cual codificar/decodificar
     * @param string $key       archivo de clave privada
     *
     * @throws \Exception si no se proporciona un algoritmo soportado
     */
    public function __construct($algorithm, $key)
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
    }

    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * @return Key
     */
    public function getKeyObject()
    {
        $key = $this->getKey();
        $algo = $this->getAlgorithm();

        return new Key($key, $algo);
    }

    abstract public function getKey();
}
