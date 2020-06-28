<?php 
class Verificar{


    public static function validar_clave($clave, $clave2, &$error_clave){
        if($clave == $clave2){
            if(strlen($clave) < 6){
               $error_clave = "La clave debe tener al menos 6 caracteres" ."<br>";
               return false;
            }
            if(strlen($clave) > 16){
               $error_clave = "La clave no puede tener más de 16 caracteres" ."<br>";
               return false;
            }
            if (!preg_match('/[a-z]/',$clave)){
               $error_clave = "La clave debe tener al menos una letra minúscula" ."<br>";
               return false;
            }
            if (!preg_match('/[A-Z]/',$clave)){
               $error_clave = "La clave debe tener al menos una letra mayúscula " ."<br>";
               return false;
            }
            if (!preg_match('/[0-9]/',$clave)){
               $error_clave = "La clave debe tener al menos un caracter numérico" ."<br>";
               return false;
            }
            $error_clave = "";
            return true;
         }
         else{
            $error_clave = "La claves no coinciden" ."<br>";
            return false;
         }
    }




    public static function usuario_duplicado($nombreUsuario,&$error_usuarioDuplicado){
        require 'BD.php';
        $sql= "SELECT nombreusuario FROM usuarios WHERE (nombreusuario = '$nombreUsuario') ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $error_usuarioDuplicado = "El nombre de usuario ya esta en uso" ."<br>";
            return false;
        }
        else {
            $error_usuarioDuplicado = "";
            return true;
        }
    } 


    public static function email_duplicado($email,&$error_emailDuplicado){
        require 'BD.php';
        $sql= "SELECT email FROM usuarios WHERE (email = '$email') ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $error_emailDuplicado = "El email ya esta en uso" ."<br>";
            return false;
        }
        else {
            $error_emailDuplicado = "";
            return true;
        }
    } 




    public static function validar_nombre($nombre,&$error_nombre){
    $expresionSoloLetras = " /^[a-z]+$/i ";
    if (!preg_match($expresionSoloLetras, $nombre)) {
        $error_nombre = "El nombre deben ser solo letras " ."<br>";
        return false;
    }
    else {
        $error_nombre = "";
        return true;
    }
    }

    public static function validar_apellido($apellido,&$error_apellido){
        $expresionSoloLetras = " /^[a-z]+$/i ";
        if (!preg_match($expresionSoloLetras, $apellido)) {
            $error_apellido = "El apellido deben ser solo letras " ."<br>";
            return false;
        }
        else {
            $error_apellido = "";
            return true;
        }
        }


        public static function obtener_claveUsuario($nombreUsuario, $clave, &$error_coincideClaveUsuario){
            require 'BD.php';
            $sql= "SELECT contrasenia FROM usuarios  WHERE (nombreusuario = '$nombreUsuario') ";
            $result = mysqli_query($conn, $sql);
            if ($row=mysqli_fetch_row($result)){
                $claveUsuario = trim($row[0]);
                if ($claveUsuario == $clave){
                    $error_coincideClaveUsuario = "ingreso correctamente"; 
                    return true;
                }
            else{
                $error_coincideClaveUsuario = "La clave es erronea" ."<br>";
                return false;
            }
            }
        }
        
        public static function validar_email($email, &$error_email){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $error_email = "El correo es incorrecto" ."<br>"; 
                return false;
            }
            else{
                $error_email = "El correo es correcto" ."<br>"; 
                return true;
            }
    
    
    
        }
    }    

        
        



}
?>