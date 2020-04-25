function validar() {
    var nombre, apellidos, correo, usuario, clave, clave2, expresionMail, expresionClave, expresionNum, expresionEspecial;
    nombre = document.getElementById("nombre").value;
    apellidos = document.getElementById("apellidos").value;
    correo = document.getElementById("correo").value;
    clave = document.getElementById("clave").value;
    clave2 = document.getElementById("clave2").value;
    usuario = document.getElementById("usuario").value;
    expresionMail = /\w+@+\w+\.+[a-z]/;
    

    expresionNum = /\d/;
    expresionEspecial = /[*!"#$%&/()¨*+~{}^+_;,:.-]/;
    if (nombre === "" || apellidos  == "" || correo == "" || usuario == ""   || clave == "" || clave2 == "") {
        alert("Todos los campos son requeridos");
        return false;
    }
    else if (nombre.length > 30) {
        alert("El nombre es muy largo");
        return false;
    }
    else if (expresionNum.test(nombre) || expresionEspecial.test(nombre)) {
        alert("El nombre no es válido");
        return false;
    }
    else if (expresionNum.test(apellidos) || expresionEspecial.test(apellidos)) {
        alert("El apellido no es válido");
        return false;
    }
    else if (apellidos.length > 30) {
        alert("El apellido es muy largo");
        return false;
    }
    else if (usuario.length > 30 || usuario.length < 6 || expresionEspecial.test(usuario)) {
        alert("El nombre de usuario debe tener al menos 6 caracteres alfanuméricos");
        return false;
    }
    else if (clave.length < 6 || ! validar_clave(clave)) { 
        alert("La contraseña debe tener al menos 6 caracteres, una mayúscula, una minúscula y un número o símbolo.");
        return false;
    }
    else if(! iguales(clave, clave2)){
        alert("Las passwords deben de coincidir");
        return false;
    }
    else if (! expresionMail.test(correo)){
        alert("El correo no es válido");
        return false;
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
			}
			return false;
        }
function iguales(p1,p2){
        if (p1 != p2) {
            
            return false;
          } else {
            return true; 
          }
    }