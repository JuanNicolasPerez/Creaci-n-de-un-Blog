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
    $comentario = new Comentarios($db);

    $resultado = $comentario->leer_individual($id);
}

// SI EXISTE LA ACCION DE EDITAR
if (isset($_POST['editarComentario'])) {

    $idComentario = $_POST['id'];

    $estado = $_POST['cambiarEstado'];

    $comentario = new Comentarios($db);

    if ($comentario->actualizar($idComentario, $estado)) {

        $mensaje = "Updated successfully.";

        header("Location:comentarios.php?mensaje=" . urlencode($mensaje));

        exit();

    } else {

        $error = "Error: Could not update.";

    }

}

// BORRAMOS AL COMENTARIO
if (isset($_POST['borrarComentario'])) {

    $idcomentario = $_POST['id'];

    // INSTANCIAMOS AL OBJETO
    $comentario = new ComentarioS($db);

    if ($comentario->borrar($idcomentario)) {

        $mensaje = "Delete successfully.";

        header("Location:comentarios.php?mensaje=" . urlencode($mensaje));

    } else {

        $error = "Successfully deleted.";
    }
}
?>

<div class="row">

</div>

<div class="row">
    <div class="col-sm-6">
        <h3>Editar Comentario</h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 offset-3">
        <form method="POST" action="">

            <input type="hidden" name="id" value="<?php echo $resultado->id_comentario; ?>">

            <div class="mb-3">
                <label for="texto">Texto</label>
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px" readonly>
                    <?php echo $resultado->titulo_articulo; ?>
                </textarea>
            </div>

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" value="<?php echo $resultado->email_usuario; ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="cambiarEstado" class="form-label">Cambiar estado:</label>
                <select class="form-select" name="cambiarEstado" aria-label="Default select example">
                    <option value="">--Seleccionar una opción--</option>
                    <option value="1" <?php if ($resultado->estado == "1") { echo "selected"; } ?>>Aprobado</option>
                    <option value="0" <?php if ($resultado->estado == "0") { echo "selected"; } ?>>No Aprobado</option>
                </select>
            </div>

            <br />
            <button type="submit" name="editarComentario" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Comentario</button>

            <button type="submit" name="borrarComentario" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Comentario</button>
        </form>
    </div>
</div>
<?php include("../includes/footer.php") ?>