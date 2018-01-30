<?php
session_start();

if(!isset($_SESSION['info-cliente'])){
	header('location:inicio');
	exit;
}

$idCliente = $_SESSION['info-cliente']['id'];

include '../controller/controllerMeusFavoritos.php';

?>
<!doctype html>
<html lang='pt-br'>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8"/>
		<title>meus favoritos</title>
        <link rel="shortcut icon" type="img/x-icon" href="img/icones/favicon.png">
        <link rel='stylesheet' type="text/css" href='css/header.css'>
        <link rel='stylesheet' type="text/css" href='css/meus-favoritos.css'>
    </head>
    <body>
	
       <?php include 'includes/header.php';?>
	   
        <div id='caixaCentro'>
            <div class='meus-favoritos' >
				<h2>Meus Produtos Favoritos</h2>
			<?php
				if($produtos['produtos'] ){

					foreach($produtos['produtos'] as $produto){
						echo "<div id='produto' align='center'>
								{$produto->getFavorito()}
								<a href='produto={$produto->getId()}' >";
						echo 		$produto->getDesconto() ? "<sub>{$produto->getDesconto()} % de desconto</sub>" : '';
						echo 		"<img src='img/produtos/{$produto->getImagens('array')[0]}' id='img'>
									<label>{$produto->getProdutoCS()->getNomeSubcategoria()} {$produto->getNome()}</label>";
						echo 		$produto->getDesconto() ? "<strong>R$ {$produto->getValor()}</strong> - <b>R$ {$produto->getValor('desconto')}</b>" : "<b>R$ {$produto->getValor()}</b>";
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
						
				}
				?>
			</div>
			
        </div>
		
    </body>
    <script type="text/javascript" src="js/jquery_code.js"></script>
	<script type='text/javascript' src='js/header.js'></script>
	<script type='text/javascript' src='js/funcaoProdutosFavoritos.js'></script>
	<script type='text/javascript' >
		$(function () {
			$('body').delegate('.btProdutoFavorito','click',function(){
				$(this).parents('#produto').fadeOut( "slow" , function() { $( this ).remove()} );
			})
		});
	</script>
</html>