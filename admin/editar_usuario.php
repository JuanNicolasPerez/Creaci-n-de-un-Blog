<?php include("../includes/header.php") ?>

<?php

// INSTANCIAMOS CLASE DE LA BASE DE ADATOS
$baseDatos = new Basemysql();

// CREAMOS UNA INSTANCIA DE LA CLASE
$db = $baseDatos->connect();

// VALIDAMOS QUE SE ENVIE EL ID A TRAVEZ DE LA URL
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // INSTANCIAMOS AL OBJETO
    $usuario = new Usuario($db);

    $resultado = $usuario->leer_individual($id);
}

// EDITAMOS AL USUARIO
if (isset($_POST['editarUsuario'])) {

    $idUsuario = $_POST['id'];

    $rol = $_POST['rol'];

    if (empty($idUsuario) || $idUsuario == '' || empty($rol) || $rol == '') {

        $error = "Error, verify that the fields are not empty.";

    } else {

        $usuario = new Usuario($db);

        if ($usuario->actualizar($idUsuario, $rol)) {

            $mensaje = "Updated successfully.";

            header("Location:usuarios.php?mensaje=" . urlencode($mensaje));

            exit();

        } else {

            $error = "Error: Could not update.";
        }
    }
}

// BORRAMOS AL USUARIO
if (isset($_POST['borrarUsuario'])) {

    $idUsuario = $_POST['id'];

    // INSTANCIAMOS AL OBJETO
    $usuario = new Usuario($db);

    if ($usuario->borrar($idUsuario)) {

        $mensaje = "Delete successfully.";

        header("Location:usuarios.php?mensaje=" . urlencode($mensaje));

    } else {

        $error = "Successfully deleted.";
    }
}

?>
<div class="row">
    <div class="col-sm-6">
        <h3>Editar Usuario</h3>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 offset-3">
        <form method="POST" action="">

            <input type="hidden" name="id" value="<?php echo $resultado->usuario_id; ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" value="<?php echo $resultado->usuario_nombre; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email" value="<?php echo $resultado->usuario_email; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="rol" class="form-label">Rol:</label>
                <select class="form-select" aria-label="Default select example" name="rol">
                    <option value="">--Selecciona un rol--</option>
                    <option value="1" <?php if ($resultado->rol == "Administrador") { echo "selected"; } ?>>Administrador</option>
                    <option value="2" <?php if ($resultado->rol == "Registrado") { echo "selected"; } ?>>Registrado</option>
                </select>
            </div>

            <br />
            <button type="submit" name="editarUsuario" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Usuario</button>

            <button type="submit" name="borrarUsuario" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Usuario</button>
        </form>
    </div>
</div>
<?php include("../includes/footer.php") ?>