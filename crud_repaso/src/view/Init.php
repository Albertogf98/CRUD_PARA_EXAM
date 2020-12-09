<?php
require_once "../Service/ValidateLogin.php";
require_once "../model/Connection.php";

$validator = new ValidateLogin(new Connection());

$checked = false;
$userName = $password = "";
$errorUserName = $errorPassword = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST["user"]))
        $errorUserName = "Usuario incorrecto.";
    else
        $userName = $validator->testData($_POST["user"]);

    if (empty($_POST["password"]))
        $errorPassword = "Contraseña incorrecto.";
    else
        $password = $validator->testData($_POST["password"]);

    if ($validator->isValidUser($userName, $password) === true) {
        session_start();
        $_SESSION["sesionUser"] = $userName;
        header("Location: Index.php");

    }  else {
        $errorLogin = "Fallo al iniciar sesión: usuario o contraseña incorrectos.";
    }
}

if (empty($userName) || empty($password) || isset($errorLogin))
    $checked = true;

if (!$_POST || $checked) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inicio</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<form class='form-group' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='POST' enctype='multipart/form-data'>
    <div class="form-group">
        <label for="user">Nombre de usuario:</label>
        <input type="text" name="user" id="user" class="form-control" style="width: 150px">
        <span style="color: #ff0000"><?= $errorUserName ?></span>
    </div>
    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" class="form-control" style="width: 150px">
        <span style="color: #ff0000"><?= $errorUserName ?></span>
    </div>
    <input type='submit' name="butLogin" id="butLogin" class='btn btn-success' value="Iniciar sesión">
    <button type='button' class='btn btn-success'>
        <a style="text-decoration: none; color: #fff" href='Login.php'>Crear cuenta</a>
    </button>
    <br> <br><span style="color: #ff0000"><?= isset($errorLogin) ? $errorLogin : " "; ?></span>
</form>
<?php
}
?>
</body>
</html>

