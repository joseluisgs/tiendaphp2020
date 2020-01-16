<?php


/**
 * Description of Usuario
 *
 * @author link
 */
class Usuario {
    //put your code here
    private $id;
    private $nombre;
    private $alias;
    private $pass;
    private $email;
    private $direccion;
    private $imagen;
    private $admin;



    public function __construct($id, $nombre, $alias, $email, $pass, $direccion, $imagen, $admin) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->alias = $alias;
        $this->pass = $pass;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->imagen = $imagen;
        $this->admin = $admin;
    }

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getAlias() {
        return $this->alias;
    }


    function getEmail() {
        return $this->email;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setAlias($alias) {
        $this->alias = $alias;
    }


    function setEmail($email) {
        $this->email = $email;
    }


    function getImagen() {
        return $this->imagen;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    function getPass() {
        return $this->pass;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getAdmin() {
        return $this->admin;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function setDireccion($dir) {
        $this->direccion = $direccion;
    }

    function setAdmin($admin) {
        $this->admin = $admin;
    }



}

