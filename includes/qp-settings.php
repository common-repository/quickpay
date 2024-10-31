<?php

add_action( 'admin_menu', 'qpay_api_key_menu' ); 
add_action( 'admin_init', 'qpay_update_api_key' ); 
function qpay_api_key_menu(){    
	$page_title = 'QuickPay Settings';   
	$menu_title = 'QuickPay';   
	$capability = 'manage_options';   
	$menu_slug  = 'quickpay-settings';   
	$function   = 'qpay_api_key_page';   
	$icon_url   = 'dashicons-money-alt';   
	$position   = 4;    
	add_menu_page( 
		$page_title,                  
		$menu_title,                   
		$capability,                   
		$menu_slug,                   
		$function,                   
		$icon_url,                   
		$position ); 
}

//Register Settings with register_setting Function
if( !function_exists("qpay_update_api_key") ) { 
	function qpay_update_api_key() {   
		register_setting( 'quickpay-api-key-settings', 'quickpay_api_key' ); 
	} 
}


//create our form to save the extran infor
if( !function_exists("qpay_api_key_page") ) 
	{ function qpay_api_key_page(){ 
		?>   
		<h1>QuickPay Settings</h1>

    	<p>Embedd shortcode <b>[quick_payment]</b> onto a page, widget or post to use the plugin.</p>

		Add the Api key generated from your Quickpay Dashboard. If you haven't created one, check out 
		<a href="https://quickpay.bluecube.co.ug" target="_blank"> QuickPay </a>

		<form method="post" action="options.php">
			<?php settings_fields( 'quickpay-api-key-settings' ); ?>
			<?php do_settings_sections( 'quickpay-api-key-settings' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">QuickPay Api Key:</th>
    				<td>
    					<input style="width: 250px;"type="text" name="quickpay_api_key" value="<?php echo esc_html(get_option( 'quickpay_api_key' )) ?>"/>
    				</td>
    			</tr>
    		</table>
    		<?php submit_button(); ?>
		</form>
	<?php
}
 } ?>