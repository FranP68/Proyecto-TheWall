function validarEditarPerfil() {
    var nombre, apellidos, correo, expresionMail, expresionNum, expresionEspecial;
    nombre = document.getElementById("nombre").value;
    apellidos = document.getElementById("apellidos").value;
    correo = document.getElementById("correo").value;
    expresionMail = /\w+@+\w+\.+[a-z]/;
    

    expresionNum = /\d/;
    expresionEspecial = /[*!"#$%&/()¨*+~{}^+_;,:.-]/;
    if (nombre === "" || apellidos  == "" || correo == "") {
        alert("Todos los campos son requeridos");
        return false;
    }
    else if (nombre.length > 30) {
        alert("El nombre es muy largo, debe tener menos de 30 letras");
        return false;
    }
    else if (expresionNum.test(nombre) || expresionEspecial.test(nombre)) {
        alert("El nombre no es válido, debe tener solo letras");
        return false;
    }
    else if (expresionNum.test(apellidos) || expresionEspecial.test(apellidos)) {
        alert("El apellido no es válido, debe tener solo letras");
        return false;
    }
    else if (apellidos.length > 30) {
        alert("El apellido es muy largo, debe tener menos de 30 letras");
        return false;
    }
    else if (! expresionMail.test(correo)){
        alert("El correo no es válido");
        return false;
    }
}

// function validarImagen(obj){
//     var uploadFile = obj.files[0];

//     if (!window.FileReader) {
//         alert('El navegador no soporta la lectura de archivos');
//         return;
//     }

//     if (!(/\.(jpg|png|gif)$/i).test(uploadFile.name)) {
//         alert('El archivo a adjuntar no es una imagen');
//     }
    
//         img.src = URL.createObjectURL(uploadFile);
                     
// }