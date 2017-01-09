<?php
require_once 'vendor/autoload.php';

$token = array(
    "key-a" => "http://example.org",
    "uid" => 446544,
    "name" => "my user name"
);

$key = 'test';

// You can get a simple private/public key pair using:
// openssl genrsa 512 > server.key
// openssl rsa -pubout < server.key > server.pem

$privateKey = 'server.key';
$publicKey = 'server.pem';

echo "---------------------ASIMETRIC---------------------------------------\n";

$asimetricEncoder = new \SIU\JWT\Encoder\AsimetricEncoder(\SIU\JWT\Util::ALG_RS256, $privateKey, $token);

$auth = new \SIU\JWT\Util();

$auth->setEncoder($asimetricEncoder);

$jwt = $auth->encode();

echo "encriptado: \n";
var_dump($jwt);


// -------------------------------- server valida respuesta cliente -------

$asimetricDecoder = new \SIU\JWT\Decoder\AsimetricDecoder(\SIU\JWT\Util::ALG_RS256, $publicKey);

$auth->setDecoder($asimetricDecoder);

$data = $auth->decode($jwt);

echo "desencriptado: \n";
var_dump($data);

echo "---------------------SIMETRIC---------------------------------------\n";

$simetricEncoder = new \SIU\JWT\Encoder\SimetricEncoder(\SIU\JWT\Util::ALG_HS512, $key, $token);

$auth2 = new \SIU\JWT\Util();

$auth2->setEncoder($simetricEncoder);

$jwt = $auth2->encode();

echo "encriptado: \n";
var_dump($jwt);


// -------------------------------- server valida respuesta cliente -------

$simetricDecoder = new \SIU\JWT\Decoder\SimetricDecoder(\SIU\JWT\Util::ALG_HS512, $key);

$auth2->setDecoder($simetricDecoder);

$data = $auth2->decode($jwt);

echo "desencriptado: \n";
var_dump($data);