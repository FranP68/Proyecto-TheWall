<?php
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

        usuario_duplicado($nombreUsuario);//devuelve true si esta duplicado
        $error_claveDif=false;
        $claveOK=false;
        if($clave == $clave2){
            if( Verificar::validar_clave( $clave, $error_clave )) {
                $claveOK=true ;
            }
            else {
                echo $error_clave;
            }
        }
        else{
            echo " Las contraseñas son diferentes " . "<br>";
            $error_claveDif=true;
        }
        $expresionSoloLetras = " /^[a-z]+$/i ";
        $bienNombre=true;
        if (!preg_match($expresionSoloLetras, $nombre)) {
            echo "El nombre deben ser solo letras " . "<br>";
            $bienNombre=false;
        }
        $bienApellido=true;
        if (!preg_match($expresionSoloLetras, $apellido)) {
            echo "El apellido deben ser solo letras " . "<br>";
            $bienApellido=false;
        }
        
         
        if(!usuario_duplicado($nombreUsuario) && $bienNombre  && !$error_claveDif && $claveOK && $bienApellido){
            //agrego nuevo usuario a la base de datos
            $sql1 = "INSERT INTO usuarios(nombre,apellido, email,foto_tipo, nombreUsuario,foto_contenido, contrasenia) VALUES ('$nombre','$apellido','$email','$tipo','$nombreUsuario','$bytesImagen', '$clave') ";
            if (mysqli_query($conn, $sql1)) {
                echo "Nuevo registro.";
                session_start();
                $_SESSION['usuario']=$nombreUsuario;
                header("Location:index.php");
                
            }
            else{
                echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
            }
        }else{
            echo "El nombre de usuario ya esta en uso";
        }    
    }
    else{
        if(empty($_FILES['img']['name'])){
            echo "La foto de perfil no está definida";
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
<?php

function usuario_duplicado($nombreUsuario){//devuelve true si esta duplicado
    require 'BD.php';
    $sql= "SELECT nombreusuario FROM usuarios WHERE (nombreusuario = '$nombreUsuario') ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        //echo "El nombre de usuario ya esta en uso";
        return true;
    }
    else {
        //echo "El nombre de usuario esta disponible";
        return false;
    }
} 

    
?>


<?php
// function validar_clave($clave,&$error_clave){
//     if(strlen($clave) < 6){
//        $error_clave = "La clave debe tener al menos 6 caracteres" ."<br>";
//        return false;
//     }
//     if(strlen($clave) > 16){
//        $error_clave = "La clave no puede tener más de 16 caracteres" ."<br>";
//        return false;
//     }
//     if (!preg_match('[a-z]',$clave)){
//        $error_clave = "La clave debe tener al menos una letra minúscula" ."<br>";
//        return false;
//     }
//     if (!preg_match('[A-Z]',$clave)){
//        $error_clave = "La clave debe tener al menos una letra mayúscula " ."<br>";
//        return false;
//     }
//     if (!preg_match('[0-9]',$clave)){
//        $error_clave = "La clave debe tener al menos un caracter numérico" ."<br>";
//        return false;
//     }
//     $error_clave = "";
//     return true;
//  }
?> 

<?php 
class Verificar{


    public static function validar_clave($clave,&$error_clave){
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
    }
?>