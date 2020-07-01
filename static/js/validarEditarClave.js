function validarEditarClave() {
    var claveNueva, claveNueva2, expresionNum, expresionEspecial;
    claveNueva = document.getElementById("claveNueva").value;
    claveNueva2 = document.getElementById("claveNueva2").value;
    expresionNum = /\d/;
    expresionEspecial = /[*!"#$%&/()¨*+~{}^+_;,:.-]/;

    if (claveNueva == "" || claveNueva2 == "") {
        alert("Todos los campos son requeridos");
        return false;
    }
    if(!validar_clave(claveNueva)){
        return false
    }
    if(!validar_clave(claveNueva2)){
        return false
    }  
    if(! iguales(claveNueva, claveNueva2)){
        alert("Las claves nuevas deben de coincidir");
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

    