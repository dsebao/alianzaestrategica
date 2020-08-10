<?php


/**
 * Main Class for Empresa
 */

class Empresa
{

    private $id;

    function __construct($id)
    {
        $this->id = $id;
    }

    public function info()
    {
        $data = get_post($this->id);
        if ($data !== NULL) {
            return $data;
        } else {
            return false;
        }
    }

    public function data()
    {
        $data = get_post_meta($this->id);
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function printdata($key)
    {
        $data = $this->data();
        if (isset($data[$key])) {
            return $data[$key][0];
        } else {
            return false;
        }
    }

    public function detectOperations()
    {
        $data = $this->printdata('empresa_data');

        if ($data) {
            $data = json_decode($this->printdata('empresa_data'), true);
            if (!empty($data)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function servicios()
    {
        $posts = get_posts("post_type=servicios&meta_key=servicio_esquema&meta_value=$this->id");
        return $posts;
    }

    public function serviciosCard()
    {

        $posts = get_posts("post_type=servicios&meta_key=servicio_esquema&meta_value=$this->id");

        $html = '';
        foreach ($posts as $service) {
            $meta = get_post_meta($service->ID);

            $terms = get_the_terms($service->ID, 'categoria');

            $cat = '';
            foreach ($terms as $t) {
                $cat .= "<span class='breadcrumb-item text-xs text-uppercase font-weight-normal text-gray-600'>$t->name</span>";
            }

            $html .= "<div class='card card-items mb-4'>";
            $html .= "<div class='card-header py-3 d-flex flex-row align-items-center justify-content-between' data-meta=''>
        <h6 class='m-0 font-weight-bold text-primary'>$service->post_title</h6>
        <div class='dropdown no-arrow'>
            <a class='dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <i class='fas fa-ellipsis-v fa-sm fa-fw text-gray-600'></i>
            </a>
            <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in' aria-labelledby='dropdownMenuLink' style=''>
                <a class='dropdown-item' href='#'>Editar</a>
                <a class='dropdown-item' data-action='js-delete-item' href='#' data-id='$service->ID' data-empresa='$this->id'>Eliminar</a>
            </div>
        </div>
    </div>";

            $html .= "<div class='card-body py-2'>";
            $html .= "<div class='card-metatag'>$cat</div>";
            $html .= "<p class='card-contenido my-2'>$service->post_content</p>";
            $html .= "<div class='card-metatag mb-2'><span class='badge badge-primary font-weight-normal text-white mr-2'>{$meta['servicio_esquema_nombre'][0]}</span><span class='badge badge-warning font-weight-normal text-dark'>{$meta['servicio_tipo'][0]}</span></div>";

            $html .= '</div>
</div>';
        }
        return $html;
    }

    public function serviciosList()
    {

        $posts = get_posts("post_type=servicios&meta_key=servicio_esquema&meta_value=$this->id");

        if (!empty($posts)) {

            $html = '';
            $html .= "<h6 class='text-primary text-uppercase small'>Servicios adjuntos</h6>";

            foreach ($posts as $servicio) {
                $meta = get_post_meta($servicio->ID);
                $html .= "<div class='alert alert-info mb-3'>
    <h6 class='mb-0'>$servicio->post_title</h6><span class='badge badge-primary'>{$meta['servicio_tipo'][0]}</span>
</div>";
            }
            return $html;
        }
    }

    public function puedeEditar()
    {
        $data = $this->info();
        $user = UserData::inst();

        if ($data) {
            $permisos = $user->permisosEmpresa($this->id);
            if ($permisos == 'administrador' || $permisos == 'editor') {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
