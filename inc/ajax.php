<?php

function sendform(){

    //Verify the nonce added in head meta data
    verify_general_nonce();

    if($_POST['typeform'] == 'login_form'){
		wp_clear_auth_cookie();

		$creds = array();
		$creds['user_email'] = sanitize_email($_POST['email']);
		$creds['user_password'] = esc_attr($_POST['pass']);
		$creds['remember'] = true;

		//Detect if validated the email
		//User exist?
		$u = get_user_by('email',$creds['user_email']);
		$check = (is_object($u)) ? wp_authenticate_username_password( NULL, $u->user_login,$creds['user_password']) : new WP_Error('error');

		if(is_object($u))
			$creds['user_login'] = $u->user_login;

		if(!is_wp_error($check)){
			//If user exist, detect if key exist
            $validatekey = get_user_meta($check->ID, '_data_user_key',true);
            
			//If the key is empty signon the user if not thrown an error
			$validated = ($validatekey == '') ? true : false;

			if($validated){
				//If the user has validate is email
				$user = wp_signon($creds, false);
				wp_set_auth_cookie($user->ID,true);
				wp_set_current_user($user->ID);
				wp_send_json(array('success'=> true,'url' => home_url('dashboard')));
			} else {
				$urllink = get_bloginfo('url') . "/login?action=resendvalidation";
				$messagebox = "Tenes que validar tu correo<br><a href='" . $urllink . "'>Reenviar la verificación via email</a>";
				wp_send_json(array('action' => 'novalidate','type' => 'warning','message'=> $messagebox,'resetform' => true));
			}

		} else {
			//Error on the credentials

			wp_send_json(array('action' => 'nouser','type' => 'warning', 'message'=> 'Datos de acceso incorrectos','resetform' => true));
		}
    }
    die();
}

add_action('wp_ajax_sendform', 'sendform');
add_action('wp_ajax_nopriv_sendform', 'sendform');