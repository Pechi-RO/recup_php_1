<?php
namespace Recuperacion;
use PDO;
use PDOException;
use Faker;


class Users extends Conexion{

    private $id;
    private $nombre;
    private $apellidos;
    private $username;
    private $mail;
    private $pass;    

    public function __construct()
    {
        parent::__construct();
    }

//_________________CRUD______________________
    public function create()
    {
        $q = "insert into users(nombre, apellidos, username, mail, pass) values(:n, :a, :u, :m, :p)";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':a' => $this->apellidos,
                ':u' => $this->username,
                ':m' => $this->mail,
                ':p' => $this->pass
            ]);
        } catch (PDOException $ex) {
            die("Error al insertar users: " . $ex->getMessage());
        }
        parent::$conexion = null; //cerramos la conexion
    }

    public function hayUsers()
    {
        $q = "select * from users";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
            parent::$conexion = null;
        } catch (PDOException $ex) {
            die("Error al comprobar si hay usuarios".$ex->getMessage());
        }
        //devuelve el numero de filas 
        return $stmt->rowCount(); 

    }

  public function generarUsers($cantidad)
    {
        if ($this->hayUsers() == 0) {
            //si no hay autores los creo, si ya los hay no
            
            $faker = Faker\Factory::create('es_ES');
            for ($i = 0; $i < $cantidad; $i++) {
                $nombre = $faker->firstName();
                $apellidos = $faker->lastName() . " " . $faker->lastName();
                $username=$faker->userName();
                $mail=$faker->email();
                $pass=$faker->password();

                (new Users)->setNombre($nombre)
                    ->setApellidos($apellidos)
                    ->setUsername($username)
                    ->setMail($mail)
                    ->setPass($pass)
                    ->create();
            }
        }
    }


    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */ 
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set the value of mail
     *
     * @return  self
     */ 
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Set the value of pass
     *
     * @return  self
     */ 
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }
}
