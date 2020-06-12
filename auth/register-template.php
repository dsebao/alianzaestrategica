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
						<div class="form-group">
							<input type="email" class="form-control form-control-user" id="email"
								aria-describedby="emailHelp" placeholder="Email">
						</div>
						<div class="form-group">
							<input type="password" class="form-control form-control-user"
								id="pass" placeholder="Contraseña">
						</div>

						<div class="mb-4">
							<span class="small">Perdiste tu contraseña?</span> <a class="small" href="forgot-password.html">Recuperala</a>
						</div>

						<button type="submit" class="btn btn-primary btn-user btn-block">
							Ingresar
						</button>
					</form>
					<hr>
					<div class="text-center">
						<a class="small" href="forgot-password.html">Recuperar contraseña</a>
					</div>
					<div class="text-center">
						<a class="small" href="register.html">Crea una cuenta</a>
					</div>
				</div>

			</div>
						
		</div>

<?php get_footer('auth');?>