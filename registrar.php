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
        // move_uploaded_file($imagenTmp, $folder.'/'.$imagenName);
        // $bytesImagen = file_get_contents($folder.'/'.$imagenName);
        $bytesImagen = addslashes(file_get_contents($imagenTmp));
        $tipo=substr($imagenType, 6);
        
        // $sql = "INSERT INTO usuarios(foto_contenido, foto_tipo, nombreUsuario) VALUES (?,?,?) "; 
        $sql1 = "INSERT INTO usuarios(nombre,apellido, email,foto_tipo, nombreUsuario,foto_contenido, contrasenia) VALUES ('$nombre','$apellido','$email','$tipo','$nombreUsuario','$bytesImagen', '$clave') "; 
        // $stm = $conn->prepare($sql);
        // $stm->bind_param( 'sss', $bytesImagen, $tipo, $nombreUsuario);
        // $stm->execute();
        
        // if (mysqli_query($conn, $sql)) {
        //     echo AAAAAAAAAA;
        // }else{
        //     echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
        // }
        
        // $sql1 = " UPDATE usuarios 
        //         SET nombre = '$nombre' , apellido = '$apellido' , contrasenia = '$clave' , email = '$email'
        //         WHERE ( nombreusuario = '$nombreUsuario' ) ";
        if (mysqli_query($conn, $sql1)) {
            echo "Nuevo registro.";
        }
        else{
            echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
        }
        
    }
    //probando foto
    /*
    $sql = "SELECT * FROM usuarios";
    $stm = $conn->query($sql);
    
    while ($datos = $stm->fetch_object()){ 
        
        $f = base64_encode($datos->foto_contenido);//descomentar para probar?>
        <p> <img width="30px" src="data:image/jpg; base64, <?php echo  $f ?>"  ></p>
    
    <?php } ?>
*/
?>    
