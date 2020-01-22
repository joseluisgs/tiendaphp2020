<!-- Cabecera de la página web -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once VIEW_PATH . "cabecera.php";

// como esta página está restringida a usuarios administradores si no está logueado como admin
// lo remitirá a la pagina de inicio
// rol:1 administrador
if ((($_SESSION['rol'])!=1) || (!isset($_SESSION['nombre']))){
    alerta("Operación no permitida", "error.php");
    exit();
}

//Comprobamos si existe un filtro de búsqueda para recuperarlo
$filtro = (isset($_REQUEST['filter']) ? $_REQUEST['filter'] : "");
$seccion = ""; // aquí no filtraremos por sección como en el navbar

?>
<?php
?>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Panel Administración de Usuarios</h2>
                </div>
                <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="buscar" class="sr-only">Titulo o descripcion</label>
                        <input type="text" class="form-control" id="buscar" name="filter" value="<?php echo $filtro ?>" placeholder="nombre o email">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"> <span class="glyphicon glyphicon-search"></span>  Buscar</button>

                    <a href="/tienda/utilidades/descargas.php?opcion=U_JSON" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  JSON</a>
                    <a href="/tienda/utilidades/descargas.php?opcion=U_PDF" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  PDF</a>
                    <a href="/tienda/vistas/usuarios_create.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-user"></span>  Añadir Usuario</a>

                </form>
            </div>
            <!-- Linea para dividir -->
            <div class="page-header clearfix">
            </div>
            <?php
            $controlador = ControladorUsuario::getControlador();
            $pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
            $enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;

            // Consulta a realizar filtraremos o bien por email o por nombre y configuramos el paginador
            $consulta = "SELECT * FROM usuarios WHERE nombre LIKE :nombre OR email LIKE :email";
            $parametros = array(':nombre' => "%".$filtro."%", ':email'=>"%".$filtro."%");
            $limite = 5; // Limite del paginador

            $paginador  = new Paginador($consulta, $parametros, $limite);
            $resultados = $paginador->getDatos($pagina);

            if(count( $resultados->datos)>0){

                // Pintamos la tabla el pass como está codificado no se mostrará
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Imagen</th>";
                echo "<th>ID</th>";
                echo "<th>Nombre</th>";
                echo "<th>Alias</th>";
                echo "<th>E-Mail</th>";
                echo "<th>Rol</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($resultados->datos as $u) {
                    // Pintamos cada fila
                    echo "<tr>";
                    echo "<td><img src='/tienda/img_usuarios/" . $u->FOTO . "' class='rounded' class='img-thumbnail' width='50' height='auto'></td>";
                    echo "<td>" . $u->ID . "</td>";
                    echo "<td>" . $u->NOMBRE . "</td>";
                    echo "<td>" . $u->ALIAS . "</td>";
                    echo "<td>" . $u->EMAIL . "</td>";
                    if($u->ADMIN==0)
                        echo "<td><span class='label label-info'>Normal</span></td>";
                    else
                        echo "<td><span class='label label-warning'>Admin</span></td>";
                    echo "<td>";
                    echo "<a href='usuarios_read.php?id=" . encode($u->ID) . "' title='Ver Usuario/a' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                    echo "<a href='usuarios_update.php?id=" . encode($u->ID) . "' title='Actualizar Usuario/a' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='usuarios_delete.php?id=" . encode($u->ID) . "' title='Borar Usuario/a' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";

                echo "<ul class='pager'>"; //  <ul class="pagination">
                echo $paginador->crearLinks($enlaces, $filtro, $seccion);
                echo "</ul>";
            } else {
                // Si no hay nada seleccionado
                echo "<p class='lead'><em>No se ha encontrado datos de uduarios/as.</em></p>";
            }
            ?>

        </div>
    </div>
</div>
<br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>

