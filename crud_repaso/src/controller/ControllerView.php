<?php
require_once "../model/Connection.php";
require_once "../model/Configuration.php";
session_start();

class ControllerView {
    public function __construct(Connection $connection) {
        $this->user = $_SESSION["sesionUser"];
        $this->connection = $connection;

    }

    public function printUsersInformation() {

        $pdo = $this->connection->getConnection();
        $stm = $pdo->query(sql_count);
        $total_pages = ceil($stm->fetchColumn() / PAGINATION_LIMIT);

        $page = !isset($_GET['page']) ? 1 : $_GET['page'];


        $result = $pdo->prepare(sql_select_users);
        $result->execute([($page - 1) * PAGINATION_LIMIT, PAGINATION_LIMIT]);

        while ($rows = $result->fetch(PDO::FETCH_ASSOC)) {
            $this->printTable(
                $rows["id_usuario"],
                $rows["dni"],
                $rows["nombre"],
                $rows["apellidos"],
                $rows["usuario"],
                $rows["edad"],
                $rows["cityName"],
                $rows["countryName"]);
        }

        $this->printPagination($total_pages);

        $this->connection->closeConnection($stm);
    }

    private function printTable($id, $nif, $name, $secondName, $userName, $age, $city, $country) {
        $years =  $this->getAgeByBirthday($age);
        echo "<tr>
                    <td>$nif</td>
                    <td><a href='Index.php?select=$id'>$name</a></td>
                    <td>$secondName</td>
                    <td>$userName</td>
                    <td>$years</td>
                    <td>$city</td>
                    <td>$country</td>
                    <td>
                    <button style='text-decoration: none' name='buttonDelete' type='button' class='btn btn-danger'>
                        <a style='color: #fff; margin-right: 1px; text-decoration: none' 
                        href='Delete.php?delete=$id'>Eliminar</a>
                   </button>
                    </td>
                    <td>
                    <button  name='buttonDelete' type='button' class='btn btn-warning'>
                    <a style='color: #fff; margin-right: 1px; text-decoration: none'
                     href='Update.php?update=$id'>Editar</a>
                    </button>
                    </td>
                   </tr>";
    }

    private function printPagination($total_pages) {
        for ($page = 1; $page <= $total_pages; $page++) {
            echo " <button class='btn btn-info' >
                    <a style='color: #fff; margin-right: 1px; text-decoration: none' 
                    href='?page=$page'>$page
                   </button>
                   </a> ";
        }
    }

    public function printUserInformation() {
        $pdo = $this->connection->getConnection();
        $users = $pdo->query(selectUserById($_GET["select"]))->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $employee => $i) {
          $age =  $this->getAgeByBirthday($i["edad"]);
            $this->drawInfo(
                $i["id_usuario"],
                $i["dni"],
                $i["nombre"],
                $i["apellidos"],
                $i["usuario"],
                $age,
                $i["clave"],
                $i["cityName"],
                $i["countryName"]);
        }
        $this->connection->closeConnection($pdo);
    }

    public function drawInfo($id, $nif, $name, $secondName, $userName, $age, $password, $city, $country) {

        echo "<h3>ID: " . $id . "</h3>" . "<br>" .
            "<h3>DNI: " . $nif . "</h3>" . "<br>" .
            "<h3>NOMBRE: " . $name . "</h3>" . "<br>" .
            "<h3>APELLIDOS: " . $secondName . "</h3>" . "<br>" .
            "<h3>USUARIO: " . $userName . "</h3>" . "<br>" .
            "<h3>EDAD: " . $age . "</h3>" . "<br>" .
            "<h3>CLAVE: " . $password . "</h3>" . "<br>" .
            "<h3>CIUDAD: " . $city . "</h3>" . "<br>" .
            "<h3>PAÍS: " . $country . "</h3>" . "<br>" .
            "<button style='text-decoration: none;' class='btn btn-light'><a href='Index.php'>Cerrar</a></button>";
    }

    function getAgeByBirthday($birthday) {
        $time = strtotime($birthday);
        $current = time();
        $age = ($current-$time) / (60 * 60 * 24 * 365.25);
        $age = floor($age);
        return $age;
    }
}