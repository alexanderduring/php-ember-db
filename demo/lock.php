<?php

$fileName = $argv[1];
$filePath = __DIR__ . '/data/' . $fileName;
$file = fopen($filePath, 'w');

$isLocked = flock($file, LOCK_EX);
if ($isLocked) {
    echo "File $fileName is locked for 15 seconds.\n";
    sleep(15);

    flock($file, LOCK_UN);
    echo "File $fileName was unlocked.\n";
}


