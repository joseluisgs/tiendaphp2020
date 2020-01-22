<?php

/*
 * Vamos a usar la libreria HTML2PF, para ello desde la raiz de nuestro proyecto, es decir
 * dentro de la carpeta tienda ejecutamos
 * composer require spipu/html2pdf
 */

// Incluimos los ficheros que ncesitamos

require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once CONTROLLER_PATH . "ControladorSesion.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";

require_once UTILITY_PATH . "funciones.php";

// Para PDF
require_once VENDOR_PATH . "autoload.php";
use Spipu\Html2Pdf\HTML2PDF;


/**
 * Controlador de descargas
 */
class ControladorDescargas
{

    // Configuración del servidor
    private $fichero;

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct()
    {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia del Controlador de Descargas
     * @return instancia de conexion
     */
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorDescargas();
        }
        return self::$instancia;
    }


    /**
     * Descarga los Usuarios en JSON
     */
    public function usuariosJSON()
    {

        $this->fichero = "usuarios.json";
        header("Content-Type: application/octet-stream");
        header('Content-type: application/json');
        //header("Content-Disposition: attachment; filename=" . $this->fichero . ""); //archivo de salida

        $controlador = ControladorUsuario::getControlador();
        $lista = $controlador->listarUsuarios("");
        $sal = [];
        foreach ($lista as $al) {
            $sal[] = $this->json_encode_private($al);
        }
        echo json_encode($sal);
    }

    private function json_encode_private($object)
    {
        $public = [];
        $reflection = new ReflectionClass($object);
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $public[$property->getName()] = $property->getValue($object);
        }
        return json_encode($public);
    }

    /**
     * Descarga los Productos en JSON
     */
    public function productosJSON()
    {

        $this->fichero = "productoss.json";
        header("Content-Type: application/octet-stream");
        header('Content-type: application/json');
        //header("Content-Disposition: attachment; filename=" . $this->fichero . ""); //archivo de salida

        $controlador = ControladorProducto::getControlador();
        $lista = $controlador->listarProductos("");
        $sal = [];
        foreach ($lista as $al) {
            $sal[] = $this->json_encode_private($al);
        }
        echo json_encode($sal);
    }


    /**
     * Descarga los Usuarios en PDF
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     */
    public function usuariosPDF(){
        $sal ='<h2 class="pull-left">Lista de Usuarios/as</h2>';
        $lista = $controlador = ControladorUsuario::getControlador();
        $lista = $controlador->listarUsuarios("");
        if (!is_null($lista) && count($lista) > 0) {
            $sal.= "<table class='table table-bordered table-striped'>";
            $sal.= "<thead>";
            $sal.="<tr>";
            $sal.="<th>Imagen</th>";
            $sal.="<th>ID</th>";
            $sal.="<th>Nombre</th>";
            $sal.="<th>Alias</th>";
            $sal.="<th>E-Mail</th>";
            $sal.="<th>Rol</th>";
            $sal.="</tr>";
            $sal.= "</thead>";
            $sal.= "<tbody>";
            // Recorremos los registros encontrados
            foreach ($lista as $u) {
                // Pintamos cada fila
                // Pintamos cada fila
                $sal.= "<tr>";
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/tienda/img_usuarios/".$u->getImagen()."'  style='max-width: 12mm; max-height: 12mm'></td>";
                $sal.="<td>" . $u->getId() . "</td>";
                $sal.="<td>" . $u->getNombre() . "</td>";
                $sal.="<td>" . $u->getAlias() . "</td>";
                $sal.="<td>" . $u->getEmail() . "</td>";
                if($u->getAdmin()==0)
                    $sal.= "<td><span class='label label-info'>Normal</span></td>";
                else
                    $sal.= "<td><span class='label label-warning'>Admin</span></td>";
                $sal.="</tr>";
            }
            $sal.="</tbody>";
            $sal.="</table>";
        } else {
            // Si no hay nada seleccionado
            $sal.="<p class='lead'><em>No se ha encontrado datos de usuarios/as.</em></p>";
        }
        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('listado.pdf');

    }

    /**
     * Descarga los Productos en PDF
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     */
    public function productosPDF(){
        $sal ='<h2 class="pull-left">Lista de Productos</h2>';
        $lista = $controlador = ControladorProducto::getControlador();
        $lista = $controlador->listarProductos("");
        if (!is_null($lista) && count($lista) > 0) {
            $sal.= "<table class='table table-bordered table-striped'>";
            $sal.= "<thead>";
            $sal.= "<tr>";
            $sal.= "<th>Imagen</th>";
            $sal.= "<th>ID</th>";
            $sal.= "<th>Marca</th>";
            $sal.= "<th>Modelo</th>";
            $sal.= "<th>Precio</th>";
            $sal.= "<th>Unidades</th>";
            $sal.= "<th>Tipo</th>";
            $sal.= "<th>Fecha</th>";
            $sal.= "<th>Dispo.</th>";
            $sal.= "<th>Oferta</th>";
            $sal.= "</tr>";
            $sal.= "</thead>";
            $sal.= "<tbody>";
            // Recorremos los registros encontrados
            foreach ($lista as $p) {
                // Pintamos cada fila
                $sal.= "<tr>";
                $sal.="<td><img src='".$_SERVER['DOCUMENT_ROOT'] . "/tienda/img_productos/".$p->getImagen()."'  style='max-width: 12mm; max-height: 12mm'></td>";
                $sal.= "<td>" . $p->getId() . "</td>";
                $sal.= "<td>" . $p->getMarca() . "</td>";
                $sal.= "<td>" . $p->getModelo() . "</td>";
                $sal.= "<td>" . $p->getPrecio() . " €</td>";
                if($p->getStock()==0)
                    $sal.= "<td><span class='label label-danger'>". $p->getStock() . "</span></td>";
                else if($p->getStock()>0 && $p->getStock()<5)
                    $sal.= "<td><span class='label label-warning'>" .$p->getStock() . "</span></td>";
                else
                    $sal.= "<td><span class='label label-info'>" .$p->getStock() . "</span></td>";

                $sal.= "<td>" . $p->getTipo() . "</td>";
                $date = new DateTime($p->getFecha());
                $sal.= "<td>" . $date->format('d/m/Y'). "</td>";
                if($p->getDisponible()!=0)
                    $sal.= "<td><span class='label label-success'>Sí</span></td>";
                else
                    $sal.= "<td><span class='label label-danger'>No</span></td>";
                if($p->getOferta()==0)
                    $sal.= "<td><span class='label label-info'>No</span></td>";
                else
                    $sal.= "<td><span class='label label-success'>-".$p->getOferta()."%</span></td>";
                $sal.="</tr>";
            }
            $sal.="</tbody>";
            $sal.="</table>";
        } else {
            // Si no hay nada seleccionado
            $sal.="<p class='lead'><em>No se ha encontrado datos de Productos.</em></p>";
        }
        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('listado.pdf');

    }


    /**
     * Descarga el Producto en PDF
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     */
    public function productoPDF($id){
        $sal ='<h1 class="pull-left">Ficha de Producto</h1>';
        $controlador = ControladorProducto::getControlador();
        $producto= $controlador->buscarProductoID($id);

        $sal.="<img src='".$_SERVER['DOCUMENT_ROOT'] . "/tienda/img_productos/".$producto->getImagen()."'  style='max-width: 300mm; max-height: 12mm'>";
        $sal.="<h1>". $producto->getModelo(). " </h1>";
        $sal.="<h4>". $producto->getMarca(). "</h4>";
        $sal.="<h4>". $producto->getTipo()."</h4>";
        $sal.="<h4>". $producto->getPrecio(). "€</h4>";
        $sal.="<p><b>Descripción:</b></p>";
        $sal.="<p>".$producto->getDesc()."</p>";
        $sal.="<p><b>Unidades:</b>".$producto->getStock();
        $sal.="</p>";
        $sal.="<p><b>Disponible:</b>";
        if($producto->getDisponible()==0)
            $sal.= "No";
        else
            $sal.= "Sí";
        $sal.="</p>";

        $sal.="<p><b>Oferta: </b>";
        if($producto->getOferta()==0)
            $sal.= "No";
        else
            $sal.= "-".$producto->getOferta()."%";

        $sal.="</p>";
        $sal.="<p><b>Fecha: </b>";
        $date = new DateTime($producto->getFecha());
        $sal.= $date->format('d/m/Y');
        $sal.="</p>";




        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('P','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('producto.pdf');

    }

    /**
     * Descarga el Producto en PDF
     * @throws \Spipu\Html2Pdf\Exception\Html2PdfException
     */
    public function usuarioPDF($id){
        $sal ='<h1 class="pull-left">Ficha de Usuario</h1>';
        $controlador = ControladorUsuario::getControlador();
        $usuario= $controlador->buscarUsuarioID($id);

        $sal.="<img src='".$_SERVER['DOCUMENT_ROOT'] . "/tienda/img_usuarios/".$usuario->getImagen()."'  style='max-width: 300mm; max-height: 12mm'>";
        $sal.="<h2>". $usuario->getNombre(). " </h2>";
        $sal.="<h4>". $usuario->getAlias(). "</h4>";
        $sal.="<h4>". $usuario->getEmail()."</h4>";
        $sal.="<p><b>Rol:</b>";
        if($usuario->getAdmin()==0)
            $sal.= "No";
        else
            $sal.= "Sí";
        $sal.="</p>";
        $sal.="<p><b>Dirección:</b>".$usuario->getDireccion();
        $sal.="</p>";



        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('P','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('producto.pdf');

    }
}
