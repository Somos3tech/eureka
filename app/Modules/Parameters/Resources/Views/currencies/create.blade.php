<!-- modal content -->
<div id="currenciesCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="currenciesCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro Divisa</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-4 p-1">
                        <label for="description" class="col-sm-6 col-form-label">Denominación</label>
                        {!! form::text('abrev', null, [
                            'id' => 'abrev',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Denominación',
                        ]) !!}
                    </div>

                    <div class="col-sm-8 p-1">
                        <label for="description" class="col-sm-6 col-form-label">Descripción</label>
                        {!! form::text('description', null, [
                            'id' => 'description',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Concepto Divisa',
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
