/*
*
* @pakage rtcamp_challenge_2a
*
*
*/
/*
=====================================================
			JAVASCRIPT FOR rtcamp_challenge_2a
=====================================================
*/

jQuery(document).ready( function(){
	
	//set media_uploader	
	var imageUploader;
	
	//store selected images
	var imgs = new Array();
	
	//saved data
	var prev_data = $('#Slider-images').val();
	console.log(prev_data);
	
	if(prev_data)	
	{
		prev_data = JSON.parse(prev_data);
	}
	
	var temp = new Array();
	
	if(!$('.ui-state-default').length)
	{
		document.getElementById('text').innerHTML="No Image is present click on <strong>Insert Image</strong> button to add images to slider......";
	    $("#remove-all-button").css({"display":"none"});
		$("#change-index").css({"display":"none"});
		$("#selectandremove").css({"display":"none"});
		
	}
	
	/**********************************************************************
					INSERT IMAGES OPTION : SET WP_IMAGE_UPLOADER AND 
							SAVE SELECTED IMAGES
	
	************************************************************************/
	
	$('#upload-button').on('click',function(e){
		
		
		
		e.preventDefault();
		
		if(imageUploader){
			
			imageUploader.open();
			return;
		}
		
		imageUploader = wp.media.frames.file_frame = wp.media({
			
				title: 'Select Images for Slider',
				button:{
					text: 'Add Images'
				},
				multiple: 'add'
		});
	
		imageUploader.on('select',function(){
			
			var selection =  imageUploader.state().get('selection');
			selection.map( function( attachment ) {
				
				attachment = attachment.toJSON();
				imgs.push(attachment.url);
			
				
			});
			
			for(var i=imgs.length-1 ; i>=0 ; i--){
				$('#image_ul').prepend("<li class=\"ui-state-default\" id="+imgs[i]+"><img id=\"image-list\" src="+imgs[i]+"></li>");
			}
			
			if(prev_data)
			{
				imgs = imgs.concat(prev_data);
				
			}	
			$('#Slider-images').val(JSON.stringify(imgs));
			
			document.getElementById('text').innerHTML="Click on the  <strong>Save Button</strong> to save changes or refresh the page.....";
			$(".plugin-button").css({"display":"none"});
			
		});
		
		
		imageUploader.open();
	
	
	});
	
	
	
	
	/**********************************************************************
					SORTABLE OPTION : SAVE SORTED LIST OF IMAGES 
	
	************************************************************************/
	
	var new_list;
	
	$('#change-index').on('click',function(){
		
		document.getElementById('text').innerHTML="Click and Hold the image and drag the image to specific index of your choice\
		and click on <strong>Save Button</strong> or refresh the page.....";
		$(".plugin-button").css({"display":"none"});
		$(".slider_settings img").css({"border":"2px dashed"});
		
		$( function() {
		
		$( "#image_ul" ).sortable({
			stop: function(e, ui) {
			
				new_list = $('#image_ul').sortable('toArray');
				
				console.log(new_list);
				$('#Slider-images').val(JSON.stringify(new_list));
				
		  }
		 
		}).disableSelection();
		
    } );
	
	})
	
	
	
	/**********************************************************************
					REMOVE IMAGES OPTION : REMOVE SELECTED IMAGES
					
	************************************************************************/
	
	//***************************SELECT IMAGES********************
	
	
	$("#selectandremove").on('click',function(){
		
		$(".slider_settings ul li ").attr('data-click-state', 1);
		$(".plugin-button").css({"display":"none"});
		document.getElementById('text').innerHTML="Click on <strong>Image</strong> to select";
		
		$(".slider_settings ul li ").on('click',function(){
			
			$("#remove-button").css({"display":"inline-block"});
			$("#remove-all-button").css({"display":"inline-block"});
			document.getElementById('text').innerHTML="Click on <strong>Remove Images</strong> button to remove selected images";
			
			var element=$(this).index();
			
			if($(this).attr('data-click-state') == 1) {
				
				$(this).attr('data-click-state', 0);
				$(this).children("img").css({ "transform" : "scale(1.3)" , "filter" : "grayscale(100%)"});
				temp.push(element);
			} 
			
			else {
				
				$(this).attr('data-click-state', 1);
				$(this).children("img").css({ "transform" : "scale(1)" , "filter" : "grayscale(0)"});
		
				var index = temp.indexOf(element);
				if (index !== -1)
					temp.splice(index, 1);
			}
			
			if(temp.length==0){
				$("#remove-button").css({"display":"none"});
				document.getElementById('text').innerHTML="Click on <strong>Image</strong> to select.....";
			}
			
				
		
		});
	});

	console.log("images to remove");
	console.log(temp);
	
	
				
	
	//***************************remove img from the list********************

	$("#remove-button").click(function(){
		
		$(".plugin-button").css({"display":"none"});
		console.log("temp in remove");
		console.log(temp);
		
		
		for(i = temp.length-1; i>=0; i--){
			
			prev_data.splice(temp[i],1);
			$(".slider_settings ul li:eq(" + temp[i] + ")").css({"display":"none"});
				
		}
		console.log("data-sent after remove images");
		console.log(prev_data);
		document.getElementById('text').innerHTML="Click on the  <strong>Save Button</strong> to save changes or refresh the page.....";
		$('#Slider-images').val(JSON.stringify(prev_data));
		
	});
	
	
		
	/**********************************************************************
					REMOVE ALL-IMAGES OPTION : REMOVE ALL THE IMAGES
					
	************************************************************************/
	
	var clear = new Array();
	$("#remove-all-button").click(function(){
		
		document.getElementById('text').innerHTML="Click on the  <strong>Save Button</strong> to save changes or refresh the page.....";
		$(".slider_settings ul").css({"display":"none"});
		$(".plugin-button").css({"display":"none"});
		
		$('#Slider-images').val(JSON.stringify(clear));
		
	});

	
});