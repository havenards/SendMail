<?php


require_once("./bibliotecas/PHPMailer/Exception.php");
require_once("./bibliotecas/PHPMailer/OAuth.php");
require_once("./bibliotecas/PHPMailer/PHPMailer.php");
require_once("./bibliotecas/PHPMailer/POP3.php");
require_once("./bibliotecas/PHPMailer/SMTP.php");

//require_once('enviar_mailer.php');



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mensagem{


	private $para;
	private $assunto;
	private $mensagem;
	public $validade_da_mensagem = false;
	public $status = array('codigo_status' => null, 'descricao_status' => '');


	public function __set($atributo, $valor){
		$this-> $atributo = $valor;

	}
	public function __get($atributo){
		return $this->$atributo;


	}


	public function __mensagemValida(){


		if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {

			return $this->validade_da_mensagem == false;
		} 



	}

}

$email = new Mensagem();
$email -> __set('para', $_POST['para']);
$email -> __set('assunto', $_POST['assunto']);
$email -> __set('mensagem', $_POST['mensagem']);
$mail = new PHPMailer(true);


/* 
if ($email-> __get('validade_da_mensagem') == false) {

	header('Location: index.php');
	# code...
}
*/



try {
    //Server settings
    $mail->SMTPDebug = false;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'EMAIL@GMAIL.COM';                     // SMTP username
    $mail->Password   = 'SENHA DO GMAIL';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('pedro.havenard@gmail.com', 'Tribunal Vivo');
    $mail->addAddress($email->__get('para'), 'Senhor das Estrelas');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
   //$mail->addReplyTo('info@example.com', 'Information');
   // $mail->addCC('cc@example.com');
   // $mail->addBCC('bcc@example.com');

    // Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
   // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $email->__get('assunto');
    $mail->Body    = $email->__get('mensagem');
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    $email ->validade_da_mensagem ['codigo_status'] = 1;
    $email ->validade_da_mensagem ['descricao_status'] = 'Mensagem enviada com sucesso!';

    echo "<pre>";
    print_r($email->validade_da_mensagem['codigo_status']);
    echo "</pre>";

} catch (Exception $e) {


	$email ->validade_da_mensagem ['codigo_status'] = 2;
	$email ->validade_da_mensagem ['descricao_status'] = 'Ops! ' . "Detalhes do Erro: {$mail->ErrorInfo}";
}





?>
<html>
<head>
	<meta charset="utf-8" />
	<title>App Mail Send</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>


	<div class="container">
		<div class="py-3 text-center">
			<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
			<h2>Send Mail</h2>
			<p class="lead">Seu app de envio de e-mails particular!</p>
		</div>


	</div>
        <div class="row">
        	<div class="col-md-12"></div>

        	<?php if($email ->validade_da_mensagem['codigo_status'] == 1) { ?>
        	

        	  <div class="container">
        	  	<h1 class="display-4 text-sucess">Sucesso</h1>
        	  	<p><?= $email->validade_da_mensagem['descricao_status']?></p>
        	  	<a href="index.php" class="btn btn-sucess btn-lg mt-5 text-white">Voltar </a>
        	  </div>


        	<?php } ?>

        	<?php if($email ->validade_da_mensagem ['codigo_status'] == 2) { ?>
        	

        	  <div class="container">
        	  	<h1 class="display-4 text-danger">Ops!</h1>
        	  	<p><?= $email->validade_da_mensagem['descricao_status']?></p>
        	  	<a href="index.php" class="btn btn-sucess btn-lg mt-5 text-white">Voltar </a>
        	  </div>


        	<?php } ?>
        	
        </div>

</body>
</html>
