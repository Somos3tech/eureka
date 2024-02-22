<!-- modal content -->
<div id="termsUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="termsUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Plan de Servicio</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-2 p-1">
                        {!! form::hidden('id', null, ['id' => 'id']) !!}
                        <label for="abrev" class="col-sm-12 col-form-label">Abrev.*</label>
                        {!! form::text('abrev_up', null, [
                            'id' => 'abrev_up',
                            'class' => 'form-control mayusc',
                            'placeholder' => 'Ingrese Codigo',
                            'maxlength' => 10,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-6 p-1">
                        <label for="description" class="col-sm-12 col-form-label">Descripción*</label>
                        {!! form::text('description_up', null, [
                            'id' => 'description_up',
                            'class' => 'form-control letter',
                            'placeholder' => 'Ingrese Descripción',
                            'maxlength' => 191,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="type_invoice_up" class="_upol-sm-12 col-form-label">Tipo Cobranza</label>
                        {!! form::select(
                            'type_invoice_up',
                            ['' => 'Seleccione Tipo Cobranza', 'D' => 'Diaria', 'S' => 'Semanal', 'Q' => 'Quincenal', 'M' => 'Mensual'],
                            null,
                            ['id' => 'type_invoice_up', 'class' => 'form-control', 'required' => 'required'],
                        ) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="prepaid_up" class="col-sm-12 col-form-label">Prepago</label>
                        {!! form::number('prepaid_up', null, [
                            'id' => 'prepaid_up',
                            'min' => '0',
                            'max' => '12',
                            'value' => 0,
                            'class' => 'form-control',
                            'placeholder' => 'Meses Prepago',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="type_cond_up" class="col-sm-12 col-form-label">Tipo Comisión</label>
                        {!! form::select(
                            'type_cond_up',
                            ['Tarifa' => 'Tarifa', 'Porcentaje' => 'Porcentaje', 'Mixto' => 'Mixto'],
                            null,
                            [
                                'id' => 'type_cond_up',
                                'class' => 'form-control',
                                'placeholder' => 'Seleccione Tipo Comisión',
                                'onchange' => 'comprobar2();',
                                'required' => 'required',
                            ],
                        ) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="type_cond1_up" class="col-sm-12 col-form-label">Tipo Tarifa</label>
                        {!! form::select('type_cond1_up', ['Fijo' => 'Fijo', 'Rango' => 'Rango'], null, [
                            'id' => 'type_cond1_up',
                            'class' => 'form-control',
                            'placeholder' => 'Seleccione Tipo Tarifa',
                            'onchange' => 'comprobar2();',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="currency_id_up" class="col-sm-12 col-form-label">Divisa<small>*</small></label>
                        {!! form::select('currency_id_up', ['' => 'Seleccione Divisa...'], null, [
                            'id' => 'currency_id_up',
                            'class' => 'form-control currency_id',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="comission_min_up" class="col-sm-12 col-form-label">Mínima Base</label>
                        {!! form::text('comission_min_up', null, [
                            'id' => 'comission_min_up',
                            'class' => 'form-control money',
                            'placeholder' => 'Ingrese Tárifa Minima Base',
                            'maxlength' => 10,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="comission_id_up" class="col-sm-12 col-form-label">Comis.Rango</label>
                        {!! form::select('comission_id_up', ['' => 'Seleccione Comisión x Rango'], null, [
                            'id' => 'comission_id_up',
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="comission_flatrate_up" class="col-sm-12 col-form-label">Tarifa Fija</label>
                        {!! form::text('comission_flatrate_up', null, [
                            'id' => 'comission_flatrate_up',
                            'class' => 'form-control money',
                            'maxlength' => 10,
                            'placeholder' => 'Ingrese Tarifa Fija',
                            'maxlength' => 10,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3 p-1">
                        <label for="comission_percentage_up" class="col-sm-12 col-form-label">Porcentaje Fijo</label>
                        {!! form::text('comission_percentage_up', null, [
                            'id' => 'comission_percentage_up',
                            'class' => 'form-control porcentage',
                            'maxlength' => 10,
                            'placeholder' => 'Ingrese Porcentaje Fijo',
                            'maxlength' => 4,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="amount_min_up" class="col-sm-12 col-form-label">Monto Cond. Mín.</label>
                        {!! form::text('amount_min_up', null, [
                            'id' => 'amount_min_up',
                            'class' => 'form-control money',
                            'placeholder' => 'Ingrese Monto Mínimo',
                            'maxlength' => 10,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-1 p-1">
                        <label for="check_up" class="col-sm-12 col-form-label">&nbsp;</label>
                        <input type="checkbox" id="check_up" name="check_up" onchange="checkAmount2();">
                    </div>
                    <div class="col-sm-3 p-1">
                        &nbsp;
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="amount_max_up" class="col-sm-12 col-form-label">Monto Cond. Máx.</label>
                        {!! form::text('amount_max_up', null, [
                            'id' => 'amount_max_up',
                            'class' => 'form-control money',
                            'placeholder' => 'Ingrese Monto Máximo',
                            'maxlength' => 10,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-12">
                        <label for="observations_up" class="col-sm-6 col-form-label">Observaciones</label>
                        {!! form::textarea('observations_up', null, [
                            'id' => 'observations_up',
                            'class' => 'form-control',
                            'maxlength' => 150,
                            'placeholder' => 'Escriba las observaciones.',
                            'rows' => 2,
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
