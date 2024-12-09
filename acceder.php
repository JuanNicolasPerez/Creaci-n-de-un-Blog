<?php include("includes/header_front.php") ?>

<?php

// INSTANCIAMOS CLASE DE LA BASE DE ADATOS
$baseDatos = new Basemysql();

// CREAMOS UNA INSTANCIA DE LA CLASE
$db = $baseDatos->connect();

// REGISTRAMOS AL USUARIO
if (isset($_POST['acceder'])) {

    $email = $_POST['email'];

    $password = $_POST['password'];

    if (empty($email) || $email == '' || empty($password) || $password == '' ) {

        $error = "Error, verify that the fields are not empty.";

    } else {

        $usuario = new Usuario($db);

            if ($usuario->acceder($email, $password)) {

                $_SESSION['autenticado'] = true;
                $_SESSION['email'] = $email;

                echo("<script>location.href= '".RUTA_FRONT."'</script>");

            } else {

                return "Error entering";

            }

    }

}

?>

<div class="container-fluid">
    <h1 class="text-center">Acceso de Usuarios</h1>
    <div class="row">
        <div class="col-sm-6 offset-3">
            <div class="card">
                <div class="card-header">
                    Ingresa tus datos para acceder
                </div>
                <div class="card-body">
                    <form method="POST" action="">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" placeholder="Ingresa el email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password" placeholder="Ingresa el password">
                        </div>

                        <br />
                        <button type="submit" name="acceder" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Acceder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<?php include("includes/footer.php") ?>