<?php

require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->setLanguage('br');
 
// Configura para envio de e-mails usando SMTP
$mail->isSMTP();

// debugador 
//$mail->SMTPDebug = 2;

// Servidor SMTP
$mail->Host = 'smtp.live.com';
 
// Usar autenticação SMTP
$mail->SMTPAuth = true;
 
// Usuário da conta
$mail->Username = 'soares_franco@hotmail.com';
 
// Senha da conta
$mail->Password = '1234567890fsf';
 
// Tipo de encriptação que será usado na conexão SMTP
$mail->SMTPSecure = 'tls';
 
// Porta do servidor SMTP
$mail->Port = 587;
 
// Informa se vamos enviar mensagens usando HTML
$mail->IsHTML(true);
 
// Email do Remetente
$mail->From = 'soares_franco@hotmail.com';
 
// Nome do Remetente
$mail->FromName = 'William';
 
// Endereço do e-mail do destinatário
$mail->addAddress('fernandosfranco@restinga.ifrs.edu.br');

//Aceitar carasteres especiais
$mail->Charset = 'UTF-8';

// Assunto do e-mail
$mail->Subject = 'Recuperação de senha';
 
// Mensagem que vai no corpo do e-mail
$mail->Body = '<h1>Mensagem enviada via PHPMailer</h1>';
 
// Envia o e-mail e captura o sucesso ou erro
if($mail->Send()):
    echo 'Enviado com sucesso !';
else:
    echo 'Erro ao enviar Email:' . $mail->ErrorInfo;
endif;
?>