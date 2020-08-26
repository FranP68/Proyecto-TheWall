<?php
    include 'claseVerificar.php';
    require 'BD.php';
    $alert="";
    if (isset($_POST['submit'])) {
    if (   (  !empty($_POST['apellidos']) )  && (  !empty($_POST['nombre'])  ) && (  !empty($_POST['clave']) )  &&  (  !empty($_POST['clave2']) )  &&  (  !empty($_POST['usuario']) ) &&  (  !empty($_POST['correo']) ) &&  (  !empty($_FILES['img']['name']) ) )
    {   
        //obtengo datos del formulario
        $apellido = $_POST['apellidos'];
        $nombre = $_POST['nombre'];
        $clave =  $_POST['clave'];
        $clave2 =  $_POST['clave2'];
        $email =  $_POST['correo'];
        $nombreUsuario =  $_POST['usuario'];
        $imagenTmp = $_FILES['img']['tmp_name'];
        $imagenType = $_FILES['img']['type'];
        $bytesImagen = addslashes(file_get_contents($imagenTmp));
        $tipo=substr($imagenType, 6);
        //---------------
        try{
         Verificar::validar_registrar($nombreUsuario, $nombre, $apellido, $email,$clave, $clave2, $tipo, $bytesImagen);
        }
        catch(Verificar $e){
            $alert = $e->getMessage();
        }   
    } 
    
    else{
        if(  empty($_POST['nombre']) ){
            echo "El nombre no está definido"."<br>";
        }
        if(  empty($_POST['apellidos']) ){
            echo "El apellido no está definido"."<br>";
        }
        
        if(  empty($_POST['correo']) ){
            echo "El correo no está definido"."<br>";
        }
        if(  empty($_POST['usuario']) ){
            echo "El usuario no está definido"."<br>";
        }
        
        if(  empty($_POST['clave']) ){
            echo "La clave no está definida"."<br>";
        }
        if(  empty($_POST['clave2']) ){
            echo "La clave 2 no está definida"."<br>";
        }
        if(  empty($_FILES['img']['name'])){
            echo "El imagen no está definida"."<br>";
        }
        
        } 
       }
?>    




