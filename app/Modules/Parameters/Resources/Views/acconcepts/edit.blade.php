<!-- modal content -->
<div id="acconceptsUpdate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="acconceptsUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Actualizar Cuenta Contable</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-4 p-1">
                        <label for="orderup" class="col-sm-12 col-form-label">Código Cuenta</label>
                        {!! form::hidden('id', null, ['id' => 'id']) !!}
                        {!! form::text('orderup', null, [
                            'id' => 'orderup',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Código Cuenta',
                        ]) !!}
                    </div>

                    <div class="col-sm-8 p-1">
                        <label for="nameup" class="col-sm-12 col-form-label">Nombre Cuenta</label>
                        {!! form::text('nameup', null, [
                            'id' => 'nameup',
                            'class' => 'form-control',
                            'minlength' => '3',
                            'maxlength' => '50',
                            'placeholder' => 'Ingrese Nombre Cuenta',
                        ]) !!}
                    </div>

                    <div class="col-sm-6 p-1">
                        <label for="codctaup" class="col-sm-12 col-form-label">Codigo Cuenta Profit</label>
                        {!! form::text('codctaup', null, [
                            'id' => 'codctaup',
                            'class' => 'form-control',
                            'minlength' => '3',
                            'maxlength' => '50',
                            'placeholder' => 'Ingrese Codigo Cuenta Profit',
                        ]) !!}
                    </div>

                    <div class="col-sm-6 p-1">
                        <label for="forma_pagoup" class="col-sm-12 col-form-label">Forma Pago (EF, CH, TJ, TP, DP)</label>
                        {!! form::text('forma_pagoup', null, [
                            'id' => 'forma_pagoup',
                            'class' => 'form-control',
                            'minlength' => '3',
                            'maxlength' => '50',
                            'placeholder' => 'Forma Pago (EF, CH, TJ, TP, DP)',
                        ]) !!}
                    </div>

                    <div class="col-sm-6 p-1">
                        <label for="tipmonoup" class="col-sm-12 col-form-label">Tipo Moneda (USD, BS)</label>
                        {!! form::text('tipmonoup', null, [
                            'id' => 'tipmonoup',
                            'class' => 'form-control',
                            'minlength' => '3',
                            'maxlength' => '50',
                            'placeholder' => 'Tipo Moneda (USD, BS)',
                        ]) !!}
                    </div>

                    <div class="col-sm-12 p-1">
                        <label for="parent_id" class="col-sm-12 col-form-label">Categoría Padre</label>
                        {!! form::select('parent_id_up', [], old('parent_id_up'), [
                            'id' => 'parent_id_up',
                            'placeholder' => 'Selecciona Categoría...',
                            'class' => 'form-control acconcept select',
                        ]) !!}
                    </div>

                    <div class="col-sm-12 p-1">
                        <label for="forma_pagoup" class="col-sm-12 col-form-label">Forma Pago (EF = Efectivo, CH = Cheque, TJ = Tarjeta, TP = Transferencia, DP = Deposito)</label>
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
