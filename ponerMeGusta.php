<?php
    session_start();
    require "BD.php";
    $idMensaje=$_POST['idMensaje'];
    $idLogueado=$_SESSION['id'];
    $sql= "INSERT INTO me_gusta(usuarios_id, mensaje_id) VALUES ($idLogueado, $idMensaje)";
    if (mysqli_query($conn, $sql)){
        echo "Me gusta asignado";
    }
    else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
?>