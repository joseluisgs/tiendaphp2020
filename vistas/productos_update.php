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

// Variables temporales
$id = $marca = $modelo = $tipo = $descripcion= $precio = $stock = $oferta= $imagen = $disponible = $fecha= "";
$idErr = $marcaErr = $modeloErr = $tipoErr = $descripcionErr= $precioErr = $stockErr = $ofertaErr= $imagenErr = $disponibleErr = $fechaErr= "";
$errores=[];


// Comprobamos que existe el id antes de ir más lejos
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = decode($_GET["id"]);
    $controlador = ControladorProducto::getControlador();
    $producto = $controlador->buscarProductoID($id);
    if (!is_null($producto)) {
        $marca = $producto->getMarca();
        $modelo = $producto->getModelo();
        $tipo = $producto->getTipo();
        $descripcion= $producto->getDesc();
        $precio = $producto->getPrecio();
        $stock = $producto->getStock();
        $oferta= $producto->getOferta();
        $disponible = $producto->getDisponible();
        $fecha= $producto->getFecha();
        $imagen = $producto->getImagen();
        $imagenAnterior = $imagen;
    } else {
        // hay un error
        alerta("Operación no permitida", "error.php");
        exit();
    }
}


// Procesamos el POST, es decir el botón borrar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errores=[];
    $id = $_POST['id'];

    // Filtramos la marca
    $marca = filtrado($_POST['marca']);
    if (empty($marca)) {
        $marcaErr = "La marca no es correcta o no puede estar vacía";
        $errores[] = $marcaErr;
    }

    // Filtramos modelo
    $modelo = filtrado($_POST['modelo']);
    if (empty($modelo)) {
        $modeloErr = "El modelo no es correcto o no puede estar vacío";
        $errores[] = $modeloErr;
    }

    // Filtramos descripción
    $descripcion= filtrado($_POST['descripcion']);
    if (empty($descripcion)) {
        $descripcionErr = "La descripción no es correcta o no puede estar vacía";
        $errores[] = $descripcionErr;
    }

    // Procesamos el tipo
    if(isset($_POST["tipo"])){
        $tipo = filtrado($_POST["tipo"]);
    }else{
        $tipoErr = "Debe elegir una opción de tipo obligatoriamente";
        $errores[] = $tipoErr;
    }

    // Filtramos precio
    $precio= filtrado($_POST['precio']);
    if (empty($precio)|| $precio<0) {
        $precioErr = "El precio no es correcto o no puede estar vacío";
        $errores[] = $precioErr;
    }

    // Filtramos unidades
    $stock= filtrado($_POST['stock']);
    if ($stock<0) {
        $stockErr = "El stock de unidades no es correcto o no puede estar vacío";
        $errores[] = $stockErr;
    }

    // Procesamos el oferta
    if(isset($_POST["oferta"])){
        $oferta = filtrado($_POST["oferta"]);
    }else{
        $ofertaErr = "Debe elegir una opción de oferta obligatoriamente";
        $errores[] = $ofertaErr;
    }


    // Procesamos el disponibilidad
    if(isset($_POST["disponible"])){
        $disponible = filtrado($_POST["disponible"]);
    }else{
        $disponibleErr = "Debe elegir una opción de disponibilidad obligatoriamente";
        $errores[] = $disponibleErr;
    }

    // Procesamos fecha
    $fecha = date("d-m-Y", strtotime(filtrado($_POST["fecha"])));
    $hoy = date("d-m-Y", time());

    // Comparamos las fechas
    $fecha_alta = new DateTime($fecha);
    $fecha_hoy = new DateTime($hoy);

    //echo $fecha_alta->format('Y-m-d').'<br>';
    //echo $fecha_hoy->format('Y-m-d').'<br>';

    $interval = $fecha_hoy->diff($fecha_alta);

    if($interval->format('%R%a días')>0){
        $fechaErr = "La fecha no puede ser superior a la fecha actual: ". $fecha_hoy->format('d/m/Y');
        $errores[] = $fechaErr;

    }else{
        $fecha = date("d/m/Y",strtotime($fecha));
    }

    // Procesamos la foto si no hay errores Para evitar cargarla varias veces
    if ($_FILES['imagen']['size']>0 && count($errores) == 0) {
        // actualizamos la imagen manteniendo el nombre que tenía
        $imagen=$_POST["imagenAnterior"];
        $ci = ControladorImagen::getControlador();
        if (!$ci->salvarImagen($_FILES['imagen']['tmp_name'], PRODUCTS_IMAGES_PATH.$imagen)) {
            $imagenErr = "No se ha podido subir la imagen en el servidor";
            $errores[] = $imagenErr;
        }
    }else{
        $imagen = trim($_POST["imagenAnterior"]);
    }

    // Si no hay errores insertamos
    if (count($errores) == 0) {
        $cu = ControladorProducto::getControlador();
        $fecha = getfechaBD($fecha);
        $producto = new Producto($id, $tipo, $marca, $modelo, $descripcion, $precio, $stock, $oferta, $disponible, $fecha, $imagen);
        if ($estado = $cu->actualizarProducto($producto)) {
            alerta("Producto actualizado correctamente", "productos.php");
            exit();
        }
    }else{
        $imagen=trim($_POST["imagenAnterior"]);
        alerta("Existen errores en el formulario: ".$errores[0],"productos_update.php?id=" . encode($id));
    }
}

