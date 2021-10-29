<?php
namespace Libreria;

use PDOException;
use PDO;
use Faker;

class Autores extends Conexion{
    private $id;
    private $nombre;
    private $apellidos;
    private $pais;

    public function __construct()
    {
        parent::__construct();
    }
    ///------------ CRUD -----------------------------------------------
    public function create(){
        $q="insert into autores(nombre, apellidos, pais) values(:n, :a, :p)";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':a'=>$this->apellidos,
                ':p'=>$this->pais
            ]);

        }catch(PDOException $ex){
            die("Error al insertar: ".$ex->getMessage());
        }
        parent::$conexion=null; //cerramos la conexion
    }
    //--------------------------------------------------
    public function read($id){
        $q="select * from autores where id=:i";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':i'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al Borrar el autor: ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetch(PDO::FETCH_OBJ);


    }
   
    public function update(){
        $q="update autores set nombre=:n, apellidos=:a, pais=:p where id=:i";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':a'=>$this->apellidos,
                ':p'=>$this->pais,
                ':i'=>$this->id
            ]);
        }catch(PDOException $ex){
            die("Error al Actualizar el autor: ".$ex->getMessage());
        }
        parent::$conexion=null;
    }
    public function delete($id){
        $q="delete from autores where id=:i";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':i'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al Borrar el autor: ".$ex->getMessage());
        }
        parent::$conexion=null;


    }
    //devolveremos todos los registros
    public function readAll(){
        $q="select * from autores order by apellidos";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al recuperar Todos los contactos: ".$ex->getMessage());
        }
        parent::$conexion=null; //cerramos la conexion
        return $stmt;


    }

    //--------------OTROS METODOS ------------------------------------
    public function generarAutores($cantidad){
        if($this->hayAutores()==0){
            //si no hay autores los creo, si ya los hay NO hago nada
            $faker= Faker\Factory::create('es_ES');
            for($i=0; $i<$cantidad; $i++) {
                $nombre=$faker->firstName();
                $apellidos=$faker->lastName()." ".$faker->lastName();
                $pais=$faker->country();
                (new Autores)->setNombre($nombre)
                ->setApellidos($apellidos)
                ->setPais($pais)
                ->create();

            }
        }
    }
    public function hayAutores(){
        $q="select * from autores";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error en hay autores: ".$ex->getMessage()); 
        }
        parent::$conexion=null;
        return $stmt->rowCount(); //devuelve el numero de filas 

    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
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
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
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
     * Get the value of apellidos
     */ 
    public function getApellidos()
    {
        return $this->apellidos;
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
     * Get the value of pais
     */ 
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set the value of pais
     *
     * @return  self
     */ 
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }
}