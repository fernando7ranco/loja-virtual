$(function () {
	
    function textoInput(input, texto) {
        $(input).parent('p').append("<a id='textoInput' >" + texto + "</a>");
    };

    $('form input[placeholder]').focusout(function () {
        $(this).parent('p').find("#textoInput").remove();
    });

    function erro(thiss) {
        $(thiss).siblings('img').remove();
        $(thiss).parent('p').append("<img id='cf' src='img/icones/error.png'>");
    } 
	
	function load(thiss) {
        $(thiss).siblings('img').remove();
        $(thiss).parent('p').append("<img id='cf' src='img/icones/load.png'>");
    }
    function valido(thiss) {
        $(thiss).siblings('img').remove();
        $(thiss).parent('p').append("<img id='cf' src='img/icones/ok.png'>");
    }
	
	
   var regex = {
		nome: function(n){
			var r = /^([a-z A-Z\u00C0-\u00FF]){3,50}$/;
			return r.test(n);
		},
		cpf: function(t){
			var r = /^((\d{3})\.(\d{3})\.(\d{3})\-(\d{2})){1,14}$/;
			return r.test(t);
		},
		rg: function(t){
			var r = /^(\d){10}$/;
			return r.test(t);
		},
		cep: function(c){
			var r = /^(\d){8}$/;
			return r.test(c);
		},
		endereco: function(e){
			var r = /^([a-z A-Z\u00C0-\u00FF](\d{1,6})?){5,80}$/;
			return r.test(e);
		},	
		bairro: function(b){
			var r = /^([a-z A-Z\u00C0-\u00FF]){5,50}$/;
			return r.test(b);
		},
		estado: function(b){
			var r = /^([A-Z]){2}$/;
			return r.test(b);
		},
		telefone: function(t){
			var r = /^(\(\d{2}\)\s\d{4,5}-\d{4}){1,15}$/;
			return r.test(t);
		}
	};
	
	$('form input[name=nome]').keyup(function(){
		var thiss = $(this);
		thiss.val(thiss.val().replace(/ /g,' '));
		var nome = thiss.val().trim();
		
		if(regex.nome(nome))
			valido(this);
        else
            erro(this);
	}).focus(function () {
        textoInput(this, 'campo nome, somente letra de A-Z e espaços, de 3 à 50 caracteres');
    });
	
	$('form input[name=cpf]').keyup(function(){
	
		var cpf = $(this).val();
		cpf = cpf.replace(/[^\d]{1,}/g,'').replace(/(\d{3})(\d{3})(\d{3})(\d{2})$/,"$1.$2.$3-$4");
		$(this).val(cpf);
		
		if(regex.cpf(cpf))
			valido(this);
        else
            erro(this);
	}).focus(function () {
        textoInput(this, 'campo cpf, somente numeros 0-9, 11 caracteres');
    });
	
	$('form input[name=rg]').keyup(function(){
	
		var rg = $(this).val();
		rg = rg.replace(/[^\d]{1,}/g,'');
		$(this).val(rg);
		
		if(regex.rg(rg))
			valido(this);
        else
            erro(this);
	}).focus(function () {
        textoInput(this, 'campo cpf, somente numeros 0-9, 11 caracteres');
    });
	
	$('form input[name=cep]').keyup(function(){
		var thiss = $(this);
		var cep = $(this).val();
		
		if(regex.cep(cep) || cep.length == 0)
			valido(this);
        else
			erro(this);
	}).focus(function () {
        textoInput(this, 'campo cep, somente numeros de 0-9, 8 caracteres');
    }).keydown(function(event){
		
		if(event.keyCode == 13){
			var thiss = $(this);
			var cep = thiss.val();
			
			if(regex.cep(cep)){
				
				load(thiss)
				//Consulta o webservice viacep.com.br/
				$.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?",function(dados){
					
					if(!("erro" in dados)){
						$("form input[name=endereco]").val(dados.logradouro);
						$("form input[name=bairro]").val(dados.bairro);
						$("form select[name=estado] option[value="+dados.uf+"]").attr("selected","'selected'");
						valido("form input[name=endereco],form input[name=bairro],form select[name=estado]");
						$('input[name=cep]').removeClass();
					}else{
						alert("CEP não encontrado.");
						erro(thiss)
						$("form input[name=endereco],form input[name=bairro]").val('').siblings('img').remove();
						$("form select[name=estado]").siblings('img').remove();
						$("form select[name=estado] option").removeAttr('selected');
					}
					
				}).fail(function() {
					alert("erro no sistema, CEP não encontrado.");
					erro(thiss)
					$("form input[name=endereco],form input[name=bairro]").val('').siblings('img').remove();
					$("form select[name=estado]").siblings('img').remove();
					$("form select[name=estado] option").removeAttr('selected');
				});
			}else
				erro(thiss);
		}
	});
	
	$('form input[name=endereco]').keyup(function(){
		var endereco = $(this).val();
		
		if(regex.endereco(endereco))
			valido(this);
		else
			erro(this);
	}).focus(function () {
        textoInput(this, 'campo endereço, limite de 80 caracteres');
	});
	
	$('form input[name=bairro]').keyup(function(){
		var bairro = $(this).val();
		
		if(regex.bairro(bairro))
			valido(this);
		else
			erro(this);
	}).focus(function () {
        textoInput(this, 'campo bairro, limite de 50 caracteres');
	});	
	
	$('form select[name=estado]').change(function(){
	
		var estado = $(this).val();
		
		if(regex.estado(estado))
			valido(this);
		else
			erro(this);
	});	
	
	$('input[name=telefone]').keyup(function(){
		
		var thiss = $(this);
		var tel = $(this).val();
		tel = tel.replace(/[^\d]{1,}/g,'').replace(/(\d{2})(\d{4,5})(\d{4})/g,"($1) $2-$3");
		thiss.val(tel);

		if(regex.telefone(tel))
			valido(this);
		else
			erro(this);
		
	}).focus(function () {
        textoInput(this, 'campo telefone , somente numeros de 0-9, 11 caracteres');
	});

    function getDadosCadastro() {

        return {
            nome: $('form input[name=nome]').val(),
            cpf: $('form input[name=cpf]').val(),
            rg: $('form input[name=rg]').val(),
            cep: $('form input[name=cep]').val(),
            endereco: $('form input[name=endereco]').val(),
            bairro: $('form input[name=bairro]').val(),
            estado: $('form select[name=estado] option:selected').val(),
            telefone: $('form input[name=telefone]').val()
        };
    };

    function valErro() {

        var dados = getDadosCadastro();

        if (!regex.nome(dados.nome)) {
            erro('form input[name=nome]');
        }
        if (!regex.cpf(dados.cpf)) {
            erro('form input[name=cpf]');
        }
        if (!regex.rg(dados.rg)) {
            erro('form input[name=rg]');
        }
        if (!regex.cep(dados.cep)) {
            erro('form input[name=cep]');
        }
		if (!regex.endereco(dados.endereco)) {
            erro('form input[name=endereco]');
        }
        if (!regex.bairro(dados.bairro)) {
            erro('form input[name=bairro]');
        }
        if (!regex.estado(dados.estado)) {
            erro('form select[name=estado]');
        }
        if (!regex.telefone(dados.telefone) ){
            erro('form input[name=telefone]');
        } 
		
    };

    $('form #fazerCadastro').click(function () {
        var dados = getDadosCadastro();
		
        if (
			regex.nome(dados.nome) && 
			regex.cpf(dados.cpf) && 
			regex.rg(dados.rg) && 
			regex.cep(dados.cep) && 
			regex.endereco(dados.endereco) && 
			regex.bairro(dados.bairro) && 
			regex.estado(dados.estado) && 
			regex.telefone(dados.telefone)
		) {
            $.ajax({
                url: '',
                method: 'POST',
                data: {
                    editarCadastro: true,
                    dados:dados
                }
            }).done(function (re) {
				
               var retorno = re.trim();
				$('header').html(re)
				
				if( retorno == 'cpf'){
					alert('seu cpf ja possui cadastro em nosso sistema');
					erro('form input[name=cpf]');
				}else if( retorno == 'rg'){
					alert('seu rg ja possui cadastro em nosso sistema');
					erro('form input[name=rg]');
				}else{
					location.reload();
				}
            });
        } else
            valErro();
    });
	
});