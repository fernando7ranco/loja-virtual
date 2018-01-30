<?php
session_start();
include '../controller/controllerProdutos.php';
?>

<!doctype html>
<html lang='pt-br'>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" >
        <title>produto</title>
        <link rel="shortcut icon" type="img/x-icon" href="img/icones/favicon.png" >
        <link rel="stylesheet" type="text/css" href='css/produtos.css'>
        <link rel="stylesheet" type="text/css" href='css/header.css'>
    </head>
    <body>
	
		<?php include 'includes/header.php'; ?>
		
		<div id='localProdutos'>	
		
			<h3 id='filtrosEmUso'>
				<?=$produtos['filtros']?>
			</h3>
			
			<div id='produtos'>
				<?php
				if($produtos['quantidade'] and $produtos['produtos'] ){

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
			<?=paginalizacao($produtos['quantidade'],(isset($_GET['pagina']) ? $_GET['pagina']: 0) )?>
		</div>
	
    </body>
	<script type='text/javascript' src='js/jquery_code.js'></script>
	<script type='text/javascript' src='js/produtos.js'></script>
	<script type='text/javascript' src='js/header.js'></script>
	<script type='text/javascript' src='js/funcaoProdutosFavoritos.js'></script>
	
</html>
