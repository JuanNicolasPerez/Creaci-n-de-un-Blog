<?php

// CREAMOS LA CLASE
class Articulos
{

    // CREAMOS LA VARIABLE DE CONECCION
    private $conn;

    // CREAMOS LA  VARIABLE DE LA TABLA A BUSCAR
    private $table = 'articulos';

    // PROPIEDADES DE LA TABLA
    public $id;
    public $titulo;
    public $imagen;
    public $texto;
    public $fecha_creacion;

    // CREAMOS EL CONSTRUCTOR O OBJETO DE LA CLASE
    public function __construct($db)
    {

        $this->conn = $db;
    }

    // CEAMOS UN METODO LEER
    public function leer()
    {

        $sql = 'SELECT id, titulo, imagen, texto, fecha_creacion
                FROM ' . $this->table;

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        $articulos = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $articulos;
    }

    // CREAMOS UN METODO LEER UN REGISTRO ESPECIFICO
    public function leer_individual($id)
    {

        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 0,1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $articulos = $stmt->fetch(PDO::FETCH_OBJ);

        return $articulos;
    }

    // CREAMOS EL METODO PARA CREAR
    public function crear($titulo, $newImage, $texto)
    {

        $sql = "INSERT INTO "
            . $this->table .
            " (titulo, imagen, texto)
                VALUES
                (:titulo, :imagen, :texto)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);

        $stmt->bindParam(':imagen', $newImage, PDO::PARAM_STR);

        $stmt->bindParam(':texto', $texto, PDO::PARAM_STR);

        try {

            $stmt->execute();

            return true;
        } catch (Exception $e) {

            print_r("Error: " . $e);
        }
    }

    // CREAMOS EL METODO PARA EDITAR
    public function actualizar($id, $titulo,  $texto, $newImage)
    {

        $sql = "UPDATE "
            . $this->table .
            " SET
                titulo = :titulo, imagen = :imagen, texto = :texto
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);

        $stmt->bindParam(':imagen', $newImage, PDO::PARAM_STR);

        $stmt->bindParam(':texto', $texto, PDO::PARAM_STR);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {

            $stmt->execute();

            return true;
        } catch (Exception $e) {

            print_r("Error: " . $e);
        }
    }

    // CREAMOS EL METODO PARA ELIMINAR
    public function borrar($id)
    {

        $sql = 'DELETE
                FROM ' . $this->table.
                ' WHERE id = :id';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {

            $stmt->execute();

            return true;

        } catch (Exception $e) {

            print_r("Error: " . $e);

        }

    }

}
