<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once VIEW_PATH . "cabecera.php";


// Variables
$id= $nombre = $alias= $email = $pass = $dire = $rol= $imagen = $imagenAnterior="";
$nombreErr = $aliasErr = $emailErr = $passErr = $direErr= $rolErr= $imagenErr= "";
$errores=[];

// Filtramos que sea el mismo usuario



// Comprobamos que existe el id y que el mail se correspnde a este id antes de ir más lejos
if(isset($_SESSION['id_usuario']) && isset($_SESSION['email']) && isset($_GET["id"]) && !empty(trim($_GET["id"]))&& isset($_GET["email"]) && !empty(trim($_GET["email"]))) {
    $id = decode($_GET["id"]);
    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->buscarUsuarioID($id);
    if (!is_null($usuario)) {
        $id = $usuario->getId();
        $nombre = $usuario->getNombre();
        $alias = $usuario->getAlias();
        $email = $usuario->getEmail();
        $pass = $usuario->getPass();
        $dire = $usuario->getDireccion();
        $rol = $usuario->getAdmin();
        $imagen = $usuario->getImagen();
        $imagenAnterior = $imagen;

        $idSesion = $_SESSION['id_usuario'];
        $emailSesion = $_SESSION['email'];

        if(($email!==$emailSesion) || ($id!==$idSesion)){
            // hay un error
            alerta("Operación no permitida. No tiene permiso en estapágina", "error.php");
            exit();
        }
    } else {
        // hay un error
        alerta("Operación no permitida. Usuario no existe", "error.php");
        exit();
    }
}else{
    // hay un error
    alerta("Operación no permitida. Página no encontrada", "error.php");
    exit();
}



// Procesamos el POST, es decir el botón borrar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

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

    // Filtramos el email.
    $email = filtrado($_POST['email']);
    if (empty($email)) {
        $emailErr = "El email no es correcto o no puede estar vacío";
        $errores[] = $emailErr;
    }
    //comprobamos que el mail no esá en uso en otro
    $controlador = ControladorUsuario::getControlador();

    // Esta libre o que ese mail sea el mio
    if (($controlador->buscarEmail($email)!=0) && ($controlador->buscarEmail($email)!=$id)) {
        $emailErr = "Ya existe un usuario en la BD con dicho correo electrónico";
        $errores[] = $emailErr;
    }


    // Filtramos el Password
    $pass = md5(filtrado($_POST['pass'])); // codificamos la contraseña con md5
    if (empty($pass)) {
        $passErr = "El password no es correcto o no pude ser vacío";
        $errores[] = $passErr;
    }

    // Filtramos la dirección
    $dire = filtrado($_POST['direccion']);
    if (empty($dire)) {
        $direErr = "La dirección no puede ser vacía";
        $errores[] = $direErr;
    }

    // Procesamos el rol
    if (isset($_POST["rol"])) {
        $rol = filtrado($_POST["rol"]);
    } else {
        $rolErr = "Debe elegir un rol obligatoriamente";
    }

    // Procesamos la foto si no hay errores Para evitar cargarla varias veces
    if ($_FILES['imagen']['size']>0 && count($errores) == 0) {
        // actualizamos la imagen manteniendo el nombre que tenía
        $imagen=$_POST["imagenAnterior"];
        $ci = ControladorImagen::getControlador();

        if (!$ci->salvarImagen($_FILES['imagen']['tmp_name'], USERS_IMAGES_PATH . $imagen)) {
            exit();
            $imagenErr = "No se ha podido subir la imagen en el servidor";
            $errores[] = $imagenErr;
        }
    }else{
        $imagen = trim($_POST["imagenAnterior"]);
    }


    // Si no hay errores insertamos
    if (count($errores) == 0) {
        $cu = ControladorUsuario::getControlador();
        // Recupero el pass para lamacenar el cambio
        $usuario = $cu->buscarUsuarioID($id);
        $usuario = new Usuario($id, $nombre, $alias, $email, $pass, $dire, $imagen, $rol);
        if ($estado = $cu->actualizarUsuario($usuario)) {
            alerta("Usuario/a actualizado/a correctamente", "/tienda/index.php");
            exit();
        }
    }else{
        $imagen=trim($_POST["imagenAnterior"]);
        alerta("Existen errores en el formulario: ".$errores[0],"usuarios_update.php?id=" . encode($id));
    }
}

