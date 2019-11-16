<?php
class Email
{
    private $vkey,$email, $subject, $message, $headers;

    public function __construct()
    {
        $this->subject = "Verificacion de email";
        $this->message = "<a 'http://wwww.cafionline.com/Views/verify.php?vkey=$this->vkey'>Verificar cuenta</a>";
        $this->headers = "From: soporte@cafionline.com \r\n";
        $this->headers .= "MIME-Version: 1.0" . "\r\n";
        $this->headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    }

    public function setEmail($email)
    {
        $this->email = $email;
        $this->vkey = hash('sha-256', time() . $email);
    }

    public function enviarEmailConfirmacion()
    {
        mail($this->email, $this->subject, $this->message, $this->headers);
    }

    
  /*   public function setContrasena($contrasena)
    {
        $this->contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
       

        //Desencriptar 
        //$contrasena es la contrasena que proviene del formulario del login para ingresar
        //$hash es la contrasena encriptada que se extrae de la base de datos.
        
        if(password_verify('$contrasena', $hash)){
            //Login exitoso.
        }else{
            //contrasena incorrecta.
        } 
    } */

}
