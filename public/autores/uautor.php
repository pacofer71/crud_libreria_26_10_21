<?php
if (!isset($_GET['id'])) {
    header("Location:index.php");
}
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Libreria\Autores;

$id = $_GET['id'];
$datosAutor = (new Autores)->read($id);
function hayError($n, $a, $p)
{
    $error = false;
    if (strlen($n) == 0) {
        $_SESSION['error_nombre'] = "Rellene el campo nombre";
        $error = true;
    }
    if (strlen($a) == 0) {
        $_SESSION['error_apellidos'] = "Rellene el campo apellidos";
        $error = true;
    }
    if (strlen($p) == 0) {
        $_SESSION['error_pais'] = "Rellene el campo pais";
        $error = true;
    }
    return $error;
}
if (isset($_POST['btnUpdate'])) {
    //procesamos el Formulario
    $nombre = trim(ucwords($_POST['nombre']));
    $apellidos = trim(ucwords($_POST['apellidos']));
    $pais = trim(ucwords($_POST['pais']));
    if (!hayError($nombre, $apellidos, $pais)) {
        (new Autores)->setNombre($nombre)
            ->setApellidos($apellidos)
            ->setPais($pais)
            ->setId($id)
            ->update();
        $_SESSION['mensaje'] = "Autor actualizado con exito";
        header("Location:index.php");
        die();
    }
    //
    header("Location:{$_SERVER['PHP_SELF']}?id=$id");
} else {

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

        <title>Actualizar Autor</title>





    </head>

    <body style="background-color:silver">
        <h3 class="text-center">Actualizar Autor</h3>
        <div class="container mt-2">
            <form name="cautor" action="<?php echo $_SERVER['PHP_SELF'] . "?id=$id"; ?>" method='POST'>
                <div class="bg-success p-4 text-white rounded shadow-lg m-auto" style="width:40rem">
                    <div class="mb-3">
                        <label for="n" class="form-label">Nombre Autor</label>
                        <input type="text" class="form-control" id="n" placeholder="Nombre" name="nombre" value="<?php echo $datosAutor->nombre ?>" required>
                        <?php
                        if (isset($_SESSION['error_nombre'])) {
                            echo <<<TXT
                            <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                {$_SESSION['error_nombre']}
                            </div>
                            TXT;
                            unset($_SESSION['error_nombre']);
                        }
                        ?>

                    </div>
                    <div class="mb-3">
                        <label for="a" class="form-label">Apellidos Autor</label>
                        <input type="text" class="form-control" id="a" placeholder="Apellidos" name="apellidos" value="<?php echo $datosAutor->apellidos ?>" required>
                        <?php
                        if (isset($_SESSION['error_apellidos'])) {
                            echo <<<TXT
                            <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                {$_SESSION['error_apellidos']}
                            </div>
                            TXT;
                            unset($_SESSION['error_apellidos']);
                        }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="p" class="form-label">País Autor</label>
                        <input type="text" class="form-control" id="p" placeholder="País" name="pais" value="<?php echo $datosAutor->pais ?>" required>
                        <?php
                        if (isset($_SESSION['error_pais'])) {
                            echo <<<TXT
                            <div class="mt-2 text-danger fw-bold" style="font-size:small">
                                {$_SESSION['error_pais']}
                            </div>
                            TXT;
                            unset($_SESSION['error_pais']);
                        }
                        ?>

                    </div>

                    <div>
                        <button type='submit' name="btnUpdate" class="btn btn-info"><i class="fas fa-user-edit"></i> Actualizar</button>
                        <a href="index.php" class="btn btn-primary"><i class="fas fa-backward"></i> Volver</a>
                    </div>
                </div>
            </form>
        </div>
    </body>

    </html>
<?php } ?>