<?php


/**
 * Main Class for User Actions
 */

class UserData
{

    private $user;

    protected static $instance = null;

    function __construct($user)
    {
        $this->user = $user;
    }

    public static function inst()
    {
        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            global $theuser;
            self::$instance = new self($theuser->ID);
        }
        return self::$instance;
    }

    /**
     * Detecta si hay proyectos creados por el usuario
     *
     * @param int $user
     * @return array
     */
    public function empresas()
    {

        $posts = get_posts("post_type=empresas&author=$this->user");
        return $posts;
    }


    /**
     * Crea un select con el istado de empresas del usuario
     *
     * @param int $user
     * @return array
     */
    public function empresasSelect()
    {

        $posts = get_posts("post_type=empresas&author=$this->user");
        $empresas = array();

        if (is_array($posts)) {
            $empresas = '';
            foreach ($posts as $p) {
                $empresas .= "<option value='{$p->ID}'>{$p->post_title}</option>";
            }
            return $empresas;
        } else {
            $empresas;
        }
    }

    private function getallmeta()
    {

        $data = get_user_meta($this->user);
        return $data;
    }

    /**
     * Obtiene un los datos de un key almacenados en un user meta
     *
     * @param [string] $key El nombre del meta
     * @return mixed
     */
    public function getUserData($key)
    {

        $d = $this->getallmeta();

        if (isset($d[$key][0])) {
            $data = json_decode($d[$key][0], true);
            if (!empty($data)) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Obtiene un dato dentro de un meta key especifico
     *
     * @param [string] $key Meta Key
     * @param [string] $row Index del dato
     * @return mixed
     */
    public function getUserdataRow($key, $row)
    {

        $data = json_decode(get_user_meta($this->user, $key, true), true);

        if (!empty($data)) {
            return (isset($data[$row])) ? $data[$row] : NULL;
        } else {
            return "";
        }
    }

    /**
     * Actualiza data dentro de un user meta
     *
     * @param [string] $key Key del meta
     * @param [string] $data Index del dato a almacenar
     * @return bool
     */
    public function updateUserData($key, $data)
    {

        $update = update_user_meta($this->user, $key, wp_json_encode($data));

        if ($update)
            return $update;
        else
            return false;
    }

    /**
     * Detecta si hay proyectos creados por el usuario
     *
     * @return array
     */
    public function adhesion()
    {

        $data = $this->getUserData('user_empresa');

        if (!empty($data))
            return $data;
        else
            return false;
    }

    public function permisosEmpresa($empresa)
    {

        $adherido = $this->adhesion();

        if ($adherido) :

            $i = array_search($empresa, array_column($adherido, 'id'));
            if ($i !== false) {
                return $adherido[$i]['rol'];
            } else {
                return false;
            }

        else :
            return false;
        endif;
    }

    public function presupuestosRecibidos()
    {
        //Obtengo la data de empresas de mi perfil
        $data = $this->adhesion();

        //Si hay data
        if ($data) {

            //Itero para saber cada id de empresa y si posee el rol adecuado
            foreach ($data as $d) {

                if ($d['rol'] === 'administrador' || $d['rol'] === 'editor' && $d['estado'] == 'activo') {

                    //Obtengo el rubro de la empresa
                    $categorias = get_the_terms($d['id'], 'rubro');

                    $rubros = array();

                    //Itero para guardar cada id del rubro
                    foreach ($categorias as $t) {
                        $rubros[] = $t->term_id;
                    }

                    //Armo el query a la db sobre los post presupuestos
                    $q = array(
                        'post_type' => 'presupuestos',
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'rubro',
                                'field' => 'id',
                                'terms' => $rubros,
                            ),
                        ),
                        'posts_per_page' => -1
                    );
                    $query = new WP_Query($q);
                    $data = $query->posts;

                    $return = array();

                    //Si hay resultados los guardo formateados para la vista tabla
                    if ($data) {
                        foreach ($data as $d) {
                            $data = get_post_meta($d->ID);
                            $productos = json_decode($data['presupuesto_items'][0], true);

                            $return[] = array(
                                $d->ID,
                                $d->post_title,
                                date('d-m-Y', strtotime($d->post_date)),
                                count($productos),
                                $data['presupuesto_esquemanombre'][0],
                                date('d-m-Y', strtotime($data['presupuesto_fechalimite'][0])),
                                createActionsButtonsPresupuestos($d->ID, $d->guid, 'recibidos')
                            );
                        }
                    }

                    return $return;
                }
            }
        } else {
            return false;
        }
    }

    public function presupuestosEnviados()
    {
        //Obtengo la data de empresas de mi perfil
        $adhesiones = $this->adhesion();

        //Si hay data
        if ($adhesiones) {

            //Itero para saber cada id de empresa y si posee el rol adecuado
            foreach ($adhesiones as $d) {
                if ($d['rol'] === 'administrador' || $d['rol'] === 'editor' && $d['estado'] == 'activo') :
                    //Armo el query a la db para cargar mis presupuestos generados
                    $q = array(
                        'post_type' => 'presupuestos',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'presupuesto_esquema',
                                'value' => $d['id'],
                                'compare' => '='
                            )
                        )
                    );
                    $query = new WP_Query($q);
                    $data = $query->posts;

                    $return = array();

                    //Si hay resultados los guardo formateados para la vista tabla
                    if ($data) :
                        foreach ($data as $d) :
                            $data = get_post_meta($d->ID);
                            $productos = json_decode($data['presupuesto_items'][0], true);

                            $return[] = array(
                                $d->ID,
                                $d->post_title,
                                date('d-m-Y', strtotime($d->post_date)),
                                count($productos),
                                $data['presupuesto_esquemanombre'][0],
                                date('d-m-Y', strtotime($data['presupuesto_fechalimite'][0])),
                                createActionsButtonsPresupuestos($d->ID, $d->guid, 'enviados')
                            );
                        endforeach;
                    endif;
                    return $return;
                endif;
            }
        }
    }

    public function propuestasListado()
    {
        $adhesiones = $this->adhesion();

        //Itero para saber cada id de empresa y si posee el rol adecuado
        foreach ($adhesiones as $d) {
            //En esta seccion deberia cargar primera mis propuestas enviadas, y si sos editor o admin ver todas.

            if ($d['estado'] == 'activo') :

                $q['post_type'] = 'propuestas';

                if ($d['rol'] != 'administrador' || $d['rol'] != 'editor') {

                    $q['author'] = $this->user;
                }

                $query = new WP_Query($q);
                $data = $query->posts;

                $return = array();

                //Si hay resultados los guardo formateados para la vista tabla
                if ($data) :
                    foreach ($data as $d) :
                        $data = get_post_meta($d->ID);
                        $datapresu = json_decode($data['propuesta_presupuesto'][0], true);


                        $return[] = array(
                            $d->ID,
                            $datapresu[0]['titulo'],
                            $datapresu[0]['empresa'],
                            $datapresu[0]['fechalimite'],
                            "",
                            createActionsButtonsPresupuestos($datapresu[0]['id'], $d->guid, 'propuestas')
                        );
                    endforeach;
                endif;
                return $return;
            endif;
        }
    }


    public static function propuestaView($idpresu)
    {

        $q['post_type'] = 'propuestas';
        $q['meta_query'][] = array('relation' => 'AND');
        $q['meta_query'][] = array('key' => 'propuesta_idpresu', 'value' => $idpresu);

        $query = new WP_Query($q);
        $data = $query->posts;
        return $data;
    }
}
