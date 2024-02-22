<!-- modal content -->
<div id="conceptUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="conceptsUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Tipificación Venta</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="description" class="col-sm-6 col-form-label">Abreviatura</label>
                        {!! form::text('abrevup', null, [
                            'id' => 'abrevup',
                            'class' => 'form-control text',
                            'placeholder' => 'Ingrese Abreviatura',
                        ]) !!}
                    </div>
                    <div class="col-sm-8">
                        <label for="description" class="col-sm-6 col-form-label">Descripción</label>
                        {!! form::text('descriptionup', null, [
                            'id' => 'descriptionup',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Concepto',
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
