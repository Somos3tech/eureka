<!-- modal content -->
<div id="csupportsUpdate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="csupportsUpdateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="csupportsUpdateLabel"><b>Gestión Soporte Administrativo</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                {!! Form::open(['id' => 'form-edit']) !!}
                {{ csrf_field() }}

                <div class="col-sm-8">
                    <label for="contract_id_up" class="col-sm-12 col-form-label">Cliente -> No.Venta -> No.
                        Cobro</label>
                    {!! Form::text('contract_id_up', null, [
                        'id' => 'contract_id_up',
                        'class' => 'form-control only-number',
                        'value' => old('rif'),
                        'placeholder' => 'Ingrese Contrato',
                        'required' => 'required',
                    ]) !!}
                </div>

                <div class="col-sm-4">
                    <label for="type_support" class="col-sm-12 col-form-label">Tipo Soporte</label>
                    {!! form::select(
                        'type_support_up',
                        [
                            '' => 'Seleccione Tipo Soporte...',
                            'customer' => 'Información Cliente',
                            'contract' => 'Información Contrato',
                            'invoice' => 'Información Cobro',
                        ],
                        null,
                        ['id' => 'type_support_up', 'class' => 'form-control select', 'disabled' => 'disabled'],
                    ) !!}
                </div>

                <div class="col-sm-12">
                    <label for="observation_response_up" class="col-sm-6 col-form-label">Observaciones Finales</label>
                    {!! form::textarea('observation_response', null, [
                        'id' => 'observation_response',
                        'class' => 'form-control',
                        'placeholder' => 'Ingrese Observaciones',
                        'rows' => 2,
                        'maxlength' => 191,
                    ]) !!}
                </div>

                <div class="col-sm-12">
                    <label for="description" class="col-sm-6 col-form-label">Observaciones Iniciales</label>
                    {!! form::textarea('observation_up', null, [
                        'id' => 'observation_up',
                        'class' => 'form-control',
                        'placeholder' => 'Ingrese Observaciones',
                        'rows' => 2,
                        'maxlength' => 191,
                        'readonly' => 'readonly',
                    ]) !!}
                </div>
            </div>

            <div class="modal-footer">
                {!! link_to('#', $title = 'Actualizar', $attributes = ['id' => 'update', 'class' => 'btn bt-sm btn-info']) !!}
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


