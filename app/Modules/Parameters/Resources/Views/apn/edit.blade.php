<!-- modal content -->
<div id="apnUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="apnUpdateLabel"
    aria-hidden="true">
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
                    <div class="col-sm-12 p-1">
                        {!! form::hidden('id', null, ['id' => 'id']) !!}
                        <label for="operator_up_id" class="col-sm-12 col-form-label">Operador</label>
                        {!! form::select('operator_up_id', ['' => 'Seleccione Operador...'], null, [
                            'id' => 'operator_up_id',
                            'class' => 'form-control select operator_id',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-12 p-1">
                        <label for="description_up" class="col-sm-12 col-form-label">Nombre APN</label>
                        {!! form::text('description_up', null, [
                            'id' => 'description_up',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Modelo Terminal',
                            'maxlength' => 50,
                            'required' => 'required',
                        ]) !!}
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
