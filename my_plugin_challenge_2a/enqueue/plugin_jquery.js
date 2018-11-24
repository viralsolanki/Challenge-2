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
	var imageUploader = new Array();
	
	//list of images in slider
	var slider_images = new Array();
	//store selected images
	var imgs = new Array();
	
	var temp = new Array();
	
	//get the list of sliders
	var slider_types = $('#slider_type').val();
	if(slider_types)	
	{
		slider_types = JSON.parse(slider_types);
	}
	
	//get the list of images present in slider
	slider_types.forEach(function(element){
		imgs[element] = new Array();
		temp[element] = new Array();
		var slider_images_list = $("#Slider-images-"+ element).val();		
		if(slider_images_list)	
		{
			slider_images[element] = JSON.parse(slider_images_list);
		}
		else
		{
			slider_images[element] = new Array();
		}
		
	});
	
	function get_slider_data(slider_type){
		
		if(!$(".ui-state-default-"+slider_type).length)
		{
			document.getElementById("text-"+slider_type).innerHTML="No Image is present click on <strong>Insert Image</strong> button to add images to slider......";
			$("#remove-all-button-" + slider_type).css({"display":"none"});
			$("#change-index-"+ slider_type).css({"display":"none"});
			$("#selectandremove-" + slider_type).css({"display":"none"});
		}
		
	}
	
	/**********************************************************************
					INSERT IMAGES OPTION : SET WP_IMAGE_UPLOADER AND 
							SAVE SELECTED IMAGES
	
	************************************************************************/
	
	function slider_image_upload(slider_type){	
		
		if(imageUploader[slider_type]){
			
			imageUploader[slider_type].open();
			return;
		}
		
		imageUploader[slider_type] = wp.media.frames.file_frame = wp.media({
			
				title: 'Select Images for Slider',
				button:{
					text: 'Add Images'
				},
				multiple: 'add'
		});
	
		imageUploader[slider_type].on('select',function(){
			
			var selection =  imageUploader[slider_type].state().get('selection');
			selection.map( function( attachment ) {
				
				attachment = attachment.toJSON();
				imgs[slider_type].push(attachment.url);

			});
			for(var i=imgs[slider_type].length-1 ; i>=0 ; i--){
				$("#image_ul-"+slider_type).prepend("<li class=\"ui-state-default\" id="+imgs[slider_type][i]+"><img id=\"image-list\" src="+imgs[slider_type][i]+"></li>");
			}
			
			if(slider_images[slider_type])
			{
				imgs[slider_type] = imgs[slider_type].concat(slider_images[slider_type]);
				
			}	
			$("#Slider-images-"+ slider_type).val(JSON.stringify(imgs[slider_type]));
			
			document.getElementById("text-"+ slider_type).innerHTML="Click on the  <strong>Save Button</strong> to save changes or refresh the page.....";
			$(".plugin-button-" + slider_type).css({"display":"none"});
			
		});
		
		
		imageUploader[slider_type].open();
	}
	
	
	/**********************************************************************
					SORTABLE OPTION : SAVE SORTED LIST OF IMAGES 
	
	************************************************************************/
	
	var new_list;
	
	function change_index_of_image(slider_type){
		
		document.getElementById("text-"+slider_type).innerHTML="Click and Hold the image and drag the image to specific index of your choice\
		and click on <strong>Save Button</strong> or refresh the page.....";
		$(".plugin-button-"+slider_type).css({"display":"none"});
		$(".slider_settings-"+slider_type+ " img").css({"border":"2px dashed"});
		
		$( function() {
		
		$( "#image_ul-"+ slider_type ).sortable({
			stop: function(e, ui) {
			
				new_list = $("#image_ul-"+slider_type).sortable('toArray');
				$("#Slider-images-"+slider_type).val(JSON.stringify(new_list));
				
		  }
		 
		}).disableSelection();
		
        } );
	}
	
	/**********************************************************************
					REMOVE IMAGES OPTION : REMOVE SELECTED IMAGES
					
	************************************************************************/
	
	//***************************SELECT IMAGES********************
	
	
	function select_remove_images(slider_type){
		$(".slider_settings-"+ slider_type +" ul li ").attr('data-click-state', 1);
		$(".plugin-button-" + slider_type).css({"display":"none"});
		document.getElementById("text-"+slider_type).innerHTML="Click on <strong>Image</strong> to select";
		
		$(".slider_settings-"+ slider_type +" ul li ").on('click',function(){
			
			$("#remove-button-" + slider_type).css({"display":"inline-block"});
			$("#remove-all-button-" + slider_type).css({"display":"inline-block"});
			document.getElementById("text-"+slider_type).innerHTML="Click on <strong>Remove Images</strong> button to remove selected images";
			
			var element_index = $(this).index();
			
			if($(this).attr('data-click-state') == 1) {
				
				$(this).attr('data-click-state', 0);
				$(this).children("img").css({ "transform" : "scale(1.3)" , "filter" : "grayscale(100%)"});
				temp[slider_type].push(element_index);
			} 
			
			else {
				
				$(this).attr('data-click-state', 1);
				$(this).children("img").css({ "transform" : "scale(1)" , "filter" : "grayscale(0)"});
		
				var index = temp[slider_type].indexOf(element_index);
				if (index !== -1)
					temp[slider_type].splice(index, 1);
			}
			
			if(temp[slider_type].length==0){
				$("#remove-button-" + slider_type).css({"display":"none"});
				document.getElementById("text-"+slider_type).innerHTML="Click on <strong>Image</strong> to select.....";
			}
		
		});
	}
	
	//***************************remove img from the list********************


	function remove_images_from_slider(slider_type){	
		$(".plugin-button-" + slider_type).css({"display":"none"});
		
		for(i = temp[slider_type].length-1; i>=0; i--){
			
			slider_images[slider_type].splice(temp[slider_type][i],1);
			$(".slider_settings-"+ slider_type +" ul li:eq(" + temp[slider_type][i] + ")").css({"display":"none"});
				
		}

		document.getElementById("text-"+slider_type).innerHTML="Click on the  <strong>Save Button</strong> to save changes or refresh the page.....";
		$("#Slider-images-"+slider_type).val(JSON.stringify(slider_images[slider_type]));
	}	
		
	/**********************************************************************
					REMOVE ALL-IMAGES OPTION : REMOVE ALL THE IMAGES
					
	************************************************************************/
	
	var clear = new Array();
	
	function remove_all_images(slider_type){	
		document.getElementById("text-"+slider_type).innerHTML="Click on the  <strong>Save Button</strong> to save changes or refresh the page.....";
		$(".slider_settings-"+slider_type+" ul").css({"display":"none"});
		$(".plugin-button-"+slider_type).css({"display":"none"});
		
		$("#Slider-images-"+slider_type).val(JSON.stringify(clear));

	}	
	
	slider_types.forEach(function(element){
		get_slider_data(element);
		
		$("#upload-button-"+ element).on('click',function(e){
			e.preventDefault();
			slider_image_upload(element);
		});
		
		$("#change-index-"+element).on('click',function(){
			change_index_of_image(element);
		});
		
		$("#selectandremove-"+element).on('click',function(){
			select_remove_images(element);
		});
		
		$("#remove-button-"+element).on('click',function(){
			remove_images_from_slider(element);
		});
		
		$("#remove-all-button-"+element).on('click',function(){
			remove_all_images(element);
		});
	});
	
});