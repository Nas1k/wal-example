<?php

namespace Nas1k\WAL;

class Csv implements DbInterface
{
    use LogTrait;

    private $ids = [];

    protected function prepareRow($id, $row)
    {
        return array_merge(['ID' => $id], $row);
    }

    public function save(array $data)
    {
        $res = fopen('db.csv', 'a+') or die('cannot create db.log');
        foreach ($data as $row) {
            $id = uniqid();
            $result = fputcsv($res, $this->prepareRow($id, $row));
            // for test rollback
            //$result = stubfputcsv($res, $this->prepareRow($id, $row));
            $this->log('data start: ' . PHP_EOL . implode(',', array_values($this->prepareRow($id, $row))) . PHP_EOL . 'end');
            if ($result) {
                $this->ids[] = $id;
            } else {
                $this->rollback($res);
                return ;
            }
        }
        $this->commit();
    }

    public function commit()
    {
        $this->log('commit ' . implode(', ', $this->ids));
    }

    public function rollback($res)
    {
        foreach (array_reverse($this->ids) as $id) {
            fseek($res, 0);
            while (!feof($res)) {
                $line = fgetcsv($res);
                if ($id === $line[0]) {
                    fputcsv($res, $line);
                }
            }
        }
        $this->log('rollback ' . implode(', ', $this->ids));
    }
}

function stubfputcsv($r, $a)
{
    static $i = 0;
    if ($i++ == 4)
        return false;
    else
        return fgetcsv($r, $a);
}
