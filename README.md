# jwt-util

Esta librería encapsula la manipulación de tokens tipo JWT (https://jwt.io/). Permite
generar y validar los tokens, utilizando para ello claves simétricas y/o asimétricas. 

Requiere actualmente la librería [php-jwt](https://github.com/firebase/php-jwt).

## Instalación

Usar composer para manejar las dependencias y descargar jwt-util:

```bash
composer require siu-toba/jwt-util
```

## Generar un token

Para generar un token o hacer el *encode* se debe elegir la encriptación, ya sea 
simétrica o asimétrica, definir una clave y un algoritmo.

```  php
    $keySimetrica = 'test';

    $datos = ['uid'=>'id-usuario', 'name'=>'usuario de prueba'];

    $simetricEncoder = new SimetricEncoder(Util::ALG_HS512, $keySimetrica, $datos);

    $jwt->setEncoder($simetricEncoder);

    $token = $jwt->encode();

    echo $token;
    // eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJ1aWQiOjEyMzQ1NiwibmFtZSI6Im15IHVzZXIgbmFtZSJ9.RZcDtMfrzoVEISsVYsVz11-rZ87rWqS7RHYctQnpZKDt8m8YsVZysh9Hu0OpDnPT-8JjHbWS_Xkz6Am11UAulQ
```

## Validar un token

También, es posible a partir del token y la clave, validar o hacer el *decode* 
y determinar si es un token válido, para así extraer la información relacionada.

```  php
    $keySimetrica = 'test';

    $simetricDecoder = new SimetricDecoder(Util::ALG_HS512, $keySimetrica);

    $this->jwt->setDecoder($simetricDecoder);

    // con el token generado previamente...
    $data = $this->jwt->decode($token);

    echo $data->uid;     // 'id-usuario'

    echo $data->name;    // 'usuario de prueba'
```

## Opciones

Los algoritmos y métodos soportados son:

|algoritmo|método encode/decode|
|---------|------|
|HS256|simétrico|
|HS384|simétrico|
|HS512|simétrico|
|RS256|asimétrico|

Para generar tokens con el método asimétrico, se requieren de claves público/privadas.
Se puede generar algunas de prueba de la siguiente forma:

```bash
    openssl genrsa 512 > server.key
    openssl rsa -pubout < server.key > server.pem
```