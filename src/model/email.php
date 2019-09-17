<?php
require_once dirname(__file__) . "/../vendor/autoload.php";

// require_once dirname(__FILE__) . "/../config/env.php";

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Email
{
  function __construct($alteracao)
  {
    $this->alteracao = $alteracao;
  }
  public function send()
  {
    $dotenv = Dotenv::create(dirname(__file__) . '/../');
    $dotenv->load();
    try {
      $dotenv->required(
        [
          'MAIL_HOST', 'MAIL_PORT', 'MAIL_MAILER', 'MAIL_SMTPSEC',
          'MAIL_SMTPAUTH', 'MAIL_USER', 'MAIL_PASS'
        ]
      );
    } catch (\Exception $e) {
      echo $e->getMessage();
      throw new Exception($e->getMessage());
    }
    try {
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->Host = getenv('MAIL_HOST');
      $mail->Port = getenv('MAIL_PORT');
      $mail->Mailer = getenv('MAIL_MAILER');
      $mail->SMTPSecure = getenv('MAIL_SMTPSEC');
      $mail->SMTPAuth = getenv('MAIL_SMTPAUTH');
      $mail->Username = getenv('MAIL_USER');
      $mail->Password = getenv('MAIL_PASS');
      $mail->SingleTo = true;

      $chamado = $this->alteracao->getChamado();
      $usuario = $chamado->getUsuario();

      $mail->setFrom($mail->Username, 'HD7 UNEB');
      $mail->addAddress($usuario->getEmail(), $usuario->getNome());
      $body = "Seu chamado alterou para " . $this->alteracao->getDescricao();
      $mail->Body = $body;
      $mail->isHTML(true);
      $situacao = $this->alteracao->getSituacao()->getNome();
      $mail->Subject = "Chamado " . $chamado->getID() . " - $situacao";
      $mail->AltBody = $body;
      $mail->send();
    } catch (Exception $e) {
      echo "Message could not be sent. $mail->ErrorInfo";
    }
  }
}
