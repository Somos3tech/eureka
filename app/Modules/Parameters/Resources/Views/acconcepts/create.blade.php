<!-- modal content -->
<div id="acconceptsCreate" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
    aria-labelledby="acconceptsCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Registrar Cuenta Contable</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-4 p-1">
                        <label for="order" class="col-sm-12 col-form-label">Código Cuenta</label>
                        {!! form::text('order', null, [
                            'id' => 'order',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Código Cuenta',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-8 p-1">
                        <label for="name" class="col-sm-12 col-form-label">Nombre Cuenta</label>
                        {!! form::text('name', null, [
                            'id' => 'name',
                            'class' => 'form-control',
                            'minlength' => '3',
                            'maxlength' => '50',
                            'placeholder' => 'Ingrese Nombre Cuenta',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6 p-1">
                        <label for="codcta" class="col-sm-12 col-form-label">Codigo Cuenta Profit</label>
                        {!! form::text('codcta', null, [
                            'id' => 'codcta',
                            'class' => 'form-control',
                            'minlength' => '3',
                            'maxlength' => '50',
                            'placeholder' => 'Ingrese Codigo Cuenta Profit',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-6 p-1">
                        <label for="forma_pago" class="col-sm-12 col-form-label">Forma Pago (EF, CH, TJ, TP, DP)</label>
                        {!! form::text('forma_pago', null, [
                            'id' => 'forma_pago',
                            'class' => 'form-control',
                            'minlength' => '3',
                            'maxlength' => '50',
                            'placeholder' => 'Forma Pago (EF, CH, TJ, TP, DP)',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-6 p-1">
                        <label for="tipmon" class="col-sm-12 col-form-label">Tipo Moneda (USD, BS)</label>
                        {!! form::text('tipmon', null, [
                            'id' => 'tipmon',
                            'class' => 'form-control',
                            'minlength' => '3',
                            'maxlength' => '50',
                            'placeholder' => 'Tipo Moneda (USD, BS)',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-12 p-1">
                        <label for="parent_id" class="col-sm-12 col-form-label">Categoría Padre</label>
                        {!! form::select('parent_id', [], old('parent_id'), [
                            'id' => 'parent_id',
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
                {!! link_to('#', $title = 'Registrar', $attributes = ['id' => 'create', 'class' => 'btn bt-sm btn-info']) !!}
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
