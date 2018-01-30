$(document).ready(function () {

	$('#imagensProduto div:eq(0)').delegate('img:not(#imgFoco)','click',function(){
		$(this).siblings('#imgFoco').removeAttr('id');
		$(this).attr('id','imgFoco');
		
		var source = $(this).attr('src');
		
		$('#imagensProduto div:eq(1)').find('img').attr('src',source);
	})
   
   $('#btInserirNaSacola').click(function(){
	 
	 var dados = {
		 inserirNaSacola: true,
		 idProduto: $(this).attr('value')
	 }
	 
	 $.ajax({
		url: '',
		method: 'POST',
		data: dados
	 }).done(function(x){
		 location.href = 'sacola';
	 });
	 
   });
   
   $('#infoProduto #maisDetalhes').hover(function(){
	   $('#infoDetalhes').stop(true,true).slideDown();
   },function(){
	    $('#infoDetalhes').slideUp();
   });
   
});