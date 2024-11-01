<?php
/**
 * Plugin Name: Scroll
 * Author URI: https://wpdevart.com/
 * Description: Scroll to top plugin with simple and nice interface.
 * Version: 1.0.5
 * Author: wpdevart
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
 
class sroll_to_top_main_class{
	// required variables
	
    /*############  Construct function  ################*/	
	
	function __construct(){				
		$this->call_base_filters(); 			
	}
	
	public function registr_requeried_scripts(){		
		wp_register_script('scroll_to_topjs',plugins_url('',__FILE__).'/js/scroll_to_top.js',array('jquery'),'1.0',false);
		wp_register_style('scroll_to_topcss',plugins_url('',__FILE__).'/css/scroll_to_top.css');
		$translation_array = array(
			'image_src' => get_option("hhg_scrol_to_top_image_src",plugins_url('',__FILE__).'/image/scroll-top-icon.png'),
			'enabled' => get_option("hhg_scrol_to_top_enabled","1"),
			'time_to_scroll' => get_option("hhg_scrol_to_top_time","1000"),
			'position_scroll' => get_option("hhg_scrol_to_top_position","right"),
			'padding' => get_option("hhg_scrol_to_top_padding","10"),
		);
		wp_localize_script( 'scroll_to_topjs', 'hhg_scroll_to_top', $translation_array );
		add_action('wp_footer',array($this,"scroll_to_top_footer"));

		// Enqueued script with localized data.
		
	}
	
    /*############  Head scripts function  ################*/		
	
	public function include_scripts_in_head(){
		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'scroll_to_topcss' );
		wp_enqueue_script( 'scroll_to_topjs' );
	}
	public function call_base_filters(){
		add_action( 'init',  array($this,'registr_requeried_scripts') );
		add_action( 'wp_head',  array($this,'include_scripts_in_head') );
		add_action('admin_menu', array($this,'create_menu'));		
	}
	
    /*############  Create menu function  ################*/		
	
	public function create_menu(){
		$main_page = add_menu_page("Scroll to top", "Scroll to top", 'manage_options', "scroll_to_top", array($this, 'main_menu_function_admin'));
		add_action('admin_print_styles-' .$main_page, array($this,'menu_requeried_scripts'));
	}
	public function menu_requeried_scripts(){
		 wp_enqueue_media();
	}

    /*############  Update options function  ################*/		
	
	private function update_options(){
		update_option("hhg_scrol_to_top_image_src",$_POST["image_src"]);
		update_option("hhg_scrol_to_top_enabled",$_POST["enabled"]);
		update_option("hhg_scrol_to_top_time",$_POST["time_to_scroll"]);
		update_option("hhg_scrol_to_top_position",$_POST["position_scroll"]);
		update_option("hhg_scrol_to_top_padding",$_POST["padding"]);
	}
	
    /*############  Main admin menu function  ################*/		
	
	public function main_menu_function_admin(){
		if(isset($_POST['scroll_to_top_nonce_name']) && wp_verify_nonce($_POST['scroll_to_top_nonce_name'],'scroll_to_top_nonce_action') ){
			$this->update_options();
			?><div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
			<p><strong>Settings changed</strong></p>
         	<button type="button" class="notice-dismiss">
            	<span class="screen-reader-text">Dismiss this notice.</span>
            </button>
        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div><?php
		}
		?>
		<style>
			.scroll_to_tablle{
				width: 50%;
				min-width: 550px;
				border: 1px solid #000;
			}
			.scroll_to_tablle tr{
				background-color: white;
			}
			.scroll_to_tablle tr:hover{
				background-color: #e6e6e6;
			}
			.scroll_to_tablle td{
				border-bottom: 1px solid #9b9b9b;
			}
			    
		</style>
		<h1>Scroll to top</h1>
		<form method="post">
			<table class="scroll_to_tablle" style="border-spacing: 0px;">
				<tr>
					<td>Enable or Disable scroll to top</td>
					<td>
						<select name="enabled">
							<option <?php selected("1",get_option("hhg_scrol_to_top_enabled","1")) ?> value="1">Enable</option>
							<option <?php selected("0",get_option("hhg_scrol_to_top_enabled","0")) ?> value="0">Disable</option>
						</select>
                    </td>
				</tr>
				<tr>
					<td>Upload image or set url:</td>
					<td>
                          <input style="float: left;" type="text" class="upload" id="image_src" name="image_src" value="<?php echo get_option("hhg_scrol_to_top_image_src",plugins_url('',__FILE__).'/image/scroll-top-icon.png') ?>">
                          <input class="upload-button button" type="button" value="Upload">
                          <img style="max-width: 30px;" src="<?php echo get_option("hhg_scrol_to_top_image_src",plugins_url('',__FILE__).'/image/scroll-top-icon.png') ?>" class="cont_button_uploaded_img">	
                    </td>
				</tr>
				<tr>
					<td>Scrolling time</td>
					<td>
						<input type="text" name="time_to_scroll"  value="<?php echo get_option("hhg_scrol_to_top_time","1000") ?>"/><small>ms</small>
                    </td>
				</tr>
				<tr>
					<td>Position of scroll button</td>
					<td>
						<select name="position_scroll">
							<option <?php selected("left",get_option("hhg_scrol_to_top_position","right")) ?> value="left">Left</option>
							<option <?php selected("right",get_option("hhg_scrol_to_top_position","right")) ?> value="right">Right</option>
						</select>
                    </td>
				</tr>
				<tr>
					<td>Padding element</td>
					<td>
						<input type="text" name="padding"  value="<?php echo get_option("hhg_scrol_to_top_padding","10"); ?>"/><small>px</small>
                    </td>
				</tr>
				<tr><td style="text-align:right" colspan="2"><input class="button button-primary" type="submit" value="Save changes"></td></tr>
			</table>
			 <?php wp_nonce_field('scroll_to_top_nonce_action','scroll_to_top_nonce_name'); ?>
		</form>
<script>
jQuery(document).ready(function($){
 
 
    var custom_uploader;
 
 
    jQuery('.upload-button').click(function(e) {
 		var self=this;
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery(self).parent().find('.upload').val(attachment.url);
			 jQuery(self).parent().find('img').attr('src',attachment.url);
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
 
 
});
</script>
		
		<?php
	}
	function scroll_to_top_footer(){
		?>
	
		<?php
	}
}
$sroll_to_top_main_class = new sroll_to_top_main_class();