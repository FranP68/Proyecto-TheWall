<?php 

function comprobar_nombre($nombre){
    //compruebo que el tamaño del string sea válido.
    if (strlen($nombre)<1 || strlen($nombre)>30){
       echo $nombre . " no es válido<br>";
       return false;
    }
 
    //compruebo que los caracteres sean los permitidos
    $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for ($i=0; $i<strlen($nombre); $i++){
       if (strpos($permitidos, substr($nombre ,$i,1))===false){
          echo $nombre . " no es válido<br>";
          return false;
       }
    }
    echo $nombre . " es válido<br>";
    return true;
 }




if(isset($_POST['submit'])){
    $apellido = $_POST['apellidos'];
    $nombre = $_POST['nombre'];
    $email =  $_POST['correo'];

    comprobar_nombre($nombre); //comprueba si el nombre esta bien

    comprobar_nombre($apellido); //comprueba si el apellido esta bien

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo"<p> El correo es incorrecto </p>";
        }
        echo"<p> El correo es correcto</p>";
}
else{
    echo"<p> salgo por el else </p>";
//header("location: index.html");
}
?>