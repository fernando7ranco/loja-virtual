<?php
session_start();
/*
if (!isset($_SESSION['idUsuario'])) {
    header('location:index.php');
    exit;
}
$idUsuario = $_SESSION['idUsuario'];
*/

include "../../controller/controllerCategoriasSubcategorias.php";
?>
<!doctype html>
<html lang='pt-br'>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" >
        <title>categorias e subcategorias</title>
        <link type="img/x-icon" rel="shortcut icon" href="img/icones/favicon.png">
        <link type="text/css" rel='stylesheet' href='../css/categoriasSubcategorias.css'>
    </head>
    <body>
        <div id='localCB'>
			<div id='localCategoiras'>
				<div>
					<input type='text' name='buscarPorCategorias' maxlength='60' placeholder='Buscar Por Categoria' ><button id='addCategoria'>adicionar</button>
				</div>
				<p id='categoriaSelecionada' >
					selecione uma categoria para ver suas subcategorias
				</p>
				<label>Gênero</label>
				
				<div id='generos' align='center'>
					<button id='foco'>todos</button><button>feminino</button><button>masculino</button>
				</div>
				<label>Categorias</label>
				<ul>
				  <?php
					if(!$listaCB)
						echo "<p>não possui nenhuma categoria cadastrada</p>";
					else
						echo $listaCB;
				  ?>
				</ul>
			</div>
			<div id='localSubcategoiras'>
				<div>
					<input type='text' name='buscarPorSubcategorias' maxlength='60' placeholder='Buscar Por Subcategoria' ><button id='addSubcategoria'>adicionar</button>
				</div>
				<div id='listSubcategoiras'>
					<ol>
					  <p>Para ver uma lista de subcategorias selecione uma categoria</p>
					</ol>
				</div>
			</div>
			
		</div>
    </body>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="../js/categoriasSubcategorias.js" ></script>
</html>
