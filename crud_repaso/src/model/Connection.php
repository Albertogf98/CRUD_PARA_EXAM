<?php
require_once "Configuration.php";

class Connection {

    public function __construct() {

    }

    public function getConnection() {
        try {
            $pdo = new PDO(HOST, USER, PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            return $pdo;
        } catch (PDOException $err) {
            die("Error: connection class");
        }
    }

    public function closeConnection($pdo) {
        unset($pdo);
    }
}