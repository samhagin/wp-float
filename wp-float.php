<?php
/*
Plugin Name: WP Float 
Plugin URI: http://webwiki.co/wp-float
Description: Add a fixed/float text,image or HTML to WordPress
Author: Sam Hagin
Version: 1.7
Author URI: http://webwiki.co
*/

global $wp_float_path;
$wp_float_path = plugins_url('/wp-float/');

class WP_Float extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function WP_Float() {
	$widget_ops = array('classname' => '', 'description' => 'Add a fixed/float image, text or HTML to WordPress');
	$control_ops = array('width' => 300, 'height' => 550);
	$this->WP_Widget('wp_float', 'WP Float', $widget_ops,$control_ops);
	add_action('wp_enqueue_scripts', array(&$this, 'wp_float_js'));
	add_action('wp_footer', array(&$this, 'wp_float_footer'));

	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		if ( isset( $instance[ 'html' ] ) ) { $html = $instance[ 'html' ];};
                if ( isset( $instance[ 'type' ] ) ) { $type= $instance[ 'type' ];};
		if ( isset( $instance[ 'position' ] ) ) { $position= $instance[ 'position' ];};
                if ( isset( $instance[ 'leftright' ] ) ) { $leftright= $instance[ 'leftright' ];};
		if ( isset( $instance[ 'center' ] ) ) { $center= $instance[ 'center' ];};
		if ( isset( $instance[ 'tbdist' ] ) ) { $tbdist= $instance[ 'tbdist' ];};		        
		if ( isset( $instance[ 'lrdist' ] ) ) { $lrdist= $instance[ 'lrdist' ];};		        
		if ( isset( $instance[ 'speed' ] ) ) { $speed= $instance[ 'speed' ];};		        
		if ( isset( $instance[ 'width' ] ) ) { $width= $instance[ 'width' ];};		        
                if ( isset( $instance[ 'home' ] ) ) { $home= $instance[ 'home' ];};
                if ( isset( $instance[ 'single' ] ) ) { $single= $instance[ 'single' ];};
                if ( isset( $instance[ 'page' ] ) ) { $page= $instance[ 'page' ];};
                if ( isset( $instance[ 'cat' ] ) ) { $cat= $instance[ 'cat' ];};
                if ( isset( $instance[ 'catlist' ] ) ) { $catlist= $instance[ 'catlist' ];};
                
