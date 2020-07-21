<!-- Modal -->
<div class="modal fade" id="nuevoitem" tabindex="-1" role="dialog" aria-labelledby="nuevoitem" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user needs-validation simpleform" method="post" novalidate>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select name="tipo" id="tipo" class="form-control" required>
                                    <option value="servicio">Servicio</option>
                                    <option value="producto">Producto</option>
                                </select>
                                <div class="invalid-feedback">Ingresá el tipo</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="esquema">Esquema</label>
                                <select name="esquema" id="esquema" class="form-control" required>
                                    <?php
                                    echo UserData::inst()->empresasSelect();
                                    ?>
                                </select>
                                <div class="invalid-feedback">Ingresá el tipo</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Titulo</label>
                        <input type="text" class="form-control" value="" name="nombre" required placeholder="Definí el titulo de tu servicio/producto">
                        <div class="invalid-feedback">Completá el titulo</div>
                    </div>

                    <div class="form-group">
                        <label for="rubro">Rubro</label>
                        <select name="rubro" id="rubro" class="customselect form-control" required>
                            <?php getOptionsCategory('rubro'); ?>
                        </select>
                        <div class="invalid-feedback">Ingresá el rubro</div>
                    </div>

                    <div class="form-group">
                        <label for="categoria">Categoria</label>
                        <input type="text" class="form-control tagsinput" name="categoria" required placeholder="Ingresa la categoría que defina tu servicio/producto">
                        <div class="invalid-feedback">Ingresá la categoría</div>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" class="form-control" required></textarea>
                        <div class="invalid-feedback">Completá una descripción concreta del servicio/producto que ofrecés.</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="nuevoitem_form">
                    <?php wp_nonce_field('seguridad', 'seguridad-form'); ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>