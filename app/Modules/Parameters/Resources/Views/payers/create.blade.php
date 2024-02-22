<!-- modal content -->
<div id="payersCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="payersCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b> Registrar No. Ordenante</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-5 p-1">
                        <label for="bank_id" class="col-sm-12 col-form-label">Banco</label>
                        {!! form::select('bank_id', ['' => 'Seleccione Banco...'], null, [
                            'id' => 'bank_id',
                            'class' => 'form-control select bank_id',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="type_file" class="col-sm-12 col-form-label">Tipo Archivo</label>
                        {!! form::select(
                            'type_file',
                            [
                                '' => 'Seleccione Tipo Archivo...',
                                'file' => 'Archivo',
                                'domiciliation' => 'Domiciliación',
                                'affiliate' => 'Afiliación',
                            ],
                            null,
                            ['name' => 'type_file', 'class' => 'form-control type_file'],
                        ) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="consecutive" class="col-sm-12 col-form-label">No. Ordenante</label>
                        {!! form::text('consecutive', 0, [
                            'id' => 'consecutive',
                            'class' => 'form-control consecutive',
                            'placeholder' => 'Ingrese Consecutivo No. Ordenante',
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
