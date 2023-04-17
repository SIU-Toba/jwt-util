<?php

namespace SIU\JWT\Test;

use PHPUnit\Framework\TestCase;
use SIU\JWT\Util;
use SIU\JWT\Encoder\AsimetricEncoder;
use SIU\JWT\Encoder\SimetricEncoder;
use SIU\JWT\Decoder\AsimetricDecoder;
use SIU\JWT\Decoder\SimetricDecoder;

class UtilTest extends TestCase
{
    protected $jwt;
    protected $datos;

    protected function setUp(): void
    {
        $this->jwt = new Util();

        $this->datos = ['uid'=> 123456, 'name'=> 'my user name' ];
    }

    public function testEncodeSimetricHS512()
    {
        $keySimetrica = 'test';

        $tokenEsperado = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJ1aWQiOjEyMzQ1NiwibmFtZSI6Im15IHVzZXIgbmFtZSJ9.RZcDtMfrzoVEISsVYsVz11-rZ87rWqS7RHYctQnpZKDt8m8YsVZysh9Hu0OpDnPT-8JjHbWS_Xkz6Am11UAulQ';

        $simetricEncoder = new SimetricEncoder(Util::ALG_HS512, $keySimetrica, $this->datos);

        $this->jwt->setEncoder($simetricEncoder);

        $token = $this->jwt->encode();

        $this->assertEquals($tokenEsperado, $token);

        return $token;
    }

    /**
     * @depends testEncodeSimetricHS512
     */
    public function testDecodeSimetricHS512($token)
    {
        $keySimetrica = 'test';

        $simetricDecoder = new SimetricDecoder(Util::ALG_HS512, $keySimetrica);

        $this->jwt->setDecoder($simetricDecoder);

        $data = $this->jwt->decode($token);

        $this->assertEquals($this->datos['uid'], $data->uid);

        $this->assertEquals($this->datos['name'], $data->name);
    }


    public function testEncodeAsimetricRS256()
    {
        $keyAsimetrica = realpath(__DIR__.'/../../assets/server.key');

        $tokenEsperado = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1aWQiOjEyMzQ1NiwibmFtZSI6Im15IHVzZXIgbmFtZSJ9.bQCLJy_VbMy5RoGKxRkXMFAatVZG0FLGrElfW7zu4iE54TpGg8_YEjw62IUcplPpqiDIcLllpYFtliV6TJrsYA';

        $asimetricEncoder = new AsimetricEncoder(Util::ALG_RS256, $keyAsimetrica, $this->datos);

        $this->jwt->setEncoder($asimetricEncoder);

        $token = $this->jwt->encode();

        $this->assertEquals($tokenEsperado, $token);

        return $token;
    }

    /**
     * @depends testEncodeAsimetricRS256
     */
    public function testDecodeAsimetricRS256($token)
    {
        $keyAsimetrica = realpath(__DIR__.'/../../assets/server.pem');

        $asimetricDecoder = new AsimetricDecoder(Util::ALG_RS256, $keyAsimetrica);

        $this->jwt->setDecoder($asimetricDecoder);

        $data = $this->jwt->decode($token);

        $this->assertEquals($this->datos['uid'], $data->uid);

        $this->assertEquals($this->datos['name'], $data->name);
    }

    public function testEncodeAsimetricRS512()
    {
        $keyAsimetrica = realpath(__DIR__.'/../../assets/server2.key');

        $tokenEsperado = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJ1aWQiOjEyMzQ1NiwibmFtZSI6Im15IHVzZXIgbmFtZSJ9.nXrqoNNIC0oHQQ8i5cL5wU0btk7Dqogn9CBzcTIfMhyowjy9DsA2tXckmCBfC8un6PrzyoLnt79gz3Vjlbw9js82aLUtH-N_eUnl0c3hGvIZbqWBsA11iYtpG67Dea7HoI6DKOkhXy8ak8FzMyuJ1d7LcJsFBcvVYNam_Y2VeDQ';

        $asimetricEncoder = new AsimetricEncoder(Util::ALG_RS512, $keyAsimetrica, $this->datos);

        $this->jwt->setEncoder($asimetricEncoder);

        $token = $this->jwt->encode();

        $this->assertEquals($tokenEsperado, $token);

        return $token;
    }

    /**
     * @depends testEncodeAsimetricRS512
     */
    public function testDecodeAsimetricRS512($token)
    {
        $keyAsimetrica = realpath(__DIR__.'/../../assets/server2.pem');

        $asimetricDecoder = new AsimetricDecoder('RS512', $keyAsimetrica);

        $this->jwt->setDecoder($asimetricDecoder);

        $data = $this->jwt->decode($token);

        $this->assertEquals($this->datos['uid'], $data->uid);

        $this->assertEquals($this->datos['name'], $data->name);
    }
}
