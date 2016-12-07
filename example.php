<?php
require_once 'vendor/autoload.php';

$token = array(
    "key-a" => "http://example.org",
    "2" => 446544,
    "3" => "test some string"
);

$key = 'test';

// You can get a simple private/public key pair using:
// openssl genrsa 512 > server.key
// openssl rsa -pubout < server.key > server.pem

$privateKey = 'server.key';
$publicKey = 'server.pem';

// ------------------------------------ server pedido inicial cliente -------

$encoder = new \SIU\JWT\Encoder($privateKey, $token);

$auth = new \SIU\JWT\Auth(\SIU\JWT\Auth::ALG_RS256);

$auth->setEncoder($encoder);

$jwt = $auth->encode();

echo "encriptado ";
var_dump($jwt);


// ------------------------------------ server valida respuesta cliente -------

$decoder = new \SIU\JWT\Decoder($publicKey);

$auth->setDecoder($decoder);

$data = $auth->decode($jwt);

echo "desencriptado ";
var_dump($data);