<?php
    require 'BD.php';
    if (   (  !empty($_POST['apellidos']) )  && (  !empty($_POST['nombre'])  ) && (  !empty($_POST['clave']) )  &&  (  !empty($_POST['clave2']) )  &&  (  !empty($_POST['usuario']) ) &&  (  !empty($_POST['correo']) ) &&  (  !empty($_FILES['img']['name']) ) )
    {
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
        
        
        $sql1 = "INSERT INTO usuarios(nombre,apellido, email,foto_tipo, nombreUsuario,foto_contenido, contrasenia) VALUES ('$nombre','$apellido','$email','$tipo','$nombreUsuario','$bytesImagen', '$clave') "; 
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