                foreach((get_the_category()) as $category) {
                $catname = $category->cat_name; }
if (is_home() && isset($home) && $home == 1 || is_single() && isset($single) && $single == 1 || is_page() && isset($page) && $page == 1 || is_front_page() && isset($home) && $home == 1 || isset($cat) && $cat == 1 && $catname == $catlist && is_single() ) { ?>
                <div id="<?php echo $this->id.'-item'; ?>">
	        <?php echo $html;?>
                     </div>
	
	<?php 	}
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['html'] = $new_instance['html'];
		$instance['type'] = $new_instance['type'];
		$instance['position'] = $new_instance['position'];
		$instance['leftright'] = $new_instance['leftright'];
		$instance['center'] = $new_instance['center'];
		$instance['tbdist'] = (int) strip_tags($new_instance['tbdist']);
		$instance['lrdist'] = (int) strip_tags($new_instance['lrdist']);
		$instance['speed'] = (int) strip_tags($new_instance['speed']);
		$instance['width'] = (int) strip_tags($new_instance['width']);
                $instance[ 'home' ] = $new_instance[ 'home' ];
                $instance[ 'single' ] = $new_instance[ 'single' ];
                $instance[ 'page' ] = $new_instance[ 'page' ];
		$instance[ 'cat' ] = $new_instance[ 'cat' ];
                $instance[ 'catlist' ] = $new_instance[ 'catlist' ];
                
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
	if ( isset( $instance[ 'html' ] ) ) { $html = $instance[ 'html' ];};
	if ( isset( $instance[ 'type' ] ) ) { $type = $instance[ 'type' ];};
	if ( isset( $instance['position'] )) { $position = $instance['position']; };
	if ( isset( $instance['leftright'] )) { $leftright = $instance['leftright']; };
	if ( isset( $instance['center'] )) { $center = $instance['center']; };
	if ( isset( $instance['tbdist'] )) { $tbdist = $instance['tbdist']; };
	if ( isset( $instance['lrdist'] )) { $lrdist = $instance['lrdist']; };
	if ( isset( $instance['speed'] )) { $speed = $instance['speed']; };
	if ( isset( $instance['width'] )) { $width = $instance['width']; };
        if ( isset( $instance[ 'home' ] ) ) { $home= $instance[ 'home' ];};
        if ( isset( $instance[ 'single' ] ) ) { $single= $instance[ 'single' ];};
        if ( isset( $instance[ 'page' ] ) ) { $page= $instance[ 'page' ];};
        if ( isset( $instance[ 'home' ] ) ) { $home= $instance[ 'home' ];};
        if ( isset( $instance[ 'single' ] ) ) { $single= $instance[ 'single' ];};
        if ( isset( $instance[ 'cat' ] ) ) { $cat= $instance[ 'cat' ];};
        if ( isset( $instance[ 'catlist' ] ) ) { $catlist= $instance[ 'catlist' ];};
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'html' ); ?>"><?php _e( 
'WP Float Content:' ); 
?></label> 
<textarea  rows="10" style="width:100%" id="<?php echo $this->get_field_id( 
'html' ); ?>" 
name="<?php echo $this->get_field_name( 'html' ); ?>" type="text" ><?php echo 
esc_textarea( $html ); ?></textarea>

		</p>



<p><label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Type
    :' ); ?></label>
<select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>" >
			<option value='true' <?php selected( $type, 'true'); ?> >Fixed</option>
			<option value='false' <?php selected( $type, 'false'); ?> >Float</option>
		</select></p>