?>
    <!-- Cuerpo de la página web -->
    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Actualizar datos de usuario/a</div>
                </div>
                <div class="panel-body" >
                    <form id="signupform" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

                        <div id="signupalert" style="display:none" class="alert alert-danger">
                            <p>Error:</p>
                            <span></span>
                        </div>


                        <!-- Imagen -->
                        <div class="form-group">
                            <img src='../img_usuarios/<?php echo $usuario->getImagen(); ?>' class='center-block'
                                 class='rounded' class='img-thumbnail' width='80' height='auto'>
                        </div>

                        <!-- Nombre -->
                        <div class="form-group" <?php echo (!empty($nombreErr)) ? 'error: ' : ''; ?>>
                            <label for="name" class="col-md-3 control-label">Nombre:</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="nombre" placeholder="Nombre y apellidos" required
                                       value="<?php echo $nombre; ?>"
                                       pattern="([^\s][A-zÀ-ž\s]+)"
                                       title="El nombre no puede contener números"
                                       minlength="3">
                                <span class="help-block"><?php echo $nombreErr;?></span>
                            </div>
                        </div>

                        <!-- Alias -->
                        <div class="form-group" <?php echo (!empty($aliasErr)) ? 'error: ' : ''; ?>>
                            <label for="name" class="col-md-3 control-label">Alias:</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="alias" placeholder="Alias" required
                                       value="<?php echo $alias; ?>">
                                <span class="help-block"><?php echo $aliasErr;?></span>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group" <?php echo (!empty($emailErr)) ? 'error: ' : ''; ?>>
                            <label for="mail" class="col-md-3 control-label">Email:</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" name="email" placeholder="Email" required
                                       value="<?php echo $email; ?>">
                                <span class="help-block"><?php echo $emailErr;?></span>


                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-group" <?php echo (!empty($passErr)) ? 'error: ' : ''; ?>>
                            <label for="password" class="col-md-3 control-label">Password:</label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="pass" placeholder="Password" required
                                       minlength="5">
                                <span class="help-block"><?php echo $passErr;?></span>
                            </div>
                        </div>

                        <!-- ROL -->
                        <div class="form-group" <?php echo (!empty($rolErr)) ? 'error: ' : ''; ?>>
                            <label for="rol" class="col-md-3 control-label">Rol:</label>
                            <div class="col-md-9">
                                <select name="rol">
                                    <option value="0" <?php echo (strstr($rol, '0')) ? 'selected' : ''; ?>>Normal</option>
                                    <option value="1" <?php echo (strstr($rol, '1')) ? 'selected' : ''; ?>>Administrador</option>
                                </select>
                            </div>
                        </div>

                        <!-- Direccion -->
                        <div class="form-group" <?php echo (!empty($direErrErr)) ? 'error: ' : ''; ?>>
                            <label for="password" class="col-md-3 control-label">Dirección:</label>
                            <div class="col-md-9">
                            <textarea type="text" class="form-control" name="direccion" placeholder="Direccion"
                                      required><?php echo $dire; ?></textarea>
                                <span class="help-block"><?php echo $direErr;?></span>
                            </div>
                        </div>

                        <!-- Imagen -->
                        <div class="form-group" <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                        <label for="imagen" class="col-md-3 control-label">Imagen:</label>
                        <div class="col-md-9">
                            <input type="file" name="imagen" class="form-control-file" id="imagen" accept="image/jpeg">
                            <span class="help-block"><?php echo $imagenErr;?></span>
                        </div>
                </div>

                <!-- Campos ocultos -->
                <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>"/>

                <div class="form-group">
                    <!-- Button -->
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn btn btn-warning"> <span class="glyphicon glyphicon-refresh"></span>  Actualizar</button>
                        <a href="javascript:history.go(-1)" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Volver</a>

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