<?php
global $userEmpresa, $e, $theuser;
?>
<div class="card">
    <div class="card-header p-3">
        <h6 class="m-0 font-weight-bold text-primary"><?php echo $e->post_title; ?></h6>
    </div>

    <div class="card-body">

        <table class="table table-bordered dataTable" width="100%" cellspacing="0">
            <thead>

                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Cargo</th>
                    <th>Estado</th>
                    <th style="width:10px"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userEmpresa as $u) {

                    $datau = getUserEmpresadata($u->ID, $e->ID);

                    $datau['usuario'] = $u->ID;
                    $datau['nombre'] = $u->display_name;

                    $datamodal = wp_json_encode($datau);

                    $html = "<tr id='$u->ID'><td>$u->display_name</td>";
                    $html .= "<td>$u->user_email</td>";
                    $html .= "<td><span class='badge badge-{$datau['rol']}'>{$datau['rol']}</span></td>";
                    $html .= "<td>{$datau['cargo']}</td>";
                    $html .= "<td><span class='badge badge-{$datau['estado']}'>{$datau['estado']}</span></td>";
                    $html .= '<td class="text-center">';

                    if ($u->ID != $e->post_author) {

                        $html .= '<div class="dropdown no-arrow">
                        <button class="py-0 btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/></svg>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                            <a data-action="js-delete-employee" class="dropdown-item" data-meta=\'[' . $datamodal . ']\' href="#">Eliminar</a>
                            <a data-toggle="modal" data-target="#employee-edit" data-meta=\'[' . $datamodal . ']\' class="dropdown-item js-employee-edit-modal" href="#">Editar</a>
                        </div>
                      </div>';
                    }
                    $html .= '</td></tr>';

                    echo $html;
                    $datau = array();
                } ?>

            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="employee-edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="js-form-edit-employee" action="">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">NOMBRE</label>
                                <input type="text" class="form-control disabled" id="nombre" name="nombre" val="" disabled>
                            </div>

                            <div class="form-group">
                                <label for="">ROL</label>
                                <select name="rol" class="form-control" id="rol">
                                    <option value="administrador">Administrador</option>
                                    <option value="editor">Editor</option>
                                    <option value="colaborador">Colaborador</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">ESTADO</label>
                                <select name="estado" class="form-control" id="estado">
                                    <option value="pendiente">Pendiente</option>
                                    <option value="activo">Activo</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="iduser" id="iduser">
                            <input type="hidden" name="empresa" id="empresa">
                            <input type="hidden" name="action" value="userform">
                            <input type="hidden" name="typeform" value="edit_employee">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>