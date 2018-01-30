$(document).ready(function () {
	
	$('.local-itens-da-sacola #item input').bind('change keyup',function(){
		
		var limite = parseInt($(this).attr('max'));
		var quantidade = parseInt($(this).val());
		
		if(quantidade < 1)
			$(this).val(1)
		else if(quantidade > limite)
			$(this).val(limite)
		
		quantidade = parseInt($(this).val());
		
		var valor = ( quantidade * parseFloat( $(this).attr('alt').split('/')[0] )).toFixed(2);
		
		$(this).parents('tr').find('td:eq(-2)').find('span').text(valor);
		
		var ids = $(this).parents('tr').attr('value').split('/');
		
		var dados = {
			alterarQuantidadeDeItens: true ,
			idItem: ids[0],
			idProduto: ids[1],
			quantidade: quantidade
		};
		
		$.ajax({
			url:'',
			method:'POST',
			data: dados
		}).done(function(x){
			//document.write(x)
		});
		
		eachValores();
		
	});
	
	$('.local-itens-da-sacola #item button').click(function(){
		
		var ids = $(this).parents('tr').attr('value').split('/');
		
		$(this).parents('#item').remove();
		
		var dados = {
			removerItemDaSacola: true ,
			idItem: ids[0],
			idProduto: ids[1]
		};
		
		$.ajax({
			url:'',
			method:'POST',
			data: dados
		});
		
		eachValores();
	});
   
   function eachValores(){
	   
	   var dados = {
			valor1 : 0,
			valor2 : 0
		}
		
		$('.local-itens-da-sacola #item').each(function(){
			
			var valores = $(this).find('td input').attr('alt').split('/');
			var quantidade = parseInt($(this).find('td input').val());
			
			var v1 = parseFloat(valores[0]);
			var v2 = parseFloat(valores[1]);
			
			dados.valor1 += v1 * quantidade;
			dados.valor2 += v2 * quantidade;
			
		});
		
		var valorTotal = (dados.valor1).toFixed(2);
		var valorDesconto = (dados.valor2.toFixed(2) - valorTotal).toFixed(2);
		
		$('#valorTotal').text(numeroParaReal(valorTotal));
		$('#valorDesconto').text(numeroParaReal(valorDesconto));
   }
   
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
   
});