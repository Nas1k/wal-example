<?php

namespace Nas1k\WAL;

interface DbInterface
{
    public function save(array $data);

    public function commit();

    public function rollback($res);
}
