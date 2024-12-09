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
    $articulos = new Articulos($db);

    $resultado = $articulos->leer_individual($id);
}

if (isset($_POST['editarArticulo'])) {

    $idArticulo = $_POST['id'];

    $titulo = $_POST['titulo'];

    $texto = $_POST['texto'];

    // PREGUNTAMOS SI TIENE UNA IMAGEN
    $logo = $_POST['imagen'];

    // VERIFICAMOS QUE LA IMAGEN NO VENGA VACIA
    if ($_FILES['imagen']['name'] != null) {

        // CAPTURAMOS LA IMAGEN
        $imagen = $_FILES['imagen']['name'];

        // CONVERTIMOS EL NOMBRE DE LA IMAGEN EN UN ARRAY
        $imagenArr = explode('.', $imagen);

        // GENERAMOS NUMEROS ALEATORIOS
        $ran = rand(1000, 99999);

        // CREAMOS EL NOMBRE DE LA IMAGEN PARA EVITAR DUPLICIDAD
        $newImage = $imagenArr[0] . $ran . '.' . $imagenArr[1];

        // CREAMOS LA RUTA CON EL NOMBRE DE LA IMAGEN
        $rutaFinal = "../img/articulos/" . $newImage;

        // CREAMOS EL ARCHIVO DONDE SE VA A GUARDAR LA IMAGEN
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFinal);

        // CREAMOS UNA VARIABLE PARA LA IMAGEN
        $logo = $newImage;
    } else {

        // VERIFICAMOS QUE SI LA IMAGEN VIENE VACIA
        if ($logo == "") {

            // SI LA IMAGEN VIENE VACIO ENVIAMOS UN MENSAJE
            $logo = "";
        } else {

            // MANDAMOS LA VARIABLE DEL POST
            $logo = $logo;
        }
    }

    if (empty($titulo) || $titulo == '' || empty($texto) || $texto == '') {

        $error = "Error, verify that the fields are not empty.";

    } else {

        $articulo = new Articulos($db);

        if ($articulos->actualizar($idArticulo, $titulo, $texto, $logo)) {

            $mensaje = "Updated successfully.";

            header("Location:articulos.php?mensaje=" . urlencode($mensaje));

            exit();

        } else {

            $error = "Error: Could not update.";
        }
    }
}

if (isset($_POST['borrarArticulo'])) {

    $idArticulo = $_POST['id'];

    // INSTANCIAMOS AL OBJETO
    $articulos = new Articulos($db);

    if ($articulos->borrar($idArticulo)) {

        $mensaje = "Delete successfully.";

        header("Location:articulos.php?mensaje=" . urlencode($mensaje));

    } else {

        $error = "Successfully deleted.";
    }
}
?>

<!-- MENSAJE -->
<div class="row">
    <div class="col-ms-12">
        <?php if (isset($error)) { ?>
            <div class=" alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?php echo $error; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
            </div>
        <?php } ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <h3>Editar Artículo</h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 offset-3">
        <form method="POST" action="" enctype="multipart/form-data">

            <!-- ID ARTICULO -->
            <input type="hidden" name="id" value="<?php echo $resultado->id; ?>">

            <!-- NOMBRE -->
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo $resultado->titulo; ?>">
            </div>

            <!-- IMAGEN -->
            <div class="mb-3">
                <img class="img-fluid img-thumbnail" src="<?php echo RUTA_FRONT . "img/articulos/" . $resultado->imagen; ?>">
            </div>

            <!-- CARGAR IMAGEN -->
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Selecciona una imagen">
                <input type="text" name="imagen" value="<?= $resultado->imagen; ?>" hidden>
            </div>

            <!-- TEXTO -->
            <div class="mb-3">
                <label for="texto">Texto</label>
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px">
                    <?php echo $resultado->texto; ?>
                </textarea>
            </div>

            <!-- ACCIONES -->
            <br />
            <button type="submit" name="editarArticulo" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Artículo</button>

            <button type="submit" name="borrarArticulo" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Artículo</button>
        </form>
    </div>
</div>
<?php include("../includes/footer.php") ?>