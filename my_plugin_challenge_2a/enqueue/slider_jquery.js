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
	var slider_types = $('#slider_type').val();
	console.log(slider_types);
	if(!slider_types)	
	{
		return;
	}
	slider_types = JSON.parse(slider_types);
	console.log(slider_types);
	slider_types.forEach(function(element){
		slider_front_end(element);
	});
	
	function slider_front_end(slider_type){
		$(".plugin_slider_images-"+ slider_type +" img:first").addClass('ontop');
		
		if($(".plugin_slider_images-"+slider_type+" img").length==1)
				return;

		var forward = function(){
			
			//for images
			var curr = $(".plugin_slider_images-"+slider_type+" img.ontop");
			var next= curr.next(".plugin_slider_images-"+slider_type+" img");
			
			if(next.length)
			{
				//for images
				next.addClass('ontop');
				curr.removeClass('ontop');
				
			}
			else
			{
				next= $(".plugin_slider_images-"+slider_type+" img:first");
				next.addClass('ontop');
				curr.removeClass('ontop');
				
			}
		}	
		
		var backward = function(){
			
			//for images
			var curr = $(".plugin_slider_images-"+slider_type+" img.ontop");
			var next= curr.prev(".plugin_slider_images-"+slider_type+" img");
			
			if(next.length)
			{
				//for images
				next.addClass('ontop');
				curr.removeClass('ontop');
				
			}
			else
			{
				next= $(".plugin_slider_images-"+slider_type+" img:last");
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
		
		$(".next_btn-"+slider_type).click(function(){
			forward();
			pause();
			reset();
		});
		
		$(".prev_btn-"+slider_type).click(function(){
			backward();
			pause();
			reset();
		});
	
	}
	/****************Lazy Loading********************
	*************************************************/
	/*
	window.onscroll = function(ev){
		imageload();
	}*/
	imageload();
	function imageload(){
		var img = document.getElementsByClassName("load_img");
		for (var i=0;i<img.length;i++){
			if(elementInViewport(img[i])){
				img[i].setAttribute('src',img[i].getAttribute('data-src'));
			}
		}
	}
	
	function elementInViewport(el){
		var rect = el.getBoundingClientRect();
		return (
			rect.top >=0 &&
			rect.left >=0 &&
			rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
			rect.right <= (window.innerWidth || document.documentElement.clientWidth) 
			);
	}
});

	