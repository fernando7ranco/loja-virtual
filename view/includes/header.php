<?php include '../controller/controllerHeader.php';?>
<header>

	<h4 id='logoSite'>
		<a href='inicio'>logo</a>
	</h4>
	
	<div class='localLC'> 
	
		<div id='loginCliente'>
			<img src='img/icones/user.png'>
			<?= isset($_SESSION['info-cliente']) ? $_SESSION['info-cliente']['nome'] : "<a href='inicio=entrar' >entrar</a>";?>
		</div>
		
		<div id='sacola'>
			<span><?=count($sacola)?></span>
			<img src='img/icones/sacola.png'>
			sacola
			<div id='conteudo-da-sacola'>
			<?php
			if(isset($sacola)){

				$valorTotal = 0;	
				foreach($sacola as $itens){
					
					echo "<div id='item' value='{$itens->getid()}/{$itens->getIdProduto()}' >";
					echo 	"<img src='img/produtos/{$itens->getProduto()->getImagens('array')[0]}'>";
							$valorUnidadeString = $itens->getProduto()->getDesconto() ? $itens->getProduto()->getValor('desconto') : $itens->getProduto()->getValor();
					echo 	"<label>{$itens->getProduto()->getProdutoCS()->getNomeSubcategoria()} {$itens->getProduto()->getNome()} <br> R$ {$valorUnidadeString}</label>";
					echo "</div>";
					
					$valorUnidade =  $itens->getProduto()->getDesconto() ? $itens->getProduto()->valorComDesconto(0) : $itens->getProduto()->getValor(0);
					$qtd = $itens->getProduto()->getQuantidade() < $itens->getQuantidade() ? $itens->getProduto()->getQuantidade() : $itens->getQuantidade();
					
					$valorTotal+= $valorUnidade * $qtd;
					
				}
				$valorTotal = number_format(round($valorTotal,2),2,'.','');
		
				$itens->getProduto()->setValor($valorTotal);
				echo "<h4>valor total R$ {$itens->getProduto()->getValor()}</h4>";
			
			}else{
				echo "<div align='center'><h5>Por enquanto sua sacola está vazia</h5></div>";
			}
			?>
			</div>
		</div>
		
	</div>
	
	<?= isset($_SESSION['info-cliente']) ? "<div id='opCliente'> 
			<a href='cadastrocliente'>meu cadastro</a>
			<a href='meusfavoritos'>meus favoritos</a><a>minhas compras</a>
			<a href='sair'>sair</a> </div>": null ;?>
			
	<div class='local-filtros'>
		<div id='filtros'>
			<div id='femininoCS' class='foco' >
				<a href='produtos=[feminino]'>Feminino</a>
			</div>
			
			<div id='masculinoCS'>
				<a href='produtos=[masculino]'>masculino</a>
			</div>
			
			<form id='search'>
				<?php
			
					$order = isset($_GET['ordem']) ? $_GET['ordem'] : null;
					$search = isset($_GET['search']) ? trim($_GET['search']) : null;
					
					for($i = 0; $i < 5; $i++)
						$selected[] = $order == $i ? "selected='selected'" : null;
				?>
				<select name='order'>
					<option <?=$selected[0]?> value='0'>ordernar por</option>
					<option <?=$selected[1]?> value='1'>maior valor</option>
					<option <?=$selected[2]?> value='2'>menor valor</option>
					<option <?=$selected[3]?> value='3'>melhor desconto</option>
					<option <?=$selected[4]?> value='4'>melhores avaliações</option>
				</select>
				<input type='search' name='search' value='<?=$search?>' placeholder="BUSQUE POR PRODUTOS, MARCAS..." ><button></button>
			</form>
		</div>
	</div>

	<div id='localCS'>
		<div id='f'><?=$listaCategorias['feminino'];?></div>
		<div id='m'><?=$listaCategorias['masculino'];?></div>
	</div>
	
</header>