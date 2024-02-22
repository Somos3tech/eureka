<!-- modal content -->
<div id="csupportsShow" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="csupportsShowLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {!! Form::open(['id' => 'form']) !!}
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="csupportsShowLabel">.::Gestión Orden de Servicio::.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-8 p-1">
                        <label for="contract_id" class="col-sm-12 col-form-label">Cliente -> No.Venta -> No.
                            Cobro</label>
                        {!! form::select('contract_id', [], null, [
                            'id' => 'contract_id',
                            'class' => 'form-control contract select2',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="type_support" class="col-sm-12 col-form-label">Tipo Soporte</label>
                        {!! form::select(
                            'type_support',
                            [
                                '' => 'Seleccione Tipo Soporte...',
                                'customer' => 'Información Cliente',
                                'contract' => 'Información Contrato',
                                'invoice' => 'Información Cobro',
                            ],
                            null,
                            ['id' => 'type_support', 'class' => 'form-control select', 'disabled' => 'disabled'],
                        ) !!}
                    </div>
                    <div class="col-sm-12 p-1">
                        <label for="observation_response" class="col-sm-6 col-form-label">Observaciones Finales</label>
                        {!! form::textarea('observation_response', null, [
                            'id' => 'observation_response',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Observaciones',
                            'rows' => 2,
                            'maxlength' => 191,
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-12 p-1">
                        <label for="description" class="col-sm-6 col-form-label">Observaciones Iniciales</label>
                        {!! form::textarea('observations', null, [
                            'id' => 'observations',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Observaciones',
                            'rows' => 2,
                            'maxlength' => 191,
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
