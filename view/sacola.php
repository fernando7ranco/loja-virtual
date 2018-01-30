<?php
session_start();

include '../controller/controllerSacola.php';
?>
<!doctype html>
<html lang='pt-br'>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" >
        <title>sacola</title>
        <link rel="shortcut icon" type="img/x-icon" href="img/icones/favicon.png" >
        <link rel="stylesheet" type="text/css" href='css/sacola.css'>

    </head>
    <body>
	
		<div class='local-itens-da-sacola'>	
			<?php
			if(isset($sacola)){
				echo "<table>
						<tr>
							<th>produtos</th>
							<th>valor unitario</th>
							<th>quantidade</th>
							<th>valor total</th>
							<th></th>
						</tr>";
						
				$valorTotal = 0;	
				$valorTotalSemDesconto = 0;	
				
				foreach($sacola as $itens){
					
					echo "<tr id='item' value='{$itens->getid()}/{$itens->getIdProduto()}' >";
					echo 	"<td><img src='img/produtos/{$itens->getProduto()->getImagens('array')[0]}'>";
					echo 	"<label>{$itens->getProduto()->getProdutoCS()->getNomeSubcategoria()} - {$itens->getProduto()->getNome()}</label></td>";
					echo 	"<td>";
					echo 		$itens->getProduto()->getDesconto() ? "De <strong>R$ {$itens->getProduto()->getValor()}</strong> <br> Por <b>R$ {$itens->getProduto()->getValor('desconto')}</b>" : "<b>R$ {$itens->getProduto()->getValor()}</b>";
					echo 	"</td>";
					
					$qtd = $itens->getProduto()->getQuantidade() < $itens->getQuantidade() ? $itens->getProduto()->getQuantidade() : $itens->getQuantidade();
					
					$valorUnidadeString = $itens->getProduto()->getDesconto() ? $itens->getProduto()->getValor('desconto') : $itens->getProduto()->getValor();
					$valorUnidade =  $itens->getProduto()->getDesconto() ? $itens->getProduto()->valorComDesconto(0) : $itens->getProduto()->getValor(0);
					
					echo 	"<td><input type='number' alt='{$valorUnidade}/{$itens->getProduto()->getValor(0)}' value='{$qtd}' min='1' max='{$itens->getProduto()->getQuantidade()}' ></td>";
					echo "<td>R$ <span>{$valorUnidadeString}</span></td>";
					echo "<td><button>remover</button></td>";
					echo "</tr>";
					
					$valorTotal+= $valorUnidade * $qtd;
					$valorTotalSemDesconto+= $itens->getProduto()->getValor(0) * $qtd;
				}
				echo "</table>";
				
				$valorTotal = number_format(round($valorTotal,2),2,'.','');
				$valorTotalSemDesconto = number_format(round( ($valorTotalSemDesconto - $valorTotal) ,2),2,'.','');
				
				echo "<div id='local-finalizar'>";
				echo 	"<lable>CALCULAR FRETE</lable><input type='text' name='cep-frete' placeholder='Informe um CEP válido' >";
				
				$itens->getProduto()->setValor($valorTotal);
				echo 	"<h3>valor total R$ <a id='valorTotal'>{$itens->getProduto()->getValor()}</a></h3>";
				
				$itens->getProduto()->setValor($valorTotalSemDesconto);
				echo 	"<h3>desconto total R$ <a id='valorDesconto'>{$itens->getProduto()->getValor()}</a></h3>";
				
				echo 	"<button>finalizar compras</button>";
				echo "</div>";

			}else{
				echo "<div align='center'>
					<h4>Para continuar comprando, navegue pelas categorias do site ou faça uma busca pelo seu produto.</h4>
					<h2>Por enquanto sua sacola está vazia</h2>
					<h3>Para adicionar produto a sua sacola basta acessar pagina de visualização <br> do produto e clicar no botão 'ADICIONAR NA SACOLA DE COMPRAS'.</h3>
					<a href='produtos'>ir para os produtos</a>
					</div>";
			}
			?>
		</div>
	
    </body>
	<script type='text/javascript' src='js/jquery_code.js'></script>
	<script type='text/javascript' src='js/sacola.js'></script>
	
</html>
