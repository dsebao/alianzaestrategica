<?php 

/**
 * Template Name: Login
 */

//Redirects if loggued
if(is_user_logged_in()){
    wp_redirect('/dashboard');
}

$state = getparams('action');

get_header('auth');?>

		<!-- Outer Row -->
		<div class="row justify-content-center h-100">
			
			<!--  The bg image left -->
			<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
			
			<div class="col-lg-6 bg-light d-flex align-items-center">

				<div class="auth-container-right p-3 p-md-5">

					<?php if($state == 'recover'){?>
					
					<h1 class="h4 text-gray-800 mb-4">Recuperá tu contraseña</h1>
					
					<form class="user needs-validation js-ajaxform" method="post" novalidate>

						<div class="message"></div>

						<div class="form-group">
							<input type="email" name="email" class="form-control form-control-user" id="email"
								aria-describedby="email" placeholder="Ingresa tu email" required>
							<div class="invalid-feedback">Ingresá un email válido</div>
						</div>

						<button type="submit" class="btn btn-primary btn-user btn-block">
							Resetear contraseña
						</button>

						<input type="hidden" name="action" value="sendform">
						<input type="hidden" name="typeform" value="recoverpass_form">

					</form>
					<hr>
					<div class="">
						<a class="small" href="<?php url();?>/ingresar">Volver atrás</a>
					</div>

					<?php } elseif($state == 'resetpass' && isset($userreset)){?>

					<h1 class="h4 text-gray-800 mb-4">Modificá tu contraseña</h1>
					
					<form class="user needs-validation js-ajaxform" method="post" novalidate>

						<div class="message"></div>

						<div class="form-group">
							<input type="password" name="pass" class="form-control form-control-user"
								id="pass" placeholder="Nueva Contraseña" required>
							<div class="invalid-feedback">Contraseña invalida</div>
						</div>

						<button type="submit" class="btn btn-primary btn-user btn-block">
							Resetear contraseña
						</button>

						<input type="hidden" name="useremail" value="<?php echo $_GET['useremail'];?>">
						<input type="hidden" name="action" value="sendform">
						<input type="hidden" name="typeform" value="resetpass_form">

					</form>
					<hr>
					<div class="">
						<a class="small" href="<?php url();?>/ingresar">Volver atrás</a>
					</div>
					

					<?php } elseif($state == 'resendvalidation'){?>
										
					<h1 class="h4 text-gray-800 mb-4">Reenviar validación de correo</h1>
					
					<form class="user needs-validation js-ajaxform" method="post" novalidate>

						<div class="message"></div>

						<div class="form-group">
							<input type="email" name="email" class="form-control form-control-user" id="email"
								aria-describedby="email" placeholder="Ingresa tu email" required>
							<div class="invalid-feedback">Ingresá un email válido</div>
						</div>

						<button type="submit" class="btn btn-primary btn-user btn-block">
							Reenviar código
						</button>

						<input type="hidden" name="action" value="sendform">
						<input type="hidden" name="typeform" value="recoverpass_form">

					</form>
					<hr>
					<div class="">
						<a class="small" href="<?php url();?>/ingresar">Volver atrás</a>
					</div>
					<?php } else {?>

					<h1 class="h4 text-gray-800 mb-4">Ingresá con tu cuenta</h1>

					<?php if(getparams('action') == 'resetpasssuccess'):?>
					<div class="alert alert-info">
						Tu contraseña fue modificada, ingresá con tus nuevos datos
					</div>
					<?php endif;?>
					
					<form class="user needs-validation js-ajaxform" method="post" novalidate>

						<div class="message"></div>

						<div class="form-group">
							<input type="email" name="email" class="form-control form-control-user" id="email"
								aria-describedby="email" placeholder="Email" required>
							<div class="invalid-feedback">Ingresa un email válido</div>
						</div>

						<div class="form-group">
							<input type="password" name="pass" class="form-control form-control-user"
								id="pass" placeholder="Contraseña" required>
							<div class="invalid-feedback">Ingresa tu contraseña</div>
						</div>

						<div class="mb-4">
							<span class="small">Perdiste tu contraseña?</span> <a class="small" href="<?php url();?>/ingresar?action=recover">Recuperala</a>
						</div>

						<button type="submit" class="btn btn-primary btn-user btn-block">
							Ingresar
						</button>
						<input type="hidden" name="action" value="sendform">
						<input type="hidden" name="typeform" value="login_form">

					</form>
					<hr>
					<div class="">
						<span class="small">No estas registrado?</span> <a class="small" href="<?php url();?>/registro">Crear una cuenta</a>
					</div>
				
				<?php }?>

				</div>

			</div>
						
		</div>

<?php get_footer('auth');?>