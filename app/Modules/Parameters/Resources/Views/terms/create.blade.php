<!-- modal content -->
<div id="termsCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="termsCreateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro Plan de Servicio</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-2 p-1">
                        <label for="abrev" class="col-sm-12 col-form-label">Abrev.*</label>
                        {!! form::text('abrev', null, [
                            'id' => 'abrev',
                            'class' => 'form-control mayusc',
                            'placeholder' => 'Ingrese Codigo',
                            'maxlength' => 10,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-6 p-1">
                        <label for="description" class="col-sm-12 col-form-label">Descripción*</label>
                        {!! form::text('description', null, [
                            'id' => 'description',
                            'class' => 'form-control letter',
                            'placeholder' => 'Ingrese Descripción',
                            'maxlength' => 191,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="comission_id" class="col-sm-12 col-form-label">Tipo Cobranza</label>
                        {!! form::select(
                            'type_invoice',
                            ['' => 'Seleccione Tipo Cobranza', 'D' => 'Diaria', 'S' => 'Semanal', 'Q' => 'Quincenal', 'M' => 'Mensual'],
                            null,
                            ['id' => 'type_invoice', 'class' => 'form-control', 'required' => 'required'],
                        ) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="prepaid" class="col-sm-12 col-form-label">Prepago(s)</label>
                        {!! form::number('prepaid', 0, [
                            'id' => 'prepaid',
                            'min' => '0',
                            'max' => '12',
                            'class' => 'form-control',
                            'placeholder' => 'Meses Prepago',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="type_cond" class="col-sm-12 col-form-label">Tipo Comisión</label>
                        {!! form::select('type_cond', ['Tarifa' => 'Tarifa', 'Porcentaje' => 'Porcentaje', 'Mixto' => 'Mixto'], null, [
                            'id' => 'type_cond',
                            'class' => 'form-control',
                            'placeholder' => 'Seleccione Tipo Comisión',
                            'onchange' => 'comprobar();',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="type_cond1" class="col-sm-12 col-form-label">Tipo Tarifa</label>
                        {!! form::select('type_cond1', ['Fijo' => 'Fijo', 'Rango' => 'Rango'], null, [
                            'id' => 'type_cond1',
                            'class' => 'form-control',
                            'placeholder' => 'Seleccione Tipo Tarifa',
                            'onchange' => 'comprobar();',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="currency_id" class="col-sm-12 col-form-label">Divisa<small>*</small></label>
                        {!! form::select('currency_id', ['' => 'Seleccione Divisa...'], null, [
                            'id' => 'currency_id',
                            'class' => 'form-control currency_id',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="comission_min" class="col-sm-12 col-form-label">Mínima Base</label>
                        {!! form::text('comission_min', null, [
                            'id' => 'comission_min',
                            'class' => 'form-control input money',
                            'placeholder' => 'Ingrese Tárifa Minima Base',
                            'maxlength' => 10,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="comission_id" class="col-sm-12 col-form-label">Comis. Rango</label>
                        {!! form::select('comission_id', ['' => 'Seleccione Comisión x Rango'], null, [
                            'id' => 'comission_id',
                            'class' => 'form-control input',
                            'placeholder' => 'Seleccione Comisión x Rango',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="comission_flatrate" class="col-sm-12 col-form-label">Tarifa Fija</label>
                        {!! form::text('comission_flatrate', null, [
                            'id' => 'comission_flatrate',
                            'class' => 'form-control input money',
                            'maxlength' => 10,
                            'placeholder' => 'Ingrese Tarifa Fija',
                            'maxlength' => 10,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="comission_percentage" class="col-sm-12 col-form-label">Porcentaje Fijo</label>
                        {!! form::text('comission_percentage', null, [
                            'id' => 'comission_percentage',
                            'class' => 'form-control input porcentage',
                            'maxlength' => 2,
                            'placeholder' => 'Ingrese Porcentaje Fijo',
                            'maxlength' => 4,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="amount_min" class="col-sm-12 col-form-label">Monto Cond. Mín.</label>
                        {!! form::text('amount_min', null, [
                            'id' => 'amount_min',
                            'class' => 'form-control input money',
                            'placeholder' => 'Ingrese Monto Mínimo',
                            'maxlength' => 10,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-1 p-1">
                        <label for="check" class="col-sm-12 col-form-label">&nbsp;</label>
                        <input type="checkbox" id="check" name="check" onchange="checkAmount();">
                    </div>
                    <div class="col-sm-3 p-1">
                        &nbsp;
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="amount_max" class="col-sm-12 col-form-label">Monto Cond. Máx.</label>
                        {!! form::text('amount_max', null, [
                            'id' => 'amount_max',
                            'class' => 'form-control input money',
                            'placeholder' => 'Ingrese Monto Máximo',
                            'maxlength' => 10,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-12">
                        <label for="observations" class="col-sm-6 col-form-label">Observaciones</label>
                        {!! form::textarea('observations', null, [
                            'id' => 'observations',
                            'class' => 'form-control input',
                            'maxlength' => 150,
                            'placeholder' => 'Escriba las observaciones.',
                            'rows' => 2,
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
