<?php

class ValidateLogin {

    function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    function isValidUser($userName, $password) {

        $pdo = $this->connection->getConnection();
        $userData = $pdo->query("SELECT * FROM usuarios WHERE usuario = '$userName' || clave = '$password'");
        foreach ($userData as $i) {
            return $i["usuario"] === $userName && $i["clave"] === $password ? true : false;
        }
        $this->connection->closeConnection($pdo);
    }

    public function testData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}