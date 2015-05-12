<?php

/**
* Plugin Name: REST API Piwik Integration
* Description: Send WP JSON REST Request and results to Piwik Server.
* Version: 1
* Depends: JSON REST API
* Author: Hana Adler
* Author URI: http://bcard777.com
* License: GPLv2+
*/
require_once('PiwikTracker.php');

add_action( 'admin_menu', 'restapipiwik_add_admin_menu' );
add_action( 'admin_init', 'restapipiwik_settings_init' );
add_filter( 'json_serve_request', 'restapipiwik_rest_pre_serve_request' ,10, 5);

function restapipiwik_add_admin_menu(  ) { 

	add_options_page( 'REST API Piwik Integration Settings', 'REST API Piwik Integration Settings', 'manage_options', 'restapipiwik_settings_generator', 'restapipiwik_settings_generator_options_page' );

}
function restapipiwik_settings_exist(  ) { 

	if( false == get_option( 'restapipiwik_settings_generator_settings' ) ) { 
		add_option( 'restapipiwik_settings_generator_settings' );
	}

}

function restapipiwik_settings_init(  ) { 

	register_setting( 'restpiwikpluginPage', 'restapipiwik_settings' );

	add_settings_section(
		'restapipiwik_pluginPage_section', 
		__( 'Piwik Integration Setting Page', 'restapipiwik' ), 
		'restapipiwik_settings_section_callback', 
		'restpiwikpluginPage'
	);

	add_settings_field( 
		'restapipiwik_text_field_0', 
		__( 'Piwik URL', 'restapipiwik' ), 
		'restapipiwik_text_field_0_render', 
		'restpiwikpluginPage', 
		'restapipiwik_pluginPage_section' 
	);
	
	add_settings_field( 
		'restapipiwik_text_field_1', 
		__( 'Website ID', 'restapipiwik' ), 
		'restapipiwik_text_field_1_render', 
		'restpiwikpluginPage', 
		'restapipiwik_pluginPage_section' 
	);
	add_settings_field( 
		'restapipiwik_text_field_2', 
		__( 'Authentication Token ', 'restapipiwik' ), 
		'restapipiwik_text_field_2_render', 
		'restpiwikpluginPage', 
		'restapipiwik_pluginPage_section' 
	);
	add_settings_field( 
		'restapipiwik_text_field_3', 
		__( 'REST Url ', 'restapipiwik' ), 
		'restapipiwik_text_field_3_render', 
		'restpiwikpluginPage', 
		'restapipiwik_pluginPage_section' 
	);

	 
	 

}


function restapipiwik_text_field_0_render(  ) { 

	$options = get_option( 'restapipiwik_settings' );
	?>
	<input type='text' name='restapipiwik_settings[restapipiwik_text_field_0]' value='<?php echo $options['restapipiwik_text_field_0']; ?>'>
	<?php

}

function restapipiwik_text_field_1_render(  ) { 

	$options = get_option( 'restapipiwik_settings' );
	?>
	<input type='text' name='restapipiwik_settings[restapipiwik_text_field_1]' value='<?php echo $options['restapipiwik_text_field_1']; ?>'>
	<?php

}

function restapipiwik_text_field_2_render(  ) { 

	$options = get_option( 'restapipiwik_settings' );
	?>
	<input type='text' name='restapipiwik_settings[restapipiwik_text_field_2]' value='<?php echo $options['restapipiwik_text_field_2']; ?>'>
	<?php

}

function restapipiwik_text_field_3_render(  ) { 

	$options = get_option( 'restapipiwik_settings' );
	?>
	<input type='text' name='restapipiwik_settings[restapipiwik_text_field_3]' value='<?php echo $options['restapipiwik_text_field_3']; ?>'>
	<?php

}

function restapipiwik_settings_section_callback(  ) { 

	echo __( 'This section description', 'restapipiwik' );

}


function restapipiwik_settings_generator_options_page(  ) { 

	?>
	<form action='options.php' method='post'>
		
		<h2>Piwik Integration Settings </h2>
		
		<?php
		settings_fields( 'restpiwikpluginPage' );
		do_settings_sections( 'restpiwikpluginPage' );
		submit_button();
		?>
		
	</form>
	<?php

}



function restapipiwik_rest_pre_serve_request($boolx, $result, $path, $method, $server){
			
			$options = get_option( 'restapipiwik_settings' );
			$piwikUrl = $options['restapipiwik_text_field_0'];
			$idSite = $options['restapipiwik_text_field_1'];	
			$authtoekn = $options['restapipiwik_text_field_2'];
			$url       = $options['restapipiwik_text_field_3'];
			
			$message = array();
			$message["userid"] = get_current_user_id();
			$message["path"] = $path;
			$message["params"] = print_r($server->params,true);
			$message["headers"] = print_r($server->headers,true);
			$message["result"] = print_r($result,true);
			$messageString = print_r($message,true);
			
			$piwikTracker  = new PiwikTracker( $idSite, $piwikUrl);	
			$piwikTracker->setTokenAuth($authtoekn);
			$piwikTracker->setCustomVariable( 1, 'REST Message',$messageString ,  'page');
			
			$piwikTracker->setUrl( $url.$path );
			
			$piwikTracker->doTrackPageView($path);
}
 ?>
