<?php
global $item;
$rubro = taxTags($item->ID, 'categoria');
$data = get_post_meta($item->ID);

?>
<div class="timeline timeline-empresa mb-4">
    <div class="timeline--card">
        <div class="timeline--header d-flex">
            <div class="timeline--icon mr-2">

                <svg class='w-100 h-100' width="191px" height="191px" viewBox="0 0 191 191" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Artboard" transform="translate(-4.000000, -5.000000)">
                            <g id="Group" transform="translate(4.000000, 5.000000)">
                                <circle id="Oval" fill="#EEF5F7" cx="95.5" cy="95.5" r="95.5"></circle>
                                <g id="bx-box" transform="translate(33.000000, 41.000000)">
                                    <path d="M19.311711,38.1428571 L19.311711,101 L107.688289,101 L107.675666,38.1428571 L19.311711,38.1428571 Z M88.7405324,63.2857143 L38.2468441,63.2857143 L38.2468441,50.7142857 L88.7405324,50.7142857 L88.7405324,63.2857143 Z M114,25.5714286 L113.987377,13 L13,13 L13,25.5714286 L113.987377,25.5714286 L114,25.5714286 Z" id="Shape"></path>
                                    <path d="M114.3,0 L12.7,0 C5.69595,0 0,5.681 0,12.6666667 L0,25.3333333 C0,29.9946667 2.57175,34.0416667 6.35,36.2393333 L6.35,101.333333 C6.35,108.319 12.04595,114 19.05,114 L107.95,114 C114.95405,114 120.65,108.319 120.65,101.333333 L120.65,36.2393333 C124.42825,34.0416667 127,29.9946667 127,25.3333333 L127,12.6666667 C127,5.681 121.30405,0 114.3,0 Z M12.7,12.6666667 L114.3,12.6666667 L114.3127,25.3333333 L114.3,25.3333333 L12.7,25.3333333 L12.7,12.6666667 Z M19.05,101.333333 L19.05,38 L107.95,38 L107.9627,101.333333 L19.05,101.333333 Z" id="Shape" fill="#888E95" fill-rule="nonzero"></path>
                                    <polygon id="Shape" fill="#888E95" fill-rule="nonzero" points="38 51 89 51 89 64 38 64"></polygon>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>

            </div>
            <div class="timeline--headercontent">
                <h3><?php echo $item->post_title; ?></h3>
                <?php echo $rubro; ?>
                <span class="timeline--badge badge badge-warning"><?php echo $data['servicio_tipo'][0]; ?></span>
            </div>
        </div>
        <div class="timeline--body my-2">
            <p><?php echo $item->post_content; ?></p>
        </div>
        <div class="timeline--actions d-flex justify-content-end">
            <a href="" class="btn btn-sm btn-warning">Contactar</a>
        </div>
    </div>
</div>