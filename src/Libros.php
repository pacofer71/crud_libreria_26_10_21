<?php

namespace Libreria;

use PDOException;
use PDO;
use Faker;

class Libros extends Conexion
{
    private $id;
    private $titulo;
    private $sinopsis;
    private $isbn;
    private $autor_id;


    public function __construct()
    {
        parent::__construct();
    }
    //-------------------- CRUD ---------------------
    public function create()
    {
        $q = "insert into libros(titulo, sinopsis, isbn, autor_id) values(:t, :s, :isbn, :ai)";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':t' => $this->titulo,
                ':s' => $this->sinopsis,
                ':isbn' => $this->isbn,
                ':ai' => $this->autor_id
            ]);
        } catch (PDOException $ex) {
            die("Error al insertar libro: " . $ex->getMessage());
        };
        parent::$conexion = null;
    }
    //----------------------------------------------------------------------------------------
    public function read($id)
    {
        $q = "select libros.*, nombre, apellidos, pais from libros, autores where 
        autor_id=autores.id AND libros.id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al recuperar UN libro: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    //-------------------------------------------------------------------------------
    public function update($id)
    {
        $q = "update libros set titulo=:t, sinopsis=:s, autor_id=:ai, isbn=:isbn where id=:id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':t' => $this->titulo,
                ':s' => $this->sinopsis,
                ':ai' => $this->autor_id,
                ':isbn' => $this->isbn,
                ':id' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al actualizar el Libro: " . $ex->getMessage());
        }
    }
    public function delete($id)
    {
        $q = "delete from libros where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar Libro: " . $ex->getMessage());
        }
        parent::$conexion = null;
    }
    public function readAll()
    {
        $q = "select * from libros order by titulo, autor_id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al devolver todos los libros: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;
    }
    public function librosxcampos($v, $c)
    {
        if ($c == "autor_id") {
            $q = "select * from libros where autor_id=:parametro order by titulo";
        }
        if ($c == "pais") {
            $q = "select libros.* from libros, autores where autor_id=autores.id AND pais=:parametro order by titulo";
        }
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':parametro' => $v
            ]);
        } catch (PDOException $ex) {
            die("Error al devolver libros por campos: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;
    }

    //---------------------Otros M??todos------------
    public function generarLibros($cant)
    {
        if (!$this->hayLibros()) {
            $faker = Faker\Factory::create('es_ES');
            $autores = (new Autores)->devolverId(); //[2, 3, 4, 8, 12 ...]

            for ($i = 0; $i < $cant; $i++) {
                $titulo = $faker->sentence(4);
                $sinopsis = $faker->text(200);
                $isbn = $faker->unique()->isbn13();
                $autor_id = $autores[array_rand($autores, 1)];

                (new Libros)->setTitulo($titulo)
                    ->setSinopsis($sinopsis)
                    ->setIsbn($isbn)
                    ->setAutor_id($autor_id)
                    ->create();
            }
        }
    }
    public function hayLibros()
    {
        $q = "select * from libros";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si hay libros: " . $ex->getMessage());
        }
        $totalLibros = $stmt->rowCount();
        parent::$conexion = null;
        return ($totalLibros > 0);
    }
    //----------------------------------------------------------------

    public function existeIsbn($i)
    {
        if (isset($this->id)) {
            $q = "select * from libros where isbn=:i AND id!={$this->id}";
        } else {
            $q = "select * from libros where isbn=:i";
        }
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $i
            ]);
        } catch (PDOException $ex) {
            die("Error al comprobar el ISBN: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return ($stmt->rowCount() == 1);
    }

    //----------------------------------------------------

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
     * Get the value of titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     *
     * @return  self
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of sinopsis
     */
    public function getSinopsis()
    {
        return $this->sinopsis;
    }

    /**
     * Set the value of sinopsis
     *
     * @return  self
     */
    public function setSinopsis($sinopsis)
    {
        $this->sinopsis = $sinopsis;

        return $this;
    }

    /**
     * Get the value of isbn
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set the value of isbn
     *
     * @return  self
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get the value of autor_id
     */
    public function getAutor_id()
    {
        return $this->autor_id;
    }

    /**
     * Set the value of autor_id
     *
     * @return  self
     */
    public function setAutor_id($autor_id)
    {
        $this->autor_id = $autor_id;

        return $this;
    }
}
