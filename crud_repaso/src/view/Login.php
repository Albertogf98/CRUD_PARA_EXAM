<?php
require_once "../Service/InsertNewUser.php";
require_once "../model/Connection.php";
$insertNew = new InsertNewUser(new Connection());
$checked = false;
$nif = $name = $secondName = $userName = $password = $passwordConfirm = $birthday = $city = "";
$errorNif = $errorName = $errorSecondName = $errorUserName = $errorPassword = $errorPasswordConfirm =
$errorBirthday = $errorCity = "";

function insertNewUser($connection,$nif, $name,$secondName, $userName, $password, $birthday, $cityId) {
    $pdo = $connection->getConnection();
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
        header("Location: Init.php");

    } catch(PDOException $err){
        die("ERROR: $sql. " . $err->getMessage());
        return false;
    }
    $connection->closeConnection($stmt);
    $connection->closeConnection($pdo);
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST["dni"]) || $insertNew->isValidDNI($_POST["dni"]) === 0 || $insertNew->isDNIinDB($_POST["dni"]) === true)
        $errorNif = "DNI incorrecto.";
    else
        $nif = $insertNew->test($_POST["dni"]);

  if (empty($_POST["name"]) || $insertNew->isValidName($_POST["name"]) != true)
        $errorName = "Nombre incorrecto.";
    else
        $name = $insertNew->test($_POST["name"]);

   if (empty($_POST["secondName"]))
        $errorSecondName = "Apellidos incorrectos.";
    else
        $secondName = $insertNew->test($_POST["secondName"]);

  if (empty($_POST["user"]) || $insertNew->isUserinDB($userName) === 0)
        $errorUserName = "Usuario incorrecto.";
    else
        $userName = $insertNew->test($_POST["user"]);

    if (empty($_POST["password"]) || $insertNew->isCorrectPassword($_POST["password"], $_POST["confirmPassword"]) != true)
      $errorPassword = "Contraseña incorrectos.";
    else
      $password = $insertNew->test($_POST["password"]);

  if (empty($_POST["confirmPassword"]) || $insertNew->isCorrectPassword($_POST["confirmPassword"], $_POST["password"]) != true)
      $errorPasswordConfirm = "Contraseña incorrectos.";
    else
      $passwordConfirm = $insertNew->test($_POST["confirmPassword"]);

    if (empty($_POST["birthday"]) || $insertNew->validateDate($_POST["birthday"], 'Y/m/d'))
        $errorBirthday = "Cumpleaños incorrecto.";
    else
        $birthday = $insertNew->test($_POST["birthday"]);

    if (empty($_POST["city"]))
        $city = "Ciudad incorrecto.";
    else
        $city = $insertNew->test($_POST["city"]);

}



if (empty($nif) || empty($name) || empty($secondName) || empty($userName) || empty($password) || empty($passwordConfirm) || empty($birthday) ||empty($city))
    $checked = true;


if (!$_POST || $checked) {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Crear cuenta de usuario</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<form class="form-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype=multipart/form-data>
    <div class="form-group">
        <label for="dni">DNI:</label>
        <input type="text" class="form-control" id="dni" name="dni" style="width: 150px">
        <span style="color: #ff0000"><?= $errorNif ?></span>
    </div>
    <div class="form-group">
        <label for="name">Nombre:</label>
        <input type="text" class="form-control" id="name" name="name" style="width: 150px">
        <span style="color: #ff0000"><?= $errorName ?></span>
    </div>
    <div class="form-group">
        <label for="secondName">Apellidos:</label>
        <input type="text" class="form-control" id="secondName" name="secondName" style="width: 150px">
        <span style="color: #ff0000"><?= $errorSecondName ?></span>
    </div>
    <div class="form-group">
        <label for="user">Nombre de usuario:</label>
        <input type="text" class="form-control" id="user" name="user" style="width: 150px">
        <span style="color: #ff0000"><?= $errorUserName ?></span>
    </div>
    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" class="form-control" id="password" name="password" style="width: 150px"><br>
        <span style="color: #ff0000"><?= $errorPassword ?></span>
        <label for="confirmPassword">Repita la conteraseña:</label>
        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" style="width: 150px">
        <span style="color: #ff0000"><?= $errorPasswordConfirm ?></span>
    </div>
    <div class="form-group">
        <label for="birthday">Año de nacimiento</label>
        <input type="date" class="form-control" id="birthday" name="birthday" style="width: 150px">
        <span style="color: #ff0000"><?= $errorBirthday ?></span>
    </div>
    <div class="form-group">
        <div class="form-group">
            <label for="city">Ciudades:</label>
            <select name="city" id="city" class="form-control" style="width: 150px">
                <?php $insertNew->printCities();?>
            </select>
            <span style="color: #ff0000"><?= $errorCity ?></span>
        </div>
        <input type="submit" class="btn btn-light" value="Crear cuenta">
        <button type='button' class='btn btn-light'><a href='Init.php'>Volver</a></button>
</form>
</body>
</html>
<?php
} else {
    $cityID = $insertNew->getCityIdByName($city);
    $conn = new Connection();
      insertNewUser($conn, $nif,$name, $secondName, $userName, $password, $birthday, $cityID);

}
?>