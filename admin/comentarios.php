<?php include("../includes/header.php") ?>
<?php

// INSTANCIAMOS CLASE DE LA BASE DE ADATOS
$baseDatos = new Basemysql();

// CREAMOS UNA INSTANCIA DE LA CLASE
$db = $baseDatos->connect();

// INSTANCIAMOS EL OBJETO DE LA CLASE ARTICULOS
$comentarios = new Comentarios($db);

$resultado = $comentarios->leer();

?>
<div class="row">
    <div class="col-sm-6">
        <h3>Lista de Comentarios</h3>
    </div>       
</div>
<div class="row mt-2 caja">
    <div class="col-sm-12">
            <table id="tblContactos" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Comentario</th>
                        <th>Usuario</th>
                        <th>Artículo</th>
                        <th>Estado</th>
                        <th>Fecha de creación</th>                                          
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($resultado as $comentarios) {
                ?>
                        <tr>
                            <td><?php echo $comentarios->id_comentario; ?></td>
                            <td><?php echo $comentarios->comentario; ?></td>
                            <td><?php echo $comentarios->email_usuario; ?></td>
                            <td><?php echo $comentarios->titulo_articulo; ?></td>
                            <td><?php echo $comentarios->estado; ?></td>
                            <td><?php echo $comentarios->fecha; ?></td>
                            <td>
                                <a href="editar_comentario.php?id=<?php echo $comentarios->id_comentario; ?>" class="btn btn-warning">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                ?>
                
                </tbody>       
            </table>
    </div>
</div>
<?php include("../includes/footer.php") ?>

<script>
    $(document).ready( function () {
        $('#tblContactos').DataTable();
    });
</script>