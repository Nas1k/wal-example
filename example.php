<?php

include "src/LogTrait.php";
include "src/DbInterface.php";
include "src/Csv.php";

$db = new \Nas1k\WAL\Csv();
$db->save(
    [
        ['key' => 'val1'],
        ['key' => 'val2'],
        ['key' => 'val3'],
        ['key' => 'val4'],
        ['key' => 'val5'],
        ['key' => 'val55'],
    ]
);
