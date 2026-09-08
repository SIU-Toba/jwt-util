<?php

namespace SIU\JWT\Test;

use PHPUnit\Framework\Attributes\Depends;
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
    protected $keyLocal = '';

    protected function setUp(): void
    {
        $this->jwt = new Util();
        $this->datos = ['uid' => 123456, 'name' => 'my user name' ];

        for($i = 1; $i < 1000; $i++) {
            $this->keyLocal .= 'test';
        }
    }

    public function testEncodeSimetricHS512():string
    {
        $keySimetrica =  $this->keyLocal;

        $tokenEsperado = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJ1aWQiOjEyMzQ1NiwibmFtZSI6Im15IHVzZXIgbmFtZSJ9.kfdWRRXUP5aiq9eOtTpi55EsgDV0cK6fHjGS0NmMJqD5VsvnaiLR9HuDATh0krB4NqtxEQWy7A4MK210lHBNrQ';

        $simetricEncoder = new SimetricEncoder(Util::ALG_HS512, $keySimetrica, $this->datos);

        $this->jwt->setEncoder($simetricEncoder);

        $token = $this->jwt->encode();

        $this->assertEquals($tokenEsperado, $token);

        return $token;
    }

    #[Depends('testEncodeSimetricHS512')]
    public function testDecodeSimetricHS512(string $token):void
    {
        $keySimetrica = $this->keyLocal;

        $simetricDecoder = new SimetricDecoder(Util::ALG_HS512, $keySimetrica);

        $this->jwt->setDecoder($simetricDecoder);

        $data = $this->jwt->decode($token);

        $this->assertEquals($this->datos['uid'], $data->uid);

        $this->assertEquals($this->datos['name'], $data->name);
    }


    public function testEncodeAsimetricRS256():string
    {
        $keyAsimetrica = realpath(__DIR__.'/../../assets/server.key');

        $tokenEsperado = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1aWQiOjEyMzQ1NiwibmFtZSI6Im15IHVzZXIgbmFtZSJ9.38dEByQAqTn3T1rDERWnmzHpIYZZyBmdqj_bX09FrngKPIiTWet9gH4LD6SuVE5u6QaipjrvbWt-DrXSFpzXtqlmY2ER9R7DM_L9Cif-PuZ9gvyx5F8JEMGi4ddH1AsN0sJxbbbo142Qs2d4WB4SgXifgsqSnOBkpSU8Ccpk7u32vPGDTDs-c9XmCDTn5lNCAF78ZTTwXO5FFokVX8tn7IleGQ6gY2aosUGNYtMG9Cjz7iZIgtHrQBMH-gXhugYMs5asAuiZNp2dqko_TRpjdSGtyMETHl1LCgUcQamSAMGoSNNlOPSAfiPVRO2-8dPoUzxekI_WjqwuXeWFJgcwIQ';

        $asimetricEncoder = new AsimetricEncoder(Util::ALG_RS256, $keyAsimetrica, $this->datos);

        $this->jwt->setEncoder($asimetricEncoder);

        $token = $this->jwt->encode();

        $this->assertEquals($tokenEsperado, $token);

        return $token;
    }

    #[Depends('testEncodeAsimetricRS256')]    
    public function testDecodeAsimetricRS256(string $token):void
    {
        $keyAsimetrica = realpath(__DIR__.'/../../assets/server.pem');

        $asimetricDecoder = new AsimetricDecoder(Util::ALG_RS256, $keyAsimetrica);

        $this->jwt->setDecoder($asimetricDecoder);

        $data = $this->jwt->decode($token);

        $this->assertEquals($this->datos['uid'], $data->uid);

        $this->assertEquals($this->datos['name'], $data->name);
    }

    public function testEncodeAsimetricRS512():string
    {
        $keyAsimetrica = realpath(__DIR__.'/../../assets/server2.key');

        $tokenEsperado = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzUxMiJ9.eyJ1aWQiOjEyMzQ1NiwibmFtZSI6Im15IHVzZXIgbmFtZSJ9.jKGfNXqqPXPzcSPWlV5EpFdo21T2xRs6mHmES1FCoVUxW5p908Wbv4OzKLWONimeYe1eUAPjUzDBbHO8nb9NU-DUxbG7PlXPCdCEGUgcLDdwfzSUX4Jj5xuv1AExNBTi66yEseGKA7LozwKgF0jVRSMIWYFmhD9vnffP_kcLK5T6wVvMzUECqHTKQ3ww2uAfLqG7X-NfpoO_d-7SiDAaubxQ4bz1SJkgULbASR7luttdVlllo_-zV6dpz3xPHG-F0zgkXxxBgknLSMBQ1koaSuqFcjbmQWVM8IaX92QNoc8qJcB8HVq9ByYQu2MUIshD5bi23JaruE5TGHBXeBzuXJZJM2c-PL1bIfutuft7AxPAidn2kCpAKewn7J0CinILnbQCIlUxME8pgD2vAv9HeAnjy8UgOLwmZtP0mz9RiZuuHIrWoWudg7e1C8Xxfda3maRfbweGsSAjyxtnKrKh1_DH0G3liFiBfGR51nwm_7vPBbJrD4-73_rwZMkJ7axprrXjSQIdOoaB0Wr6BLoYg9yj87iCK0c_lUrUYZCeVK2nvsc0NxilXXeS9if3yreORRfVHkccVMEPV-GYhPt5gHUTlHbYYdVKuCWLl4_MwcIVyteI7ZDeWQMJ5Ek0-Mkzie3ND8ObH6ii2MSIKd59MVGFwJofHh80doj0ykmkhIg';

        $asimetricEncoder = new AsimetricEncoder(Util::ALG_RS512, $keyAsimetrica, $this->datos);

        $this->jwt->setEncoder($asimetricEncoder);

        $token = $this->jwt->encode();

        $this->assertEquals($tokenEsperado, $token);

        return $token;
    }

    #[Depends('testEncodeAsimetricRS512')]        
    public function testDecodeAsimetricRS512(string $token):void
    {
        $keyAsimetrica = realpath(__DIR__.'/../../assets/server2.pem');

        $asimetricDecoder = new AsimetricDecoder('RS512', $keyAsimetrica);

        $this->jwt->setDecoder($asimetricDecoder);

        $data = $this->jwt->decode($token);

        $this->assertEquals($this->datos['uid'], $data->uid);
        $this->assertEquals($this->datos['name'], $data->name);
    }
}
