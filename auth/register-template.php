<?php 

/**
 * Template Name: Signup
 */

get_header('auth');?>

		<!-- Outer Row -->
		<div class="row justify-content-center h-100">
						
			<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
			
			<div class="col-lg-6 bg-light d-flex align-items-center">

				<div class="auth-container-right p-3 p-md-5">

					<h1 class="h4 text-gray-800 mb-4">Crear una cuenta</h1>

					<form class="user js-ajaxform" method="post">
						
						<div class="message"></div>

						<div class="form-group">
							<input type="text" name="nombre" class="form-control form-control-user" id="nombre" placeholder="Nombre">
						</div>

						<div class="form-group">
							<input type="text" name="apellido" class="form-control form-control-user" id="apellido" placeholder="Apellido">
						</div>

						<div class="form-group">
							<input type="email" name="email" class="form-control form-control-user" id="email" placeholder="Email">
						</div>

						<div class="form-group">
							<input type="password" name="pass" class="form-control form-control-user" placeholder="Contraseña">
						</div>

						<div class="mb-4">
							<span class="small">Perdiste tu contraseña?</span> <a class="small" href="forgot-password.html">Recuperala</a>
						</div>

						<input type="hidden" name="action" value="sendform">
						<input type="hidden" name="typeform" value="register_form">

						<button type="submit" class="btn btn-primary btn-user btn-block">Registrarme</button>
					</form>

					<div class="my-4">
					<span class="small">No tenés una cuenta?</span> <a class="small" href="">Crear una</a>
					</div>
				</div>

			</div>
						
		</div>

<?php get_footer('auth');?>