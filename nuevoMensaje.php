<?php
    require 'BD.php';
    session_start();
    $usuario = $_SESSION['usuario'];
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    
    $texto = $_POST['nuevoMensaje'];
    $imagenTmp = $_FILES['img']['tmp_name'];
    $imagenType = $_FILES['img']['type'];
    $bytesImagen = addslashes(file_get_contents($imagenTmp));
    $tipo=substr($imagenType, 6);
    $rs=mysqli_query($conn, "SELECT id FROM usuarios WHERE nombreusuario='$usuario' ");
    if ($row = mysqli_fetch_row($rs)) {
        $id = trim($row[0]);
    }
    $sql1 = "INSERT INTO mensaje(texto, imagen_contenido, imagen_tipo, usuarios_id, fechayhora) VALUES ('$texto', '$bytesImagen' , '$tipo' , '$id' , 'current_Date()') ";
    if (mysqli_query($conn, $sql1)) {
        echo "Nuevo mensaje.";
    }
    else{
        echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
    }
?>
