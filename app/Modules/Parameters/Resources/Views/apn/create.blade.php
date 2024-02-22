<!-- modal content -->
<div id="apnCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="apnCreateCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro APN</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12 p-1">
                        <label for="operator_id" class="col-sm-12 col-form-label">Operador</label>
                        {!! form::select('operator_id', ['' => 'Seleccione Operador...'], null, [
                            'id' => 'operator_id',
                            'class' => 'form-control select operator_id',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-12 p-1">
                        <label for="description" class="col-sm-12 col-form-label">Nombre APN</label>
                        {!! form::text('description', null, [
                            'id' => 'description',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Nombre APN',
                            'maxlength' => 50,
                            'required' => 'required',
                        ]) !!}
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
