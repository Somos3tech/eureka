<!-- modal content -->
<div id="csupportsCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="csupportsCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="csupportsCreateLabel"><b>Crear Soporte Administrativo</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => 'form-create', 'route' => 'csupports.store', 'method' => 'POST']) !!}
                {{ csrf_field() }}

                <div class="form-group row">
                    <div class="col-sm-8 p-1">
                        <label for="contract_id" class="col-sm-12 col-form-label">Cliente -> No.Venta -> No.
                            Cobro</label>
                        {!! form::select('contract_id', [], null, [
                            'id' => 'contract_id',
                            'class' => 'form-control contract_id select2',
                            'required' => 'required',
                            'data-live-search' => true,
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="type_support" class="col-sm-12 col-form-label">Tipo Soporte</label>
                        {!! form::select(
                            'type_support',
                            ['' => 'Seleccione Tipo Soporte...', 'customer' => 'Información Cliente'],
                            null,
                            ['id' => 'type_support', 'class' => 'form-control select', 'required' => 'required'],
                        ) !!}
                    </div>
                    <div class="col-sm-12 p-1">
                        <label for="description" class="col-sm-6 col-form-label">Observaciones</label>
                        {!! form::textarea('observation', null, [
                            'id' => 'observation',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Observaciones',
                            'rows' => 2,
                            'maxlength' => 191,
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
