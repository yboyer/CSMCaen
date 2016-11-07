<?php

namespace YF\DAO;

use Doctrine\DBAL\Connection;

abstract class DAO
{
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    protected function getDb()
    {
        return $this->db;
    }
}
