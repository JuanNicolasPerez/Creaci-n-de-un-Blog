<?php

class Usuario{

    private $conn;
    private $table = 'usuarios';

    // PROPIEDADES
    public $id;
    public $nombre;
    public $email;
    public $password;
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
                    u.id AS usuario_id, 
                    u.nombre AS usuario_nombre, 
                    u.email AS usuario_email,
                    u.fecha_creacion AS usuario_fecha_creacion,
                    r.nombre AS rol
                FROM ' . $this->table . 
                ' u INNER JOIN roles r 
                ON r.id = u.rol_id';

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $usuarios;
    }

    // CREAMOS UN METODO LEER INDIVIDUAL
    public function leer_individual($id)
    {

        $sql = 'SELECT 
                    u.id AS usuario_id, 
                    u.nombre AS usuario_nombre, 
                    u.email AS usuario_email,
                    u.fecha_creacion AS usuario_fecha_creacion,
                    r.nombre AS rol
                FROM ' . $this->table . 
                ' u INNER JOIN roles r 
                ON r.id = u.rol_id
                WHERE u.id = :id 
                LIMIT 0,1';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_OBJ);

        return $usuario;

    }

    // CREAMOS UN METODO LEER
    public function actualizar($id, $rol)
    {

        $sql = 'UPDATE ' . $this->table . 
                ' SET rol_id = :rol_id 
                WHERE id = :id';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':rol_id', $rol, PDO::PARAM_INT);
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

    // CREAMOS UN METODO REGISTRAR
    public function registrar($nombre, $email, $password)
    {

        $sql = 'INSERT INTO ' . $this->table . 
                ' (nombre, email, password, rol_id) 
                VALUES (:nombre, :email, :password, 2)';

        $passwordEncriptado = md5($password);

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $passwordEncriptado, PDO::PARAM_STR);

        try {

            $stmt->execute();

            return true;

        } catch (Exception $e) {

            print_r("Error: " . $e);

        }

    }

    // CREAMOS UN METODO LEER EMAIL
    public function validar_email($email)
    {

        $sql = 'SELECT * FROM ' . $this->table . 
                ' WHERE email = :email';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();

        $registroEmail = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registroEmail) {

            return false;

        } else {

            return true;

        }

    }

    // CREAMOS UN METODO ACCEDER EMAIL
    public function acceder($email, $password)
    {

        $sql = 'SELECT * FROM ' . $this->table . 
                ' WHERE email = :email 
                AND password = :password';

        // ENCRIPTAMOS LA CONTRASEÑA PARA COMPARAR
        $passwordEncriptado = md5($password);

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->bindParam(':password', $passwordEncriptado, PDO::PARAM_STR);

        $stmt->execute();

        $existeUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existeUsuario) {

            return true;

        } else {

            return false;

        }

    }
}

?>