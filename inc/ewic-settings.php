<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function ewic_opt_init() {
    $ewic_featured_page = add_submenu_page('edit.php?post_type=easyimageslider', 'Global Settings', __('Global Settings', 'easywic'), 'edit_posts', 'ewic_settings_page', 'ewic_stt_page');
}
add_action( 'admin_menu', 'ewic_opt_init' );


function ewic_stt_page() {
	
	?>
    
    <div class="wrap">
    <div class="metabox-holder">
			<div class="postbox">
            <h3 style="padding-bottom: 8px; border-bottom: 1px solid #CCC;"><span class="setpre"></span><?php _e( 'Global Settings', 'easywic' ); ?></h3>
            <form id="easywic_settings">
            <div style="padding: 5px 15px 15px 15px;">
            <h4><?php _e( "Auto Update Plugin", "easywic" ); ?> :</h4>
            <div style="margin-top: 10px;">
			<?php $ewic_opt_updt = get_option("ewic-settings-automatic_update"); ?>
            <input type="radio" name="ewic_sett_autoupd" onclick="ewic_ajax_autoupdt(this);" <?php echo $ewic_opt_updt == "1" ? "checked=\"checked\"" : "";?> value="1"><label style="vertical-align: baseline;"><?php _e( "Enable", "easywic" ); ?></label>
            <input type="radio" name="ewic_sett_autoupd" onclick="ewic_ajax_autoupdt(this);" <?php echo $ewic_opt_updt == "0" ? "checked=\"checked\"" : "";?> style="margin-left: 10px;" value="0"><label style="vertical-align: baseline;"><?php _e( "Disable", "easywic" ); ?></label>
            </div>
            </div>
            </form>
           </div>
	</div>
    </div>

<style>
.setpre {
	display:none;
	margin-right:10px;
	float: left;
	width:16px;
	height:16px;
	background-repeat:no-repeat;
	}
</style>

<script type="text/javascript">
/*<![CDATA[*/

	function ewic_ajax_autoupdt(cmd) {
		jQuery('.setpre').show().css('background-image','url(<?php echo plugins_url('images/89.gif' , __FILE__ ); ?>)');
		var data = {
			action: 'ewic_ajax_autoupdt',
			security: '<?php echo wp_create_nonce( "easywic-lite-nonce"); ?>',				
			cmd: jQuery(cmd).val(),
			};
			
			jQuery.post(ajaxurl, data, function(response) {
				if (response == 1) {
					jQuery('.setpre').css('background-image','url(<?php echo plugins_url('images/valid.png' , __FILE__ ); ?>)');
					setTimeout(function() {
					jQuery('.setpre').fadeOut();
					}, 3000);
					}						
					else {
						jQuery('.setpre').hide();
						alert('Ajax request failed, please refresh your browser window.');
						}
					});
	}
/*]]>*/
</script> 
	
<?php	
	
}

?>