    <?php
    global $item;
    $rubro = taxTags($item->ID, 'rubro');
    $data = get_post_meta($item->ID);

    ?>
    <div class="timeline timeline-empresa mb-4">
        <div class="timeline--card">
            <div class="timeline--header d-flex">
                <div class="timeline--avatar">
                    <?php

                    if (isset($data['empresa_logo'][0]) && $data['empresa_logo'][0] != '') {
                        echo "<img width='55px' class='rounded-circle mr-2' src='{$data['empresa_logo'][0]}' alt=''>";
                    } else {
                        echo "<img width='55px' class='rounded-circle mr-2' src='" . get_bloginfo('template_url') . "/img/avatar.png' alt=''>";
                    } ?>

                </div>
                <div class="timeline--headercontent">
                    <h3><?php echo ($data['empresa_validacion'][0] == 'on') ? $GLOBALS['svg-verified'] : ""; ?> <?php echo $item->post_title; ?></h3>
                    <?php echo $rubro; ?>
                    <span class="timeline--badge badge badge-info"><?php echo $data['empresa_tipo'][0]; ?></span>
                </div>
            </div>
            <div class="timeline--body my-2">
                <div class='timeline--body--content js-long-text'><?php echo $item->post_content; ?></div>
            </div>
            <div class="timeline--actions d-flex justify-content-end">
                <a href="" class="btn btn-sm btn-primary"><i class="far fa-address-card mr-2"></i>Contactar</a>
            </div>
        </div>
    </div>