<?php 

function comprobar_nombre_usuario($nombre_usuario){
    //compruebo que el tamaño del string sea válido.
    if (strlen($nombre_usuario)<6 || strlen($nombre_usuario)>30){
       echo $nombre_usuario . " no es válido<br>";
       return false;
    }
 
    //compruebo que los caracteres sean los permitidos
    $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for ($i=0; $i<strlen($nombre_usuario); $i++){
       if (strpos($permitidos, substr($nombre_usuario,$i,1))===false){
          echo $nombre_usuario . " no es válido<br>";
          return false;
       }
    }
    echo $nombre_usuario . " es válido<br>";
    return true;
 }




if(isset($_POST['submit'])){
    $apellido = $_POST['apellidos'];
    $nombre = $_POST['nombre'];
    $email =  $_POST['correo'];

    comprobar_nombre_usuario($nombre); //comprueba si el nombre esta bien

    comprobar_nombre_usuario($apellido); //comprueba si el apellido esta bien

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo"<p> El correo es incorrecto </p>";
        }
        
}
else{
header("location: index.html");
}
?>