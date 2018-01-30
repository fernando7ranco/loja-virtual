<?php
session_start();

include '../controller/controllerProduto.php';

?>
<!doctype html>
<html lang='pt-br'>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" >
        <title>produto</title>
        <link rel="shortcut icon" type="img/x-icon" href="img/icones/favicon.png" >
        <link rel="stylesheet" type="text/css" href='css/produto.css'>
        <link rel="stylesheet" type="text/css" href='css/header.css'>
    </head>
    <body>
		<?php include 'includes/header.php'; ?>
		
		<div id='localProduto'>	
			<h3 id='caminho'>
				<?php
					$genero = $produto->getProdutoCS()->getGeneroCategoria('texto');
					$categoria = $produto->getProdutoCS()->getNomeCategoria();
					$subcategoria = $produto->getProdutoCS()->getNomeSubcategoria();
					
					echo "<a href='produtos'>home</a> > ";
					echo "<a href='produtos=[{$genero}]'>{$genero}</a> > ";
					echo "<a href='produtos=[{$genero}+".stringLimpa($categoria)."]'>{$categoria}</a> > ";
					echo "<a href='produtos=[{$genero}+".stringLimpa($categoria)."+".stringLimpa($subcategoria)."]'>{$subcategoria}</a>";
				?>
			</h3>
			<p id='nomeProduto'><?=$produto->getNome();?></p>
			<div>
				<div id='imagensProduto'> 
					<div>
						<?php
						$imagens = $produto->getImagens('array');
							
						foreach($imagens as $idx => $imagem)
							echo (!$idx) ? "<img src='img/produtos/{$imagem}' id='imgFoco'>" : "<img src='img/produtos/{$imagem}'>";
						?>
					</div>
					<div>
						<?="<img src='img/produtos/{$imagens[0]}'>";?>
					</div>
				</div>
				<div id='infoProduto'>
					<div>
						<?=$produto->getQuantidade() ? 
							"<font color='green'>disponível</font> 
							<a id='btInserirNaSacola' value='{$produto->getId()}' ><img src='img/icones/sacola.png'> adicionar na sacola de compras</a>"
							:"<font color='red'>indisponível</font><br>"
						?>
					</div>
					<div>
						<?php
						if($produto->getDesconto())
							echo "de <strong>R$ {$produto->getValor()}</strong> por <b>R$ {$produto->getValor('desconto')}</b> <sup>{$produto->getDesconto()} % de desconto</sup> ";
						else
							echo "<b>R$ {$produto->getValor()}</b>";
						?>
					</div>
					
					<div>
						<?php
						if($produto->getParcelas()){
							echo '<label>Parcelas:</label><br>';
							foreach($produto->getParcelas('array') as $valor)
								echo "<a>{$valor['vezes']} x R$ {$valor['valor']}</a>";
						}
						?>
					</div>
					
					<div><?=$produto->getAvaliacoes('ranque');?></div>
					
					<div>adicionar aos favoritos <?=$produto->getFavorito();?></div>
					
					<p><?=$produto->getDescricao()?></p>
					
					<?=$produto->getInformacoes() ? 
						"<div>
							<a id='maisDetalhes'><span>+</span> mais detalhes</a>
							<p id='infoDetalhes'>
								<span>detalhes e informações do produto</span>
								{$produto->getInformacoes()}
							</p>
						</div>" : null;
					?>
				</div>
			</div>
			<?php
			
			if($produtosRelacionados){
				
				echo"<div id='produtoRelacionados' align='center' >";
				echo "<h3>Produtos Relacionados</h3>";
				
				foreach($produtosRelacionados as $PR){
					echo "<div id='PR'><a href='produto={$PR->getId()}' >";
					echo $PR->getDesconto() ? "<sub>{$PR->getDesconto()} % de desconto</sub>" : '';
					echo "<img src='img/produtos/{$PR->getImagens('array')[0]}'>
							<label>{$PR->getNome()}</label>";
					echo $PR->getDesconto() ? "<strong>R$ {$produto->getValor()}</strong> - <b>R$ {$produto->getValor('desconto')}</b>" : "<b>R$ {$PR->getValor()}</b>";
					echo "</a></div>";
				}
				echo"</div>";
			}
			
			if($feedbackAvaliacoes){
				echo"
				<div id='feedbackAvaliacoes'>
					<h3>Feedback de Avaliações dos Clientes</h3>
					{$produto->getAvaliacoes('ranque')}
					{$feedbackAvaliacoes}
				</div>
				<div id='avaliacoesDeClientes'>
					<h3>Avaliações de Nossos Clientes que já Adquiriram o Produto</h3>
					{$avaliacoesDeClientes}
				</div>";
			}
			?>
		</div>
	
    </body>
	<script type='text/javascript' src='js/jquery_code.js'></script>
	<script type='text/javascript' src='js/produto.js'></script>
	<script type='text/javascript' src='js/funcaoProdutosFavoritos.js'></script>
	
</html>
