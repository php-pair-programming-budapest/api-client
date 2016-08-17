<?php

require __DIR__.'/vendor/autoload.php';

require __DIR__.'/bootstrap.php';


$user = $client->getUser('kocsismate');



echo 'Hello, '.$user->getName();

