<div id="changeSupport" name="changeSupport" class="modal fade " tabindex="-1" role="dialog"
    aria-labelledby="changeSupportLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form" name="form-csupport">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"
                    id="token">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="changeSupportLabel"><b>Solicitud Soporte Administrativo</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    {!! form::hidden('contract_id', null, ['id' => 'contract_id']) !!}
                    <div class="col-sm-12">
                        {!! form::label('Tipo Soporte') !!}
                        {!! form::select(
                            'type_support',
                            [
                                '' => 'Seleccione Tipo Soporte...',
                                'customer' => 'Actualizar Información Cliente',
                                'contract' => 'Cambio Información Contrato',
                                'invoice' => 'Cambio Soporte
                                                            Pago',
                            ],
                            null,
                            ['id' => 'type_support', 'class' => 'form-control'],
                        ) !!}
                    </div>
                    <div class="col-sm-12">
                        {!! form::label('Observaciones') !!}
                        {!! form::textarea('observations', null, [
                            'id' => 'observations',
                            'class' => 'form-control blank',
                            'value' => old('observation_support'),
                            'placeholder' => 'Ingrese sus observaciones',
                            'rows' => 2,
                            'maxlength' => 191,
                        ]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-12">
                        <a href="#" $title="Soporte" id="csupport" name="csupport"
                            class="btn bt-sm btn-info waves-effect waves-light">Registrar Solicitud</a>
                    </div>

                </div>
        </div>
        </form>
    </div>
</div>
