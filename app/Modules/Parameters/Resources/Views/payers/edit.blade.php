<!-- modal content -->
<div id="payersUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="payersUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar No. Ordenante</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-5 p-1">
                        <label for="bank_id_up" class="col-sm-12 col-form-label">Banco</label>
                        {!! form::text('bank_name', null, ['id' => 'bank_name', 'class' => 'form-control', 'readonly' => 'readonly']) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="type_file_up" class="col-sm-12 col-form-label">Tipo Archivo</label>
                        {!! form::text('type_file_up', null, [
                            'id' => 'type_file_up',
                            'class' => 'form-control',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="consecutive_up" class="col-sm-12 col-form-label">No. Ordenante</label>
                        {!! form::text('consecutive_up', null, [
                            'id' => 'consecutive_up',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Consecutivo No. Ordenante',
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
