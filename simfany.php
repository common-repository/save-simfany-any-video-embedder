<?
/*
Plugin Name: SAVE (Simfany Any Video Embedder)
Plugin URI: http://simfany.com/apps.html
Description: The main advantage of this plug-in is that it supports all embeddable video formats and doesn't need to be updated to support any future ones. It allows you to quickly embed videos into your posts, pages or comments. After the plug-in is installed, you will see either the video button or the Simfany button in your editor. Copy the video embed code or the video link from Youtube or any other video resource and paste it between the [video] tags. It will convert your embed code or the link into very simple Simfany format.
Version: 1.1
Author: 2by2host.com
Author URI: http://2by2host.com/hosting/wordpress/
*/

define('SIMFANY_VERSION', '1.1');

$folder = '/wp-content/plugins/save-simfany-any-video-embedder';
@include_once( ABSPATH . $folder . '/simfany_api.php' );

function simfany_config_page() {
	if ( function_exists('add_submenu_page') )
	add_submenu_page('options-general.php', __('Simfany Any Video Embedder Settings'), __('Simfany Any Video Embedder'), 'manage_options', 'simfany-config', 'simfany_conf');

}

function simfany_conf()
{

	if($_POST['send']=="Save Changes")
	{
		$width=$_POST['simfany_w'];
		$height=$_POST['simfany_h'];
		$com=$_POST['simfany_com'];
		$simfany_video=$_POST['simfany_v'];
		update_option("simfany_w", $width);
		update_option("simfany_h", $height);
		update_option("simfany_button", $simfany_video);
		update_option("simfany_com", $com);
		?>
		<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>
		<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Simfany Any Video Embedder Settings</h2>
		<form method="POST" action="">
		<table class="form-table">
		<tr valign="top">
		<th scope="row"><label for="home">Default Video Width</label></th>
		<td><input type="text" name="simfany_w" size="5" value="<?echo $width;?>">
		<span class="description">The maximum width in pixels of the video player to be displayed. If set to 0 it will be calculated automatically based on the height</span></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="home">Default Video Height</label></th>
		<td><input type="text" name="simfany_h" size="5" value="<?echo $height;?>">
		<span class="description">The maximum height in pixels of the video player to be displayed. If set to 0 it will be calculated automatically based on the width. We recommend setting it to 0</span></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="home">Allow Publishing In Comments</label></th>
		<td><input type="checkbox" name="simfany_com" <?if($com=="1"){echo 'checked';}?> value="1">
		</td>
		</tr>
		<tr>
		<th scope="row">BBCode To Use</th>
		<td>
		<fieldset><legend class="screen-reader-text"><span>BBCode To Use</span></legend>
		<label><input type="radio" value="simfany" <?if($simfany_video=="simfany"){echo 'checked';}?> name="simfany_v">&nbsp;[simfany][/simfany]</label><br />
		<label><input type="radio" value="video" <?if($simfany_video=="video"){echo 'checked';}?> name="simfany_v">&nbsp;[video][/video]</label><br />
		</fieldset>
		</td>
		</tr>
		</table>
		<p class="submit"><input type="submit"  class="button-primary" value="Save Changes" name="send"></p>
		</form>
		</div>

		<?
	}

	else

	{

		$com=get_option("simfany_com");
		$simfany_video=get_option("simfany_button");
		$width=get_option("simfany_w");
		$height=get_option("simfany_h");

		?>
		<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Simfany Any Video Embedder Settings</h2>
		<form method="POST" action="">
		<table class="form-table">
		<tr valign="top">
		<th scope="row"><label for="home">Default Video Width</label></th>
		<td><input type="text" name="simfany_w" size="5" value="<?echo $width;?>">
		<span class="description">The maximum width in pixels of the video player to be displayed. If set to 0 it will be calculated automatically based on the height</span></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="home">Default Video Height</label></th>
		<td><input type="text" name="simfany_h" size="5" value="<?echo $height;?>">
		<span class="description">The maximum height in pixels of the video player to be displayed. If set to 0 it will be calculated automatically based on the width. We recommend setting it to 0</span></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="home">Allow Publishing In Comments</label></th>
		<td><input type="checkbox" name="simfany_com" <?if($com=="1"){echo 'checked';}?> value="1">
		</td>
		</tr>
		<tr>
		<th scope="row">BBCode To Use</th>
		<td>
		<fieldset><legend class="screen-reader-text"><span>BBCode To Use</span></legend>
		<label><input type="radio" value="simfany" <?if($simfany_video=="simfany"){echo 'checked';}?> name="simfany_v">&nbsp;[simfany][/simfany]</label><br />
		<label><input type="radio" value="video" <?if($simfany_video=="video"){echo 'checked';}?> name="simfany_v">&nbsp;[video][/video]</label><br />
		</fieldset>
		</td>
		</tr>
		</table>
		<p class="submit"><input type="submit"  class="button-primary" value="Save Changes" name="send"></p>

		</form>
		</div>
		<?

	}
}

