<?php 
class Verificar extends Exception{

    public function __construct($message= '', $code = 0) {
        // some code
        // make sure everything is assigned properly
        parent::__construct($message, $code);
      }

      
    public static function validar_registrar($nombreUsuario, $nombre, $apellido, $email,$clave, $clave2, $tipo, $bytesImagen){
        require "BD.php";
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
        
        $fotoOk=Verificar::validar_foto($tipo,$error_foto);

        if($usuarioDuplicadoOk && $nombreOk && $claveOk && $apellidoOk && $emailOk && $emailDuplicadoOk && $fotoOk){
            //agrego nuevo usuario a la base de datos
            $sql1 = "INSERT INTO usuarios(nombre,apellido, email,foto_tipo, nombreUsuario,foto_contenido, contrasenia) VALUES ('$nombre','$apellido','$email','$tipo','$nombreUsuario','$bytesImagen', '$clave') ";
            if (mysqli_query($conn, $sql1)) {
                
                session_start();
                $_SESSION['usuario']=$nombreUsuario;
                $_SESSION['nombre']=$nombre;
                $_SESSION['apellido']=$apellido;
                $_SESSION['email'] = $email;
                $_SESSION['clave'] = $clave;

                //obtengo id de usuario
                $rs=mysqli_query($conn, "SELECT id FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
                if ($row = mysqli_fetch_row($rs)) {
                    $id = trim($row[0]);
                }
                $_SESSION['id']=$id;

                header("Location:inicio.php");
                
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
            if (!$fotoOk)
                echo "$error_foto";   
         
        }
        
    }
        
    
    public static function validar_login($nombreUsuario, $clave){
        require 'BD.php';
        Verificar::usuario_valido($nombreUsuario, $error_usuarioDuplicado);
        Verificar::obtener_claveUsuario($nombreUsuario, $clave, $error_coincideClaveUsuario) ;
        session_start();
        $rs = mysqli_query($conn, "SELECT nombre FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
        if ($row = mysqli_fetch_row($rs)) {
            $nombre = trim($row[0]);
        }
        $rs = mysqli_query($conn, "SELECT apellido FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
        if ($row = mysqli_fetch_row($rs)) {
            $apellido = trim($row[0]);
        }

        $rs = mysqli_query($conn, "SELECT email FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
        if ($row = mysqli_fetch_row($rs)) {
            $email = trim($row[0]);
        }

        $_SESSION['usuario'] = $nombreUsuario;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        $_SESSION['email'] = $email;
        $_SESSION['clave'] = $clave;
        //obtengo id de usuario
        $rs = mysqli_query($conn, "SELECT id FROM usuarios WHERE nombreusuario='$nombreUsuario' ");
        if ($row = mysqli_fetch_row($rs)) {
            $id = trim($row[0]);
        }
        $_SESSION['id'] = $id;
    }
    
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


    public static function usuario_valido($nombreUsuario, &$error_usuario){
        require 'BD.php';
        $sql= "SELECT nombreusuario FROM usuarios WHERE (nombreusuario = '$nombreUsuario') ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $error_usuario = "El nombre de usuario ya esta en uso" ."<br>";
            
            // return false;
        }
        else {
            $error_usuario = "El nombre de usuario es incorrecto";
            throw new Verificar("$error_usuario");
            // return true;
        }
    } 

    public static function usuario_duplicado($nombreUsuario, &$error_usuarioDuplicado){
        require 'BD.php';
        $sql= "SELECT nombreusuario FROM usuarios WHERE (nombreusuario = '$nombreUsuario') ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $error_usuarioDuplicado = "El nombre de usuario ya esta en uso" ."<br>";
            throw new Verificar("$error_usuarioDuplicado");
            // return false;
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
    $expresionSoloLetras = " /^[a-zA-Z ]+$/i ";
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
        $expresionSoloLetras = " /^[a-zA-Z ]+$/i ";
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
                    // return true;
                }
                else{
                    throw new Verificar("La clave es erronea");
                    // return false;
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
        public static function validar_foto($foto_tipo, &$error_foto){
            if ($foto_tipo=="png" || $foto_tipo=="jpg" || $foto_tipo=="jpeg" || $foto_tipo=="PNG" || $foto_tipo=="JPG" || $foto_tipo=="JPEG"){
                return true;
            }
            else{
                $error_foto = "El formato es incorrecto. Se aceptan .pgn, .jgp, .jpeg" ."<br>"; 
                return false;
            }
        }
    }    

?>