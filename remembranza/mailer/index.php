<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

class Mailer{

	private $data;
	

	public function __construct( $data ){
		$this->data = $data;
	}

	public function sendMessage(){
		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
		    //Server settings
		    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
		    $mail->isSMTP();                                            // Set mailer to use SMTP
		    $mail->Host       = 'remembranzza.com';  // Specify main and backup SMTP servers
		    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $mail->Username   = 'no-reply@remembranzza.com';                     // SMTP username
		    $mail->Password   = 'V%Na2_-q&wf;';                               // SMTP password
		    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
		    $mail->Port       = 465;                                    // TCP port to connect to

		    //Recipients
		    $mail->setFrom( $this->data['email'], utf8_decode( $this->data['name'] ));
		    $mail->addAddress('hola@remembranzza.com');  // Add a recipient
		    //$mail->addCC('no-reply@remembranzza.com');        
		    $mail->addCC('aroque@smart-teaching.com');        
		    $mail->addReplyTo( $this->data['email'], utf8_decode( $this->data['name'] ) );

		    // Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Formulario de contacto Remembranzza';
		    $mail->Body    = $this->getEmailTemplate();

		    $mail->send();

		    echo json_encode(array(
		    		"status" => true,
		    		"msg" => "Tu mensaje ha sido enviado"
		    	));
		} catch (Exception $e) {
		    echo json_encode(array(
		    		"status" => false,
		    		"msg" => "Ocurrió un problema de envío, intenta nuevamente"
		    	));			
		}		
	}

	public function getEmailTemplate(){
		$tpl = file_get_contents("tpl/email.tpl");
		foreach( $this->data as $index => $item ){
			$tpl = str_replace("[" . $index. "]", $item, $tpl);
		}
		return utf8_decode($tpl);
	}
}

function main(){
	//Inicializa mailer
	if( !empty($_POST['name']) &&
		!empty($_POST['email'] &&
		!empty($_POST['phone']) &&
		!empty($_POST['msg']) ) ){

		( new Mailer( $_POST ) ) -> sendMessage();
	}
}

main();

