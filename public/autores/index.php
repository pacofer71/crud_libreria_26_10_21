<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Libreria\Autores;

(new Autores)->generarAutores(50);
$datosAutores = (new Autores)->readAll();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Autores</title>





</head>

<body style="background-color:silver">
    <h3 class="text-center">Gestion Autores</h3>
    <div class="container mt-2">
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo <<<TXT
                <div class="alert alert-primary" role="alert">
                {$_SESSION['mensaje']}
                </div>
                TXT;
            unset($_SESSION['mensaje']);
        }
        ?>
        <a href="cautor.php" class="btn btn-primary mb-2"><i class="fas fa-user-plus"></i> Nuevo Autor</a>
        <table class="table table-success table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">País</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $datosAutores->fetch(PDO::FETCH_OBJ)) {
                    echo <<<TXT

                <tr>
                    <th scope="row">{$fila->id}</th>
                    <td>{$fila->nombre}</td>
                    <td>{$fila->apellidos}</td>
                    <td>{$fila->pais}</td>
                    <td>
                    <form name='s' action='bautor.php' method='POST'>
                    <input type='hidden' name='id' value='{$fila->id}'>
                    <a href="uautor.php?id={$fila->id}" class="btn btn-warning"><i class="fas fa-user-edit"></i></a>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Desea Borrar el Autor?')"><i class="fas fa-trash-alt"></i></button>
                    </form>
                    </td>
                </tr>
                TXT;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>