function myplugin_addbuttons()
{


	add_filter("mce_external_plugins", "add_myplugin_tinymce_plugin");
	add_filter('mce_buttons', 'register_myplugin_button');

}

function register_myplugin_button($buttons)
{
	array_push($buttons, "simfany2");
	return $buttons;
}

function add_myplugin_tinymce_plugin($plugin_array)
{
	$simfany_video=get_option("simfany_button");
	if($simfany_video=="video")
	{
		$plugin_array['simfany'] = get_bloginfo('wpurl').'/wp-content/plugins/save-simfany-any-video-embedder/tinymce/editor_plugin.js';
	}
	if($simfany_video=="simfany")
	{
		$plugin_array['simfany'] = get_bloginfo('wpurl').'/wp-content/plugins/save-simfany-any-video-embedder/tinymce/editor_plugin2.js';
	}
	return $plugin_array;
}


function simfany_plugin_action_links( $links, $file ) {


	$url = "options-general.php?page=simfany-config";

	$settings_link = '<a href="options-general.php?page=simfany-config">'
		. esc_html( __( 'Settings', 'simfany' ) ) . '</a>';

	array_unshift( $links, $settings_link );

	return $links;
}

function simfany_api_output_callback($content)
{
	$width=get_option("simfany_w");
	$height=get_option("simfany_h");
	$options="width=$width&height=$height";
	 return simfany_api_output($content, $options);
}

function add_button(){

		wp_print_scripts( 'quicktags' );


		$simfany_video=get_option("simfany_button");
		echo "<script type=\"text/javascript\">"."\n";
		echo "/* <![CDATA[ */"."\n";
		echo "edButtons[edButtons.length] = new edButton"."\n";
		echo "\t('ed_nocross',"."\n";

		if($simfany_video=="video")
		{
			echo "\t'video'"."\n";
			echo "\t,'[video]'"."\n";
			echo "\t,'[/video]'"."\n";
		}
		if($simfany_video=="simfany")
		{
			echo "\t'simfany'"."\n";
			echo "\t,'[simfany]'"."\n";
			echo "\t,'[/simfany]'"."\n";
		}

		echo "\t,'n'"."\n";
		echo "\t);"."\n";
		echo "/* ]]> */"."\n";
		echo "</script>"."\n";

}
add_filter( 'content_save_pre', 'simfany_api_input' );
add_filter( 'the_content', 'simfany_api_output_callback' );
add_action('admin_menu', 'simfany_config_page');

add_option("simfany_w", "450");
add_option("simfany_h", "0");
add_option("simfany_button", "simfany");
add_option("simfany_com", "1");

$com=get_option("simfany_com");

if($com=="1")
{
	add_filter( 'pre_comment_content', 'simfany_api_input' );
	add_filter( 'comment_text', 'simfany_api_output_callback' );
}
add_action('admin_head','add_button');

add_filter( 'plugin_action_links', 'simfany_plugin_action_links',10,2);


add_action('init', 'myplugin_addbuttons');



?>