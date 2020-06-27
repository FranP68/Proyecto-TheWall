<?php 

function comprobar_nombre($nombre){
    //compruebo que el tamaño del string sea válido.
    if (strlen($nombre)<1 || strlen($nombre)>30){
       return false;
    }
 
    //compruebo que los caracteres sean los permitidos
    $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for ($i=0; $i<strlen($nombre); $i++){
       if (strpos($permitidos, substr($nombre ,$i,1))===false){
          return false;
       }
    }
    return true;
 }




if(isset($_POST['submit'])){
    $apellido = $_POST['apellidos'];
    $nombre = $_POST['nombre'];
    $email =  $_POST['correo'];

    if(comprobar_nombre($nombre)){
        echo"<p> El nombre es correcto</p>";
    } 
    //comprueba si el nombre esta bien
    else{
        echo"<p> El nombre es incorrecto</p>";
    }
    if(comprobar_nombre($apellido)){
        echo"<p> El apellido es correcto</p>";
    } //comprueba si el apellido esta bien
    else{
        echo"<p> El apellido es incorrecto</p>";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo"<p> El correo es incorrecto </p>";
    }
    else{
         echo"<p> El correo es correcto</p>";
    }
       
}
else{
    //echo"<p> salgo por el else </p>";
//header("location: index.html");
}
?>