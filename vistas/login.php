<!-- Cabecera de la página web -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once VIEW_PATH . "cabecera.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $pass = md5($_POST['pass']); // codificamos la contraseña con md5

    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->login($email, $pass);


    // si no encuentra el usuario te indica que son incorrectos los datos
    if (is_null($usuario)) {
        alerta("Email o password incorrectos");
    } else {
        // se loguea correctamente. Debemos comprobar si existe una cookie con ese usuario
        // si es así, pasaremos los datos de las cookies del carrito a la sessión
        // Si no existe, creamos la cookie
        // relleno los datos de la sesión e inicializo valores como valor del carrito
        $cs = ControladorSesion::getControlador();
        $cs->crearSesion($usuario);
        $cs->crearCookie();
        //buscarCookie();
        alerta('Bienvenid@: ' . $_SESSION['alias'], "../index.php");
        //destruirCookie();
    }
}
?>
<!-- Cuerpo de la página web -->
<div class="container">
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Indentificación</div>
                <div style="float:right; font-size: 80%; position: relative; top:-10px"></div>
            </div>

            <div style="padding-top:30px" class="panel-body">

                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                <form id="loginform" class="form-horizontal" role="form"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="email" type="email" class="form-control" name="email" value="" placeholder="email"
                               required="">
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="pass" type="password" class="form-control" name="pass" placeholder="password"
                               required="" placeholder="Direccion">
                    </div>


                    <div class="input-group">
                        <div class="checkbox">
                            <label>
                                <input id="login-remember" type="checkbox" name="remember" value="1"> Recordar
                                contraseña
                            </label>
                        </div>
                    </div>


                    <div style="margin-top:10px" class="form-group">
                        <!-- Button -->

                        <div class="col-sm-12 controls">

                            <button type="submit" id="btn-signup" type="button" class="btn btn-primary"><span
                                        class="glyphicon glyphicon-log-in"></span> &nbsp Identificarse / Login
                            </button>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-12 control">
                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                Si no tienes cuenta!
                                <a href="registro.php">
                                    Regístrate aquí
                                </a>
                            </div>
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