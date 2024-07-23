<!-- modal content -->
<div id="preafiliationsView" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="preafiliationsViewLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0" id="preafiliationsViewLabel"><b>Detalles PreAfiliación No. </b><span
                        id="preafiliation_id" name="preafiliation_id"
                        class="preafiliations_view"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Status:
                    </b></h4><span id="status_view" name="status_view" class="preafiliations_view"></span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="mt-0 m-b-20 header-title"><b>Información Básica Cliente</b></h5>
                                </div>
                                <div class="col-sm-4">
                                    <center><label class="col-sm-12 col-form-label"><b>RIF*</b></label>
                                        <span id="rif_view" name="rif_view" class="preafiliations_view"></span>
                                    </center>
                                </div>
                                <div class="col-sm-4">
                                    <center><label class="col-sm-12 col-form-label"><b>Almacén*</b></label>
                                        <span id="company_view" name="company_view" class="preafiliations_view"></span>
                                    </center>
                                </div>
                                <div class="col-sm-4">
                                    <center><label class="col-sm-12 col-form-label"><b>Razón Social*</b></label>
                                        <span id="business_name_view" name="business_name_view"
                                            class="preafiliations_view"></span>
                                    </center>
                                </div>
                                <div class="col-sm-8">
                                    <center><label class="col-sm-12 col-form-label"><b>Actividad Comercial*</b></label>
                                        <span id="cactivity_view" name="cactivity_view"
                                            class="preafiliations_view"></span>
                                    </center>
                                </div>
                                <div class="col-sm-4">
                                    <center><label class="col-sm-12 col-form-label"><b>Email*</b></label>
                                        <span id="email_view" name="email_view" class="preafiliations_view"></span>
                                    </center>
                                </div>
                                <div class="col-sm-3">
                                    <center><label class="col-sm-12 col-form-label"><b>Movíl*</b></label>
                                        <span id="mobile_view" name="mobile_view" class="preafiliations_view"></span>
                                    </center>
                                </div>
                                <div class="col-sm-3">
                                    <center><label class="col-sm-12 col-form-label"><b>Movíl 2*</b></label>
                                        <span id="mobile2_view" name="mobile2_view" class="preafiliations_view"></span>
                                    </center>
                                </div>
                                <div class="col-sm-3">
                                    <center> <label class="col-sm-12 col-form-label"><b>Teléfono</b></label>
                                        <span id="telephone_view" name="telephone_view"
                                            class="preafiliations_view"></span>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="mt-0 m-b-20 header-title"><b>Dirección Residencia</b></h5>
                                </div>

                                <div class="col-sm-2">
                                    <center><label
                                            class="col-sm-12 col-form-label"><b>Estado<small>*</small></b></label>
                                        <span id="state_view" name="state_view" class="preafiliations_view"></span>
                                    </center>
                                </div>

                                <div class="col-sm-2">
                                    <center><label class="col-sm-12 col-form-label"><b>Ciudad*</b></label>
                                        <span id="city_view" name="city_view" class="preafiliations_view"></span>
                                    </center>
                                </div>

                                <div class="col-sm-3">
                                    <center><label
                                            class="col-sm-12 col-form-label"><b>Municipalidad<small>*</small></b></label>
                                        <span id="municipality_view" name="municipality_view"
                                            class="preafiliations_view"></span>
                                    </center>
                                </div>

                                <div class="col-sm-3">
                                    <label
                                        class="col-sm-12 col-form-label"><b>Dir.Residencia<small>*</small></b></label>
                                    <span id="address_view" name="address_view" class="preafiliations_view"></span>
                                </div>

                                <div class="col-sm-2">
                                    <center><label
                                            class="col-sm-12 col-form-label"><b>Postal<small>*</small></b></label>
                                        <span id="postal_code_view" name="postal_code_view"
                                            class="preafiliations_view"></span>
                                    </center>
                                </div>

                                <div class="col-sm-12 fiscal" style="display:none;">
                                    <br>
                                    <h5 class="mt-0 m-b-20 header-title"><b>Dirección Físcal</b></h5>
                                </div>

                                <div class="col-sm-2 fiscal" style="display:none;">
                                    <label class="col-sm-12 col-form-label"><b>Estado<small>*</small></b></label>
                                    {!! Form::select('state_fiscal_id', ['' => 'Seleccione Estado...'], null, [
                                        'id' => 'state_fiscal_id',
                                        'class' => 'form-control addressfiscal',
                                        'value' => old('state_fiscal_id'),
                                        'disabled' => 'disabled',
                                    ]) !!}
                                </div>

                                <div class="col-sm-2 fiscal" style="display:none;">
                                    <label class="col-sm-12 col-form-label"><b>Ciudad<small>*</small></b></label>
                                    {!! Form::select('city_fiscal_id', ['' => 'Seleccione Ciudad...'], null, [
                                        'id' => 'city_fiscal_id',
                                        'class' => 'form-control addressfiscal',
                                        'value' => old('city_fiscal_id'),
                                        'disabled' => 'disabled',
                                    ]) !!}
                                </div>

                                <div class="col-sm-2 fiscal" style="display:none;">
                                    <label
                                        class="col-sm-12 col-form-label"><b>Municipalidad<small>*</small></b></label>
                                    {!! Form::text('municipality_fiscal', null, [
                                        'id' => 'municipality_fiscal',
                                        'class' => 'form-control addressfiscal letter',
                                        'value' => old('municipality_fiscal'),
                                        'placeholder' => 'Ingrese Municipalidad',
                                        'disabled' => 'disabled',
                                    ]) !!}
                                </div>

                                <div class="col-sm-4 fiscal" style="display:none;">
                                    <label class="col-sm-12 col-form-label"><b>Dirección
                                            Fiscal<small>*</small></b></label>
                                    {!! Form::text('address_fiscal', null, [
                                        'id' => 'address_fiscal',
                                        'class' => 'form-control addressfiscal mayusc',
                                        'value' => old('address_fiscal'),
                                        'minlength' => 3,
                                        'maxlength' => 191,
                                        'placeholder' => 'Ingrese Dirección
                                                                                          Comercial',
                                        'disabled' => 'disabled',
                                    ]) !!}
                                </div>

                                <div class="col-sm-2 fiscal" style="display:none;">
                                    <label class="col-sm-12 col-form-label"><b>Postal<small>*</small></b></label>
                                    {!! Form::text('postal_code_fiscal', null, [
                                        'id' => 'postal_code_fiscal',
                                        'class' => 'form-control addressfiscal postal',
                                        'value' => old('postal_code_fiscal'),
                                        'placeholder' => 'Digite Codigo
                                                                                          Postal',
                                        'minlength' => 4,
                                        'maxlength' => 4,
                                        'required' => 'required',
                                        'disabled' => 'disabled',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 row">
                                    <div class="col-sm-12">
                                        <h5 class="header-title"><b>Información Representante Legal</b></h5>
                                    </div>

                                    <div class="col-sm-12 p-2">
                                        <center>
                                            <table id="rm-detail" name="rm-detail"
                                                class="table table-striped table-bordered" cellspacing="0"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <center>No. Documento</center>
                                                        </th>
                                                        <th>
                                                            <center>Nombre Completo</center>
                                                        </th>
                                                        <th>
                                                            <center>Cargo</center>
                                                        </th>
                                                        <th>
                                                            <center>Email</center>
                                                        </th>
                                                        <th>
                                                            <center>Móvil</center>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="mt-0 m-b-20 header-title"><b>Información Mercantil</b></h5>
                                </div>

                                <div class="col-sm-3">
                                    <center><label class="col-sm-12 col-form-label"><b>Contribuyente</b></label>
                                        <span id="type_cont_view" name="type_cont_view"
                                            class="preafiliations_view"></span>
                                    </center>
                                </div>

                                <div class="col-sm-3">
                                    <center><label class="col-sm-12 col-form-label"><b>Retención</b></label>
                                        <span id="tax_view" name="tax_view" class="preafiliations_view"></span>
                                    </center>
                                </div>

                                <div class="col-sm-6">
                                    <center><label class="col-sm-12 col-form-label"><b>Registro Mercantíl</b></label>
                                        <span id="comercial_register_view" name="comercial_register_view"
                                            class="preafiliations_view">----</span>
                                    </center>
                                </div>

                                <div class="col-sm-3">
                                    <center><label class="col-sm-12 col-form-label"><b>Ciudad Registro</b></label>
                                        <span id="city_register_view" name="city_register_view"
                                            class="preafiliations_view">----</span>
                                    </center>
                                </div>

                                <div class="col-sm-3">
                                    <center><label class="col-sm-12 col-form-label"><b>No. Registro</b></label>
                                        <span id="number_register_view" name="number_register_view"
                                            class="preafiliations_view">----</span>
                                    </center>
                                </div>

                                <div class="col-sm-2">
                                    <center><label class="col-sm-12 col-form-label"><b>Tomo</b></label>
                                        <span id="took_register_view" name="took_register_view"
                                            class="preafiliations_view">---</span>
                                    </center>
                                </div>

                                <div class="col-sm-4">
                                    <center><label class="col-sm-12 col-form-label"><b>Cláusula Delegatoria</b></label>
                                        <span id="clause_register_view" name="clause_register_view"
                                            class="preafiliations_view">----</span>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 row">
                                    <div class="col-sm-12">
                                        <h5 class="header-title"><b>Información Banco</b></h5>
                                    </div>
                                    <div class="col-sm-5">
                                        <center><label class="col-sm-12 col-form-label"><b>Banco</b></label>
                                            <span id="bank_view" name="bank_view" class="preafiliations_view"></span>
                                        </center>
                                    </div>
                                    <div class="col-sm-4">
                                        <center><label class="col-sm-12 col-form-label"><b>No. Cuenta</b></label>
                                            <span id="account_bank_view" name="account_bank_view"
                                                class="preafiliations_view"></span>
                                        </center>
                                    </div>
                                    <div class="col-sm-3">
                                        <center><label class="col-sm-12 col-form-label"><b>Afiliación</b></label>
                                            <span id="affiliate_number_view" name="affiliate_number_view"
                                                class="preafiliations_view"></span>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 row">
                                    <div class="col-sm-12">
                                        <h5 class="header-title"><b>Información Venta</b></h5>
                                    </div>
                                    <div class="col-sm-4">
                                        <center><label class="col-sm-12 col-form-label"><b>Modelo Equipo</b></label>
                                            <span id="modelTerminal_view" name="modelTerminal_view"
                                                class="preafiliations_view"></span< /center>
                                    </div>
                                    <div class="col-sm-4">
                                        <center><label class="col-sm-12 col-form-label"><b>Operador</b></label>
                                            <span id="operator_view" name="operator_view"
                                                class="preafiliations_view"></span>
                                        </center>
                                    </div>

                                    <div class="col-sm-4">
                                        <center><label class="col-sm-12 col-form-label"><b>Plan VEPAGOS</b></label>
                                            <span id="term_view" name="term_view" class="preafiliations_view"></span>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 row">
                                    <div class="col-sm-12">
                                        <h5 class="header-title"><b>Observaciones.</b></h5>
                                    </div>
                                    <div class="col-sm-12">
                                        <span id="observation_initial_view" name="observation_initial_view"
                                            class="preafiliations_view"></span></center>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 row">
                                <div class="col-sm-12">
                                    <h5 class="header-title"><b>Información Pago</b></h5>
                                </div>

                                <div class="col-sm-3">
                                    <center><label class="col-sm-12 col-form-label"><b>Divisa</b></label>
                                        <span id="currency_view" name="currency_view"
                                            class="preafiliations_view"></span>
                                    </center>
                                </div>
                                <div class="col-sm-3">
                                    <center><label class="col-sm-12 col-form-label"><b>Tasa Cambio</b></label>
                                        <span id="currencyvalue_view" name="currencyvalue_view"
                                            class="preafiliations_view"></span>
                                    </center>
                                </div>
                                <div class="col-sm-3">
                                    <center><label class="col-sm-12 col-form-label"><b>Monto</b></label>
                                        <span id="amount_view" name="amount_view" class="preafiliations_view"></span>
                                    </center>
                                </div>
                                <div class="col-sm-3">
                                    <center><label class="col-sm-12 col-form-label"><b>Monto Bs.</b></label>
                                        <span id="amount_exchange_view" name="amount_exchange_view"
                                            class="preafiliations_view"></span>
                                    </center>
                                </div>
                                <div class="col-sm-5">
                                    <center><label class="col-sm-12 col-form-label"><b>Tipo Pago</b></label>
                                        <span id="pmethod_view" name="pmethod_view"
                                            class="preafiliations_view"></span>
                                    </center>
                                </div>
                                <div class="col-sm-7">
                                    <center><label class="col-sm-12 col-form-label"><b>Referencia</b></label>
                                        <span id="refere_view" name="refere_view" class="preafiliations_view"></span>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
