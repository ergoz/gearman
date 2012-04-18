<?php

$client = new GearmanClient();
$client->addServer();

$client->doBackground(
    isset($argv[1]) ? $argv[1] : "fail",
    isset($argv[2]) ? $argv[2] : 'Function data'
);
