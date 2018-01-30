$(function () {

    var reloadPagina = true;

    $(window).bind('beforeunload', function () {
        if (reloadPagina)
            return true;
    });
	
	 $(document).ready(function(){

		if ($('title').text().trim() == 'editar') {
			
			var genero = $('form select[name=genero]').attr('alt');
			$('form select[name=genero] option[value='+genero+']').attr('selected','selected');
			var categoria = $('form select[name=categoria]').attr('alt');
			ajaxGetCategorias(genero, categoria);
			var subcategoria = $('form select[name=subcategoria]').attr('alt');
			ajaxGetSubcategorias(categoria, subcategoria);
			
			var dataDesconto = $('#dataDeDesconto').attr('value');
			
			if(dataDeDesconto){
				date = dataDesconto.split('-');
				$('form select[name=ano] option[value='+date[0]+']').attr('selected','selected');
				$('form select[name=ano]').change();
				$('form select[name=mes] option[value='+date[1]+']').attr('selected','selected');
				$('form select[name=mes]').change();
				$('form select[name=dia] option[value='+date[2]+']').attr('selected','selected');
				$('form select[name=dia]').change();
			}

		}
	})
	
	
	
	$('form select[name=genero]').change(function(){
		var genero = $(this).val();
		
		$('form select[name=categoria]').html("<option value=''>SELECIONE UM GÊNERO PARA SELECIONAR UMA CATEGORIA</option>");
		$('form select[name=subcategoria]').html("<option value=''>SELECIONE UMA CATEGORIA PARA SELECIONAR UMA SUBCATEGORIA</option>");
		
		ajaxGetCategorias(genero);
	});	
	
	function ajaxGetCategorias(genero,selected){
		
		if(genero){
			$.ajax({
				url:'',
				method:'POST',
				dataType:'json',
				data:{
					listarCategorias:true,
					genero: genero
				}
			}).done(function(re){
				if(re){
					var options = "<option value=''>SELECIONE UMA CATEGORIA</option>";
					for(var i in re)
						options += "<option value='"+re[i][0]+"'>"+re[i][1]+"</option>";
				
					$('form select[name=categoria]').html(options);
					if(selected) $('form select[name=categoria] option[value='+selected+']').attr('selected','selected');
					
				}else{
					genero = genero == 1 ? 'Masculino' : 'Feminino';
					alert('não possui nenhuma categoria no sistema para gênero '+genero);
				}
			});	
		}
	};
	
	$('form select[name=categoria]').change(function(){
		var idCategoria = $(this).val();
		
		var nome = $(this).find('option:selected').text();
		
		$('form select[name=subcategoria]').html("<option value=''>SELECIONE UMA CATEGORIA PARA SELECIONAR UMA SUBCATEGORIA</option>");
		
		ajaxGetSubcategorias(idCategoria);

	});
	
	function ajaxGetSubcategorias(idCategoria,selected){
		
		if(idCategoria){
			$.ajax({
				url:'',
				method:'POST',
				dataType:'json',
				data:{
					listarSubcategorias:true,
					idCategoria: idCategoria
				}
			}).done(function(re){
				if(re){
					var options = "<option value=''>SELECIONE UMA SUBCATEGORIA</option>";
					for(var i in re)
						options += "<option value='"+re[i][0]+"'>"+re[i][1]+"</option>";
				
					$('form select[name=subcategoria]').html(options);
					if(selected) $('form select[name=subcategoria] option[value='+selected+']').attr('selected','selected');
				}else
					alert('não possui nenhuma subcategoria no sistema para categoria');
			});
		}
	};
	
    var arrayImgs = [], principalImg = 0, condicaoImg, indexAlteraImg;

    $('#localImg #caixaImg img').each(function (i, value) {
        arrayImgs.push($(this).attr('src').split('/').pop());
    });

    $('#btAnexarImg').click(function () {
        $('[name=inputFiles]').click();
        condicaoImg = 'inseri';
    });

    $('form [name=inputFiles]').change(function (e) {

        if ($(this).val().trim() !== '') {

            var files = e.target.files;

            var types = ['image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png'];

            if (types.indexOf(files[0].type) > -1) {

                var file = URL.createObjectURL(files[0]);

                var veSeAUrlEImagem = "<img src='" + file + "' >";

                $(veSeAUrlEImagem).bind('load',function () {

                    var w = $(this).get(0).naturalWidth;
                    var h = $(this).get(0).naturalHeight;

                    if (w >= 300 && h >= 300) {
                        if (condicaoImg == 'inseri') {

                            $('#localFileImgs #localImg').append("<div id='caixaImg'><div><label>PRINCIPAL</label>" + veSeAUrlEImagem + "</div><button type='button' id='removerImg'>remove</button><button type='button' id='alteraImg'>altera</button></div>");
                            arrayImgs.push(files[0]);
                            if (arrayImgs.length == 6)
                                $('#btAnexarImg').hide();

                        } else if (condicaoImg == 'altera') {

                            arrayImgs.splice(indexAlteraImg, 1, files[0]);
                            $('#localImg #caixaImg').eq(indexAlteraImg).find('img').attr('src', file);

                        };
                        
                    } else
                        alert('sua imagem não é grande o suficiente possui as seguintes dimenções ' + w + ' largura e ' + h + ' altura e as minimas necessarias são de 300px de largura e 300px de altura');
                });
            } else
                alert('arquivo invalido');
        }
  
    });

    $('#localFileImgs').delegate('#removerImg', 'click', function () {
        var thiss = $(this).parents('#caixaImg');
        var index = thiss.index();
        thiss.remove();
        arrayImgs.splice(index, 1);
        $('#btAnexarImg').show();

        if (principalImg === index)
            principalImg = 0;

    }).delegate('#alteraImg', 'click', function () {
        var thiss = $(this).parents('#caixaImg');
        indexAlteraImg = thiss.index();
        $('[name=inputFiles]').click();
        condicaoImg = 'altera';

    }).delegate('#localImg #caixaImg div:not(.principal)', 'mouseover mouseout', function (e) {

        if (e.type === 'mouseover') {
            $(this).find('label').show();
        } else {
            $(this).find('label').hide();
        }

    }).delegate('#localImg #caixaImg div:not(.principal)','click', function () {
		
        $('#localImg  #caixaImg div').removeAttr('class');
        $('#localImg  #caixaImg div label').hide();
        $(this).attr('class','principal');
        $(this).find('label').show();
        var index = $(this).parent('#caixaImg').index();
        principalImg = index;
		
    });
    
    function numeroParaReal(valor){
		
        valor = valor.replace(/\D/g, "");

        if(valor.length === 1)
            valor = '00'+valor;

        if(valor.length > 3 )
            valor = valor.replace(/^(0{1})(\d)/g,"$2");

        valor = valor.replace(/(\d+)(\d{2})/, "$1,$2");
        valor = valor.replace(/(\d+)(\d{3})(\,\d{2})/, "$1.$2$3");
        valor = valor.replace(/(\d+)(\d{3})(\.\d{3}\,\d{2})/, "$1.$2$3");
        valor = valor.replace(/(\d+)(\d{3})(\.\d{3}\.\d{3}\,\d{2})/, "$1.$2$3");

        return valor;

    };
	
	function calcularValores(valor,desconto){
		
		valor = valor.replace(/\D/g, "");
	
		if(valor && valor > 0){
			
			valor = valor.replace(/(\d)(\d{2})$/i, "$1.$2");
			
			valor = parseFloat(valor);
			
			if(desconto && desconto > 0)
				valor = valor - (desconto / 100 * valor);
			
			valor = valor.toFixed(2);
			
			return numeroParaReal(valor.toString());
		}
		
		return '0.00'
		
	}
    
    $('form input[name=valor]').keyup(function () {
        
        var valor = $(this).val();
        
        valor = numeroParaReal(valor);

        $(this).val(valor);
		
		 var desconto = $('input[name=desconto]').val();
		 
		valor = calcularValores(valor,desconto);
		$('#valorDesconto').text(valor);
		
		eachParcelas()
	
    });
	
	$('form input[name=desconto]').keyup(function () {
        
        var desconto = $(this).val();
		desconto = desconto.replace(/\D/g, "");

        $(this).val(desconto);
		
		 var valor = $('input[name=valor]').val();
		 
		valor = calcularValores(valor,desconto);
		$('#valorDesconto').text(valor);
		
		eachParcelas()
    });

	
	var date = new Date();
	var anoAtual = date.getFullYear();
	var mesAtual = date.getMonth()+1;
	var diaAtual = date.getDate();
	
	var anos = "<option value=''>ano</option>"
	for(i = anoAtual; i <= (anoAtual + 5); i++ )
		anos+='<option value="'+i+'">'+i+'</option>';
	
	$('form select[name=ano]').html(anos);

	function mesesDoAno(totalMeses){
		var codeMes = "<option value=''>mes</option>";
		for(var i = totalMeses ;i <= 12 ;i++ ){
			var m = i.toString().replace(/^(\d{1})$/i, "0$1");
			codeMes +='<option value="'+m+'">'+i+'</option>';
			
		}
		
		$('form select[name=mes]').html(codeMes);
		$('form select[name=dia]').html("<option value=''>dia</option>");
	}
	
	function diaDoMes(ano,mes,dia){

		var diasDoMes = new Date(ano, mes, 0).getDate();
		
		var dias = "<option value=''>dia</option>";
		for (var i = dia; i <= diasDoMes; i++){ 
			var d = i.toString().replace(/^(\d{1})$/i, "0$1")
			dias +='<option value="'+d+'">'+i+'</option>';
		}
			
		$('form select[name=dia]').html(dias);
	}
	
	$('form  select[name=ano]').change(function(){
		var ano = $('select[name=ano]').val();
	
		if(ano == anoAtual)
			mesesDoAno(mesAtual);
		else
			mesesDoAno(1);
	});
	
	$('form select[name=mes]').change(function(){
		
		var ano = $('select[name=ano]').val();
		var mes = $('select[name=mes]').val();
		
		if(ano == anoAtual && mes == mesAtual)
			diaDoMes(ano,mes,diaAtual);
		else
			diaDoMes(ano,mes,1);
	});
	
	$('#addParcela').click(function(){
		var html = "<div><input type='text' name='pacrescimo' placeholder='acréscimo R$ 0.00' > <input type='text' name='pquantas' placeholder='quantas vezes (X)'> <a id='removeParcela'>remover</a><a id='cadaParcela'><a></div>";
		$('form #inputsparcelas').append(html);
	});
	
	$('#inputsparcelas').delegate('#removeParcela','click',function(){
		$(this).parent('div').remove();
		
	}).delegate('input[name=pacrescimo]','keyup',function(){
		
		var acrescimo = $(this).val();
        
        acrescimo = numeroParaReal(acrescimo);

        $(this).val(acrescimo);
		
		var vezes = $(this).siblings('input[name=pquantas]').val();
	
		if(vezes){
			var valor = calcularValoresParcelas(acrescimo,vezes);
			$(this).siblings('#cadaParcela').text(vezes + 'x de R$ '+valor)
		}else
			$(this).siblings('#cadaParcela').text('');
		
	}).delegate('input[name=pquantas]','keyup',function(){
		
		var vezes = $(this).val().replace(/\D/g, "");

        $(this).val(vezes);
		
		if(vezes){
			var acrescimo = $(this).siblings('input[name=pacrescimo]').val();
			var valor = calcularValoresParcelas(acrescimo,vezes);
			$(this).siblings('#cadaParcela').text(vezes + 'x de R$ '+valor)
		}else
			$(this).siblings('#cadaParcela').text('');
	});
	
	function eachParcelas(){
		
		if($('#inputsparcelas div').length > 0){
		
			$('#inputsparcelas div').each(function(){
					
				var vezes = $(this).find('input[name=pquantas]').val();
				
				if(vezes){
					var acrescimo = $(this).find('input[name=pacrescimo]').val();
					var valor = calcularValoresParcelas(acrescimo,vezes);
					$(this).find('#cadaParcela').text(vezes + 'x de R$ '+valor)
				}else
					$(this).find('#cadaParcela').text('');
				
			});
		}
	};
	
	function calcularValoresParcelas(acrescimo,vezes){
		
		var valor = $('input[name=valor]').val().replace(/\D/g, "").replace(/(\d)(\d{2})$/i, "$1.$2");
		valor = valor ? valor : '0';
		
		var desconto = $('input[name=desconto]').val().replace(/\D/g, "");
		
		acrescimo = acrescimo ? acrescimo : '0';
		acrescimo = acrescimo.replace(/\D/g, "").replace(/(\d)(\d{2})$/i, "$1.$2");
		
		valor = parseFloat(valor);
		
		if(desconto && desconto > 0)
			valor = valor - (desconto / 100 * valor);
		
		valor = parseFloat(valor) + parseFloat(acrescimo);
		
		valor = valor / vezes;
		
		valor = valor.toFixed(2);
		
		return numeroParaReal(valor.toString());
	
	}
	
	$('form input[name=quantidade]').keyup(function(){
		
		var vezes = $(this).val().replace(/\D/g, "");
        $(this).val(vezes);
	})
	
    $('form').keydown(function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            return false;
        } 
    });
	
	function upload(dados) {

        var form = new FormData();
       
        form.append('imagens[0]', dados.imagens[principalImg]);
		delete dados.imagens[principalImg];
		
        var index = 1;
        for (var i in dados.imagens) {
            form.append('imagens[' + index + ']', dados.imagens[i]);
            index++;
        }
        delete dados.imagens;
        
        for (var key in dados) {
            form.append(key, dados[key]);
        }
		var title = $('title').text().trim();
		
		if(title == 'anúnciar')
			form.append('anunciarProduto', true);
		else
			form.append('editarProduto', true);

        $.ajax({
            url: '',
            data: form,
            method: 'POST',
			contentType: false,
			cache: false,
			processData: false,
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                xhr.upload.onprogress = function (e) {
                    var porcent = (Math.floor(e.loaded / e.total * 100) + '%');
                    $('#caixaUploadAnuncio #centro #progress div').css('width', porcent);
                };
                return xhr;
            }, success: function (re) {
				reloadPagina = false;
				document.write(re)
                if (title === 'anúnciar') {
                    var html = "<center><h2>produto publicado com sucesso!</h2>" +
                            "<h3><a href=''>Atualizar pagina</a></h3>" +
                            "<h3><a href='../produto.php?produto=" + re + "'>Visualizar produto</a></h3></center>";
                } else {
                    var html = "<center><h2>Produto foi editado com sucesso!</h2>" +
                            "<h3><a href=''>Atualizar Pagina</a></h3>" +
                            "<h3><a href='../produto.php?produto=" + re + "'>Visualizar produto</a></h3></center>";
                }
                $('#caixaUploadAnuncio #centro').html(html);
            }, beforeSend: function (jqXHR) {
                $('#btCancelarUploadProduto').click(function () {
                    jqXHR.abort();
                });
            }
        }).done(function(re) {
			$('header').html('retorno '+re)
		})
    };
	
	var regex = {
        valor: function (v) {
            var r = /^(\d\.?\,?){1,}$/;
            return r.test(v);
        }
    };

    $('#btUploadProduto').click(function () {
		
        var dados = {},	validacao = true;
		
		dados['categoria'] = $('form select[name=categoria] option:selected').val();
		dados['subcategoria'] = $('form select[name=subcategoria] option:selected').val();
		dados['imagens'] = arrayImgs;
		dados['nome'] = $('form input[name=nome]').val().trim();
		dados['descricao'] = $('form textarea[name=descricao]').val().trim();
		dados['valor'] = $('form input[name=valor]').val();
		dados['desconto'] = $('form input[name=desconto]').val();
		dados['novidade'] = $('form input[name=novidade]:checked').val();
		dados['quantidade'] = $('form input[name=quantidade]').val();
		dados['informacoes'] = $('form textarea[name=informacoes]').val().trim();

		if(!dados.categoria){
			validacao = false ; 
			alert('selecione uma categoria para o produto');
		}else if(!dados.subcategoria){
			validacao = false ; 
			alert('selecione uma subcategoria para o produto');
		}else if(!dados.imagens.length){
			validacao = false ; 
			alert('selecione aomenos uma imagem para o produto');
		}else if(!dados.nome){
			validacao = false ; 
			alert('preencha o campo nome do produto');
		}else if(!regex.valor(dados.valor)){
			validacao = false ; 
			alert('preencha o campo descrição do produto');
		}
		
		if(validacao && dados.desconto){
			
			var ano = $('select[name=ano] option:selected').val();
			var mes = $('select[name=mes] option:selected').val();
			var dia = $('select[name=dia] option:selected').val();
			
			if(ano && mes && dia)
				dados['dataDesconto'] = ano+'-'+mes+'-'+dia;
			else {
				validacao = false;
				alert('selecione uma data limite para o desconto');
			}
			
		}
		
		if(validacao && $('#inputsparcelas div').length > 0){
			
			parcelas = [];
			$('#inputsparcelas div').each(function(){
					
				var acrescimo = $(this).find('input[name=pacrescimo]').val() || '0';
				var vezes = $(this).find('input[name=pquantas]').val();
				
				if(vezes)
					parcelas.push([acrescimo,vezes]);
				else
					validacao = false;
			});
			
			if(!validacao) 
				alert('erro verifique os campos de quantidades de parcelas, todos devem possui valor');
			else
				dados['parcelas'] = JSON.stringify(parcelas);
		}
		
		if(validacao && !dados.quantidade){
			validacao = false;
			alert('erro preencha quantidade em estoque do produto');
		}

		if(validacao){
			$('#caixaUploadAnuncio').show();
			upload(dados);
		}
		
    });

});