<?php
/*
 * Titulo			            : email.php
 * Descripción                  : Envó de correos
 * Compañía			            :  UTL
 * Fecha de creación            : 18-junio-2019
 * Desarrollador                : Ricardo Franco
 * Versión			            : 1.0
 */

// Librerías
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../resource/vendor/autoload.php';



class email
{
    // Intancias
    private $mail;


    function __construct()
    { 
        $this->mail = new PHPMailer(TRUE);
    }


    function enviarCorreo($correo=[], $asunto ='',$cuerpo_correo = '')
    {
        $enviado = false;
        try {

            $this->mail->setFrom('notificaciones@utleon.edu.mx', 'Registro Curso Dual');
            $i = 0;
			
            $size = (count( $correo ))-1;
			
			
            while($i <= $size)
            {
				
                $this->mail->addAddress($correo[$i]['correo']);
                $i++;
            }
            // foreach($correo as $val){
            //     $this->mail->addAddress($val);
            // }
            
            $this->mail->Subject = $asunto;
            $this->mail->Body = $cuerpo_correo;

            /* SMTP parameters. */

            /* Tells PHPMailer to use SMTP. */
            $this->mail->isSMTP();

            /* SMTP server address. */
            $this->mail->Host = 'smtp.office365.com';

            /* Use SMTP authentication. */
            $this->mail->SMTPAuth = TRUE;

            /* Set the encryption system. */
            $this->mail->SMTPSecure = 'tls';

            /* SMTP authentication username. */
            $this->mail->Username = 'notificaciones@utleon.edu.mx';

            /* SMTP authentication password. */
            $this->mail->Password = 'Notificacion062020';

            /* Set the SMTP port. */
            $this->mail->Port = 587;

            /* Enable SMTP debug output. */
            $this->mail->SMTPDebug = 0;
			$this->mail->CharSet = 'UTF-8';
			$this->mail->IsHTML(true);

            /* Finally send the mail. */
            $enviado =  $this->mail->send();
        } catch (Exception $e) {
            echo "E1: ".$e->errorMessage();
        } catch (\Exception $e) {
            echo "E2: ".$e->getMessage();
        }
        return $enviado;
    }
}
