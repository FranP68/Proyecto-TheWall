<?php


    // include 'claseVerificar.php';
    // require 'BD.php';

    // session_start();
    // $usuario = $_SESSION['usuario'];
    // $emailActual = $_SESSION['email'];
    // $alert ="";
    // if (isset($_POST['submit'])){
    // if (   (  !empty($_POST['apellidos']) )  && (  !empty($_POST['nombre'])  )  &&   (  !empty($_POST['correo']) ) ) 
    // { 
    //     $apellido = $_POST['apellidos'];
    //     $nombre = $_POST['nombre'];
    //     $email =  $_POST['correo'];
        

       
    //     // verificar nombre
    //     $nombreOk=Verificar::validar_nombre($nombre,$error_nombre);

    //     // ---------------------

    //     // verificar apellido

    //     $apellidoOk = Verificar::validar_apellido($apellido,$error_apellido); 

    //     // ---------------------

    //     // verificar email

    //     $emailOk = Verificar::validar_email($email, $error_email);

    //     // ---------------------

    //     if($email==$emailActual){
    //         $emailDuplicadoOk=true;
    //     }
    //     else{
    //         $emailDuplicadoOk = Verificar::email_duplicado($email,$error_emailDuplicado);
    //     }
        

    //     if( $nombreOk && $emailOk && $apellidoOk && $emailDuplicadoOk){
    //         //actualizo usuario en la base de datos
            
    //         if(empty($_FILES['img']['name']) ){
    //             $sql1 = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido' , email='$email'  WHERE nombreusuario='$usuario' ";
    //         }
    //         elseif(!empty($_FILES['img']['name']) ){
                
    //             $imagenTmp = $_FILES['img']['tmp_name'];
    //             $imagenType = $_FILES['img']['type'];
    //             $bytesImagen = addslashes(file_get_contents($imagenTmp));
    //             $tipo=substr($imagenType, 6);
    //             if (Verificar::validar_foto($tipo,$error_foto)){             
    //                 $sql1 = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido' , email='$email', foto_contenido='$bytesImagen', foto_tipo='$tipo'  WHERE nombreusuario='$usuario' ";
    //             }
    //             else{
    //                 $sql1 = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido' , email='$email'  WHERE nombreusuario='$usuario' ";
    //                 // echo $error_foto;
    //             }
    //         }
            
    //         if (mysqli_query($conn, $sql1)) {
    //             $alert = "Datos actualizados";
    //             $_SESSION['nombre'] = $nombre;
    //             $_SESSION['apellido'] =$apellido; 
    //             $_SESSION['correo'] = $email; 
                
    //             $bool= true;
    //             header("Location:miPerfil.php");
                
    //         }
    //         else{
    //             //echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
    //         }
    //     }else{
    //         if (!$emailDuplicadoOk)
    //             $alert = $alert . "$error_emailDuplicado";
    //         if (!$emailOk)
    //              $alert = $alert . "$error_email";
                
    //         if (!$nombreOk)
    //             $alert = $alert . "$error_nombre";
                
    //         if (!$apellidoOk)
    //             $alert = $alert . "$error_apellido";
    //     }    
    //     }



    
    // else{
    //     if(  empty($_POST['apellidos']) ){
    //         $alert = $alert . "El apellido no está definido"."<br>";
    //     }
    //     if(  empty($_POST['nombre']) ){
    //         $alert = $alert . "El nombre no está definido"."<br>";
    //     }
    //     if(  empty($_POST['correo']) ){
    //         $alert= $alert . "El correo no está definido"."<br>";
    //     }
       
    // }
    // //header("Location:editarPerfil.php");
    //     $bool = false;
    // }


?>