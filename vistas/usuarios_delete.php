<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once VIEW_PATH . "cabecera.php";

// como esta página está restringida a usuarios administradores si no está logueado como admin
// lo remitirá a la pagina de inicio
// rol:1 administrador
if ((($_SESSION['rol']) != 1) || (!isset($_SESSION['nombre']))) {
    header("location: error.php");
    exit();
}

// Compramos la existencia del parámetro id antes de usarlo
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = decode($_GET["id"]);
    // Cargamos el controlador
    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->buscarUsuarioID($id);

    //si no existe el usuario lo enviamos a error para que no haga nada
    if (is_null($usuario)) {
        // hay un error
        header("location: error.php");
        exit();
    }

}


// Si borramos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cu = ControladorUsuario::getControlador();
    $usuario = $cu->buscarUsuarioID($_POST["id"]);
    if ($estado = $cu->eliminarUsuario($_POST["id"])) {
        //Se ha borrado y volvemos a la página principal
        // Debemos borrar la foto del alumno
        $imagen = USERS_IMAGES_PATH . $usuario->getImagen();
        $ci = ControladorImagen::getControlador();
        if ($ci->eliminarImagen($imagen)) {
            alerta("Usuario/a eliminado/a correctamente", "usuarios.php");
            exit();
        } else {
            alerta("Ha habido un problema al eliminar el/la usuario/a");
            exit();
        }
    } else {
        alerta("Ha habido un problema al eliminar el/la usuario/a");
        exit();
    }

}
?>


<!-- Cuerpo de la página web -->
<div class="container">
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="panel-title">Eliminar usuario/a</div>
            </div>
            <div class="panel-body">
                <form id="signupform" class="form-horizontal" role="form"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">


                    <!-- Imagen -->
                    <div class="form-group">
                        <img src='../img_usuarios/<?php echo $usuario->getImagen(); ?>' class='center-block'
                             class='rounded' class='img-thumbnail' width='80' height='auto'>
                    </div>

                    <!-- ID -->
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">ID:</label>
                        <div class="col-md-9">
                            <label for="name" class="col-md-3 control-label"><?php echo $usuario->getId(); ?></label>
                        </div>
                    </div>

                    <!-- Nombre -->
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Nombre:</label>
                        <div class="col-md-9">
                            <label for="name"
                                   class="col-md-3 control-label"><?php echo $usuario->getNombre(); ?></label>
                        </div>
                    </div>

                    <!-- Alias -->
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Alias:</label>
                        <div class="col-md-9">
                            <label for="name" class="col-md-3 control-label"><?php echo $usuario->getAlias(); ?></label>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="mail" class="col-md-3 control-label">Email:</label>
                        <div class="col-md-9">
                            <label for="name" class="col-md-3 control-label"><?php echo $usuario->getEmail(); ?></label>
                        </div>
                    </div>

                    <!-- ROL -->
                    <div class="form-group">
                        <label for="mail" class="col-md-3 control-label">Rols:</label>
                        <div class="col-md-9">
                            <?php
                            if ($usuario->getAdmin() == 0)
                                echo "<label for='name' class='col-md-3 control-label'><span class='label label-info'>Normal</span></label>";
                            else
                                echo "<label for='name' class='col-md-3 control-label'><span class='label label-warning'>Admin</span></label>";
                            ?>

                        </div>
                    </div>

                    <!-- Direccion -->
                    <div class="form-group" <?php echo (!empty($direErrErr)) ? 'error: ' : ''; ?>>
                        <label for="password" class="col-md-3 control-label">Dirección:</label>
                        <div class="col-md-9">
                            <label for="name"
                                   class="col-md-3 control-label"><?php echo $usuario->getDireccion(); ?></label>
                        </div>
                    </div>

                    <div class="form-group">

                        <!-- Campo oculto -->
                        <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                        <!-- Button -->
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn btn btn-danger"><span
                                        class="glyphicon glyphicon-remove"></span> Eliminar
                            </button>
                            <a href="usuarios.php" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span>
                                Volver</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>

