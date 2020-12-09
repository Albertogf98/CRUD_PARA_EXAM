<?php
require_once "./src/model/Configuration.php";
require_once "./src/model/Connection.php";

$connection = new Connection();
$pdo = $connection->getConnection();


function create($sql) {
    $conn = new Connection();
    $pdo = $conn->getConnection();
    try {
        $pdo->exec($sql);

    } catch (PDOException $err) {
        die("ERROR: Could not able to execute $sql. " . $err->getMessage());
    }
    $conn->closeConnection($pdo);
}
create(create_database);
create(create_country_table);
create(create_city_table);
create(create_users_table);

function insert($sql) {
    $conn = new Connection();
    $pdo = $conn->getConnection();
    try{
        $pdo->exec($sql);
        echo "Records inserted successfully.";
    } catch(PDOException $err){
        die("ERROR: Could not able to execute $sql. " . $err->getMessage());
    }
    $conn->closeConnection($pdo);
}

/*src/view/Init.php
insert(sql_insert_country);
insert(sql_insert_city);
*/
//insert("UPDATE usuarios SET clave='php' WHERE id_usuario=1");

?>