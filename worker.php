<?php

$worker = new GearmanWorker();
$worker->addServer();
$worker->addFunction("fail", "my_fail_function");
while ($worker->work()) ;

function my_fail_function(GearmanJob $job)
{
    echo 'Function got: "' . $job->workload() . '" and fail'.PHP_EOL;

    $job->sendFail();
}