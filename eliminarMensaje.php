<?php 
    require "BD.php";
    session_start();
    $idLogueado = $_SESSION["id"];
    $idMensaje=$_POST['idMensaje'];
    $sql= "DELETE FROM me_gusta WHERE $idMensaje=mensaje_id ";
    mysqli_query($conn, $sql);
    $sql= "DELETE FROM mensaje WHERE $idMensaje=id ";
    if(mysqli_query($conn, $sql)){
        echo "Mensaje eliminado";
        header('Location:' . getenv('HTTP_REFERER'));//si se quiere ver los mensajes comentar la redireccion
    }

?>