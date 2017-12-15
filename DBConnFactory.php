<?php

namespace IDFGPDO;

use PDO;

class PDOConnectionFactory
{
    protected $pdo;
    protected $connvars = [];
    protected $fetchMode;
    public $conn = null;
    public $dbType = "mysql";
    public $host;
    public $user;
    public $pass;
    public $db;

    public function getConnection($connvars)
    {
        // Define some default options
        // TODO: roll these into the doQuery singleton
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        if (empty($connvars)) {
            echo "You did not pass credentials, we need host, user, pass, and db in an associative array please<br/>";
            $this->close();
            die();
        } else {
            $this->host = $connvars['host'];
            $this->user = $connvars['user'];
            $this->pass = $connvars['pass'];
            $this->db   = $connvars['db'];
        }

        try {
            $vars = sprintf("mysql:host=%s;dbname=%s", $this->host, $this->db);
            $conn = new PDO($vars, $this->user, $this->pass, $opt);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            $this->close();
        }
    }

    public function close()
    {
        if ($this->conn != null) {
            $this->conn = null;
        }
        echo "connection closed";
    }

    // TODO: this should be moved to it's own singleton
    public function doQuery($qry, $connvars)
    {
        $conn = $this->getConnection($connvars);

        try {
            $data = $conn->query($qry)->fetchAll();
            return $data;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
