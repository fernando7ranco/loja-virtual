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
        <title>anúnciar</title>
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
					
					<select id='sNormal' name='genero'>
						<option value=''>SELECIONE UM GÊNERO</option>
						<option value='1'>MASCULINO</option>
						<option value='2'>FEMENINO</option>
					</select>
                   
                </p> 
				
				<p>
                    <label>Selecione uma categoria *</label><br>
				    <select id='sNormal' name='categoria' >
						<option value=''>SELECIONE UM GÊNERO PARA SELECIONAR UMA CATEGORIA</option>
					</select>
                </p>
				
                <p>
                    <label>Selecione uma subcategoria *</label><br>
                    <select id='sNormal' name='subcategoria' >
						<option value=''>SELECIONE UMA CATEGORIA PARA SELECIONAR UMA SUBCATEGORIA</option>
					</select>
                </p>
				
                <p>
                    <label>Anexe até 6 imagem *</label><img src='../img/icones/anexarimagens.png' id='btAnexarImg'>

					<div id='localFileImgs'>
						<input type='file' name='inputFiles' accept="image/jpg,image/jpeg,image/pjpeg,image/png" />
						<div id='localImg'></div>
					</div>

                </p>
               
                <p>
                    <label>Adicione um nome *</label><br>
                    <font color='#e01847'>campo nome, no minimo 1 caracter e no maximo 80 caracteres</font><br>
                    <input type='text' name='nome' placeholder='nome do produto' maxlength='80'>
                </p>

                <p>
                    <label>Adicione uma descrição</label><br>
                    <font color='#e01847'>campo descrição, no maximo 400 caracteres</font><br>
                    <textarea name='descricao' placeholder='descrição do anúncio' maxlength='400'></textarea>
                </p>

                <p>
                    <label>Valor (R$) *</label><br>
                    <font color='#e01847'>campo valor, somente numeros de 0-9 e pontos e virgular</font><br>
                    <input type='text' name='valor' placeholder='R$ 0.00'/>
                </p>  
				
				<p>
                    <label>Adicione uma porecentagem de desconto</label><br>
					<font color='#e01847'>campo desconto, somente numeros de 0-9</font><br>
                    <input type='text' name='desconto' placeholder='0'/>
					<br> valor com desconto R$  <a id='valorDesconto'>0.00</a>
                    
                </p>    
				
				<p>
                    <label>Adicione uma data limite para promoção: <font color='#e01847'>ANO / MÊS / DIA</font> </label><br>
                    <select name='ano' ></select> / 
					<select name='mes' ><option value=''>mes</option></select> /
					<select name='dia' ><option value=''>dia</option></select> 
				</p>
				
				<p>
                    <label>Adicione parcelas</label><br>
                    <div id='inputsparcelas'></div>
					<button type='button' id='addParcela'>add parcela</button>
				</p>
				
				<p>
                    <label>Novidade ? produto novo no sistema</label> <input type='checkbox' name='novidade' value='1' />
                </p>    
				
				<p>
                    <label>Quantidade em estoque *</label><br>
                    <font color='#e01847'>campo quantidade, somente numeros de 0-9</font><br>
                    <input type='text' name='quantidade' placeholder='0'/>
                </p>  
				
				<p>
                    <label>informações do produto</label><br>
                    <font color='#e01847'>campo informações, no maximo 400 caracteres</font><br>
                    <textarea name='informacoes' placeholder='informações e detalhes importantes' maxlength='400'></textarea>
                </p>
				
				<button type='button' id='btUploadProduto' >anunciar produto</button>

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
