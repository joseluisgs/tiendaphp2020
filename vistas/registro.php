<!-- Cabecera de la página web -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once VIEW_PATH . "cabecera.php";

// Variables temporales
$nombre = $alias = $email = $pass = $dire = $imagen = "";
$nombreErr = $aliasErr = $emailErr = $passErr = $direErr = $imagenErr = "";
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Filtramos el nombre
    $nombre = filtrado($_POST['nombre']);
    if (empty($nombre)) {
        $nombreErr = "El nombre no es correcto o no puede estar vacío";
        $errores[] = $nombreErr;
    }

    //Filtramos el alias
    $alias = filtrado($_POST['alias']);
    if (empty($alias)) {
        $aliasErr = "El alias no es correcto o no puede estar vacío";
        $errores[] = $aliasErr;
    }

    // Filtramos el email
    $email = filtrado($_POST['email']);
    if (empty($email)) {
        $emailErr = "El email no es correcto o no puede estar vacío";
        $errores[] = $emailErr;
    }

    //comprobamos que el mail no esá en uso
    $controlador = ControladorUsuario::getControlador();
    if ($controlador->buscarEmail($email) != 0) {
        $emailErr = "Ya existe un usuario en la BD con dicho correo electrónico";
        $errores[] = $emailErr;
    }

    // Filtramos el Password
    $pass = md5(filtrado($_POST['pass'])); // codificamos la contraseña con md5
    echo $pass;
    if (empty($pass)) {
        $passErr = "El password no es correcto o no pude ser vacío";
        $errores[] = $passErr;
    }

    // Filtramos el Password
    $dire = filtrado($_POST['direccion']);
    if (empty($dire)) {
        $direErr = "La dirección no puede ser vacía";
        $errores[] = $direErr;
    }

    // Procesamos la foto si no hay errores Para evitar cargarla varias veces
    if (count($errores) == 0) {

        $propiedades = explode("/", $_FILES['imagen']['type']);
        $extension = $propiedades[1];
        // salvamos la imagen

        $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'] . time()) . "." . $extension;
        $ci = ControladorImagen::getControlador();
        if (!$ci->salvarImagen($_FILES['imagen']['tmp_name'], USERS_IMAGES_PATH, $imagen)) {
            $imagenErr = "No se ha podido subir la imagen en el servidor";
            $errores[] = $imagenErr;


        }
    }


    // Si no hay errores insertamos
    if (count($errores) == 0) {

        $usuario = new Usuario(0, $nombre, $alias, $email, $pass, $dire, $imagen, 0);
        $cu = ControladorUsuario::getControlador();
        if ($estado = $cu->insertarUsuario($usuario)) {
            alerta("Se ha registrado correctamente", "login.php");
            exit();
        }
    } else {
        alerta("Existen errores en el formulario");
    }
}

?>
<!-- Cuerpo de la página web -->
<div class="container">
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Registrarse</div>
                <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink"
                                                                                           href="login.php">Login</a>
                </div>
            </div>
            <div class="panel-body">
                <form id="signupform" class="form-horizontal" role="form"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                      enctype="multipart/form-data">

                    <div id="signupalert" style="display:none" class="alert alert-danger">
                        <p>Error:</p>
                        <span></span>
                    </div>


                    <!-- Imagen -->
                    <div class="form-group">
                        <img src='../images/sinfoto.png' class='center-block' class='rounded' class='img-thumbnail'
                             width='50' height='auto' enctype="multipart/form-data">
                    </div>

                    <!-- Nombre -->
                    <div class="form-group" <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>>
                        <label for="name" class="col-md-3 control-label">Nombre:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre y apellidos"
                                   required
                                   value="<?php echo $nombre; ?>"
                                   pattern="([^\s][A-zÀ-ž\s]+)"
                                   title="El nombre no puede contener números"
                                   minlength="3">
                            <span class="help-block"><?php echo $nombreErr; ?></span>
                        </div>
                    </div>

                    <!-- Alias -->
                    <div class="form-group" <?php echo (!empty($aliasErr)) ? 'error: ' : ''; ?>>
                        <label for="name" class="col-md-3 control-label">Alias:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="alias" placeholder="Alias" required
                                   value="<?php echo $alias; ?>">
                            <span class="help-block"><?php echo $aliasErr; ?></span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group" <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>>
                        <label for="mail" class="col-md-3 control-label">Email:</label>
                        <div class="col-md-9">
                            <input type="email" class="form-control" name="email" placeholder="Email" required
                                   value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $emailErr; ?></span>


                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group" <?php echo (!empty($passErr)) ? 'error: ' : ''; ?>>
                        <label for="password" class="col-md-3 control-label">Password:</label>
                        <div class="col-md-9">
                            <input type="password" class="form-control" name="pass" placeholder="Password" required
                                   minlength="5"
                                   value="">
                            <span class="help-block"><?php echo $passErr; ?></span>
                        </div>
                    </div>

                    <!-- Direccion -->
                    <div class="form-group" <?php echo (!empty($direErrErr)) ? 'error: ' : ''; ?>>
                        <label for="password" class="col-md-3 control-label">Dirección:</label>
                        <div class="col-md-9">
                            <textarea type="text" class="form-control" name="direccion" placeholder="Direccion"
                                      required><?php echo $dire; ?></textarea>
                            <span class="help-block"><?php echo $direErr; ?></span>
                        </div>
                    </div>

                    <!-- Imagen -->
                    <div class="form-group" <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                    <label for="imagen" class="col-md-3 control-label">Imagen:</label>
                    <div class="col-md-9">
                        <input type="file" required name="imagen" class="form-control-file" id="imagen"
                               accept="image/jpeg">
                        <span class="help-block"><?php echo $imagenErr; ?></span>
                    </div>
            </div>


            <div class="form-group">
                <!-- Button -->
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn btn-info"><span class="glyphicon glyphicon-ok"></span> Aceptar
                    </button>
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