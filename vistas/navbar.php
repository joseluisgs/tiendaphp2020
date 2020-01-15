<?php
$cp = ControladorProducto::getControlador();
$secciones = $cp->mostrarSecciones();
?>
<!-- ¡Barra de navegacion -->
<nav class="navbar navbar-inverse navbar-fixed-top">

    <div class="container-fluid">
        <div class="navbar-header">

            <a href=<?php echo DIRECTORIO_PATH . "index.php"; ?>><image class="navbar-brand" src='<?php echo DIRECTORIO_PATH . "images/logo.png"; ?>'> </a>
        </div>
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Artículos <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href=<?php echo DIRECTORIO_PATH . "index.php"; ?>>Todos</a></li>
                    <?php
                    // Mostramos el menú según tipo de usuarios
                    foreach ($secciones as $seccion => $tipo) {
                        echo " <li><a href='" . DIRECTORIO_PATH . "index.php?seccion=" . $tipo->nombre . "'>" . $tipo->nombre . "</a></li>";
                    }
                    ?>
                </ul>
            </li>

            </li>
            <?php
            // Si el usuario se ha autenticado y es administrador rol:0, mostrarmos panel de productos
            if ((isset($_SESSION['nombre']) && ($_SESSION['rol'])==1)) {
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración y Gestión <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href=<?php echo DIRECTORIO_PATH . "vistas/gestionProductos.php"; ?>>Productos</a></li>
                        <li><a href=<?php echo DIRECTORIO_PATH . "vistas/gestionUsuarios.php"; ?>>Usuarios</a></li>
                    </ul>
                </li>

            <?php } ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">



            <?php
            // Si usuairo identificado mostramos nombre, si no muestra registro/login


            if (isset($_SESSION['nombre'])) {

                $itemscarrito = $_SESSION['uds'] != 0 ? "<font color='darksalmon'> ".$_SESSION['uds']."</font>":"";
                echo "<li><a href='/tienda/vistas/carritoMostrar.php' class='cart-link' title='Ver Carrito'> <b>".$itemscarrito."</b> <span class='glyphicon glyphicon-shopping-cart'></span></a></li>";
                echo "<li><a href='/tienda/vistas/usuarioUpdate.php?id=".$_SESSION['id_usuario']."&email=".$_SESSION['email']."'><span class='glyphicon glyphicon-user'></span> ". $_SESSION['email']. " </a></li>";
                echo "<li><a href='/tienda/vistas/logout.php'><span class='glyphicon glyphicon glyphicon-log-out'></span> Cerrar sesión </a></li>";

            } else {
                ?>

                <li><a href=<?php echo "/tienda/vistas/registro.php"; ?>><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>
                <li><a href=<?php echo "/tienda/vistas/login.php"; ?>><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>
<br><br>
