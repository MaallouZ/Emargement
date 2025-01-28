<?php
require_once 'src/lib/config.php';

class Database
{
    // Attribute
    private static ?Database $instance = null;
	private ?PDO $conn = null;

    // Constructeur
    private function __construct(string $host, string $db, string $user, string $pwd){
        try {
            $this->conn = new PDO("mysql:host=".$host.";dbname=".$db.";charset=utf8",$user,$pwd);
            $this -> conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die("Connexion à la base de données impossible: ". $e->getMessage());
        }
    }

    // Instance
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database($GLOBALS['host'], $GLOBALS['db'], $GLOBALS['user'], $GLOBALS['pwd']);
        }
        return self::$instance;
    }

    // Connection
	public function getConnection(): PDO
	{
    	return $this->conn;
	}
}