<p><label for="<?php echo $this->get_field_id( 'position' ); ?>"><?php _e( 'Position
    :' ); ?></label>
<select name="<?php echo $this->get_field_name('position'); ?>" id="<?php echo $this->get_field_id('position'); ?>" >
                        <option value='top' <?php selected( $position, 'top'); ?> >Top</option>
                        <option value='bottom' <?php selected( $position, 'bottom'); ?> >Bottom</option>
                </select>


<select name="<?php echo $this->get_field_name('leftright'); ?>" id="<?php echo $this->get_field_id('leftright'); 
?>">
                        <option value='left' <?php selected( $leftright, 'left'); ?> >Left</option>
                        <option value='right' <?php selected( $leftright, 'right'); ?> >Right</option>
                </select>
</p>

<p><label for="<?php echo $this->get_field_id( 'lrdist' ); ?>"><?php _e( 'Distance from Left/Right
    :' ); ?></label>
<input type="text" id="<?php echo $this->get_field_id('lrdist'); ?>" name="<?php echo 
$this->get_field_name('lrdist'); ?>" value="<?php echo $lrdist; ?>" size="2" />px
</p>


<p><label for="<?php echo $this->get_field_id( 'tbdist' ); ?>"><?php _e( 'Distance from Top/Bottom
    :' ); ?></label>
<input type="text" id="<?php echo $this->get_field_id('tbdist'); ?>" name="<?php echo 
$this->get_field_name('tbdist'); ?>" value="<?php echo $tbdist; ?>" size="2" />px
</p>

<p>
	  <input type="checkbox" value="true" class="checkbox" id="<?php echo $this->get_field_id('center'); ?>" 
name="<?php echo $this->get_field_name('center'); ?>"<?php checked( $center, 'true'); ?> />
		<label for="<?php echo $this->get_field_id('center'); ?>"><?php _e( 'Set Alignment from Center'); ?></label>
	</p>
<p><label for="<?php echo $this->get_field_id( 'speed' ); ?>"><?php _e( 'Float Speed
    :' ); ?></label>
<input type="text" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo
$this->get_field_name('speed'); ?>" value="<?php echo $speed; ?>" size="2" /></p>

<p><label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width
    :' ); ?></label>
<input type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo
$this->get_field_name('width'); ?>" value="<?php echo $width; ?>" size="2" /></p>

<p>
  <input type="checkbox" value="1" class="checkbox" id="<?php echo $this->get_field_id('home'); ?>" 
name="<?php echo $this->get_field_name('home'); ?>"<?php checked( $home, '1'); ?> />
		<label for="<?php echo $this->get_field_id('home'); ?>"><?php _e( 'Show on Homepage'); ?></label><br />
                
    <input type="checkbox" value="1" class="checkbox" id="<?php echo $this->get_field_id('single'); ?>" 
name="<?php echo $this->get_field_name('single'); ?>"<?php checked( $single, '1'); ?> />
		<label for="<?php echo $this->get_field_id('single'); ?>"><?php _e( 'Show on Posts'); ?></label><br />
                
   <input type="checkbox" value="1" class="checkbox" id="<?php echo $this->get_field_id('page'); ?>" 
name="<?php echo $this->get_field_name('page'); ?>"<?php checked( $page, '1'); ?> />
		<label for="<?php echo $this->get_field_id('page'); ?>"><?php _e( 'Show on Pages'); ?></label><br />
                
  <input type="checkbox" value="1" class="checkbox" id="<?php echo $this->get_field_id('cat'); ?>" 
name="<?php echo $this->get_field_name('cat'); ?>"<?php checked( $cat, '1'); ?> />
		<label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e( 'Show for Posts Only in Category'); ?></label>
              
    
        <select name="<?php echo $this->get_field_name('catlist'); ?>" id="<?php echo $this->get_field_id('catlist'); 
?>">
            <?php
         $categories = get_categories('type=post&hide_empty=0');
            foreach($categories as $category) { 
            $item = $category->name;
            $selected = ($catlist==$item) ? 'selected="selected"' : '';
                echo "<option value='$category->name' $selected>$item</option>";
        }  ?>
        </select>
                
</p>
		<p><a target="_blank"
href="http://webwiki.co/wp-float"><?php 
esc_attr_e('Visit plugin site'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" 
href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CMGALCCS6UUZN"><?php 
esc_attr_e('Donate'); ?></a>
</p>
		<?php 
	}

	public function wp_float_js() {
                if ( is_active_widget( false, false, $this->id_base, true ) ) {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script('jqueryeasing',$wp_float_path. 'js/jquery.easing.js');
        wp_enqueue_script('jqueryfloater',$wp_float_path. 'js/jquery.floater.2.2.js');
        wp_enqueue_script('jqueryhoverintent',$wp_float_path. 'js/jquery.hoverIntent.minified.js');
		}
	}


	public function wp_float_footer(){
		
		if(!is_admin()){
		
		$wp_float_settings = $this->get_settings();
		
		foreach ($wp_float_settings as $key => $wp_sh_float){
		
			$widget_id = $this->id_base . '-' . $key;
			
			$floater_id = 'wp-float-widget-' . $key;

			if(is_active_widget(false, $widget_id, $this->id_base)){
				
				$type = $wp_sh_float['type'];
				
				$speed = $wp_sh_float['speed'];
				if($speed == ''){$speed = '1500';};
				
				$position = $wp_sh_float['position'];
				$leftright = $wp_sh_float['leftright'];

				$tbdist = $wp_sh_float['tbdist'];
				$lrdist = $wp_sh_float['lrdist'];
				
				$center = $wp_sh_float['center'];
				$centered = $center == 'true' ? 'center: true, centerPx: '.$lrdist.',' : '' ;
				
				$width= $wp_sh_float['width'];
                                if($width == '0'){$width = '';};
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					jQuery('#<?php echo $widget_id.'-item'; ?>').dcFloater({
			width: '<?php echo $width; ?>',
			location: '<?php echo $position; ?>',
                        align: '<?php echo $leftright; ?>',
                        offsetLocation: <?php echo $tbdist; ?>,
                        offsetAlign: <?php echo $lrdist; ?>,
                        speedFloat: <?php echo $speed; ?>,
                        tabText: '',
                        tabClose: false,
                        easing: 'easeOutQuint',
                        event: 'hover',
                        disableFloat:<?php echo $type; ?>,
			<?php echo $centered; ?>
                        idWrapper: '<?php echo $floater_id ?>',

						
					});
				});
			</script>
<?php
			}
		}
	}
    } 

}


// register widget
add_action( 'widgets_init', create_function( '', 'register_widget( "wp_float" );' ) );

function wp_float_shortcode($atts, $content = null){
    extract(shortcode_atts(array(
			'width' => ' ',
                        'location' => ' ',
                        'align' => ' ',
			'center' => ' ',
                        'offsetlocation' => '0',
                        'offsetalign' => '0',
                        'speed' => '1500',
                        'type' =>' ',

 ), $atts));
if ($atts['type'] == 'float') {
$type = 'false'; }
else { 
$type = 'true'; };
if ($atts['offsetlocation'] == '' || $atts['offsetalign'] == '' )
{ $offsetlocation = '0' ; $offsetalign = '0'; }
	global $post; 
if(is_single() || is_page()) {
return "<div id='wp-float-$post->ID'>$content</div> 

    <script type='text/javascript'>
                                jQuery(document).ready(function($) {
                                        jQuery('#wp-float-$post->ID').dcFloater({
                        width: '$width',
                        location: '$location',
                        align: '$align',
                        offsetLocation:$offsetlocation,
                        offsetAlign:$offsetalign,
                        speedFloat:'$speed',
                        tabText: '',
                        tabClose: false,
                        easing: 'easeOutQuint',
                        event: 'hover',
                        disableFloat:$type,
			center: $center, centerPx: $offsetalign,
                        idWrapper: 'wp-float-post-$post->ID',
                                           	
                                        });
                                });
                        </script>";
   }
}
add_shortcode('wp_float', 'wp_float_shortcode');

function wp_float_shortcode_js(){
    global $wp_float_path;
    wp_enqueue_script( 'jquery' );
        wp_enqueue_script('jqueryeasing',$wp_float_path. 'js/jquery.easing.js');
        wp_enqueue_script('jqueryfloater',$wp_float_path. 'js/jquery.floater.2.2.js');
        wp_enqueue_script('jqueryhoverintent',$wp_float_path. 'js/jquery.hoverIntent.minified.js');
}
add_action('wp_enqueue_scripts','wp_float_shortcode_js');
add_action('init', 'wp_float_add_button');

function wp_float_add_button() {
if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
	{
  add_filter('mce_external_plugins', 'wp_float_add_plugin');  
     add_filter('mce_buttons', 'wp_float_register_button');  
	}
}

function wp_float_register_button($buttons) {
 array_push( $buttons, "|", "wpfloat" );
 return $buttons;
}

/**
Register TinyMCE Plugin
*/
 
function wp_float_add_plugin( $plugin_array ) {
   global $wp_float_path;
   $plugin_array['wpfloat'] = $wp_float_path . 'js/wp-float-button.js';
   return $plugin_array;
}

function wp_float_tinymce() {
global $wp_float_path, $pagenow;
if ( $pagenow == 'widgets.php' ) {
wp_enqueue_script('tiny_mce');
	}
}
add_action('admin_enqueue_scripts', 'wp_float_tinymce');


//WP Float plugin
function wpfsh_ad() { ?>
<!--Donate-->
<p style="margin-top:15px;">
                        <p style="font-style: italic; font-weight: bold;color: #26779a;">Need Help ? Check out the documentation for WP Float
at <a href="http://webwiki.co/wp-float" target="_blank">WebWiki.Co</a><br
?>If you have found this plugin  useful, please consider making a <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CMGALCCS6UUZN"
target="_blank" >donation</a>. Thanks.</p>
&nbsp;&nbsp;<span><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CMGALCCS6UUZN" title="PayPal Donate" target="_blank"><img
 src="<?php echo plugins_url(); ?>/wp-float/images/paypal.png" /></a></span>

                        <span><a href="http://www.facebook.com/pages/WebWikiCo/220588208033178" title="Our Facebook page" target="_blank"><img
 src="<?php echo plugins_url(); ?>/wp-float/images/facebook.png" /></a></span>
                        &nbsp;&nbsp;<span><a href="http://www.twitter.com/webhost123" title="Follow on Twitter"
target="_blank"><img  src="<?php echo plugins_url();
?>/wp-float/images/twitter.png" /></a></span>
                        &nbsp;&nbsp;<span><a href="http://webwiki.co" title="WebWiki.Co" target="_blank"><img
 src="<?php echo plugins_url(); ?>/wp-float/images/website.png" /></a></span>
                </p>
<!--End-->
<?php }

function wpfsh_menu(){
add_options_page('WP Float Options', 'WP Float Options', 'manage_options',__FILE__, 'wpfsh_settings');
}


function wpfsh_options() {
        register_setting('wpfsh_settings', 'wpfsh_settings');
}
function wpfsh_settings () {
if (!current_user_can('manage_options'))  {
                wp_die( __('You do not have sufficient permissions to access this page.') );

           }
wpfsh_ad();
?>
<div class="wrap">

                <!-- Display Plugin Icon, Header, and Description -->
                <div class="icon32" id="icon-options-general"><br></div>
                <h2>WP Float Options</h2>
                <p></p>

                <!-- Beginning of the Plugin Options Form -->
                <form method="post" action="options.php">
                        <?php settings_fields('wpfsh_settings'); ?>
                        <?php $wpfsh_options = get_option('wpfsh_settings'); ?>
                        <table>

						<!-- Text Area Using the Built-in WP Editor -->

                                                <tr><td><b><h3>WP Float Content</h3></b><?php
                                                                $args = array(
                                                                "textarea_name" => "wpfsh_settings[html]",
                                                                'wpautop' => true,
								'width' => '50%',
                                                                'textarea_rows' => get_option('default_post_edit_rows', 10),
                                                                'tinymce' => true,
                                                                'mode' => 'exact',
                                                                'weight' => 200, );
                                                wp_editor( $wpfsh_options['html'], "wpfsh_options[html]", $args );
                                                        ?>
                                                <br /><span style="color:#666666;margin-left:2px;">Fixed/Float content. This can be HTML, an image or any text.</span>
                        </td>
                        </tr>

<tr>
<td>
        <b>Type:</b>
<select name="wpfsh_settings[type]">
                        <option value='false' <?php selected( $wpfsh_options['type'], 'false'); ?> >Float</option>
                        <option value='true' <?php selected( $wpfsh_options['type'], 'true'); ?> >Fixed</option>
</select>
</td></tr>
<tr>
<td>
<b> Position:</b>
<select name="wpfsh_settings[position]">
                        <option value='top' <?php selected( $wpfsh_options['position'], 'top'); ?> >Top</option>
                        <option value='bottom' <?php selected( $wpfsh_options['position'], 'bottom'); ?> >Bottom</option>
</select>
<select name="wpfsh_settings[leftright]">
                        <option value='left' <?php selected( $wpfsh_options['leftright'], 'left'); ?> >Left</option>
                        <option value='right' <?php selected( $wpfsh_options['leftright'], 'right'); ?> >Right</option>       
</select>
</td> </tr>
<tr>
<td>
<b> Distance from Left/Right:</b>
<?php if($wpfsh_options['lrdist'] == '') $wpfsh_options['lrdist'] = '0' ; ?>
<input type="text" name="wpfsh_settings[lrdist]" size="1" value="<?php echo $wpfsh_options['lrdist']; ?>" />px
</td></tr>
<tr>
<td>
<b> Distance from Top/Bottom:</b>
<?php if($wpfsh_options['tbdist'] == '') $wpfsh_options['tbdist'] = '0' ; ?>
<input type="text" name="wpfsh_settings[tbdist]" size="1" value="<?php echo $wpfsh_options['tbdist']; ?>" />px
</td></tr>
<tr>
<tr><td><input type="checkbox" name="wpfsh_settings[center]" value="1" <?php checked( $wpfsh_options['center'], 1 ); ?> />
Set Alignment from Center </td></tr>
<td>
<b> Float Speed:</b>
<?php if($wpfsh_options['speed'] == '0') $wpfsh_options['speed'] = '' ; ?>
<input type="text" name="wpfsh_settings[speed]" size="4" value="<?php echo $wpfsh_options['speed']; ?>" />
</td></tr>
<tr>
<td>
<b> Width:</b>
<input type="text" name="wpfsh_settings[width]" size="4" value="<?php echo $wpfsh_options['width']; ?>" />px
</td></tr>
<tr><td><input type="checkbox" name="wpfsh_settings[home]" value="1" <?php checked( $wpfsh_options['home'], 1 ); ?> />
Show on HomePage</td></tr>
<tr><td><input type="checkbox" name="wpfsh_settings[single]" value="1" <?php checked( $wpfsh_options['single'], 1 ); ?> />
Show on Posts</td></tr>
<tr><td><input type="checkbox" name="wpfsh_settings[page]" value="1" <?php checked( $wpfsh_options['page'], 1 ); ?> />
Show on Pages</td></tr>
<tr><td><input type="checkbox" name="wpfsh_settings[cat]" value="1" <?php checked( $wpfsh_options['cat'], 1 ); ?> />
Show on Posts in Category

 <select name="wpfsh_settings[catlist]">
            <?php
         $categories = get_categories('type=post&hide_empty=0');
            foreach($categories as $category) {
            $item = $category->name;
            $selected = ($catlist==$item) ? 'selected="selected"' : '';
                echo "<option value='$category->name' $selected>$item</option>";
        }  ?>
        </select>


</td></tr>

</table>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>
<?php
}

add_action('admin_menu', 'wpfsh_menu');
add_action('admin_init', 'wpfsh_options');
add_action('wp_head', 'wpfsh_head');

function wpfsh_head() {

foreach((get_the_category()) as $category) {
                $catname = $category->cat_name; }
$wpfsh_options = get_option('wpfsh_settings');
if(is_array($wpfsh_options)) extract($wpfsh_options);
global $wp_query;
$postID = $wp_query->post->ID;
$centered = $center == '1' ? 'center: true, centerPx: '.$lrdist.',' : '' ;
if (is_home() && isset($home) && $home == 1 || is_single() && isset($single) && $single == 1 || is_page() && isset($page) && $page == 1 || is_front_page() && isset($home) && $home == 1 || isset($cat) && $cat == 1 && $catname == $catlist && is_single() ) { ?>
                <div id="<?php echo $postID.'-wpf'; ?>">
                <?php echo $html;?>
                     </div>
				<script type='text/javascript'>
                                jQuery(document).ready(function($) {
                                        jQuery('#<?php echo $postID.'-wpf'; ?>').dcFloater({
                        width: '<?php echo $width; ?>',
                        location: '<?php echo $position; ?>',
                        align: '<?php echo $leftright; ?>',
                        offsetLocation:<?php echo $tbdist; ?>,
                        offsetAlign:<?php echo $lrdist; ?>,
                        speedFloat:'<?php echo $speed; ?>',
                        tabText: '',
                        tabClose: false,
                        easing: 'easeOutQuint',
                        event: 'hover',
			<?php echo $centered; ?>
                        disableFloat:<?php echo $type; ?>,
                        idWrapper: '<?php echo $postID.'-wpf-id'; ?>',
                                                
                                        });
                                });
                        </script>


        <?php   }
        }

