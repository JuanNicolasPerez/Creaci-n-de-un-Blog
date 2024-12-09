<?php include("../includes/header.php") ?>

<?php

// INSTANCIAMOS CLASE DE LA BASE DE ADATOS
$baseDatos = new Basemysql();

// CREAMOS UNA INSTANCIA DE LA CLASE
$db = $baseDatos->connect();

// VERIFICAMOS SI RE REALIZA LA ACCION POST DEL FORMULARIO
if (isset($_POST['crearArticulo'])) {

    // OBTENEMOS LOS VALORES
    $titulo = $_POST['titulo'];
    $texto = $_POST['texto'];

    // VALIDAMOS LA IMAGEN
    if ($_FILES["imagen"]["error"] > 0) {

        $error = "Error, no image selected.";
    } else {

        if (empty($titulo) || $titulo == '' || empty($texto) || $texto == '') {

            $error = "Error, verify that the fields are not empty.";
        } else {

            $imagen = $_FILES['imagen']['name'];
            $imagenArr = explode('.', $imagen);

            $ran = rand(1000, 99999);

            $newImage = $imagenArr[0] . $ran . '.' . $imagenArr[1];

            $rutaFinal = "../img/articulos/" . $newImage;

            move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFinal);

            $articulo = new Articulos($db);

            if ($articulo->crear($titulo, $newImage, $texto)) {

                $mensaje = "Successfully created item.";

                header("Location:articulos.php?mensaje=" . urlencode($mensaje));
            }
        }
    }
}

?>

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
        <h3>Crear un Nuevo Artículo</h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 offset-3">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ingresa el título">
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="apellidos" placeholder="Selecciona una imagen">
            </div>

            <div class="mb-3">
                <label for="texto">Texto</label>
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px"></textarea>
            </div>

            <br>
            <button type="submit" name="crearArticulo" class="btn btn-primary w-100">
                <i class="bi bi-person-bounding-box"></i> 
                Crear Nuevo Artículo
            </button>
        </form>
    </div>
</div>
<?php include("../includes/footer.php") ?>