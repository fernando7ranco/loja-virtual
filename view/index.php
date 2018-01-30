<?php
session_start();
include '../controller/controllerIndex.php';

?>
<!doctype html>
<html lang='pt-br'>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
        <title>comesticos</title>
        <link rel="shortcut icon" type="img/x-icon" href="img/icones/favicon.png">
        <link rel='stylesheet' type="text/css" href='css/index.css'>
        <link rel='stylesheet' type="text/css" href='css/header.css'>
    </head>
    <body>
        <?php include 'includes/header.php';?>
        <div id='caixaCentro'>
			
			<div class='slides-show'>
				<button id='left'> < </button>
				<button id='right'> > </button>
				<div id='box-slides-show'>
					<div id='scroll-box-slides-show'>
						<?php
							foreach($produtos['produtos'] as $produto){
								echo "<div id='produto' align='center'>
										<a href='produto={$produto->getId()}' >";
								echo 		$produto->getDesconto() ? "<sub>{$produto->getDesconto()} % de desconto</sub>" : '';
								echo 		"<img src='img/produtos/{$produto->getImagens('array')[0]}' id='img'>
											<label>{$produto->getProdutoCS()->getNomeSubcategoria()} {$produto->getNome()}</label>";
								echo "<div>";
								echo  	$produto->getDesconto() ? "<strong>R$ {$produto->getValor()}</strong> - <b>R$ {$produto->getValor('desconto')}</b>" : "<b>R$ {$produto->getValor()}</b>";
								echo "</div>";
								if($produto->getParcelas()){
									echo "<div>";
									foreach($produto->getParcelas('array') as $valor)
										echo " <span>{$valor['vezes']} x R$ {$valor['valor']}</span> ";
									echo "</div>";
								}
								echo 	"<div>{$produto->getAvaliacoes('ranque')}</div>";
								echo 	"</a>
									</div>";
							}
						?>
					</div>
				</div>
			</div>
			<?php if (!isset($_SESSION['info-cliente'])) { ?>
			
			<div id='autenficacoes' >
                <div>
                    <span id='foco' >entrar</span>
                    <span>cadastrar-se</span>
                </div>

                <div id='forms'>

                    <div id='login' align='center' >

                        <h2>Acessar minha conta</h2>
                        <form>
                            <p>
								<label>E-MAIL:</label>
								<input type='email' name='email' maxlength='80' placeholder='E-MAIL DE USUARIO' >
							</p>
                            <p>
								<label>SENHA:</label>
								<input type='password' name='senha' placeholder='SENHA DE USUARIO' >
							</p>
                            <p>
                                <input type='checkbox' value='true' id='Mlogado' > Me mantenha logado 
                                <a href='recuperarsenha.php' >Recuperar Senha</a>
                            </p>
                            <button type='button' id='fazerLogin'>logar</button>
                        </form>

                    </div>

                    <div id='cadastro' align='center' >
					
                        <h2>Ainda não tenho cadastro</h2>
						<h4><font color='red'>* Dados Obrigatórios</font></h4>
                        <form method='POST'>
						
							<div id='divisorCadastro'>
								<p>
									<label>NOME: *</label>
									<input type='text' name='nome' placeholder='DIGITE SEU NOME' maxlength='30' autocomplete='off' >
								</p>
								<p>
									<label>CPF: *</label>
									<input type='text' name='cpf' placeholder='DIGITE SEU CPF' maxlength='14' autocomplete='off' >
								</p>
								<p>
									<label>RG: *</label>
									<input type='text' name='rg' placeholder='DIGITE SEU RG' maxlength='10' autocomplete='off' >
								</p>
								<p>
									<label>CEP: * pressione ENTER para completar o enderço</label>
									<input type='text' name='cep' placeholder='DIGITE SEU CEP' maxlength='16' autocomplete='off' >
								</p>
								<p>
									<label>ENDEREÇO: *</label>
									<input type='text' name='endereco' placeholder='DIGITE (rua, número, complemento, apartamento)' maxlength='80' autocomplete='off' >
								</p>
								<p>
									<label>BAIRRO: *</label>
									<input type='text' name='bairro' placeholder='DIGITE SEU BAIRRO' maxlength='50' autocomplete='off' >
								</p>
						
								<p>
									<label>ESTADO: *</label>
									<select name='estado'>
									<?php
										include '../model/database/dados/estados.php';
										foreach($estados as $uf => $estado){
											echo "<option value='{$uf}'>{$estado}</option>";
										}
									?>
									</select>
										
								</p>
							</div>
							<div id='divisorCadastro'>
								<p>
									<label>TELEFONE: * DDD + digitos do telefone</label>
									
									<input type='text' name='telefone' placeholder='DIGITE SEU TELEFONE (DDD) 0000-0000'  maxlength='15' autocomplete='off' >
									<br><font color='red'></font>
								</p>
								<p>
									<label>E-MAIL: *</label>
									<input type='email' name='email' placeholder='DIGITE SEU E-MAIL'  maxlength='60' autocomplete='off' >
									<br><font color='red'></font>
								</p>
								<p>
									<label>SENHA: *</label>
									<input type='password' name='senha1' placeholder='DIGITE SUA SENHA' maxlength='16' autocomplete='off' >
								</p>
								<p>
									<label>CONFIRMA SENHA: *</label>
									<input type='password' name='senha2' placeholder='CONFIRME SUA SENHA' maxlength='16' autocomplete='off' >
								</p>
								<p><input type='checkbox' id='vsenha' title='visualizar senha'> visualizar senha</p>
							
								<button type='button' id='fazerCadastro'>cadastre-se</button>
								
							</div>
                        </form>
                    </div>
                  
                </div>
            </div>
			<?php } ?>
        </div>
    </body>
    <script type="text/javascript" src="js/jquery_code.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="js/header.js"></script>
	
    <?php if (!isset($_SESSION['info-cliente'])) { ?> <script type="text/javascript" src="js/cadastroCliente.js"></script> <?php } ?>
	
</html>