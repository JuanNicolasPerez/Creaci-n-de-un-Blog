<?php

class Comentarios{

    private $conn;
    private $table = 'comentarios';
    private $table2= 'usuarios';

    // PROPIEDADES
    public $id;
    public $comentarios;
    public $estado;
    public $fecha_creacion;

    // CREAMOS EL CONSTRUCTOR O OBJETO DE LA CLASE
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // CREAMOS UN METODO LEER
    public function leer()
    {

        $sql = 'SELECT 
                    c.id AS id_comentario, 
                    c.comentario AS comentario, 
                    c.estado AS estado,
                    c.fecha_creacion AS fecha,
                    c.usuario_id AS id_usuario,
                    u.email AS email_usuario,
                    a.titulo AS titulo_articulo
                FROM ' . $this->table . 
                ' c LEFT JOIN usuarios u 
                ON u.id = c.usuario_id 
                LEFT JOIN articulos a 
                ON a.id = c.articulo_id';

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        $comentarios = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $comentarios;
    }

    // CREAMOS UN METODO LEER
    public function leer_individual($id)
    {

        $sql = 'SELECT 
                    c.id AS id_comentario, 
                    c.comentario AS comentario, 
                    c.estado AS estado,
                    c.fecha_creacion AS fecha,
                    c.usuario_id AS id_usuario,
                    u.email AS email_usuario,
                    a.titulo AS titulo_articulo
                FROM ' . $this->table . 
                ' c LEFT JOIN usuarios u 
                ON u.id = c.usuario_id 
                LEFT JOIN articulos a 
                ON a.id = c.articulo_id
                WHERE c.id = :id 
                LIMIT 0,1';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {

            $stmt->execute();
    
            $comentario = $stmt->fetch(PDO::FETCH_OBJ);
    
            return $comentario;

        } catch (Exception $e) {

            print_r("Error: " . $e);

        }

    }

    // CREAMOS UN METODO LEER
    public function actualizar($idComentario, $estado)
    {

        $sql = 'UPDATE ' . $this->table . 
                ' SET estado = :estado 
                WHERE id = :id';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
        $stmt->bindParam(':id', $idComentario, PDO::PARAM_INT);

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

    // CREAMOS UN METODO LEER POR ID
    public function leer_Por_Id($idArticulo)
    {

        $sql = 'SELECT 
                    c.id AS id_comentario, 
                    c.comentario AS comentario, 
                    c.estado AS estado,
                    c.fecha_creacion AS fecha,
                    c.usuario_id AS id_usuario,
                    u.email AS email_usuario
                FROM ' . $this->table . 
                ' c INNER JOIN usuarios u 
                ON u.id = c.usuario_id 
                WHERE c.articulo_id = :articulo_id 
                AND c.estado = 1';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':articulo_id', $idArticulo, PDO::PARAM_INT);

        try {

            $stmt->execute();
    
            $comentarios = $stmt->fetchAll(PDO::FETCH_OBJ);
    
            return $comentarios;

        } catch (Exception $e) {

            print_r("Error: " . $e);

        }

    }

    // CREAMOS UN METODO LEER
    public function crear($email, $comentario, $idArticulo)
    {

        $sql = 'SELECT * FROM ' . $this->table2 . 
                ' WHERE email = :email';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        try {

            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_OBJ);

            $idUsuario = $usuario->id;

        } catch (Exception $e) {

            print_r("Error: " . $e);

        }

        $sql = 'INSERT INTO ' . $this->table . 
                ' (comentario, usuario_id, articulo_id, estado) 
                VALUES (:comentario, :usuario_id, :articulo_id, 0)';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
        $stmt->bindParam(':usuario_id', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':articulo_id', $idArticulo, PDO::PARAM_INT);

        try {

            $stmt->execute();

            return true;

        } catch (Exception $e) {

            print_r("Error: " . $e);

        }
    }
}

?>