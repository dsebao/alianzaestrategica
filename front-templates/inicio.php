<?php

/*
Template Name: Inicio Landing
*/

get_header('landing');

?>


    <section class="fdb-block bg-dark"
        style="background-image: url(<?php urlt();?>/img/bg.svg);">
        <div class="container justify-content-center align-items-center d-flex">
            <div class="row justify-content-center text-center">
                <div class="col-12 col-md-9">
                    <h1 class="text-primary mb-5">Conectamos y potenciamos negocios</h1>

                    <p class="text-center">
                        <a href="" class="btn btn-primary btn-lg mx-md-3">Registrate gratis</a>
                        <a href="" class="btn btn-warning btn-lg mx-md-3">Conocé la plataforma</a>
                    </p>
                </div>
            </div>
        </div>
    </section>


<?php

get_footer('landing');

?>