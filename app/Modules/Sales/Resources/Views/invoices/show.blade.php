<!-- modal content -->
<div id="showInvoice" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showInvoiceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-show']) !!}
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="showInvoiceLabel"><b>Gestión Conciliación</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="customer_id" class="col-sm-12 col-form-label"><b>Código</b></label>
                        {!! form::text('customer_id', null, [
                            'id' => 'customer_id',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="rif" class="col-sm-12 col-form-label"><b>RIF</b></label>
                        {!! form::text('rif', null, ['id' => 'rif', 'class' => 'form-control outlinenone ', 'readonly' => 'readonly']) !!}
                    </div>

                    <div class="col-sm-6">
                        <label for="business_name" class="col-sm-12 col-form-label"><b>Comercio</b></label>
                        {!! form::text('business_name', null, [
                            'id' => 'business_name',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="state" class="col-sm-12 col-form-label"><b>Estado</b></label>
                        {!! form::text('state', null, [
                            'id' => 'state',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="city" class="col-sm-12 col-form-label"><b>Ciudad</b></label>
                        {!! form::text('city', null, ['id' => 'city', 'class' => 'form-control outlinenone ', 'readonly' => 'readonly']) !!}
                    </div>

                    <div class="col-sm-6">
                        <label for="address" class="col-sm-12 col-form-label"><b>Dirección</b></label>
                        {!! form::text('address', null, [
                            'id' => 'address',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-2">
                        <label for="postal_code" class="col-sm-12 col-form-label"><b>Postal</b></label>
                        {!! form::text('postal_code', null, [
                            'id' => 'postal_code',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-4">
                        <label for="email" class="col-sm-12 col-form-label"><b>Email*</b></label>
                        {!! form::text('email', null, [
                            'id' => 'email',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="telephone" class="col-sm-12 col-form-label"><b>Teléfono</b></label>
                        {!! form::text('telephone', null, [
                            'id' => 'telephone',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="mobile" class="col-sm-12 col-form-label"><b>Movíl</b></label>
                        {!! form::text('mobile', null, [
                            'id' => 'mobile',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-12">
                        <hr />
                    </div>
                    <div class="col-sm-12">
                        <h6 class="modal-title mt-0" id="myModalLabel"><b>Información Venta</b></h6>
                    </div>

                    <div class="col-sm-3">
                        <label for="contract_id" class="col-sm-12 col-form-label"><b>No. Contrato</b></label>
                        {!! form::text('contract', null, [
                            'id' => 'contract',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="created_contract" class="col-sm-12 col-form-label"><b>Fecha Contrato</b></label>
                        {!! form::text('created_contract', null, [
                            'id' => 'created_contract',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="user_name" class="col-sm-12 col-form-label"><b>Asesor / Asistente</b></label>
                        {!! form::text('user_name', null, [
                            'id' => 'user_name',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="consultant_name" class="col-sm-12 col-form-label"><b>Aliado Comercial</b></label>
                        {!! form::text('consultant_name', null, [
                            'id' => 'consultant_name',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="company" class="col-sm-12 col-form-label"><b>Almacén Venta</b></label>
                        {!! form::text('company', null, [
                            'id' => 'company',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="bank" class="col-sm-12 col-form-label"><b>Banco</b></label>
                        {!! form::text('bank', null, ['id' => 'bank', 'class' => 'form-control outlinenone ', 'readonly' => 'readonly']) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="affiliate_number" class="col-sm-12 col-form-label"><b>No. Afiliac.</b></label>
                        {!! form::text('affiliate_number', null, [
                            'id' => 'affiliate_number',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="term" class="col-sm-12 col-form-label"><b>Cond. Comercial</b></label>
                        {!! form::text('term', null, ['id' => 'term', 'class' => 'form-control outlinenone ', 'readonly' => 'readonly']) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="currency_invoice" class="col-sm-12 col-form-label"><b>Divisa</b></label>
                        {!! form::text('currency_invoice', null, [
                            'id' => 'currency_invoice',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="amount_contract" class="col-sm-12 col-form-label"><b>Valor Equipo</b></label>
                        {!! form::text('amount_invoice', null, [
                            'id' => 'amount_invoice',
                            'class' => 'form-control outlinenone ',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="status_contract" class="col-sm-12 col-form-label"><b>Status</b></label>
                        {!! form::text('status_contract', null, [
                            'id' => 'status_contract',
                            'class' => 'form-control outlinenone  outline',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-12">
                        <label for="observation_contract" class="col-sm-12 col-form-label"><b>Observación
                                Venta*</b></label>
                        {!! form::textarea('observation_contract', null, [
                            'id' => 'observation_contract',
                            'class' => 'form-control outlinenone ',
                            'rows' => 2,
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-12">
                        <hr />
                        <h6 class="modal-title mt-0" id="myModalLabel"><b>Información Cobro</b></h6>
                    </div>
                    <div class="col-sm-12 p-2">
                        <table id="invoices-detail" name="invoices-detail"
                            class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>No. Cobro</center>
                                    </th>
                                    <th>
                                        <center>No. Recibo</center>
                                    </th>
                                    <th>
                                        <center>Creado</center>
                                    </th>
                                    <th>
                                        <center>Método Pago</center>
                                    </th>
                                    <th>
                                        <center>Referencia</center>
                                    </th>
                                    <th>
                                        <center>Divisa</center>
                                    </th>
                                    <th>
                                        <center>Monto</center>
                                    </th>
                                    <th>
                                        <center>Descuento</center>
                                    </th>
                                    <th>
                                        <center>Status</center>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="invoiceitem" style="display:none;">
                        <div class="col-sm-12">
                            <hr />
                            <h6 class="modal-title mt-0" id="myModalLabel2">Información Detallada Cobro</h6>
                        </div>
                        <div class="col-sm-12 p-2">
                            <table id="invoiceitems-detail" name="invoiceitems-detail"
                                class="table table-striped table-bordered table-responsive" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>No. Detalle</center>
                                        </th>
                                        <th>
                                            <center>Creado</center>
                                        </th>
                                        <th>
                                            <center>Item</center>
                                        </th>
                                        <th>
                                            <center>Refer.</center>
                                        </th>
                                        <th>
                                            <center>Divisa</center>
                                        </th>
                                        <th>
                                            <center>Monto</center>
                                        </th>
                                        <th>
                                            <center>Dicom</center>
                                        </th>
                                        <th>
                                            <center>Pago Limite</center>
                                        </th>
                                        <th>
                                            <center>Status</center>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
