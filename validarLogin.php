<?php
    include 'claseVerificar.php';
    require 'BD.php';

    if ( (!empty($_POST['usuario']) )  && (!empty($_POST['clave']) ) )
    {   
        $clave =  $_POST['clave'];
        $nombreUsuario =  $_POST['usuario'];


        if (Verificar::usuario_duplicado($nombreUsuario,$error_usuarioDuplicado)){
            echo "El usuario no existe";
        }
        else{
        if (Verificar::obtener_claveUsuario($nombreUsuario,$clave,$error_coincideClaveUsuario)){
            echo "$error_coincideClaveUsuario";
        }
        else
        {
            echo "$error_coincideClaveUsuario";
        }
    
        }
    }
    else {
        echo "sale por el emty";
    }

?>   