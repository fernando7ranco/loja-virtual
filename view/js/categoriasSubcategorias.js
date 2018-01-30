$(function () {
	
	$('#localCategoiras input[name=buscarPorCategorias]').keyup(function(){
		var dados = {
			buscarPorCategorias: true,
			nome:  $(this).val().trim(),
			genero: $('#localCategoiras #generos button#foco').index()
		};
		
		htmlLoading('#localCategoiras ul');
		
		$.ajax({
			url:'categorias_subcategorias.php',
			method:'POST',
			data:dados
		}).done(function(re){
			
			var html = re.trim();
			
			if(!html) html = "<p> não foi encontrado nenhuma correspondecia para: "+dados.nome+"</p>";
			
			$('#localCategoiras ul').html(html);
		});
		
	});
	
	$('#localSubcategoiras input[name=buscarPorSubcategorias]').keyup(function(){
		var dados = {
			buscarPorSubcategorias: true,
			idCategoria: $('#localCategoiras #categoriaSelecionada').attr('value'),
			nome: $(this).val().trim(),
		};
		
		if(dados.idCategoria){
			htmlLoading('#listSubcategoiras ol');
			$.ajax({
				url:'categorias_subcategorias.php',
				method:'POST',
				data:dados
			}).done(function(re){
				
				var html = re.trim();
				
				if(!html) html = "<p> não foi encontrado nenhuma correspondecia para: "+dados.nome+"</p>";
				
				$('#listSubcategoiras ol').html(html);
			});
		}else
			$('#listSubcategoiras ol').html("<p>Para buscar por uma subcategoria primeiro selecione ao lado categoria</p>");
		
	});
	
	$('#addCategoria').click(function(){
		
		var html = "<div align='center' id='boxAdicionarCategoria'>"+
				"<h3>Inserir Categoria</h3>"+
				"<p>"+
					"Feminino <input type='radio' value='1' checked='checked' name='generoCategoria'>"+
					" Masculino <input type='radio' value='2' name='generoCategoria'>"+
				"</p>"+
				"<p>"+
					"<input type='text' name='nomeCategoria' maxlength='60' placeholder='Nome da Categoria'>"+
				"</p>"+
				"<p>"+
					"<button id='cancelarAcao'>cancelar</button><button id='adicionarCategoria'>inserir</button>"+
				"</p>"+
			"</div>";
		lightbox(html);
	});
	
	$('body').delegate('#boxAdicionarCategoria #adicionarCategoria','click',function(){
		
		var dados = {
			adicionarCategoria: true,
			genero: $('#boxAdicionarCategoria input[name=generoCategoria]:checked').val(),
			nome: $('#boxAdicionarCategoria input[name=nomeCategoria]').val().trim()
		}

		if(dados.nome){
		
			$.ajax({
				url:'categorias_subcategorias.php',
				method:'POST',
				data:dados
			}).done(function(re){
				location.reload();
			});
		}else
			alert('insira um nome para categoria')
		
	});
	
	$('#addSubcategoria').click(function(){
		
		var genero  = $('#localCategoiras #categoriaSelecionada a').text().trim();
		var checked = ['',''];

		
		if(genero == '| feminino |' || genero == '| masculino |'){
			var index = genero == '| feminino |' ? 0 : 1;
			checked[index] = "checked='checked'";
		}
		
		var html = "<div align='center' id='boxAdicionarSubcategoria' >"+
				"<h3>Inserir Subcategoria</h3>"+
				"<p>"+
					"Feminino <input type='radio' value='1' name='generoCategoria' "+checked[0]+">"+
					" Masculino  <input type='radio' value='2' name='generoCategoria' "+checked[1]+">"+
				"</p>"+
				"<p>"+
					"<select name='allCategorias'><option value=''>selecione um gênero para selecionar uma categoria</option></select>"+
				"</p>"+
				"<p>"+
					"<input type='text' name='nomeSubcategoria' maxlength='60' placeholder='Nome da Subcategoria'>"+
				"</p>"+
				"<p>"+
					"<button id='cancelarAcao'>cancelar</button><button id='adicionarSubcategoria' >inserir</button>"+
				"</p>"+
			"</div>";
		lightbox(html);
	
		if(genero == '| feminino |' || genero == '| masculino |'){
			index = !index ? 1 : 2;
			listarInSelectcategorias(index);
		}
	});
	
	$('body').delegate('#boxAdicionarSubcategoria input[name=generoCategoria]','change',function(){
		listarInSelectcategorias($(this).val());
		
	}).delegate('#boxAdicionarSubcategoria #adicionarSubcategoria','click',function(){
		
		var dados = {
			adicionarSubcategoria: true,
			idCategoria: $('#boxAdicionarSubcategoria select option:selected').val(),
			nome: $('#boxAdicionarSubcategoria input[name=nomeSubcategoria]').val().trim()
		}

		if(dados.idCategoria && dados.nome){
		
			$.ajax({
				url:'categorias_subcategorias.php',
				method:'POST',
				data:dados
			}).done(function(re){
				
				if($('#boxAdicionarSubcategoria select option:selected').val() == $('#localCategoiras #categoriaSelecionada').attr('value')){
					
					var dados = {
						buscarPorSubcategorias: true,
						idCategoria: $('#localCategoiras #categoriaSelecionada').attr('value'),
						nome: '',
					};
					htmlLoading('#listSubcategoiras ol');
					$.ajax({
						url:'categorias_subcategorias.php',
						method:'POST',
						data:dados
					}).done(function(re){
						var html = re.trim();
						$('#listSubcategoiras ol').html(html);
					});
				}
				
				$('#boxAdicionarSubcategoria input[name=nomeSubcategoria]').val('');
			});
		}else
			alert('selecione uma categoria e insira um nome para subcategoria')
		
	});
	
	function listarInSelectcategorias(genero){
		
		$.ajax({
			url:'categorias_subcategorias.php',
			method:'POST',
			dataType:'json',
			data:{requisitarCategoria: true, genero: genero}
		}).done(function(re){
		
			if(re){
		
				var options = "<option value=''>selecione uma categoria</option>";
				
				var idCategoria = $('#localCategoiras #categoriaSelecionada').attr('value');
				
				for(var i in re){
				
					selected = re[i][0] == idCategoria ? "selected='selected'": '';
					
					options += "<option "+selected+" value='"+re[i][0]+"'>"+re[i][1]+"</option>";
				}
				
				$('#boxAdicionarSubcategoria select').html(options);
			}else
				alert('não é possui adicionar uma subcategoria porque ainda não possui nenhuma categoria no sistema');
		});
	}
	
	$('#localCategoiras #generos').delegate('button:not(#foco)','click',function(){
		
		$(this).siblings('#foco').removeAttr('id');
		$(this).attr('id','foco');
		
		var dados = {
			buscarPorCategorias: true,
			nome:  '',
			genero: $(this).index()
		};
		
		switch(dados.genero){
			case 0: var generoTexto = 'todos';
			case 1: var generoTexto = 'Feminino';
			case 2: var generoTexto = 'Masculino';
		}
		
		htmlLoading('#localCategoiras ul');
		
		$.ajax({
			url:'categorias_subcategorias.php',
			method:'POST',
			data:dados
		}).done(function(re){
			
			var html = re.trim();
			
			if(!html) html = "<p> não foi encontrado nenhuma correspondecia para: Gênero "+generoTexto+"</p>";
			
			$('#localCategoiras ul').html(html);
		});
		
	});
	
	$('#localCategoiras ul').delegate('li div','click',function(){
		
		var idCategoria = $(this).parent('li').attr('value');
		var categoria = $(this).find('a').text();
		var genero = $(this).find('span').text();
		
		$('#localCategoiras #categoriaSelecionada').html(categoria + '<a>| '+genero+' |</a>');
		$('#localCategoiras #categoriaSelecionada').attr('value',idCategoria);
		
		var dados = {
			buscarPorSubcategorias: true,
			idCategoria: idCategoria,
			nome:'',
		};
		
		htmlLoading('#localSubcategoiras ol');
		
		$.ajax({
			url:'categorias_subcategorias.php',
			method:'POST',
			data:dados
		}).done(function(re){
			
			var html = re.trim();
			
			if(!html) html = "<p>categoria "+categoria+" não possui subcategorias</p>";
			
			$('#listSubcategoiras ol').html(html);
		});
		
	
	}).delegate('li #btEditar','click',function(){
		
		var idCategoria = $(this).parent('li').attr('value');
		var nome = $(this).parent('li').find('div a').text().trim();
		var genero = $(this).parent('li').find('div span').text().trim();
		
		var checked = ['',''];
		var index = genero == 'feminino' ? 0 : 1;
		checked[index] = "checked='checked'";
			
		var html = "<div align='center' id='boxEditarCategoria'>"+
				"<h3>Editar Categoria</h3>"+
				"<p>"+
					"Feminino <input type='radio' value='1' name='generoCategoria' "+checked[0]+">"+
					" Masculino <input type='radio' value='2' name='generoCategoria' "+checked[1]+">"+
				"</p>"+
				"<p>"+
					"<input type='text' name='nomeCategoria' maxlength='60' value='"+nome+"' >"+
				"</p>"+
				"<p>"+
					"<button id='cancelarAcao'>cancelar</button><button id='editarCategoria' value='"+idCategoria+"' >salvar</button>"+
				"</p>"+
			"</div>";
		lightbox(html);
		
	}).delegate('li #btExcluir','click',function(){
		
		var idCategoria = $(this).parent('li').attr('value');
		var nome = $(this).parent('li').find('div a').text().trim();
		var genero = $(this).parent('li').find('div span').text().trim();
	
		var html = "<div align='center' id='boxExcluirCategoria'>"+
				"<h3>Excluir Categoria</h3>"+
				"<h3>"+nome+" | "+genero+" |</h3>"+
				"<h4><font color='red'>Ao excluir esta categoria suas subcategorias também serão excluidas.<br> e também os produtos que possuim ligação a ela</font></h4>"+
				"<button id='cancelarAcao'>cancelar</button><button id='excluirCategoria' value='"+idCategoria+"' >excluir</button>"+
			"</p>";
		lightbox(html);
	});
	
	$('body').delegate('#boxEditarCategoria #editarCategoria','click',function(){
		
		var dados = {
			editarCategoria: true,
			idCategoria: $(this).attr('value'),
			genero: $('#boxEditarCategoria input[name=generoCategoria]:checked').val(),
			nome: $('#boxEditarCategoria input[name=nomeCategoria]').val().trim()
		};
		
		$.ajax({
			url:'categorias_subcategorias.php',
			method:'POST',
			data:dados
		}).done(function(re){
			location.reload();
		});
		
	}).delegate('#boxExcluirCategoria #excluirCategoria','click',function(){

		var dados = {
			excluirCategoria: true,
			idCategoria: $(this).attr('value')
		};
		
		$.ajax({
			url:'categorias_subcategorias.php',
			method:'POST',
			data:dados
		}).done(function(re){
			location.reload();
		});
	});
		
	
	$('#localSubcategoiras ol').delegate('li #btEditar','click',function(){
		
		var idSubcategoria = $(this).parent('li').find('div').attr('value');
		
		var nome = $(this).parent('li').find('div').text().trim();
		
		var html = "<div align='center' id='boxEditarSubcategoria' >"+
				"<h3>Editar Subcategoria</h3>"+
				"<p>"+
					"<input type='text' name='nomeSubcategoria' maxlength='60' value='"+nome+"' >"+
				"</p>"+
				"<p>"+
					"<button id='cancelarAcao'>cancelar</button><button id='editarSubcategoria' value='"+idSubcategoria+"' >salvar</button>"+
				"</p>"+
			"</div>";
		lightbox(html);
		
	}).delegate('li #btExcluir','click',function(){
		
		var idSubcategoria = $(this).parent('li').find('div').attr('value');
		var nome = $(this).parent('li').find('div').text();
		
		var html = "<div align='center' id='boxExcluirSubcategoria' >"+
				"<h3>Excluir Subcategoria</h3>"+
				"<h3>"+nome+"</h3>"+
				"<h4><font color='red'>Ao excluir esta subcategoria os produtos que possuim ligação a ela também serão excluidos</font></h4>"+
				"<button id='cancelarAcao'>cancelar</button><button id='excluirSubcategoria' value='"+idSubcategoria+"'>excluir</button>"+
			"</p>";
		lightbox(html);
	});

	$('body').delegate('#boxEditarSubcategoria #editarSubcategoria','click',function(){
		
		var dados = {
			editarSubcategoria: true,
			idSubcategoria: $(this).attr('value'),
			nome: $('#boxEditarSubcategoria input[name=nomeSubcategoria]').val().trim()
		};
		
		if(dados.nome){
			$.ajax({
				url:'categorias_subcategorias.php',
				method:'POST',
				data:dados
			}).done(function(re){
				$('#localSubcategoiras ol li div[value='+dados.idSubcategoria+']').text(dados.nome);
				$('#lightbox').remove();
			});
			
		}else
			alert('insira um nome para subcategoria');
		
	}).delegate('#boxExcluirSubcategoria #excluirSubcategoria','click',function(){

		var dados = {
			excluirSubcategoria: true,
			idSubcategoria: $(this).attr('value')
		};
		
		$.ajax({
			url:'categorias_subcategorias.php',
			method:'POST',
			data:dados
		}).done(function(re){
			$('#localSubcategoiras ol li div[value='+dados.idSubcategoria+']').parent('li').remove();
			$('#lightbox').remove();
		});
	});
	
	function lightbox(conteudo) {
        var html = "<div id='lightbox'>" +
                "<div id='conteudoLightbox'>" +
                conteudo +
                "</div>" +
            "</div>";
        $('body').append(html);
    }
	
	function htmlLoading(caminho){
		
		$(caminho).html("<p id='loading'>carregando <img src='../img/icones/load.gif'></p>")
	}
	
	$('body').delegate('#lightbox #conteudoLightbox #cancelarAcao', 'click', function (e) {
        $('#lightbox').remove();
    });
	
	
});