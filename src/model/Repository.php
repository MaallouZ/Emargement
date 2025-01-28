<?php
require_once 'src/lib/Database.php';

abstract class Repository
{
    protected PDO $conn;

    public function __construct(Database $db) {
        $this->conn = $db -> getConnection();
    }
}
