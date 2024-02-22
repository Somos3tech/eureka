<!-- modal content -->
<div id="termsDetails" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="termsDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Detalles de Condición Comercial</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                {!! Form::open(['id' => 'form-show']) !!}
                <div class="col-sm-12">
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="abrev" class="col-sm-12 col-form-label">Abrev.*</label>
                            {!! form::text('abrev_show', null, [
                                'id' => 'abrev_show',
                                'class' => 'form-control',
                                'placeholder' => 'Ingrese Codigo',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-7">
                            <label for="description" class="col-sm-12 col-form-label">Descripción*</label>
                            {!! form::text('description_show', null, [
                                'id' => 'description_show',
                                'class' => 'form-control',
                                'placeholder' => 'Ingrese Descripción',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label for="comission_id" class="col-sm-12 col-form-label">Tipo Cobranza</label>
                            {!! form::text('type_invoice_show', null, [
                                'id' => 'type_invoice_show',
                                'class' => 'form-control',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label for="prepaid" class="col-sm-12 col-form-label">Meses Prepago</label>
                            {!! form::text('prepaid_show', null, [
                                'id' => 'prepaid_show',
                                'class' => 'form-control',
                                'placeholder' => 'Meses Prepago',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label for="type_cond" class="col-sm-12 col-form-label">Tipo Comisión</label>
                            {!! form::text('type_cond_show', null, [
                                'id' => 'type_cond_show',
                                'class' => 'form-control',
                                'placeholder' => 'Seleccione Tipo Comisión',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label for="type_cond1" class="col-sm-12 col-form-label">Tipo Tarifa</label>
                            {!! form::text('type_cond1_show', null, [
                                'id' => 'type_cond1_show',
                                'class' => 'form-control',
                                'placeholder' => 'Seleccione Tipo Tarifa',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label for="currency_id" class="col-sm-12 col-form-label">Divisa<small>*</small></label>
                            {!! form::text('currency_id_show', null, [
                                'id' => 'currency_id_show',
                                'class' => 'form-control',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label for="comission_min" class="col-sm-12 col-form-label">Tarifa Mínima Base</label>
                            {!! form::text('comission_min_show', null, [
                                'id' => 'comission_min_show',
                                'class' => 'form-control',
                                'placeholder' => 'Ingrese Tárifa Minima Base',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label for="comission_id" class="col-sm-12 col-form-label">Comisión x Rango</label>
                            {!! form::text('comission_id_show', null, [
                                'id' => 'comission_id_show',
                                'class' => 'form-control',
                                'placeholder' => 'Seleccione Comisión x Rango',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label for="comission_flatrate" class="col-sm-12 col-form-label">Tarifa Fija</label>
                            {!! form::text('comission_flatrate_show', null, [
                                'id' => 'comission_flatrate_show',
                                'class' => 'form-control',
                                'placeholder' => 'Ingrese Tarifa Fija',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label for="comission_percentage" class="col-sm-12 col-form-label">Porcentaje Fijo</label>
                            {!! form::text('comission_percentage_show', null, [
                                'id' => 'comission_percentage_show',
                                'class' => 'form-control input porcentage',
                                'placeholder' => 'Ingrese Porcentaje Fijo',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label for="amount_min" class="col-sm-12 col-form-label">Monto Cond. Mín.</label>
                            {!! form::text('amount_min_show', null, [
                                'id' => 'amount_min_show',
                                'class' => 'form-control',
                                'placeholder' => 'Ingrese Monto Mínimo',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label for="amount_max" class="col-sm-12 col-form-label">Monto Cond. Máx.</label>
                            {!! form::text('amount_max_show', null, [
                                'id' => 'amount_max_show',
                                'class' => 'form-control',
                                'placeholder' => 'Ingrese Monto Máximo',
                                'disabled' => true,
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            &nbsp;
                        </div>

                        <div class="col-sm-3">
                            <label for="amount_max" class="col-sm-12 col-form-label">Status</label>
                            {!! form::text('status_show', null, ['id' => 'status_show', 'class' => 'form-control', 'disabled' => true]) !!}
                        </div>

                        <div class="col-sm-12">
                            <label for="observations" class="col-sm-6 col-form-label">Observaciones</label>
                            {!! form::text('observations_show', null, [
                                'id' => 'observations_show',
                                'class' => 'form-control ',
                                'placeholder' => 'Escriba las observaciones.',
                                'rows' => 2,
                                'disabled' => true,
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
