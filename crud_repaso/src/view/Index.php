<?php
require_once "../controller/ControllerView.php";
require_once "../model/Connection.php";

$controller = new ControllerView(new Connection());
$errorCloseSesion = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["butCloseSession"])) {
            session_destroy();
            header("Location: Init.php");
        } else {
            $errorCloseSesion = "Fallo al cerrar sesión.";
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cuenta <?= $controller->user ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
    button, input {
        text-decoration: none;
    }
</style>
<body>
<form class='form-group' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='POST' enctype='multipart/form-data'>
    <input style="float: right" type="submit" name="butCloseSession" id="butCloseSession" value="cerrar sesión" class='btn btn-success'>
    <table style="margin-top: 2%" class="table table-dark">
    <tbody>
    <tr>
        <th>DNI</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Usuario</th>
        <th>Edad</th>
        <th>Ciudad</th>
        <th>País</th>
        <th>Eliminar</th>
        <th>Editar</th>
    </tr>
    <?php
    $controller->printUsersInformation();
    $controller->printUserInformation();
    ?>
    </tbody>
</table>
<button style='text-decoration: none' name='buttonDelete' type='button' class='btn btn-success'>
    <a style='color: #fff; margin-right: 1px; text-decoration: none'
       href='Insert.php?insert='>Añadir usuario</a>
</button>
</form>
</body>
</html>