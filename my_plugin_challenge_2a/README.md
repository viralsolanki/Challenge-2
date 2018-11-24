# WordPress Plugin Challenge

This Assignment is on rtcamp’s challenge-2 : WordPress Plugin development. As given on the link there are two assignments I choose the WordPress Slideshow Plugin Assignment.

## Getting Started

Along with this document u will get the copy of the project. This plugin is for create slider in your page the brief description is given below
This project full filed all the requirements given in the rules. Additionally some jQuery effects are used to make it look good.

### Requirements

To use this Plugin no aditional software or plugins are needed we just need a latest version of WordPress in worcking condition.

## What it will do ?

Activation of the Plugin will Create a custom admin menu **Slider_Settings** here you can create multiple Sliders. It will add a custom button to the 
visual editor of post type 'page' & 'post'.   

### How It Works ?

To customize Slider go to WordPress **Dashboard -> Menubar -> Slider_Settings**. 

From here You can create multiple slides using <strong>'Insert Slider Type'</strong> field. All you have to do is enter name of the slider in field and click on create slide. 
Then you can insert, delete and change index of slides of your slider easily by clicking on the respective buttons.To add Slider in 'post' or 'page' open the edit page of your respective post click on the
button **Add slider**. By clicking on it a popup menu will appear that contains list of sliders you have created. You can select any slider which you want to attach to the post.  

![Button](/images/button.png)

**Slider_Settings** page contains following buttons to do respective changes :

# Insert Images - Insert images to your Slider
# Change Index - Change index of images in Slider
# Select & Remove - Select and Remove remove images from Slider 
# Remove All Images - Remove All the Images From the Slider 

![Slider_Setting](/images/Slider_Setting.png)

### Shortcode

A Shortcode named **'name_of_slider'** will be generated. You can use it in pages and post using syntax :
```
[name_of_slider]
```
ex. if you have slider name 'Bikes' then shortcode of that slider will be [Bikes].

**Note** - On plugin Deactivation All the Sliders and images in the sliders will be lost. you can again create Sliders and insert images.

## Frameworks used

* JS framework : jQuery
* Testing framework : PHPUnit

## Tests

For testing PHPUnit testing framework is used. All the tests are rest in test directory.

## Author

* **Viral Solanki** 

## Acknowledgments

* [WordPress.org](https://wordpress.org)
* [WordPress Codex](https://codex.wordpress.org)
* [WordPress StackExchange](https://codex.wordpress.stackexchange.com)
* etc

## Version

* 2.0 : Multiple sliders & Button to Visual Editor

## Demo Link

*[http://myplugin.gq/](http://myplugin.gq/) - Shortcode 'myslideshow' is used in **Shortcode** page. Open the page to see how it works.
