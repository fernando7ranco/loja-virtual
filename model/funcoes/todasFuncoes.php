<?php

function codificacao($string, $vezes, $tipo) {

    $str_r[] = ['=', '+', '/'];
    $str_r[] = ['laugi', 'roiam', 'arrab'];

    if ($tipo == 1) {
        for ($i = 0; $i < $vezes; $i++)
            $string = strrev(base64_encode($string));

        $string = str_replace($str_r[0], $str_r[1], $string);
    } else {
        $string = str_replace($str_r[1], $str_r[0], $string);

        for ($i = 0; $i < $vezes; $i++)
            $string = base64_decode(strrev($string));
    }
    return $string;
}

function enviarEmails($para, $assunto, $mensagem) {
    
    require '../model/framework/PHPMailer/class.phpmailer.php';
    require '../model/framework/PHPMailer/class.smtp.php';

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
    $mail->addAddress($para);
    //Aceitar carasteres especiais
    $mail->CharSet = "UTF-8";
    // Assunto do e-mail
    $mail->Subject = $assunto;
    // Mensagem que vai no corpo do e-mail
    $mail->Body = $mensagem;
    // Envia o e-mail e captura o sucesso ou erro
    if ($mail->Send())
        return 'Enviado com sucesso !';
    else
        return 'Erro ao enviar Email:' . $mail->ErrorInfo;
}

function stringLimpa($string){
	$what = array("á","à","ã","â","ä","Á","À","Ã","Â","Ä","é","è","ê","ë","É","È","Ê","Ë","í","ì","î","ï","Í","Ì","Î","Ï","ó","ò","õ","ô","ö","Ó","Ò","Õ","Ô","Ö","ú","ù","û","ü","Ú","Ù","Û","Ü",'ñ','Ñ','ç','Ç',' ','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
	$by   = array('a','a','a','a','a','A','A','A','A','A','e','e','e','e','E','E','E','E','i','i','i','i','I','I','I','I','o','o','o','o','o','O','O','O','O','O','u','u','u','u','U','U','U','U','n','n','c','C','-','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
	$string = str_replace($what, $by, $string);
	$string = strtolower($string);

	return $string;
}
	
function paginalizacao($numeroDeAnuncios,$pagina) 
{
    $rows = round($numeroDeAnuncios / 20);
    $numeroDeAnuncios = $rows < 1 ? 1 : $rows;
    $total = $numeroDeAnuncios;
    $atual = $pagina > $numeroDeAnuncios ? 0 : $pagina;
    $inicio = $atual - 6;
    $inicio = $inicio < 1 ? 1 : $atual - 5;
    $contador = 1;

    $paginas = null;
    for ($i = $inicio; ($contador <= 10 AND $i <= $total); $i++) {
        $id = $i == $atual ? 'id=foco' : null;
        $paginas .= "<a {$id} >{$i}</a>";
        $contador++;
    }

    if (($atual) > 6 and $total > 10)
        $paginas = "<a>1</a>..." . $paginas;

    if (($total - $atual) > 4 and $total > 10)
        $paginas .= "...<a>{$total}</a>";

    return "<div><div id='paginalizacao' >{$paginas}</div></div>";
}

