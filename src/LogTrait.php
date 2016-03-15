<?php

namespace Nas1k\WAL;

trait LogTrait
{
    public function log($msg)
    {
        $res = fopen('wal.log', 'a+');
        fwrite($res, $msg . PHP_EOL);
        fclose($res);
    }
}
