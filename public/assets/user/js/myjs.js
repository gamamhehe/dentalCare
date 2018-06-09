 $(function(){
 	$('.c1').click(function(){
 		$('html,body').animate({scrollTop:0},1100,"easeInOutExpo");
 		return false;
 	})
 	$('.c2').click(function(){
 		$('html,body').animate({scrollTop:632},1100,"easeInOutExpo")
 		return false;
 	})
 	$('.c3').click(function(){
 		$('html,body').animate({scrollTop:1500},1100,"easeInOutExpo")
 		return false;
 	})
 	$('.c4').click(function(){
 		$('html,body').animate({scrollTop:3865},1100,"easeInOutExpo")
 		return false;
 	})
 	$('.c5').click(function(){
 		$('html,body').animate({scrollTop:4965},1100,"easeInOutExpo")
 		return false;
 	})
 	$('.c6').click(function(){
 		$('html,body').animate({scrollTop:5765},1100,"easeInOutExpo")
 		return false;
 	})
 	$(window).scroll(function(){
 		vitrihientai=$('html,body').scrollTop();
 		console.log(vitrihientai);
 		/*menu*/
 		if(vitrihientai>199)
 		{
 			$('.thanhmenu').addClass('biendoimenu');
 		}
 		else if(vitrihientai<199)
 		{
 			$('.thanhmenu').removeClass('biendoimenu');
 		}
 		if(vitrihientai>199)
 		{
 			$('.thanhmenu ul.navbar-nav li.nav-item a.nav-link').addClass('biendoichumenu');
 		}
 		else if(vitrihientai<199)
 		{
 			$('.thanhmenu ul.navbar-nav li.nav-item a.nav-link').removeClass('biendoichumenu');
 		}
 		/*about*/

 		if(vitrihientai>299)
 		{
 			$('.hinhabout').addClass('traiqua');
 		}
 		else if(vitrihientai<299)
 		{
 			$('.hinhabout').removeClass('traiqua');
 		}
 		if(vitrihientai>299)
 		{
 			$('.textabout').addClass('phaiqua');
 		}
 		else if(vitrihientai<299)
 		{
 			$('.textabout').removeClass('phaiqua');
 		}
 	})
})  
