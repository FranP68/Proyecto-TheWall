<?php
    include 'claseVerificar.php';
    require 'BD.php';
    if (   (  !empty($_POST['apellidos']) )  && (  !empty($_POST['nombre'])  ) && (  !empty($_POST['clave']) )  &&  (  !empty($_POST['clave2']) )  &&  (  !empty($_POST['usuario']) ) &&  (  !empty($_POST['correo']) ) &&  (  !empty($_FILES['img']['name']) ) )
    {   
        //obtengo datos del formulario
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
        //---------------
        
        // verificar clave
            $claveOk=Verificar::validar_clave($clave, $clave2, $error_clave);

        // ----------------------

        // verificar nombre
            $nombreOk=Verificar::validar_nombre($nombre,$error_nombre);

        // ---------------------

        // verificar apellido

        $apellidoOk=Verificar::validar_apellido($apellido,$error_apellido);
    
         // verificar email

         $emailOk = Verificar::validar_email($email, $error_email);

         // ---------------------
 
        // verificar email duplicado
         $emailDuplicadoOk = Verificar::email_duplicado($email,$error_emailDuplicado);

        // ---------------------
        $usuarioDuplicadoOk = Verificar::usuario_duplicado($nombreUsuario,$error_usuarioDuplicado);


        if($usuarioDuplicadoOk && $nombreOk && $claveOk && $apellidoOk && $emailOk && $emailDuplicadoOk ){
            //agrego nuevo usuario a la base de datos
            $sql1 = "INSERT INTO usuarios(nombre,apellido, email,foto_tipo, nombreUsuario,foto_contenido, contrasenia) VALUES ('$nombre','$apellido','$email','$tipo','$nombreUsuario','$bytesImagen', '$clave') ";
            if (mysqli_query($conn, $sql1)) {
                echo "Nuevo registro.";
                session_start();
                $_SESSION['usuario']=$nombreUsuario;
                $_SESSION['nombre']=$nombre;
                $_SESSION['apellido']=$apellido;
                //obtengo id de usuario
                $rs=mysqli_query($conn, "SELECT id FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
                if ($row = mysqli_fetch_row($rs)) {
                    $id = trim($row[0]);
                }
                $_SESSION['id']=$id;
                /* $rs = mysqli_query ($conn, " SELECT MAX(id_tabla) AS id FROM tabla " );
                if ($row = mysqli_fetch_row($rs)) {
                    $id = trim($row[0]);
                    
                }
                
                $_SESSION['id']=$id; */

                header("Location:index.php");
                
            }
            else{
                echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
            }
        }else{
            if (!$nombreOk)
                echo "$error_nombre";
            if (!$apellidoOk)
                echo "$error_apellido";
            if (!$emailOk)
                echo "$error_email";
            if (!$emailDuplicadoOk)
                echo "$error_emailDuplicado";
            if (!$usuarioDuplicadoOk)
                echo "$error_usuarioDuplicado";
            if (!$claveOk)
                echo "$error_clave";    

           // echo "El nombre de usuario ya esta en uso 11";
        }    
    }
    else{
        if(  empty($_POST['nombre']) ){
            echo "El nombre no está definido"."<br>";
        }
        if(  empty($_POST['apellidos']) ){
            echo "El apellido no está definido"."<br>";
        }
        
        if(  empty($_POST['correo']) ){
            echo "El correo no está definido"."<br>";
        }
        if(  empty($_POST['usuario']) ){
            echo "El usuario no está definido"."<br>";
        }
        
        if(  empty($_POST['clave']) ){
            echo "La clave no está definida"."<br>";
        }
        if(  empty($_POST['clave2']) ){
            echo "La clave 2 no está definida"."<br>";
        }
        if(  empty($_FILES['img']['name'])){
            echo "El imagen no está definida"."<br>";
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



