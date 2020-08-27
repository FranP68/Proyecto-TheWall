<?php 
    require "BD.php";
    session_start();
    $idSeguido = $_POST ["US_id"];
    $idLogueado = $_SESSION["id"];
    $usuarioSeguido= $_POST ["usuarioSeguido"];
    $sql = "SELECT * FROM siguiendo s WHERE s.usuarioseguido_id=$idSeguido AND s.usuarios_id=$idLogueado ";
    if ($rs = mysqli_query($conn, $sql) ){
        if($row = mysqli_fetch_row($rs)){
            if (isset($row[0])){
                $sql1 = " DELETE FROM siguiendo WHERE id=$row[0] ";
                if ($r = mysqli_query($conn, $sql1) ){
                    echo "Ha dejado de seguir a @$usuarioSeguido ";
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                }
                else{
                    echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
                }
            }
            else{
                echo "Usted no sigue al usuario @$usuarioSeguido ";
            }
        }
    }
    else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    ?>