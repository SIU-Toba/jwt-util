<?php

namespace SIU\JWT;

use Firebase\JWT\JWT;
use SIU\JWT\Encoder\AbstractEncoder;
use SIU\JWT\Decoder\AbstractDecoder;

class JWTBase
{
    // JWT::$supported_algs
    const ALG_HS256 = 'HS256';
    const ALG_HS384 = 'HS384';
    const ALG_HS512 = 'HS512';
    const ALG_RS256 = 'RS256';

    private $encoder;
    private $decoder;
    private $algorithm;

    /**
     * @param string $algorithm el algoritmo con el cual codificar/decodificar
     *
     * @throws \Exception si no se proporciona un algoritmo soportado
     */
    public function __construct($algorithm)
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
    }

    public function setEncoder(AbstractEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function setDecoder(AbstractDecoder $decoder)
    {
        $this->decoder = $decoder;
    }

    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * Codifica el $token según el encoder utilizado.
     *
     * @return string el $token codificado
     *
     * @throws \Exception si no se seteó un encoder
     */
    public function encode()
    {
        if (!$this->encoder instanceof AbstractEncoder) {
            throw new \Exception('Debe setear un encoder primero.');
        }

        return JWT::encode($this->encoder->getToken(), $this->encoder->getKey(), $this->getAlgorithm());
    }

    /**
     * Decodifica el token $jwt según el decoder configurado.
     *
     * @return string el $jwt decodificado
     *
     * @throws \Exception si no se seteó un decoder
     */
    public function decode($jwt)
    {
        if (!$this->decoder instanceof AbstractDecoder) {
            throw new \Exception('Debe setear un decoder primero.');
        }

        return JWT::decode($jwt, $this->decoder->getKey(), array($this->getAlgorithm()));
    }
}
