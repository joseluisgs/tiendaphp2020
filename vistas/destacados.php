<?php
    $cu = ControladorProducto::getControlador();
    $destacados = $cu->listarDestacados();

    if(!is_null($destacados) && count($destacados)>0) {
        ?>


        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Destacados</h1>
            <p class="lead">Productos destacados de la semana.</p>

            <div class="container" style="margin-top:50px;" id="ofertas">

                <!-- Fila -->
                <div class="row">
                    <?php
                    // Recorremos todos
                    foreach ($destacados as $p) {
                        ?>
                        <!-- Item -->
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="col-item col-md-12">
                                <div class="post-img-content">
                                    <a href ='<?php echo "/tienda/vistas/producto.php?id=" . encode($p->getId())?>'>
                                        <img src='/tienda/img_productos/<?php echo $p->getImagen(); ?>' class="center-block"
                                             class="img-responsive" width='220px' height='auto'/></a>
                                    <span class="post-title">
                        <b><?php echo $p->getTipo();?></b>
                                </span><span class="round-tag">-<?php echo $p->getOferta();?>%</span>
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-12">
                                            <h5> <?php echo $p->getMarca(). " " . $p->getModelo();?></h5>
                                        </div>
                                        <div class="price col-md-12">
                                            <h4 class="price-text-color"><?php echo $p->getPrecio();?> €</h4>
                                        </div>
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i>
                                            <?php
                                            // Si está logueado, vamos al carrito, si no a login
                                            if(isset($_SESSION['id_usuario'])){
                                                // Metemos al carrito.
                                                echo "<a href='/tienda/vistas/producto.php?id=" . encode($p->getId()) ."' class='hidden-sm'>Comprar</a>";
                                            }else{
                                                echo "<a href='/tienda/vistas/login.php' class='hidden-sm'>Comprar</a>";
                                            }
                                            ?>


                                        </p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a href='<?php echo "/tienda/vistas/producto.php?id=" . encode($p->getId())?>' class="hidden-sm">Detalles</a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>

                    <!--Fin de fila -->
                </div>

            </div>
        </div>
        <?php
    }
?>
<br><br>