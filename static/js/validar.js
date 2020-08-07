function validar(obj) {
    var nombre, apellidos, correo, usuario, clave, clave2, expresionMail, expresionNum, expresionEspecial;
    nombre = document.getElementById("nombre").value;
    apellidos = document.getElementById("apellidos").value;
    correo = document.getElementById("correo").value;
    clave = document.getElementById("clave").value;
    clave2 = document.getElementById("clave2").value;
    usuario = document.getElementById("usuario").value;
    foto = document.getElementById("foto").value;
    expresionMail = /\w+@+\w+\.+[a-z]/;
    

    expresionNum = /\d/;
    expresionEspecial = /[*!"#$%&/()¨*+~{}^+_;,:.-]/;
    if (nombre === "" || apellidos  == "" || correo == "" || usuario == ""   || clave == "" || clave2 == "") {
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
    else if (usuario.length > 30 || usuario.length < 6 || expresionEspecial.test(usuario)) {
        alert("El nombre de usuario debe tener al menos 6 caracteres alfanuméricos");
        return false;
    }
    if(!validar_clave(clave)){
        return false
    } 
   
    else if(! iguales(clave, clave2)){
        alert("Las passwords deben de coincidir");
        return false;
    }
    else if (! expresionMail.test(correo)){
        alert("El correo no es válido");
        return false;
    
    }
    if (foto == ""){
        alert("La imagen no esta definida");
        return false;
    }
    
    else{
        uploadFile = obj.files[0];
        if (!window.FileReader) {
            alert('El navegador no soporta la lectura de archivos');
            img.src = URL.createObjectURL(null);  
            return false;
        }
    
        if (!(/\.(jpg|jpeg|png|gif)$/i).test(uploadFile.name)) {
            alert('El archivo a adjuntar no es una imagen'); 
            return false;

        }
        else{
                img.src = URL.createObjectURL(uploadFile);
            
        }
    }
    

}




function validar_clave(contrasenna)
		{
			if(contrasenna.length >= 6)
			{		
				var mayuscula = false;
				var minuscula = false;
				var numero = false;
				var caracter_raro = false;
				
				for(var i = 0;i<contrasenna.length;i++)
				{
					if(contrasenna.charCodeAt(i) >= 65 && contrasenna.charCodeAt(i) <= 90)
					{
						mayuscula = true; 
                    }
					else if(contrasenna.charCodeAt(i) >= 97 && contrasenna.charCodeAt(i) <= 122)
					{
						minuscula = true;
					}
					else if(contrasenna.charCodeAt(i) >= 48 && contrasenna.charCodeAt(i) <= 57)
					{
						numero = true;
					}
					else
					{
						caracter_raro = true;
					}
                }
				if(mayuscula == true && minuscula == true && (caracter_raro == true || numero == true))
				{
					return true;
                }
                else if(mayuscula==false){
                    alert("La contraseña debe contener al menos una mayuscula");
                }
                else if(minuscula==false){
                    alert("La contraseña debe contener al menos una minuscula");
                }
                else if(numero==false){
                    alert("La contraseña debe contener al menos un numero");
                }
                else if(caracter_raro==false){
                    alert("La contraseña debe contener al menos un caracter especial");
                }
                    
            }
            alert("La contraseña debe tener al menos 6 caracteres"); 
			return false;
        }
function iguales(p1,p2){
        if (p1 != p2) {
            
            return false;
          } else {
            return true; 
          }
    }

    

    function validarMensaje(){
        
        var mensaje;
        var exp;
        mensaje=document.getElementById("mensaje").value;
        
        exp=/^\S/;
        if (mensaje.length==0 || !exp.test(mensaje)){
            alert("El mensaje esta en blanco");
            return false;
        }
        return true;
    }

    function validarIndex(){ 
            var usuario, clave;

            usuario = document.getElementById("usuario").value;

            clave = document.getElementById("clave").value;

            if(usuario == ""  || clave == ""){
                alert("Todos los campos son requeridos");
                return false;
            }
        }

function validarBuscar(){
    var busqueda;
    busqueda = document.getElementById("buscador").value;
    exp=/^\S/;
    
    if (busqueda == "" || !exp.test(busqueda)){
        alert("Ingrese un patrón de búsqueda");
        return false;
    }       
}


function validarEditarPerfil(img) {
    var nombre, apellidos, correo, expresionMail, expresionNum, expresionEspecial;
    nombre = document.getElementById("nombre").value;
    apellidos = document.getElementById("apellidos").value;
    correo = document.getElementById("correo").value;
    expresionMail = /\w+@+\w+\.+[a-z]/;
    foto = document.getElementById("foto").value;
    

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
    if (foto != ""){
        return validarImagen(img);
    }
    
}
function validarImagen(obj){
    var uploadFile = obj.files[0];

    if (!window.FileReader) {
        alert('El navegador no soporta la lectura de archivos');
        img.src = URL.createObjectURL(null);  
        return false;
    }

    if (!(/\.(jpeg|jpg|png|gif)$/i).test(uploadFile.name)) {
        alert('El archivo a adjuntar no es una imagen'); 
        return false;
    }
    else{
            img.src = URL.createObjectURL(uploadFile);
            return true;
    }             
}