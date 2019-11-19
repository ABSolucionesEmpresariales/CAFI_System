<?php 
namespace Models;
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

class Email
{
    private $vkey,$email, $subject, $message, $headers;

    public function __construct()
    {
    
    try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp1.example.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'user@example.com';                     // SMTP username
    $mail->Password   = 'secret';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    // Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }


        $this->subject = "Verificacion de email";
        $this->message = "<a 'http://wwww.cafionline.com/Views/verify.php?vkey=$this->vkey'>Verificar cuenta</a>";
        $this->headers = "From: soporte@cafionline.com \r\n";
        $this->headers .= "MIME-Version: 1.0" . "\r\n";
        $this->headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    }

    public function setEmail($email)
    {
        $this->email = $email;
        $this->vkey = hash('sha256', time() . $email);
        return $this->vkey;
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
