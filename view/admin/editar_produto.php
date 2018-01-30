<?php
session_start();
/*
if (!isset($_SESSION['idUsuario'])) {
    header('location:index.php');
    exit;
}
$idUsuario = $_SESSION['idUsuario'];
*/

include '../../controller/controllerUploadProduto.php';
?>
<!doctype html>
<html lang='pt-br'>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" >
        <title>editar</title>
        <link type="img/x-icon" rel="shortcut icon" href="img/icones/favicon.png">
        <link type="text/css" rel='stylesheet' href='../css/anunciarEditarProduto.css'>
    </head>
    <body>
        <header id='demo'></header>
        <div id='localAnunciar'>
		
            <h2>Informações do produto</h2>
            <h5>As informações marcadas com asterisco (*) são obrigatórias</h5>

            <form>
                <p>
                    <label>Selecione um gênero *</label><br>
				
					<select id='sNormal' name='genero' alt='<?=$produto->getProdutoCS()->getGeneroCategoria();?>' >
						<option value=''>SELECIONE UM GÊNERO</option>
						<option value='1'>MASCULINO</option>
						<option value='2'>FEMENINO</option>
					</select>
                   
                </p> 
				
				<p>
                    <label>Selecione uma categoria *</label><br>
				    <select id='sNormal' name='categoria' alt='<?=$produto->getProdutoCS()->getIdCategoria();?>' >
						<option value=''>SELECIONE UM GÊNERO PARA SELECIONAR UMA CATEGORIA</option>
					</select>
                </p>
				
                <p>
                    <label>Selecione uma subcategoria *</label><br>
                    <select id='sNormal' name='subcategoria' alt='<?=$produto->getProdutoCS()->getIdSubcategoria();?>' >
						<option value=''>SELECIONE UMA CATEGORIA PARA SELECIONAR UMA SUBCATEGORIA</option>
					</select>
                </p>
				
				<p>
                    <label>Anexe até 6 imagem *</label>
                    <?php
                        $imagens = $produto->getImagens('array');
                        if (count($imagens) < 6) echo "<img src='../img/icones/anexarimagens.png' id='btAnexarImg'>";
                    ?>

                    <div id='localFileImgs'>
                        <input type='file' name='inputFiles' accept="image/jpg,image/jpeg,image/pjpeg,image/png" />
                        <div id='localImg'>
                            <?php
                                foreach ($imagens as $img) {
                                    echo"<div id='caixaImg'>
											<div>
												<label>PRINCIPAL</label>
												<img src='../img/produtos/{$img}'>
											</div>
                                            <button type='button' id='removerImg'>remove</button>
                                            <button type='button' id='alteraImg'>altera</button>
                                        </div>";
                                }
                            ?>
                        </div>
                        
                    </div>
                </p>
               
                <p>
                    <label>Adicione um nome *</label><br>
                    <font color='#e01847'>campo nome, no minimo 1 caracter e no maximo 80 caracteres</font><br>
                    <input type='text' name='nome' value='<?=$produto->getNome();?>' placeholder='nome do produto' maxlength='80'>
                </p>

                <p>
                    <label>Adicione uma descrição</label><br>
                    <font color='#e01847'>campo descrição, no maximo 400 caracteres</font><br>
                    <textarea name='descricao' placeholder='descrição do anúncio' maxlength='400'><?=$produto->getDescricao();?></textarea>
                </p>

                <p>
                    <label>Valor (R$) *</label><br>
                    <font color='#e01847'>campo valor, somente numeros de 0-9 e pontos e virgular</font><br>
                    <input type='text' name='valor' value='<?=$produto->getValor();?>' placeholder='R$ 0.00'/>
                </p>  
				
				<p>
                    <label>Adicione uma porecentagem de desconto</label><br>
					<font color='#e01847'>campo desconto, somente numeros de 0-9</font><br>
                    <input type='text' name='desconto' value='<?=$produto->getDesconto();?>' placeholder='0'/>
					<br> valor com desconto R$  <a id='valorDesconto'><?=$produto->valorComDesconto();?></a>
                    
                </p>    
				
				<p>
                    <label id='dataDeDesconto' value='<?=$produto->getDataDesconto();?>'>Adicione uma data limite para promoção: <font color='#e01847'>ANO / MÊS / DIA</font> </label><br>
                    <select name='ano' ></select> / 
					<select name='mes' ><option value=''>mes</option></select> /
					<select name='dia' ><option value=''>dia</option></select> 
				</p>
				
				<p>
                    <label>Adicione parcelas</label><br>
                    <div id='inputsparcelas'>
					<?php
						if($produto->getParcelas()){
							foreach($produto->getParcelas('array') as $valores){
								echo "<div>
									<input type='text' name='pacrescimo' value='{$valores['acrescimo']}' placeholder='acréscimo R$ 0.00' > 
									<input type='text' name='pquantas' value='{$valores['vezes']}' placeholder='quantas vezes (X)'> 
									<a id='removeParcela'>remover</a>
									<a id='cadaParcela'>{$valores['vezes']}x de R$ {$valores['valor']}<a>
								</div>";
							}
						}
					?>
					</div>
					<button type='button' id='addParcela'>add parcela</button>
				</p>
				
				<p>
                    <label>Novidade ? produto novo no sistema</label> <input type='checkbox' <?=$produto->getNovidade() ? "checked='checked'" : ''; ?> name='novidade' value='1' />
                </p>    
				
				<p>
                    <label>Quantidade em estoque *</label><br>
                    <font color='#e01847'>campo quantidade, somente numeros de 0-9</font><br>
                    <input type='text' name='quantidade' value='<?=$produto->getQuantidade();?>'placeholder='0'/>
                </p>  
				
				 <p>
                    <label>informações do produto</label><br>
                    <font color='#e01847'>campo informações, no maximo 400 caracteres</font><br>
                    <textarea name='informacoes' placeholder='informações e detalhes importantes' maxlength='400'><?=$produto->getInformacoes();?></textarea>
                </p>
				
				<button type='button' id='btUploadProduto' >editar produto</button>

            </form>

            <div id='caixaUploadAnuncio'>
                <div id='centro'>
                    <button type='button' id='btCancelarUploadProduto' >cancelar publicação</button>
                    <div id='progress'>
                        <div></div>
                        <span></span>
                    </div>
                </div>
            </div>

        </div>

    </body>
    <script type="text/javascript" src="../js/jquery_code.js"></script>
    <script type="text/javascript" src="../js/anunciarEditarProduto.js"></script>
</html>
