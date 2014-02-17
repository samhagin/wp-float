<?php

//  Here was the main bug which prevented the isharis's plugin from working in some server configurations
// (tinyMCE form just redirected to the site homepage).
//  A good practice is to locate the  WP loader and use the includes_url() function before loading needed resources.

// Ensure single declaration of function!
// Credits: http://wordpress.stackexchange.com/questions/32388/solutions-for-generating-dynamic-javascript-css
if(!function_exists('wp_locate_loader')):
    /**
     * Locates wp-load.php looking backwards on the directory structure.
     * It start from this file's folder.
     * Returns NULL on failure or wp-load.php path if found.
     *
     * @author EarnestoDev
     * @return string|null
     */
    function wp_locate_loader(){
        $increments = preg_split('~[\\\\/]+~', dirname(__FILE__));
        $increments_paths = array();
        foreach($increments as $increments_offset => $increments_slice){
            $increments_chunk = array_slice($increments, 0, $increments_offset + 1);
            $increments_paths[] = implode(DIRECTORY_SEPARATOR, $increments_chunk);
        }
        $increments_paths = array_reverse($increments_paths);
        foreach($increments_paths as $increments_path){
            if(is_file($wp_load = $increments_path.DIRECTORY_SEPARATOR.'wp-load.php')){
                return $wp_load;
            }
        }
        return null;
    }
endif;

// Now try to load wp-load.php and pull it in
if(!is_file($wp_loader = wp_locate_loader())){
    header("{$_SERVER['SERVER_PROTOCOL']} 403 Forbidden");
    header("Status: 403 Forbidden");
    echo 'Access denied!'; // Or whatever
    die;
}

require_once($wp_loader); // Pull it in
unset($wp_loader); // Cleanup variables

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>WP Float</title>
	
	<style type='text/css' src='<?php echo includes_url('js/tinymce/themes/advanced/skins/wp_theme/dialog.css'); ?>'></style>
	<style type='text/css'>
	body { background: #f1f1f1; }
	#button-dialog { }
	#button-dialog div { padding: 10px 0; }
	#button-dialog label { display: block; margin: 0 8px 8px 0; color: #333; font-weight: bold; }
    #button-dialog input[type=text] { display: block; padding: 3px 5px; width: 20%; font-size: 1em; }
    #button-dialog textarea { display: block; padding: 3px 5px; width: 90%; font-size: 1em; 
}
	#button-dialog input[type=radio] { }
    #button-dialog input[type=submit] { padding: 5px; font-size: 1em; background-color: 
#70a0ff; color: #fff; }
    #button-dialog input:disabled { background-color: #f1f1f1; }
	</style>
	
	<script type='text/javascript' src='<?php echo includes_url('js/jquery/jquery.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo includes_url('js/tinymce/tiny_mce_popup.js'); ?>'></script>
	
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#button-form').submit(function(e) {
            ButtonDialog.insert(ButtonDialog.local_ed);
		    e.preventDefault();
		});

        jQuery('input[name=type]').change(function() {
            var type = jQuery('input[name=type]:checked').val();
            if (type == 'classic') {
                jQuery('input#title').attr("disabled", true);
            } else {
                jQuery('input#title').removeAttr("disabled");
                jQuery('input#title').val(type[0].toUpperCase() + type.slice(1));
            }
        });

		var ButtonDialog = {
			local_ed : 'ed',
			init : function(ed) {
				ButtonDialog.local_ed = ed;
 				tinyMCEPopup.resizeToInnerSize();
			},
			insert : function insertButton(ed) {
                // Try and remove existing style / blockquote
				tinyMCEPopup.execCommand('mceRemoveNode', false, null);

				// set up variables to contain our input values
				var content = jQuery('textarea[name=content]').val();
				var type = jQuery('input[name=type]').val();
				var location = jQuery('input[name=location]:checked').val();
				var align = jQuery('input[name=align]:checked').val();
				var offsetlocation = jQuery('input[name=offsetlocation]').val();
				var offsetalign = jQuery('input[name=offsetalign]').val();
				var speed = jQuery('input[name=speed]').val();
				var width = jQuery('input[name=width]').val();
				var center = jQuery('input[name=center]:checked').val();	
				var output = '';
		 
				// setup the output of our shortcode
				output = '[wp_float ';
                    output += 'type="' + type + '" ';
					output += 'location="' + location + '" ';
					output += 'align="' + align + '" ';
					output += 'center="' + center + '" ';
					output += 'offsetlocation="' + offsetlocation + '" ';
					output += 'offsetalign="' + offsetalign + '" ';
					output += 'speed="' + speed + '" ';
					output += 'width="' + width + '" ';
										

				// check to see if the TEXT field is blank
				if(content) {	
					output += ']'+ content + '[/wp_float]';
				}
				// if it is blank, use the selected text, if present
				else {
					output += ']'+ButtonDialog.local_ed.selection.getContent() + '[/wp_float]';
				}
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);

				// Return
				tinyMCEPopup.close();

				return false
			}
		};
		tinyMCEPopup.onInit.add(ButtonDialog.init, ButtonDialog);
	});
	</script>
</head>
<body>
	<div id="button-dialog">
		<form id="button-form" action="/" method="get" accept-charset="utf-8">
			<div>
				<label for="wp-float">WP Float Content <span 
style="color:#929199;"> (leave blank if text is selected) </span></label>
				<textarea name="content" id="content" rows="3" cols="20"></textarea>
			</div>
			
			
			<div>
                <label>Type</label>
                <input type="radio" name="type" value="float" checked="checked">Float
                <input type="radio" name="type" value="fixed">Fixed
			</div>

     <div>
                <label>Location</label>
                <input type="radio" name="location" value="top" checked="checked">Top
                <input type="radio" name="location" value="bottom">Bottom
                        </div>
            
     <div>
                <label>Align</label>
                <input type="radio" name="align" value="left" checked="checked">Left
                <input type="radio" name="align" value="right">Right
                        </div>

<div>
                <label>Set Aligment from Center</label>
                <input type="radio" name="center" value="false" checked="checked">No
		<input type="radio" name="center" value="true">Yes
                        </div>



	<div>
                <label for="offsetlocation">Distance from Top/Bottom <span 
style="color:#929199;">(numbers only)</span></label>
                <input type="text" size="2" name="offsetlocation" value="" id="offsetlocation" />
            </div>

	<div>
                <label for="offsetalign">Distance from Left/Right <span 
style="color:#929199;">(numbers only)</span></label>
                <input type="text" size="2" name="offsetalign" value="" id="offsetalign" />
            </div>

<div>
             	<label for="speed">Float Speed <span style="color:#929199;">(default speed is 1500 
if left blank)</span></label>
                <input type="text" size="2" name="speed" value="" id="speed" />
            </div>


<div>
             	<label for="width">Width</label>
                <input type="text" size="2" name="width" value="" id="width" />
            </div>



			<div>
				<input type='submit' class="button-primary" value='Submit' 
/>
			</div>
		</form>
	</div>
</body>
</html>
