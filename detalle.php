<?php include("includes/header_front.php") ?>
<?php

// INSTANCIAMOS CLASE DE LA BASE DE ADATOS
$baseDatos = new Basemysql();

// CREAMOS UNA INSTANCIA DE LA CLASE
$db = $baseDatos->connect();

// VALIDAMOS QUE SE ENVIE EL ID A TRAVEZ DE LA URL
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // INSTANCIAMOS AL OBJETO
    $articulos = new Articulos($db);

    $resultado = $articulos->leer_individual($id);

    // INSTANCIAMOS AL OBJETO
    $articulos = new Comentarios($db);

    $resultado_comentario = $articulos->leer_Por_Id($id);
}

// CREAMOS EL COMENTARIO
if (isset($_POST['enviarComentario'])) {

    $idArticulo = $_POST['articulo'];
    $email = $_POST['usuario'];
    $comentario = $_POST['comentario'];

    if (empty($comentario) || $comentario == '' || empty($email) || $email == '' ) {

        $error = "Error, verify that the fields are not empty.";

    }else{

        // INSTANCIAMOS AL OBJETO
        $articulos = new Comentarios($db);

        if ($articulos->crear($email, $comentario, $id)) {

            $mensaje = "Comment created successfully";

            echo("<script>location.href= '".RUTA_FRONT."'</script>");

        } else {

            $error = "Error: I can't create the comment.";

        }
    }

}

?>

<div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card" style="background-color: #C7C7C7;">
                <div class="card-header">
                    <div class="text-center">
                        <h1><?php echo $resultado->titulo; ?></h1>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid img-thumbnail" src="<?php echo RUTA_FRONT . "img/articulos/" . $resultado->imagen; ?>">
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <p><?php echo $resultado->texto; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div class="card" style="background-color: #C7C7C7;">
                <div class="card-header">
                    <div class="text-center">
                        <h1>Agregar Comentario</h1>
                    </div>
                </div>
                <form method="POST" action="">
                    <div class="card-body">
                        <input type="hidden" name="articulo" value="<?php echo $id; ?>">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario:</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="comentario">Comentario</label>
                            <textarea class="form-control" name="comentario" style="height: 200px"></textarea>
                        </div>
                    </div>
                    <br />
                    <div class="card-footer">
                        <div class="text-center">
                            <div>
                                <button type="submit" name="enviarComentario" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Crear Nuevo Comentario</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>

    <hr>

    <div class="row">
        <div class="col-sm-12">
            <div class="card" style="background-color: #C7C7C7;">
                <div class="card-header">
                    <div class="text-center">
                        <h3>Comentarios</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <?php foreach ($resultado_comentario as $comentario) {
                        ?>
                            <h4>
                                <i class="bi bi-person-circle"></i>
                                <?php echo $comentario->email_usuario; ?>
                            </h4>
                            <p><?php echo $comentario->comentario; ?></p>
                        <?php 
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include("includes/footer.php") ?>