<?php
    include 'claseVerificar.php';
    require 'BD.php';

    session_start();
    $usuario = $_SESSION['usuario'];
    $emailActual = $_SESSION['email'];

    if (   (  !empty($_POST['apellidos']) )  && (  !empty($_POST['nombre'])  )  &&   (  !empty($_POST['correo']) )  &&  (  !empty($_FILES['img']['name']) ) ) 
    { 
        $apellido = $_POST['apellidos'];
        $nombre = $_POST['nombre'];
        $email =  $_POST['correo'];
        $imagenTmp = $_FILES['img']['tmp_name'];
        $imagenType = $_FILES['img']['type'];
        $bytesImagen = addslashes(file_get_contents($imagenTmp));
        $tipo=substr($imagenType, 6);

       
        // verificar nombre
        $nombreOk=Verificar::validar_nombre($nombre,$error_nombre);

        // ---------------------

        // verificar apellido

        $apellidoOk = Verificar::validar_apellido($apellido,$error_apellido); 

        // ---------------------

        // verificar email

        $emailOk = Verificar::validar_email($email, $error_email);

        // ---------------------

        if($email==$emailActual){
            $emailDuplicadoOk=true;
        }
        else{
            $emailDuplicadoOk = Verificar::email_duplicado($email,$error_emailDuplicado);
        }
        

        if( $nombreOk && $emailOk && $apellidoOk && $emailDuplicadoOk){
            //actualizo usuario en la base de datos
            $sql1 = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido' , email='$email'  WHERE nombreusuario='$usuario' ";
            if (mysqli_query($conn, $sql1)) {
                echo "Actualizar registro.";
                session_start();
                $_SESSION['nombre'] = $nombre;
                $_SESSION['apellido'] =$apellido; 
                $_SESSION['correo'] = $email; 
        
                header("Location:index.php");
                
            }
            else{
                echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
            }
        }else{
            if (!$emailDuplicadoOk)
                echo "$error_emailDuplicado";
            if (!$emailOk)
                echo "$error_email";
            if (!$nombreOk)
                echo "$error_nombre";
            if (!$apellidoOk)
                echo "$error_apellido";

           // echo "El nombre de usuario ya esta en uso 11";
        }    
        }



    
    else{
        if(  empty($_POST['apellidos']) ){
            echo "El apellido no está definido"."<br>";
        }
        if(  empty($_POST['nombre']) ){
            echo "El nombre no está definido"."<br>";
        }
        if(  empty($_POST['correo']) ){
            echo "El correo no está definido"."<br>";
        }
        if(  empty($_FILES['img']['name'])){
            echo "El imagen no está definida"."<br>";
        }
    
    }

?>