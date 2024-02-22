<!-- modal content -->
<div id="operatorsCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="operatorsCreateCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro Operador</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="description" class="col-sm-12 col-form-label">Nombre Operador</label>
                        {!! form::text('description', null, [
                            'id' => 'description',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Nombre Operador',
                            'maxlength' => 50,
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <center>
                            <label class="col-sm-12 col-form-label">Tiene Simcard</label>
                            <label class="col-sm-12 col-form-label"><input type="checkbox" id="is_simcard"
                                    name="is_simcard" class="checkbox"></label>
                        </center>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                {!! link_to('#', $title = 'Registrar', $attributes = ['id' => 'create', 'class' => 'btn bt-sm btn-info']) !!}
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
