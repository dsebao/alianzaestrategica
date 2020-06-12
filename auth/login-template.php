<?php 

/**
 * Template Name: Login
 */

get_header('auth');?>

		<!-- Outer Row -->
		<div class="row justify-content-center h-100">
						
			<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
			
			<div class="col-lg-6 bg-light d-flex align-items-center">

				<div class="auth-container-right p-3 p-md-5">

					<h1 class="h4 text-gray-800 mb-4">Ingresá con tu cuenta</h1>
					
					<form class="user needs-validation js-ajaxform" method="post" novalidate>

						<div class="form-group">
							<input type="email" class="form-control form-control-user" id="email"
								aria-describedby="email" placeholder="Email" required>
							<div class="invalid-feedback">Ingresa un email válido</div>
						</div>

						<div class="form-group">
							<input type="password" class="form-control form-control-user"
								id="pass" placeholder="Contraseña" required>
							<div class="invalid-feedback">Ingresa tu contraseña</div>
						</div>

						<div class="mb-4">
							<span class="small">Perdiste tu contraseña?</span> <a class="small" href="forgot-password.html">Recuperala</a>
						</div>

						<button type="submit" class="btn btn-primary btn-user btn-block">
							Ingresar
						</button>

						<?php wp_nonce_field( 'login' ); ?>
						<input type="hidden" name="action" value="sendform">
						<input type="hidden" name="typeform" value="login_form">

					</form>
					<hr>
					<div class="">
						<span class="small">No estas registrado?</span> <a class="small" href="">Crear una cuenta</a>
					</div>
				</div>

			</div>
						
		</div>

<?php get_footer('auth');?>