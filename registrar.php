<?php
    require 'BD.php';
    if ((!empty($_POST['apellidos'])) && (!empty($_POST['nombre'])) && (!empty($_POST['clave']))){
        $apellido = $_POST['apellidos'];
        $nombre = $_POST['nombre'];
        $clave =  $_POST['clave'];
        $clave2 =  $_POST['clave2'];
        $email =  $_POST['correo'];
        $nombreUsuario =  $_POST['usuario'];
        $folder = 'images';
        $imagenName = $_FILES['img']['name'];
        $imagenTmp = $_FILES['img']['tmp_name'];
        $imagenType = $_FILES['img']['type'];
        move_uploaded_file($imagenTmp, $folder.'/'.$imagenName);
        $bytesImagen = file_get_contents($folder.'/'.$imagenName);
        $tipo=substr($imagenType, 6);
        $sql = "INSERT INTO usuarios(apellido, nombre, contrasenia, email, nombreUsuario) VALUES ('$apellido', '$nombre', '$clave', '$email', '$nombreUsuario') "; 
        $sql2 = "INSERT INTO usuarios( foto_contenido, foto_tipo) VALUES (?,?)";
        $stm = $conn->prepare($sql2);
        $stm->bind_param( 'ss', $bytesImagen, $tipo);
        $stm->execute();
        
        if (mysqli_query($conn, $sql)) {
            echo "Nuevo registro.";
        }
        else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    $sql = "SELECT * FROM usuarios";
    $stm = $conn->query($sql);
    
    while ($datos = $stm->fetch_object()){ 
        
        $f = base64_encode($datos->foto_contenido);?>
        <p> <img width="30px" src="data:image/jpg; base64, <?php echo  $f ?>"  ></p>
    
    <?php } ?>