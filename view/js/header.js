$(document).ready(function () {
	
	$('header #sacola').hover(function(){
		$('header #conteudo-da-sacola').stop(true,true).show();
	},function(){
		$('header #conteudo-da-sacola').hide();
		
	}).click(function(){
		location.href = 'sacola';
	});
    
   $('#localCS div div').hover(function(){
	   $(this).find('ul').stop(true,true).slideDown();
   },function(){
	    $(this).find('ul').slideUp();
   });
   
   $('#filtros').delegate('div[id$=CS]:not(.foco)','mouseover',function(){
	   
	   if($(this).index()){
		   $('#localCS #f').hide();
		   $('#localCS #m').show();
	   }else{
		   $('#localCS #m').hide();
		   $('#localCS #f').show();
	   }
	   
	   $(this).siblings('div[id$=CS]').removeClass();
	   $(this).addClass('foco');
   });
   
   $('#search').submit(function(){
	   
		var pn = window.location.pathname.split('/').pop();
	   
		var url = pn.match(/\[([a-zA-Z\-\+]+)\]/g);
		var o = $(this).find('select option:selected').val();
		var s = $(this).find('input[type=search]').val().trim();
		
		if(url)
			window.location.href= 'produtos='+ url[0] +'&order='+ o +'&search='+ s;
		else
			window.location.href= 'produtos?order='+ o +'&search='+ s;
			
		return false;
		
	});
  
	$('#search select').change(function(){
		$('#search').submit();
	});
	
});