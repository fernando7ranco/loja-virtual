<?php
session_start();

if(!isset($_SESSION['info-cliente'])){
	header('location:inicio');
	exit;
}

$idCliente = $_SESSION['info-cliente']['id'];

include '../controller/controllerCadastroCliente.php';

?>
<!doctype html>
<html lang='pt-br'>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
		<title>cadastro de cliente</title>
        <link rel="shortcut icon" type="img/x-icon" href="img/icones/favicon.png">
        <link rel='stylesheet' type="text/css" href='css/cadastro-cliente.css'>
        <link rel='stylesheet' type="text/css" href='css/header.css'>
    </head>
    <body>
	
       <?php include 'includes/header.php';?>
	   
        <div id='caixaCentro'>
			
            <div id='editarcadastro' >
	   
				<h2>Editar informações de cadastro</h2>
				<h4><font color='red'>* Dados Obrigatórios</font></h4>
				
				<form method='POST'>
				
					<p>
						<label>NOME: *</label>
						<input type='text' name='nome' value='<?=$cliente->getNome();?>' placeholder='DIGITE SEU NOME' maxlength='30' autocomplete='off' >
					</p>
					<p>
						<label>CPF: *</label>
						<input type='text' name='cpf' value='<?=$cliente->getCpf();?>' placeholder='DIGITE SEU CPF' maxlength='14' autocomplete='off' >
					</p>
					<p>
						<label>RG: *</label>
						<input type='text' name='rg' value='<?=$cliente->getRg();?>' placeholder='DIGITE SEU RG' maxlength='10' autocomplete='off' >
					</p>
					<p>
						<label>CEP: * pressione ENTER para completar o enderço</label>
						<input type='text' name='cep' value='<?=$cliente->getCep();?>' placeholder='DIGITE SEU CEP' maxlength='16' autocomplete='off' >
					</p>
					<p>
						<label>ENDEREÇO: *</label>
						<input type='text' name='endereco' value='<?=$cliente->getEndereco();?>' placeholder='DIGITE (rua, número, complemento, apartamento)' maxlength='80' autocomplete='off' >
					</p>
					<p>
						<label>BAIRRO: *</label>
						<input type='text' name='bairro' value='<?=$cliente->getBairro();?>' placeholder='DIGITE SEU BAIRRO' maxlength='50' autocomplete='off' >
					</p>
			
					<p>
						<label>ESTADO: *</label>
						<select name='estado'>
						<?php
							include '../model/database/dados/estados.php';
							foreach($estados as $uf => $estado){
								$selected = $cliente->getEstado() == $uf ? "selected='selected'" : null;
								echo "<option value='{$uf}' {$selected} >{$estado}</option>";
							}
						?>
						</select>
							
					</p>
	
					<p>
						<label>TELEFONE: * DDD + digitos do telefone</label>
						
						<input type='text' name='telefone' value='<?=$cliente->getTelefone();?>' placeholder='DIGITE SEU TELEFONE (DDD) 0000-0000'  maxlength='15' autocomplete='off' >
						<br><font color='red'></font>
					</p>
					
				
					<button type='button' id='fazerCadastro'>salvar alterações</button>
						
				</form>
			</div>
        </div>
    </body>
    <script type="text/javascript" src="js/jquery_code.js"></script>
    <script type="text/javascript" src="js/cadastro-cliente.js"></script>
</html>