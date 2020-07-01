<?php
include 'claseVerificar.php';
require 'BD.php';

if ((!empty($_POST['usuario']))  && (!empty($_POST['clave']))) {
    $clave =  $_POST['clave'];
    $nombreUsuario =  $_POST['usuario'];

    try {
        if (Verificar::usuario_duplicado($nombreUsuario, $error_usuarioDuplicado)) {
            throw new Exception("El usuario no existe");
            //header("Location:index.php"); //comentar si se quiere ver la validacion
        }
    } catch (Exception $e) {
        echo $e;
    }
    if (Verificar::obtener_claveUsuario($nombreUsuario, $clave, $error_coincideClaveUsuario)) {
        session_start();
        $rs = mysqli_query($conn, "SELECT nombre FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
        if ($row = mysqli_fetch_row($rs)) {
            $nombre = trim($row[0]);
        }
        $rs = mysqli_query($conn, "SELECT apellido FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
        if ($row = mysqli_fetch_row($rs)) {
            $apellido = trim($row[0]);
        }

        $rs = mysqli_query($conn, "SELECT email FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
        if ($row = mysqli_fetch_row($rs)) {
            $email = trim($row[0]);
        }

        $_SESSION['usuario'] = $nombreUsuario;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        $_SESSION['email'] = $email;
        $_SESSION['clave'] = $clave;
        //obtengo id de usuario
        $rs = mysqli_query($conn, "SELECT id FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
        if ($row = mysqli_fetch_row($rs)) {
            $id = trim($row[0]);
        }
        $_SESSION['id'] = $id;
        header("Location:inicio.php");
    } else {
        echo "$error_coincideClaveUsuario";
        //header("Location:index.php"); //comentar si quiero ver la validacion de php

    }
} else {
    //header("Location:index.php"); //comentar si quiero ver la validacion de php
    echo "Todos los campos son requeridos";
}
