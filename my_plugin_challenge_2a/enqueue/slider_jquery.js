/*
*
* @pakage rtcamp_challenge_2a
*
*
*/
/*
===========================================================
			JAVASCRIPT FOR rtcamp_challenge_2a SLIDER
===========================================================
*/	

$(document).ready( function(){
	$('.plugin_slider_images img:first').addClass('ontop');
	
	if($('.plugin_slider_images img').length==1)
			return;

	var forward = function(){
		
		//for images
		var curr = $('.plugin_slider_images img.ontop');
		var next= curr.next(".plugin_slider_images img");
		
		if(next.length)
		{
			//for images
			next.addClass('ontop');
			curr.removeClass('ontop');
			
		}
		else
		{
			next= $('.plugin_slider_images img:first');
			next.addClass('ontop');
			curr.removeClass('ontop');
			
		}
	}	
	
	var backward = function(){
		
		//for images
		var curr = $('.plugin_slider_images img.ontop');
		var next= curr.prev(".plugin_slider_images img");
		
		if(next.length)
		{
			//for images
			next.addClass('ontop');
			curr.removeClass('ontop');
			
		}
		else
		{
			next= $('.plugin_slider_images img:last');
			next.addClass('ontop');
			curr.removeClass('ontop');
			
		}
	}	
	
	var start1,reset1;
	var start=function(){
		start1= setInterval(forward,3000);
	}
	var pause=function(){
		clearInterval(start1);
		clearInterval(reset1);
	}
	var reset=function(){
		reset1=setTimeout(start,3000);
	}
	
	start();
	
	$('.next_btn').click(function(){
		forward();
		pause();
		reset();
	});
	
	$('.prev_btn').click(function(){
		backward();
		pause();
		reset();
	});
});

	