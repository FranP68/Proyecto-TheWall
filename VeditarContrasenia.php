<?php
    include 'claseVerificar.php';
    require 'BD.php';

    session_start();
    $usuario = $_SESSION['usuario'];
    $claveUsuario = $_SESSION['clave'];

    if (   (  !empty($_POST['claveActual']) )  && (  !empty($_POST['claveNueva'])  )  &&   (  !empty($_POST['claveNueva2']) ) ) 
    { 
        $claveActual = $_POST['claveActual'];
        $claveNueva = $_POST['claveNueva'];
        $claveNueva2 =  $_POST['claveNueva2'];

        $claveActualOk=Verificar::validar_clave($claveUsuario, $claveActual, $error_clave);
        
        $claveNuevaOk=Verificar::validar_clave($claveNueva, $claveNueva2, $error_clave2);

        if($claveActualOk && $claveNuevaOk && ($claveUsuario!==$claveNueva)){
            //actualizo usuario en la base de datos
            $sql1 = "UPDATE usuarios SET contrasenia='$claveNueva' WHERE nombreusuario='$usuario' ";

            if (mysqli_query($conn, $sql1)) {
                echo "Actualizar contraseña.";
                $_SESSION['clave'] = $claveNueva;
                header("Location:inicio.php");    //si quiero ver el mensaje, comentar
            }
            else{
                echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
            }
        }
        else{
            if (!$claveActualOk)
                echo "Error en clave actual: $error_clave";
            if (!$claveNuevaOk)
                echo "Error en clave nueva: $error_clave2";
            if ($claveUsuario==$claveNueva)
                echo "La clave nueva debe ser distinta de la clave actual";
        }
    }
    else{
        if(  empty($_POST['claveActual']) ){
            echo "No se ingreso clave actual"."<br>";
        }
        if(  empty($_POST['claveNueva']) ){
            echo "No se ingreso clave nueva"."<br>";
        }
            
        if(  empty($_POST['claveNueva2']) ){
            echo "No confirmo clave nueva"."<br>";
        }
         

    }

?>