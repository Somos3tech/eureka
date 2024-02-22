<!-- modal content -->
<div id="operatorsUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="operatorsUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Categoría Empresa</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="description_up" class="col-sm-12 col-form-label">Nombre Operador</label>
                        {!! form::text('description_up', null, [
                            'id' => 'description_up',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Nombre Operador',
                            'maxlength' => 50,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-6">
                        <center>
                            <label class="col-sm-12 col-form-label">Tiene Simcard</label>
                            <label class="col-sm-12 col-form-label"><input type="checkbox" id="is_simcard_up"
                                    name="is_simcard_up" class="checkbox"></label>
                        </center>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                {!! link_to('#', $title = 'Actualizar', $attributes = ['id' => 'update', 'class' => 'btn bt-sm btn-info']) !!}
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
