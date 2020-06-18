<?php

function sendform(){

    //Verify the nonce added in head meta data
	verify_general_nonce();

	//SIGNUP
	if($_POST['typeform'] == 'register_form'){

		$nombre = sanitize_text_field($_POST['nombre']);
		$apellido = sanitize_text_field($_POST['apellido']);
		$email = sanitize_email($_POST['email']);
		$pass = $_POST['pass'];

		if(!is_email($email))
			new WP_Error( 'error','Email inválido');

		$user_id = wp_insert_user(array(
			'user_pass'    => $pass,
			'user_login'   => $email,
			'user_email'   => $email,
			'first_name'   => $nombre,
			'last_name'    => $apellido,
			'display_name' => $nombre . " " . $apellido
		));

		if (!is_wp_error($user_id)){
			$user = new WP_User($user_id);
			wp_clear_auth_cookie();

			//generate key for validation
			$link = md5(uniqid());
			update_user_meta($user->ID,'_data_user_key',$link);

			//Send notification email
			$subject = 'Por favor confirma tu cuenta';
			$link = get_bloginfo('url') ."/ingresar?_emailvalidation=" . $link . "&user=" . $user->ID;
			$button = htmlButton($link,'Confirmar email');
			$content = "<h2>Hola " . $user->display_name ."!</h2><p>Bienvenido a Alianza Estratégica. Para validar tu cuenta haz click en el boton inferior.</p><p style='margin-top:25px;margin-bottom:25px'>$button<br>";

			$sent = sendNotification($subject,$content,$email,true);

			//Send email notification to the custom dmin
			wp_mail($GLOBALS['ADMINEMAIL'], 'Nuevo registro de usuario', $subject. ": " . $user->display_name . ' (' . $email . ')');

			wp_send_json(array('result'=> 'success','type' => 'success','message' => 'Registro exitoso. Te enviamos un email para validar tu cuenta.','url' => '','resetform' => true));
			
		} else {

			$error_string = $user_id->get_error_message();
			wp_send_json(array('type'=> 'danger','result' => 'error','message'=>  $error_string,'error' => $error_string,'resetform' => false));

		}
	}

    if($_POST['typeform'] == 'login_form'){

		wp_clear_auth_cookie();

		$creds = array();
		$creds['user_email'] = sanitize_email($_POST['email']);
		$creds['user_password'] = $_POST['pass'];
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

				//If the user has validate email log the user
				$user = wp_signon($creds, false);
				wp_set_auth_cookie($user->ID,true);
				wp_set_current_user($user->ID);

				wp_send_json(array('result'=> 'success','url' => home_url('dashboard')));

			} else {

				$urllink = get_bloginfo('url') . "/ingresar?action=resendvalidation";
				$messagebox = "Tenes que validar tu correo<br><a href='" . $urllink . "'>Reenviar la verificación via email</a>";

				wp_send_json(array('result' => 'novalidate','type' => 'warning','message'=> $messagebox,'resetform' => true));
			}

		} else {

			//Error on the credentials
			wp_send_json(array('result' => 'nouser','type' => 'warning', 'message'=> 'Datos de acceso incorrectos','resetform' => true));

		}
	}
	
	if($_POST['typeform'] == 'recoverpass_form'){

		$email = sanitize_email($_POST['email']);

		$u = get_user_by('email',$email);

		if ($u){
			$user_login = $u->user_login;
        	$user_email = $u->user_email;
        	$key = substr( md5( uniqid( microtime() ) ), 0, 8);
        	global $wpdb;
        	$wpdb->query("UPDATE $wpdb->users SET user_activation_key = '$key' WHERE user_login = '$user_login'");

        	$subject = 'Resetear contraseña';
			$link = get_bloginfo('url') ."/ingresar?action=resetpass&key=" . $key . "&useremail=" . $email;
			$button = htmlButton($link,'Resetear contraseña');
			$content = "<p>Se ha solicitado modificar tu contraseña en {$GLOBALS['SITENAME']}. Si fuiste vos podes cambiarla clickeando el siguiente enlace, sino es así simplemente ignora este email: </p><p style='margin-top:25px;margin-bottom:25px'>".$button."<br>";

			$sent = sendNotification($subject,$content,$user_email,true);

			wp_send_json(array('result' => 'resetok','type' => 'success','message'=> 'Las instrucciones se te enviaron via email','resetform' => true));

		} else {
			wp_send_json(array('result' => 'nouser','type' => 'danger','message'=> 'Este usuario no existe','resetform' => true));
		}
	}

	if($_POST['typeform'] == 'resetpass_form'){
		$u = get_user_by('email',$_POST['useremail']);
		$pass = $_POST['pass'];
	    if($u){
	    	wp_set_password($pass,$u->ID);
	    	wp_send_json(array('result' => 'resetpass','action' => 'resetok','type' => 'success','message'=> "Contraseña modificada!",'resetform' => true,'url' => get_bloginfo('url') . "/ingresar?action=resetpasssuccess"));
	    } else {
	    	wp_send_json(array('result' => 'nouser','type' => 'danger','message'=> 'Este usuario no existe','resetform' => true));
	    }
	}

	if($_POST['typeform'] == 'form_resendvalidation'){
		$u = get_user_by('email',$_POST['email']);
	    if($u){
	    	$validatekey = get_user_meta($u->ID, '_data_user_key',true);
	    	if($validatekey != ''){
	    		$link = md5(uniqid());
				update_user_meta($u->ID,'_data_user_key',$link);

				//Send notification email
				$subject = __( 'Validate your email', 'growlink' );
				$link = get_bloginfo('url') ."/login?_emailvalidation=" . $link . "&user=" . $u->ID;
				$content = "<p>" . __( 'You have resend the link to validate your acount. Please click the next link.', 'growlink' ) . "</p><p style='margin-top:25px;margin-bottom:25px'><a href='".$link."' style='background: #4137CF;color:#ffffff;padding:14px 30px;text-decoration:none;font-size:17px;text-align-center;border-radius:6px' target='_blank' title=''>Confirm email</a><br>";

				$sent = sendNotification($subject,$content,$u->user_email,true);
	    	}
	    	wp_send_json(array('action' => 'resendcode','type' => 'success','message'=> __('We have just send the link to yor inbox.','growlink'),'resetform' => true));
	    } else {

	    }
	}

    die();
}

add_action('wp_ajax_sendform', 'sendform');
add_action('wp_ajax_nopriv_sendform', 'sendform');