 $(function(){
 	 
 	$(window).scroll(function(){
 		vitrihientai=$('html,body').scrollTop();
 		console.log(vitrihientai);
 		/*menu*/
 		if(vitrihientai>15)
 		{
 			$('.thanhmenu').addClass('biendoimenu');
 			$('#navHeader').addClass('navHidden');
 			$('#navHeader').removeClass('navVisible');
 			$('#navTop').addClass('navVisible');
 			$('#navTop').removeClass('navHidden');
 		}
 		else if(vitrihientai<15)
 		{
 			$('.thanhmenu').removeClass('biendoimenu');
 			$('#navHeader').addClass('navVisible');
 			$('#navHeader').removeClass('navHidden');
 			$('#navTop').addClass('navHidden');
 			$('#navTop').removeClass('navVisible');
 		}
 		if(vitrihientai>15)
 		{
 			$('.thanhmenu ul.navbar-nav li.nav-item a.nav-link').addClass('biendoichumenu');
 		}
 		else if(vitrihientai<15)
 		{
 			$('.thanhmenu ul.navbar-nav li.nav-item a.nav-link').removeClass('biendoichumenu');
 		}
 	})
})  
