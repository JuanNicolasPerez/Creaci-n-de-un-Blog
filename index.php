<?php include("includes/header_front.php") ?>

<?php

// INSTANCIAMOS CLASE DE LA BASE DE ADATOS
$baseDatos = new Basemysql();

// CREAMOS UNA INSTANCIA DE LA CLASE
$db = $baseDatos->connect();

// INSTANCIAMOS EL OBJETO DE LA CLASE ARTICULOS
$articulos = new Articulos($db);

$resultado = $articulos->leer();

?>

<div class="container-fluid">
    <h1 class="text-center">Artículos</h1>
    <div class="col-md-12">
        <div class="row">
            <?php
            foreach ($resultado as $articulos) {
            ?>
                <div class="col-sm-4">
                    <div class="card">
                        <img src="<?php echo RUTA_FRONT; ?>img/articulos/<?php echo $articulos->imagen; ?>" class="card-img-top" alt="Imagen Articulo"
                            <div class="card-body">
                        <h5 class="card-title"><?php echo $articulos->titulo; ?></h5>
                        <p><strong><?php echo $articulos->fecha_creacion; ?></strong></p>
                        <p class="card-text"><?php echo $articulos->texto; ?></p>
                        <a href="detalle.php?id=<?php echo $articulos->id; ?>" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include("includes/footer.php") ?>