?>
    <!-- Cuerpo de la página web -->
    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-10 col-md-offset-1 col-sm-1 col-sm-offset-1">

            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="panel-title">Actualizar Producto</div>
                </div>
                <div class="panel-body" >
                    <form id="signupform" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

                        <div class="container">
                            <div class="row">
                                <!-- Columna Izquierda -->
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="text-center">
                                        <img src='../img_productos/<?php echo $producto->getImagen(); ?>' class = 'center-block' class='avatar img-thumbnail' alt='imagen' width='215' height='auto'>
                                        <h6>Sube una imagen del producto</h6>
                                        <!-- Imagen -->
                                        <div class="form-group" <?php echo (!empty($imagenErr)) ? 'error: ' : ''; ?>">
                                            <input type="file" name="imagen" class="form-control-file" id="imagen" accept="image/jpeg">
                                            <span class="help-block"><?php echo $imagenErr;?></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Columna de la derecha-->
                                <div class="col-md-8 col-sm-3 col-xs-12 personal-info">
                                    <!-- ID -->
                                    <!-- Marca-->
                                    <div class="form-group" <?php echo (!empty($marcaErrErr)) ? 'error: ' : ''; ?>>
                                        <label for="marca" class="col-lg-1 control-label">Marca:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="marca" placeholder="marca" required
                                                   value="<?php echo $marca; ?>"
                                                   minlength="3">
                                            <span class="help-block"><?php echo $marcaErr;?></span>
                                        </div>
                                    </div>
                                    <!-- Modelo-->
                                    <div class="form-group" <?php echo (!empty($modeloErr)) ? 'error: ' : ''; ?>>
                                        <label for="modelo" class="col-lg-1 control-label">Modelo:</label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="modelo" placeholder="modelo" required
                                                   value="<?php echo $modelo; ?>"
                                                   minlength="3">
                                            <span class="help-block"><?php echo $modeloErr;?></span>
                                        </div>
                                    </div>
                                    <!-- Descripción-->
                                    <div class="form-group" <?php echo (!empty($descripcionErr)) ? 'error: ' : ''; ?>>
                                        <label for="descripcion" class="col-lg-1 control-label">Descrip.:</label>
                                        <div class="col-lg-6">
                                            <textarea type="text" class="form-control" name="descripcion" placeholder="descripción"
                                                      required><?php echo $descripcion ?></textarea>
                                            <span class="help-block"><?php echo $descripcionErr;?></span>
                                        </div>
                                    </div>

                                    <!-- Tipo -->
                                    <div class="form-group" <?php echo (!empty($tipoErr)) ? 'error: ' : ''; ?>>
                                        <label for="rol" class="col-lg-1 control-label">Tipo:</label>
                                        <div class="col-lg-6">
                                            <select name="tipo">
                                                <option value="Ordenador" <?php echo (strstr($tipo, 'Ordenador')) ? 'selected' : ''; ?>>Ordenador</option>
                                                <option value="Monitor" <?php echo (strstr($tipo, 'Monitor')) ? 'selected' : ''; ?>>Monitor</option>
                                                <option value="Otros" <?php echo (strstr($tipo, 'Otros')) ? 'selected' : ''; ?>>Otros</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Precio-->
                                    <div class="form-group" <?php echo (!empty($precioErr)) ? 'error: ' : ''; ?>>
                                        <label for="precio" class="col-lg-1 control-label">Precio:</label>
                                        <div class="col-lg-6">
                                            <input type="number" class="form-control" name="precio" placeholder="1.00" required
                                                   value="<?php echo $precio; ?>"
                                                   min="0.00", step="0.01">
                                            <span class="help-block"><?php echo $precioErr;?></span>
                                        </div>
                                    </div>

                                    <!-- Stock -->
                                    <div class="form-group" <?php echo (!empty($stockErr)) ? 'error: ' : ''; ?>>
                                        <label for="stock" class="col-lg-1 control-label">Stock:</label>
                                        <div class="col-lg-6">
                                            <input type="number" class="form-control" name="stock" placeholder="1" required
                                                   value="<?php echo $stock; ?>"
                                                   min="0", step="1">
                                            <span class="help-block"><?php echo $stockErr;?></span>
                                        </div>
                                    </div>

                                    <!-- Oferta -->
                                    <div class="form-group" <?php echo (!empty($ofertaErr)) ? 'error: ' : ''; ?>>
                                        <label for="oferta" class="col-lg-1 control-label">Oferta:</label>
                                        <div class="col-lg-6">
                                            <select name="oferta">
                                                <option value="0" <?php echo (strstr($oferta, '0')) ? 'selected' : ''; ?>>No</option>
                                                <option value="1" <?php echo (strstr($oferta, '1')) ? 'selected' : ''; ?>>Sí</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Disponibilidad -->
                                    <div class="form-group" <?php echo (!empty($disponibleErr)) ? 'error: ' : ''; ?>>
                                        <label for="disponible" class="col-lg-1 control-label">Dispo.:</label>
                                        <div class="col-lg-6">
                                            <select name="disponible">
                                                <option value="1" <?php echo (strstr($disponible, '1')) ? 'selected' : ''; ?>>Sí</option>
                                                <option value="0" <?php echo (strstr($disponible, '0')) ? 'selected' : ''; ?>>No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Fecha -->
                                    <div class="form-group" <?php echo (!empty($fechaErr)) ? 'error: ' : ''; ?>>
                                        <label for="stock" class="col-lg-1 control-label">Fecha:</label>
                                        <div class="col-lg-6">
                                            <input type="date" required name="fecha"
                                            <?php
                                            if($fecha=="")
                                                echo "value='". date('Y-m-d', time())."'>";
                                            else
                                                echo "value='". date('Y-m-d', strtotime(str_replace('/', '-', $fecha)))."'>";
                                            ?>
                                            <span class="help-block"><?php echo $fechaErr;?></span>
                                        </div>
                                    </div>

                                    <!-- Campos ocultos -->
                                    <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                                    <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>"/>

                                    <!-- Botones -->
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <button type="submit" class="btn btn btn-warning"> <span class="glyphicon glyphicon-refresh"></span>  Aceptar</button>
                                            <a href="javascript:history.go(-1)" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Volver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>

    <br>
    <!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>