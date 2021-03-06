<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once VIEW_PATH . "cabecera.php";

// como esta página está restringida a usuarios administradores si no está logueado como admin
// lo remitirá a la pagina de inicio
// rol:1 administrador
if ((($_SESSION['rol']) != 1) || (!isset($_SESSION['nombre']))) {
    alerta("Operación no permitida", "error.php");
    exit();
}

// Compramos la existencia del parámetro id antes de usarlo
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = decode($_GET["id"]);
    // Cargamos el controlador
    $controlador = ControladorUsuario::getControlador();
    $usuario = $controlador->buscarUsuarioID($id);

}

//si no existe el usuario lo enviamos a error para que no haga nada
if (is_null($usuario)) {
    // hay un error
    alerta("Operación no permitida", "error.php");
    exit();
}
?>


<!-- Cuerpo de la página web -->
<div class="container">
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Ficha de usuario/a</div>
            </div>
            <div class="panel-body">


                <!-- Imagen -->
                <div class="form-group">
                    <img src='../img_usuarios/<?php echo $usuario->getImagen(); ?>' class='center-block' class='rounded'
                         class='img-thumbnail' width='80' height='auto' enctype="multipart/form-data">
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
                        <label for="name" class="col-md-3 control-label"><?php echo $usuario->getNombre(); ?></label>
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
                        <label for="name" class="col-md-3 control-label"><?php echo $usuario->getDireccion(); ?></label>
                    </div>
                </div>


                <div class="form-group">
                    <!-- Button -->
                    <div class="col-md-offset-3 col-md-9">
                        <p><a href="javascript:history.go(-1)" class="btn btn-primary"><span
                                        class="glyphicon glyphicon-ok"></span> Aceptar</a></p>
                        <?php
                        echo "<a href='/tienda/utilidades/descargas.php?opcion=USR_PDF&id=" . encode($usuario->getId()) . " ' class='btn pull-right' target='_blank'><span class='glyphicon glyphicon-download'></span>  PDF</a>";
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>

