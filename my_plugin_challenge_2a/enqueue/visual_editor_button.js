(function() {
			
    if(typeof shortcodes == 'undefined'|| !shortcodes)
		return;
	shortcodes_list = JSON.parse(shortcodes);
	if(old_value && old_value!=='' && typeof old_value === 'string'){
		var old_value_json = JSON.parse(old_value);
	}
	var slide;
    tinymce.create("tinymce.plugins.add_shortcode_button", {

        init : function(ed, url) {

            //add new button     
            ed.addButton("addshortcode", {

				type: 'listbox',
				name: 'mylistbox',
				text: 'Add Slider',
				icon: false,
				tooltip:"Insert Slider to the Post",
				onselect: function (e) {
		
					slide = this.value();
					if(slide == ""){
						document.getElementById("post_id").value = null;
						return;
					}
					if(!temp){
						var temp = [];
					}
					
					temp[0] = posts;
					temp[1] = slide;
					console.log(temp);
					temp = JSON.stringify(temp);
					console.log(temp);
					
					document.getElementById("post_id").value = temp;
		
				},
				values:add_listbox_values(),
				
				onPostRender: function () {
					// Select the second item by default
					if(!old_value_json || typeof old_value_json == 'undefined' ){
						return;
					}
					this.value(old_value_json[1]);
				}
				
            });

        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Extra Buttons",
                author : "Viral Solanki",
                version : "1"
            };
        }
    });
	
	function add_listbox_values(){
	
		var result = [];
		var temp ={};
		temp['text']= '---- None ----';
		temp['value'] = "";
		result.push(temp);
		shortcodes_list.forEach(function(element){
			var d = {};
			d['text'] = element+' slider';
			d['value'] = element;
			result.push(d);
		});
		
		return result;
	}

    tinymce.PluginManager.add("shortcode_button", tinymce.plugins.add_shortcode_button);
})();