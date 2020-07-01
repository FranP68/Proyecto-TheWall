<?php
    session_start();
    require "BD.php";
    $idMensaje=$_POST['idMensaje'];
    $idLogueado=$_SESSION['id'];
    $sql= "DELETE FROM me_gusta WHERE $idLogueado=usuarios_id AND $idMensaje=mensaje_id";
    if (mysqli_query($conn, $sql)){
        echo "Ya no me gusta asignado";
        header('Location:' . getenv('HTTP_REFERER'));//si se quiere ver los mensajes comentar la redireccion
    
    }
    else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
?>