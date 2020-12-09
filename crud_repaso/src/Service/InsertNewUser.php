<?php
require_once "../model/Connection.php";
require_once "../model/Configuration.php";

class InsertNewUser {
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function isValidDNI($nif) {
        return preg_match('/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]$/i', $nif);
    }

    public function isValidName($name) {
        return preg_match('/^([A-Z]{1}[a-zñáéíóú]+[\s]*)+$/', $name);
    }


    public function isCorrectPassword($password, $verifyPassword) {
        return $password === $verifyPassword ? true : false;
    }

    function isDNIinDB($nif) {
        $pdo = $this->connection->getConnection();
        $employees = $pdo->query("SELECT dni FROM ".USERS." WHERE dni = '$nif'");
        foreach ($employees as $i) {
           return $i["dni"] === $nif ? true : false ;
        }
        $this->connection->closeConnection($pdo);
    }

     function isUserinDB($userName) {
        $pdo = $this->connection->getConnection();
        $employees = $pdo->query("SELECT usuario FROM ".USERS." WHERE usuario = '$userName'");
        foreach ($employees as $i) {
            return $i["usuario"] === $userName ? true : false ;
        }
        $this->connection->closeConnection($pdo);
    }


    public function printCities() {
        $pdo = $this->connection->getConnection();
        $cities = $pdo->query(select_city);
        foreach ($cities as $i) {
            ?>
            <option class="form-control" style="width: 150px" value="<?php echo $i["nombre"]?>">
                <?php echo $i["nombre"]?>
            </option>
            <?php
        }
    }

    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function test($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }



    function getCityIdByName($cityName) {
        $pdo = $this->connection->getConnection();
        $citiToFind = $pdo->query("SELECT id_ciudad FROM ". CITY ." WHERE nombre = '$cityName'");
        foreach ($citiToFind as $i) {
            return $i["id_ciudad"];
        }
        $this->connection->closeConnection($pdo);
    }

   /*function insertNewUser($nif, $name,$secondName, $userName, $password, $birthday, $cityId) {
        $pdo = $this->connection->getConnection();
        try {
            $sql = "INSERT INTO usuarios  (dni, nombre, apellidos, usuario, clave, edad, codCiudad)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $nif);
            $stmt->bindParam(2, $name);
            $stmt->bindParam(3, $secondName);
            $stmt->bindParam(4, $userName);
            $stmt->bindParam(5, $password);
            $stmt->bindParam(6, $birthday);
            $stmt->bindParam(7, $cityId);
            $stmt->execute();
            return true;

        } catch(PDOException $err){
            die("ERROR: $sql. " . $err->getMessage());
            return false;
        }
        $this->connection->closeConnection($stmt);
        $this->connection->closeConnection($pdo);
    }*/

}