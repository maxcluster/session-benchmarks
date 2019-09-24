<?php

// Settings start
$backend        = "MySQLStorage";           // Backend. Possible are FileSystemStorage, MySQLStorage and RedisStorage
$sessionsPerRun = 1000000;                  // How many sessions to check
$sessionSize   = 1500;                      // How big are the Sessions
// Settings end

include_once "$backend.php";                //Load the selected Backend

function RndString($n) {                    //Function to simulate session generation by returning random string
    $characters     = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $randomString   = "";

    for ($i = 0; $i < $n; $i++) {
        $index          = rand(0, strlen($characters) - 1);
        $randomString  .= $characters[$index];
    }
    return $randomString;
}

if(!isset($argv[1])) { //it is possible run this php script in parallel. To ensure there is no collision, the first parameter must be the namespace.
  $argv[1] = "";
}

$Class  = $backend;         //Instantiate the backend
$object = new $Class();

$writeOps   = 0;
$writeTime  = 0;

$updateOps  = 0;
$updateTime = 0;

$readOps    = 0;
$readTime   = 0;

$delOps     = 0;
$delTime    = 0;

$timeStart = microtime(true);

for($i = 0; $i < $sessionsPerRun; $i++) {
    $object->storeSession(
        "{$argv[1]}_{$i}",
        RndString($sessionSize)
    );
}

$timeStop  = microtime(true);

$writeOps   += $sessionsPerRun;
$writeTime  += $timeStop - $timeStart;

$timeStart = microtime(true);

for($i = 0; $i < $sessionsPerRun; $i++) {
    $object->readSession("{$argv[1]}_{$i}");
}

$timeStop = microtime(true);

$readOps    += $sessionsPerRun;
$readTime   += $timeStop - $timeStart;

$timeStart = microtime(true);

for($i = 0; $i < $sessionsPerRun; $i++) {
    $object->updateSession(
        "{$argv[1]}_{$i}",
        RndString($sessionSize)
    );
}

$timeStop = microtime(true);

$updateOps  += $sessionsPerRun;
$updateTime += $timeStop - $timeStart;

echo PHP_EOL . "Write OP/s: " . (int) ($writeOps / $writeTime);
echo PHP_EOL . "Read OP/s: " . (int) ($readOps / $readTime);
echo PHP_EOL . "Update OP/s: " . (int) ($updateOps / $updateTime);
