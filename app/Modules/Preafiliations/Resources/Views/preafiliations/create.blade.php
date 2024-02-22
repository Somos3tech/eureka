@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/dropzone.min.css') }}">
    <link href="/assets/css/select2.min.css" rel="stylesheet" />
    @toastr_css
    <style>
        .error {
            background-color: #FDCDCD;
        }
    </style>
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    {!! Form::open([
        'id' => 'preafiliation',
        'name' => 'preafiliation',
        'route' => 'preafiliations.store',
        'method' => 'POST',
        'files' => true,
    ]) !!}
    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-4 offset-4">
            <div class="card mb-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8  ">
                            {!! Form::text('find', null, [
                                'id' => 'find',
                                'class' => 'form-control text-center mayusc rif',
                                'placeholder' => 'Ingrese RIF',
                            ]) !!}
                        </div>
                        <div class="col-sm-4  ">
                            <button type="button" name="find" class="btn btn-sm btn-dark find">Consultar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title customer"><b>Información Básica Cliente</b></h5>
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>RIF*</b></label>
                            {!! Form::hidden('type_contract', 'basic', ['id' => 'type_contract']) !!}
                            {!! Form::text('rif', null, [
                                'id' => 'rif',
                                'class' => 'form-control mayusc',
                                'value' => old('rif'),
                                'placeholder' => 'Ingrese RIF',
                                'required' => 'required',
                                'readonly' => 'readonly',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Almacén Venta*</b></label>
                            {!! Form::select('company_id', ['' => 'Seleccione Almacén...'], null, [
                                'id' => 'company_id',
                                'class' => 'form-control',
                                'value' => old('company_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 user customer" style="display:none;">
                            <label for="user_id" class="col-sm-14 col-form-label"><b>Asesor / Asistente*</b></label>
                            {!! form::select('user_id', ['' => 'Seleccione Asesor/Asistente Venta...'], null, [
                                'id' => 'user_id',
                                'value' => old('user_id'),
                                'class' => 'form-control select2 user',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label for="consultant_id" class="col-sm-15 col-form-label"><b>Aliado Asociado*</b></label>
                            {!! form::select('consultant_id', ['' => 'Seleccione Aliado Asociado...'], null, [
                                'id' => 'consultant_id',
                                'value' => old('consultant_id'),
                                'class' => 'form-control select2',
                            ]) !!}
                        </div>

                        <div class="col-sm-4 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Razón Social*</b></label>
                            {!! Form::text('business_name', null, [
                                'id' => 'business_name',
                                'class' => 'form-control mayusc',
                                'value' => old('business_name'),
                                'placeholder' => 'Ingrese Razón Social',
                                'maxlength' => '191',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Actividad Comercial*</b></label>
                            {!! Form::select('cactivity_id', ['Seleccione Actividad Comercial...'], null, [
                                'id' => 'cactivity_id',
                                'class' => 'form-control cactivity_id',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Email*</b></label>
                            {!! Form::email('email', null, [
                                'id' => 'email',
                                'class' => 'email form-control minusc blank',
                                'value' => old('email'),
                                'placeholder' => 'usuario@dominio.com',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Movíl*</b></label>
                            {!! Form::text('mobile', null, [
                                'id' => 'mobile',
                                'class' => 'form-control phone',
                                'value' => old('mobile'),
                                'minlength' => 12,
                                'maxlength' => 12,
                                'placeholder' => 'Digite Nro. Móvil',
                                'maxlength' => 12,
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Movíl 2*</b></label>
                            {!! Form::text('mobile2', null, [
                                'id' => 'mobile2',
                                'class' => 'form-control phone',
                                'value' => old('mobile2'),
                                'minlength' => 12,
                                'maxlength' => 12,
                                'placeholder' => 'Digite Nro. Móvil',
                                'maxlength' => 12,
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Teléfono</b></label>
                            {!! Form::text('telephone', null, [
                                'id' => 'telephone',
                                'class' => 'form-control phone',
                                'value' => old('telephone'),
                                'minlength' => 12,
                                'maxlength' => 12,
                                'placeholder' => 'Digite Nro. Telefono',
                                'maxlength' => 12,
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title"><b>Dirección Residencia</b></h5>
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Estado*</b></label>
                            {!! Form::select('state_id', ['' => 'Seleccione Estado...'], null, [
                                'id' => 'state_id',
                                'class' => 'form-control select2',
                                'value' => old('state_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Ciudad*</b></label>
                            {!! Form::select('city_id', ['' => 'Seleccione Ciudad...'], null, [
                                'id' => 'city_id',
                                'class' => 'form-control select2',
                                'value' => old('city_id'),
                                'required' => 'required',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Municipalidad*</b></label>
                            {!! Form::text('municipality', null, [
                                'id' => 'municipality',
                                'class' => 'form-control letter',
                                'value' => old('municipality'),
                                'placeholder' => 'Ingrese Municipalidad',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Dir.Residencia*</b></label>
                            {!! Form::text('address', null, [
                                'id' => 'address',
                                'class' => 'form-control mayusc',
                                'value' => old('address'),
                                'minlength' => 3,
                                'maxlength' => 191,
                                'placeholder' => 'Ingrese Dirección Comercial',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Postal*</b></label>
                            {!! Form::text('postal_code', null, [
                                'id' => 'postal_code',
                                'class' => 'form-control postal',
                                'value' => old('postal_code'),
                                'placeholder' => 'Digite Codigo Postal',
                                'minlength' => 4,
                                'maxlength' => 4,
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <center>
                                <label>&nbsp;</label>
                                <label class="checkbox checkbox-info">
                                    <input id="checkbox" name="checkbox" type="checkbox" checked="checked"
                                        onclick="checkfiscal();"><span><b>Dir. Fiscal</b></span><span
                                        class="checkmark"></span>
                                </label>
                            </center>
                        </div>

                        <div class="col-sm-12 fiscal" style="display:none;">
                            <br>
                            <h5 class="mt-0 m-b-20 header-title"><b>Dirección Físcal</b></h5>
                        </div>

                        <div class="col-sm-2   fiscal" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Estado*</b></label>
                            {!! Form::select('state_fiscal_id', ['' => 'Seleccione Estado...'], null, [
                                'id' => 'state_fiscal_id',
                                'class' => 'form-control addressfiscal',
                                'value' => old('state_fiscal_id'),
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-2   fiscal" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Ciudad*</b></label>
                            {!! Form::select('city_fiscal_id', ['' => 'Seleccione Ciudad...'], null, [
                                'id' => 'city_fiscal_id',
                                'class' => 'form-control addressfiscal',
                                'value' => old('city_fiscal_id'),
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-2   fiscal" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Municipalidad*</b></label>
                            {!! Form::text('municipality_fiscal', null, [
                                'id' => 'municipality_fiscal',
                                'class' => 'form-control addressfiscal letter',
                                'value' => old('municipality_fiscal'),
                                'placeholder' => 'Ingrese Municipalidad',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-4   fiscal" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Dirección Fiscal*</b></label>
                            {!! Form::text('address_fiscal', null, [
                                'id' => 'address_fiscal',
                                'class' => 'form-control addressfiscal mayusc',
                                'value' => old('address_fiscal'),
                                'minlength' => 3,
                                'maxlength' => 191,
                                'placeholder' => 'Ingrese Dirección Comercial',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-2   fiscal" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Postal*</b></label>
                            {!! Form::text('postal_code_fiscal', null, [
                                'id' => 'postal_code_fiscal',
                                'class' => 'form-control addressfiscal postal',
                                'value' => old('postal_code_fiscal'),
                                'placeholder' => 'Digite Codigo Postal',
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
    </div>
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title"><b>Representante Legal</b></h5>
                        </div>

                        <div class="col-sm-12 mb-4" align="center">
                            <div class="">
                                <label><b>Necesita más Campos?</b></label>
                                <center>
                                    <button class="btn btn-sm btn-info" type="button" id="btnDel"
                                        value="-" /><b>-</b></button>
                                    <button class="btn btn-sm btn-info" type="button" id="btnAdd"
                                        value="+" /><b>+</b></button>
                                </center>
                            </div>
                        </div>

                        <div id="input1" class="col-sm-12 clonedInput">

                            <div class="row" id="item1">
                                <div class="col-sm-2">
                                    {!! form::text('ident_number_r[]', null, [
                                        'id' => 'ident_number_r[]',
                                        'class' => 'form-control mayusc document',
                                        'placeholder' => 'Ingrese Identificación*',
                                        'required' => 'required',
                                    ]) !!}
                                </div>

                                <div class="col-sm-3">
                                    {!! form::text('fullname_r[]', null, [
                                        'id' => 'fullname_r[]',
                                        'class' => 'form-control mayusc',
                                        'placeholder' => 'Ingrese Nombre Completo*',
                                        'required' => 'required',
                                    ]) !!}
                                </div>

                                <div class="col-sm-3">
                                    {!! form::text('jobtitle_r[]', null, [
                                        'id' => 'jobtitle_r[]',
                                        'class' => 'form-control mayusc',
                                        'placeholder' => 'Ingrese Cargo*',
                                        'required' => 'required',
                                    ]) !!}
                                </div>

                                <div class="col-sm-2">
                                    {!! form::email('email_r[]', null, [
                                        'id' => 'email_r[]',
                                        'class' => 'form-control',
                                        'placeholder' => 'Ingrese Email*',
                                        'required' => 'required',
                                    ]) !!}
                                </div>

                                <div class="col-sm-2">
                                    {!! form::text('mobile_r[]', null, [
                                        'id' => 'mobile_r[]',
                                        'class' => 'form-control phone',
                                        'placeholder' => 'Ingrese Movíl*',
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 row">
                            <div class="col-sm-12 customer" style="display:none;">
                                <h5 class="header-title customer"><b>Información Mercantil</b></h5>
                            </div>
                            <div class="col-sm-7 customer" style="display:none;">
                                <label class="col-sm-12 col-form-label"><b>Tipo Contribuy.*</b></label>
                                {!! Form::select('type_cont', ['1' => 'Ordinario', '2' => 'Especial'], null, [
                                    'id' => 'type_cont',
                                    'class' => 'form-control select2',
                                    'value' => old('type_cont'),
                                    'placeholder' => 'Seleccione Contribuyente....',
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-sm-5 customer" style="display:none;">
                                <label class="col-sm-12 col-form-label"><b>% Ret.</b></label>
                                {!! Form::select('tax', ['75' => '75%', '100' => '100%'], null, [
                                    'id' => 'tax',
                                    'class' => 'form-control',
                                    'value' => old('tax'),
                                    'placeholder' => 'Seleccione % Retención IVA',
                                    'disabled' => true,
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-sm-8 row">
                            <div class="col-sm-12 customer" style="display:none;">
                                <h5 class="header-title customer"><b>Información Banco</b></h5>
                            </div>
                            <div class="col-sm-3 customer" style="display:none;">
                                <label class="col-sm-12 col-form-label"><b>Banco*</b></label>
                                {!! Form::select('bank_id', ['' => 'Seleccione Banco...'], null, [
                                    'id' => 'bank_id',
                                    'class' => 'form-control',
                                    'value' => old('bank_id'),
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-sm-2 customer" style="display:none;">
                                <label class="col-sm-12 col-form-label"><b>ID*</b></label>
                                {!! Form::text('bank_code', null, [
                                    'id' => 'bank_code',
                                    'class' => 'form-control',
                                    'value' => old('bank_code'),
                                    'placeholder' => 'ID Bancario',
                                    'required' => 'required',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>
                            <div class="col-sm-4 customer" style="display:none;">
                                <label class="col-sm-12 col-form-label"><b>No. Cuenta*</b></label>
                                {!! Form::text('account_bank', null, [
                                    'id' => 'account_bank',
                                    'class' => 'form-control account_bank account',
                                    'value' => old('account_bank'),
                                    'placeholder' => 'No. Cuenta',
                                    'required' => 'required',
                                    'readonly' => true,
                                ]) !!}
                            </div>
                            <div class="col-sm-3 customer" style="display:none;">
                                <label class="col-sm-12 col-form-label"><b>Afiliación*</b></label>
                                {!! Form::text('affiliate_number', null, [
                                    'id' => 'affiliate_number',
                                    'class' => 'form-control mayusc affiliate_number numberl',
                                    'value' => old('affiliate_number'),
                                    'placeholder' => 'No. Afiliación',
                                    'required' => 'required',
                                    'readonly' => true,
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12   customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title"><b>Información General Contrato</b></h5>
                        </div>

                        <div class="col-sm-3   customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Modelo Equipo*</b></label>
                            {!! Form::select('modelterminal_id', ['' => 'Seleccione Modelo Equipo...'], null, [
                                'id' => 'modelterminal_id',
                                'class' => 'form-control available terminalvalue modelterminal',
                                'value' => old('modelterminal_id'),
                                'required' => 'required',
                            ]) !!}
                            <div id="total-available"></div>
                        </div>

                        <div class="col-sm-3   customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Operador</b></label>
                            {!! Form::select('operator_id', ['' => 'Seleccione Operador...'], null, [
                                'id' => 'operator_id',
                                'class' => 'form-control',
                                'value' => old('operator_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-4   customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Planes VEPAGOS*</b></label>
                            {!! Form::select('term_id', ['' => 'Seleccione Plan VEPAGOS...'], null, [
                                'id' => 'term_id',
                                'class' => 'form-control',
                                'value' => old('term_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12   customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title"><b>Información de Pago</b></h5>
                        </div>


                        <div class="col-sm-3 customer" style="display:none;">
                            <div class="col-sm-12">
                                <label for="date_value" class="col-sm-12 col-form-label"><b>Fecha
                                        Valor*</b></label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="i-calendar"></i></span>
                                    </div>
                                    <input id="date_value" name="date_value" type="text"
                                        class="form-control terminalvalue datepicker" value="{{ old('date_value') }}"
                                        placeholder="yyyy-mm-dd" data-toggle="datepicker" required>
                                </div><!-- input-group -->
                            </div>
                        </div>

                        <div class="col-sm-2  customer" style="display:none;">
                            <label for="currency_id" class="col-sm-12 col-form-label"><b>Divisa*</b></label>
                            {!! form::hidden('currency', null, ['id' => 'currency']) !!}
                            {!! form::select('currency_id', ['' => 'Seleccione Divisa...'], null, [
                                'id' => 'currency_id',
                                'class' => 'form-control terminalvalue',
                                'value' => old('currency_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display: none;">
                            <label class="col-sm-12 col-form-label"><b>Tarifa Cambio*</b></label>
                            {!! form::text('dicom', null, [
                                'id' => 'dicom',
                                'class' => 'form-control money',
                                'placeholder' => 'Ingrese Tarifa Cambio',
                                'value' => old('dicom'),
                                'maxlength' => '20',
                                'readonly' => 'readonly',
                            ]) !!}
                            <div id="date_dicom" name="date_dicom"></div>
                        </div>

                        <div class="col-sm-2 amountu_display" style="display: none;">
                            <label class="col-sm-12 col-form-label"><b>Valor Equipo*</b></label>
                            {!! form::text('amount', null, [
                                'id' => 'amount',
                                'class' => 'form-control money amountu',
                                'placeholder' => 'Ingrese Valor Equipo',
                                'value' => old('amount'),
                                'maxlength' => '20',
                                'readonly' => 'readonly',
                            ]) !!}
                            <div id="date_amount" name="date_amount"></div>
                        </div>

                        <div class="col-sm-2 amountm_display" style="display: none;">
                            <label class="col-sm-12 col-form-label"><b>Valor Equipo*</b></label>
                            {!! form::select('amountm', [], null, [
                                'id' => 'amountm',
                                'value' => old('amountm'),
                                'class' => 'form-control amountm',
                            ]) !!}
                            <div id="date_amountm" name="date_amountm"></div>
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Forma Pago</b></label>
                            {!! Form::select('pmethod_id', ['' => 'Seleccione Forma de Pago...'], null, [
                                'id' => 'pmethod_id',
                                'class' => 'form-control',
                                'value' => old('payment_id'),
                            ]) !!}
                        </div>

                        <div class="col-sm-3 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Referencia</b></label>
                            {!! Form::text('refere', null, [
                                'id' => 'refere',
                                'class' => 'form-control',
                                'value' => old('refere'),
                                'placeholder' => 'No. Referencia',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title customer"><b>Observaciones</b></h5>
                        </div>
                        <div class="col-sm-12 customer" style="display:none;">
                            {!! form::textarea('observation_initial', null, [
                                'id' => 'observation_initial',
                                'class' => 'form-control blank',
                                'value' => old('observation'),
                                'placeholder' =>
                                    'Ingrese sus observaciones si existe una prioridad con la gestión del punto de venta en caso contrario puede dejar en blanco',
                                'rows' => 2,
                            ]) !!}
                        </div>
                        <hr>
                        <div class="col-sm-12 customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title customer"><b>Documentos</b></h5>
                        </div>

                        <div class="col-sm-3 mb-2 customer" style="display:none;">
                            <div class="card text-left">
                                <div class="card-body">
                                    <center>
                                        <h6><b>Documento <br>RIF*</b></h6>
                                        <div id="upload-rif">
                                            <a href="#" data-toggle="modal" data-target="#uploadRif">
                                                <div id="image_rif" name="image_rif" data-toggle="tooltip"
                                                    data-placement="top" title="Clic x Cargar Documento RIF"><img
                                                        src="/assets/images/upload-pdf.png" width="35%"></div>
                                            </a>
                                            {!! Form::hidden('rif_path', null, ['id' => 'rif_path']) !!}
                                            <div id="response-rif"></div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-2 customer" style="display:none;">
                            <div class="card">
                                <div class="card-body">
                                    <center>
                                        <h6><b>Documento Registro Mercantíl*</b></h6>
                                        <div id="upload-rm">
                                            <a href="#" data-toggle="modal" data-target="#uploadMercantil">
                                                <div id="image_rm" name="image_rm" data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Clic x Cargar Documento Registro Mercantíl">
                                                    <img src="/assets/images/upload-pdf.png" width="35%">
                                                </div>
                                            </a>
                                            {!! Form::hidden('rm_path', null, ['id' => 'rm_path']) !!}
                                            <div id="response-rm"></div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-2 customer" style="display:none;">
                            <div class="card text-left">
                                <div class="card-body">
                                    <center>
                                        <h6><b>Documento Soporte Cuenta Bancaria*</b></h6>
                                        <div id="upload-bank">
                                            <a href="#" data-toggle="modal" data-target="#uploadBank">
                                                <div id="image_bank" name="image_bank" data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Clic x Cargar Documento Soporte Cuenta Bancaría"><img
                                                        src="/assets/images/upload-pdf.png" width="35%"></div>
                                            </a>
                                            {!! Form::hidden('bank_path', null, ['id' => 'bank_path']) !!}
                                            <div id="response-bank"></div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-2 customer" style="display:none;">
                            <div class="card text-left">
                                <div class="card-body">
                                    <center>
                                        <h6><b>Documento Autorización Débito en Cuenta*</b></h6>
                                        <div id="upload-auth-bank">
                                            <a href="#" data-toggle="modal" data-target="#uploadAuthBank">
                                                <div id="image_auth_bank" name="image_auth_bank" data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Clic x Cargar Documento Autorización Débito en Cuenta"
                                                    id=""><img src="/assets/images/upload-pdf.png"
                                                        width="35%"></div>
                                            </a>
                                            {!! Form::hidden('auth_bank_path', null, ['id' => 'auth_bank_path']) !!}
                                            <div id="response-auth-bank"></div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-2 customer" style="display:none;">
                            <div class="card text-left">
                                <div class="card-body">
                                    <center>
                                        <h6><b>Soporte Pago*</b></h6>
                                        <div id="upload-payment">
                                            <a href="#" data-toggle="modal" data-target="#uploadPayment">
                                                <div id="image_payment" name="image_payment" data-toggle="tooltip"
                                                    data-placement="top" title="Clic x Cargar Soporte de Pago"><img
                                                        src="/assets/images/upload-pdf.png" width="35%"></div>
                                            </a>
                                        </div>
                                        {!! Form::hidden('payment_path', null, ['id' => 'payment_path']) !!}
                                        <div id="response-payment"></div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row customer" style="display:none;">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12 mb-4 customer" style="display:none;">
                        <br>
                        <center><button id="submit" type="submit" class="btn btn-info" data-toggle="tooltip"
                                data-placement="top" title="Registrar Preafiliación">Registrar</button></center>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        @include('preafiliations::preafiliations.upload')
    @endsection

    @section('page-js')
        <script src="/assets/js/select2.min.js"></script>
        <script src="{{ asset('/assets/js/vendor/dropzone.min.js') }}"></script>
        <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
        @include('preafiliations::preafiliations.js')

        @toastr_js
        @toastr_render

        <script type="text/javascript">
            $(document).ready(function() {
                $('.cactivity_id').select2();
                $('.select2').attr("style", "display:block;");
                fiscal();
            });
            flatpickr(".datepicker", {
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    },
                    months: {
                        shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                        longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                            'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                        ],
                    },
                }
            });
            Dropzone.options.rifDropzone = {
                autoProcessQueue: true,
                maxFilesize: 1,
                maxFiles: 1,
                addRemoveLinks: true,
                dictRemoveFile: "Eliminar",
                dictDefaultMessage: "<h4 class='sbold'>Suelte los archivos PDF aquí  o haga clic para seleccionar los documentos<h4>",
                init: function() {
                    var submitBtn = document.querySelector("#rif-dropzone");
                    myDropzone = this;

                    submitBtn.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                    });
                    this.on('sending', function(file, xhr, formData) {
                        formData.append('rif', document.getElementById("rif").value);
                        formData.append('type_document', 'rif');
                    });
                    this.on("success",
                        function(file, result) {
                            file.serverId = result;
                            document.getElementById("rif_path").value = result;
                            $("#image_rif").empty();
                            $("#image_rif").prepend("<img src='/assets/images/upload-success.png' width='35%'>");
                            toastr.info("Documento Rif Cargado Correctamente al Sistema")
                        });
                    this.on("removedfile", function(file) {
                        if (!file.serverId) {
                            return;
                        }
                        $.post('/preafiliations/remove?path=' + file.serverId);
                        $("#image_rif").empty();
                        $("#image_rif").prepend("<img src='/assets/images/upload-pdf.png' width='35%'>");
                        document.getElementById("rif_path").value = '';
                        toastr.info("Documento Rif Removido Correctamente")
                    });
                }
            };
            Dropzone.options.rmDropzone = {
                autoProcessQueue: true,
                maxFilesize: 1,
                maxFiles: 1,
                addRemoveLinks: true,
                dictRemoveFile: "Eliminar",
                dictDefaultMessage: "<h4 class='sbold'>Suelte los archivos PDF aquí  o haga clic para seleccionar los documentos<h4>",
                init: function() {
                    var submitBtn = document.querySelector("#rm-dropzone");
                    myDropzone = this;
                    submitBtn.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                    });
                    this.on('sending', function(file, xhr, formData) {
                        formData.append('rif', document.getElementById("rif").value);
                        formData.append('type_document', 'rm');
                    });
                    this.on("success",
                        function(file, result) {
                            file.serverId = result;
                            document.getElementById("rm_path").value = result;
                            $("#image_rm").empty();
                            $("#image_rm").prepend("<img src='/assets/images/upload-success.png' width='35%'>");
                            toastr.info("Documento Registro Mercantíl Cargado Correctamente al Sistema")
                        });
                    this.on("removedfile", function(file) {
                        if (!file.serverId) {
                            return;
                        }
                        $.post('/preafiliations/remove?path=' + file.serverId);
                        $("#image_rm").empty();
                        $("#image_rm").prepend("<img src='/assets/images/upload-pdf.png' width='35%'>");
                        document.getElementById("rm_path").value = '';
                        toastr.info("Documento Registro Mercantíl Removido Correctamente")
                    });
                }
            };

            Dropzone.options.bankDropzone = {
                autoProcessQueue: true,
                maxFilesize: 1,
                maxFiles: 1,
                addRemoveLinks: true,
                dictRemoveFile: "Eliminar",
                dictDefaultMessage: "<h4 class='sbold'>Suelte los archivos PDF aquí  o haga clic para seleccionar los documentos<h4>",
                init: function() {
                    var submitBtn = document.querySelector("#bank-dropzone");
                    myDropzone = this;

                    submitBtn.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                    });
                    this.on('sending', function(file, xhr, formData) {
                        formData.append('rif', document.getElementById("rif").value);
                        formData.append('type_document', 'bank');
                    });
                    this.on("success",
                        function(file, result) {
                            file.serverId = result;
                            document.getElementById("bank_path").value = result;
                            $("#image_bank").empty();
                            $("#image_bank").prepend("<img src='/assets/images/upload-success.png' width='35%'>");
                            toastr.info("Documento Soporte Bancario Cargado Correctamente al Sistema")
                        });
                    this.on("removedfile", function(file) {
                        if (!file.serverId) {
                            return;
                        }
                        $.post('/preafiliations/remove?path=' + file.serverId);
                        $("#image_bank").empty();
                        $("#image_bank").prepend("<img src='/assets/images/upload-pdf.png' width='35%'>");
                        document.getElementById("bank_path").value = '';
                        toastr.info("Documento Soporte Bancario Removido Correctamente")
                    });
                }
            };
            Dropzone.options.authBankDropzone = {
                autoProcessQueue: true,
                maxFilesize: 1,
                maxFiles: 1,
                addRemoveLinks: true,
                dictRemoveFile: "Eliminar",
                dictDefaultMessage: "<h4 class='sbold'>Suelte los archivos PDF aquí  o haga clic para seleccionar los documentos<h4>",
                init: function() {
                    var submitBtn = document.querySelector("#auth-bank-dropzone");
                    myDropzone = this;

                    submitBtn.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                    });
                    this.on('sending', function(file, xhr, formData) {
                        formData.append('rif', document.getElementById("rif").value);
                        formData.append('type_document', 'auth-bank');
                    });
                    this.on("success",
                        function(file, result) {
                            file.serverId = result;
                            document.getElementById("auth_bank_path").value = result;
                            $("#image_auth_bank").empty();
                            $("#image_auth_bank").prepend(
                                "<img src='/assets/images/upload-success.png' width='35%'>");
                            toastr.info("Documento Autorización Débito en Cuenta Cargado Correctamente al Sistema")
                        });
                    this.on("removedfile", function(file) {
                        if (!file.serverId) {
                            return;
                        }
                        $.post('/preafiliations/remove?path=' + file.serverId);
                        $("#image_auth_bank").empty();
                        $("#image_auth_bank").prepend("<img src='/assets/images/upload-pdf.png' width='35%'>");
                        document.getElementById("auth_bank_path").value = '';
                        toastr.info("Documento  Autorización Débito en Cuenta Removido Correctamente")
                    });
                }
            };
            Dropzone.options.paymentDropzone = {
                autoProcessQueue: true,
                maxFilesize: 1,
                maxFiles: 1,
                addRemoveLinks: true,
                dictRemoveFile: "Eliminar",
                dictDefaultMessage: "<h4 class='sbold'>Suelte los archivos PDF aquí  o haga clic para seleccionar los documentos<h4>",
                init: function() {
                    var submitBtn = document.querySelector("#payment-dropzone");
                    myDropzone = this;

                    submitBtn.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                    });
                    this.on('sending', function(file, xhr, formData) {
                        formData.append('rif', document.getElementById("rif").value);
                        formData.append('type_document', 'payment');
                    });
                    this.on("success",
                        function(file, result) {
                            file.serverId = result;
                            document.getElementById("payment_path").value = result;
                            $("#image_payment").empty();
                            $("#image_payment").prepend(
                                "<img src='/assets/images/upload-success.png' width='35%'>");
                            toastr.info("Documento Soporte Pago Cargado Correctamente al Sistema")
                        });
                    this.on("removedfile", function(file) {
                        if (!file.serverId) {
                            return;
                        }
                        $.post('/preafiliations/remove?path=' + file.serverId);
                        $("#image_payment").empty();
                        $("#image_payment").prepend("<img src='/assets/images/upload-pdf.png' width='35%'>");
                        document.getElementById("payment_path").value = '';
                        toastr.info("Documento Soporte Pago Removido Correctamente")
                    });
                }
            };
            /**************************************************************************/
            $('.find').on('click', function() {
                formaRif(document.getElementById("find").value);
                var find = document.getElementById("find").value;
                if (find != '') {
                    $.get('/customers/find?valid_preafiliation=1&data_customer=' + find, function(data) {
                        if (data) {
                            $("#rif").val('');
                            $(".customer").attr("style", "display:none");
                            swal('', '<b>Cliente ya registrado en el Sistema o tiene un proceso de Preafiliación, Consulta a detalle.</b>',
                                'info');
                        } else {
                            $(".customer").attr("style", "display:block");
                            $("#rif").val(find);
                        }
                    });
                } else {
                    $(".customer").attr("style", "display:none");
                    swal('', 'Por favor Ingresar RIF de Comercio', 'warning');
                }
            });
            /**************************************************************************/
            $('#state_id').on('change', function(e) {
                var state = e.target.value;
                //ajax
                $.get('/cities/select?state=' + state, function(data) {
                    if (data.length == '') {
                        document.getElementById("city_id").disabled = true;
                        $('#city_id').empty();
                        $('#city_id').append("<option value=''>Seleccione Ciudad...</option>");
                    } else {
                        document.getElementById("city_id").disabled = false;
                        $('#city_id').empty();
                        $('#city_id').append("<option value=''>Seleccione Ciudad...</option>");

                        $.each(data, function(index, subciudObj) {
                            $('#city_id').append("<option value='" + subciudObj.id + "'>" + subciudObj
                                .description + "</option>");
                        });
                    }
                });
            });
            /**************************************************************************/
            $('#state_fiscal_id').on('change', function(e) {
                var state = e.target.value;
                //ajax
                $.get('/cities/select?state=' + state, function(data) {
                    if (data.length == '') {
                        document.getElementById("city_fiscal_id").disabled = true;
                        $('#city_fiscal_id').empty();
                        $('#city_fiscal_id').append("<option value=''>Seleccione Ciudad...</option>");
                    } else {
                        document.getElementById("city_fiscal_id").disabled = false;
                        $('#city_fiscal_id').empty();
                        $('#city_fiscal_id').append("<option value=''>Seleccione Ciudad...</option>");

                        $.each(data, function(index, subciudObj) {
                            $('#city_fiscal_id').append("<option value='" + subciudObj.id + "'>" +
                                subciudObj.description + "</option>");
                        });
                    }
                });
            });
            /**************************************************************************/
            $('#bank_id').change(function(e) {
                var bank_id = e.target.value;
                $('.account_bank').val('');
                $('.affiliate_number').val('');
                if (bank_id) {
                    $.get('/banks/bankcode?bank_id=' + bank_id, function(data) {
                        document.getElementById("bank_code").value = data.bank_code;
                        $('.account_bank').removeAttr('readonly');
                        $('.affiliate_number').removeAttr('readonly');
                    });
                } else {
                    document.getElementById("bank_code").value = 'ID Bancario';
                    $('.account_bank').attr('readonly', 'readonly');
                    $('.affiliate_number').attr('readonly', 'readonly');
                }

                if (bank_id == 9 || bank_id == 14) {
                    document.getElementById("affiliate_number").classList.remove('numberl');
                    document.getElementById("affiliate_number").classList.add('numbermercant');
                } else {
                    document.getElementById("affiliate_number").classList.remove('numbermercant');
                    document.getElementById("affiliate_number").classList.add('numberl');
                }

                /************************************************************************/
                $('.numberl').mask('AAAAAAAA', {
                    'translation': {
                        A: {
                            pattern: /[0-9]/
                        }
                    }
                });
                /************************************************************************/
                $('.numbermercant').mask('SAAAAAAAAAAAAA', { //Mercantil y Provincial
                    'translation': {
                        S: {
                            pattern: /[0CVEJPGRcvejpgr]{1}/
                        },
                        A: {
                            pattern: /[0-9]/
                        }
                    }
                });
            });
            /**************************************************************************/
            $('#currency_id').change(function(e) {
                $('#date_dicom').empty();
                currency_id = e.target.value;
                $.get('/currencies/find?currency_id=' + currency_id, function(data) {
                    document.getElementById("currency").value = data.abrev;
                });

                $.get('/currencyvalues/valueDycon?currency_id=' + currency_id, function(data) {
                    if (data) {
                        document.getElementById("dicom").value = data.dicom;
                        $('#date_dicom').empty();
                        if (currency_id > 1) {
                            $('#date_dicom').append(
                                '<span class="badge badge-pill badge-success p-2 m-1">Fecha: ' + data
                                .date_value + ' (Bs.)</span>');
                        } else {
                            $('#date_dicom').append(
                                '<span class="badge badge-pill badge-dark p-2 m-1">Fecha: No Aplica</span>');
                            document.getElementById("dicom").value = 0;
                        }
                    } else {
                        document.getElementById("dicom").value = 0;
                        if (currency_id > 1) {
                            toastr.info(
                                "No se encuentra Valor Cambio Divisa en el Sistema, Validar con Área encargada"
                            )
                        }
                    }
                });
            });

            /**************************************************************************/
            $('#company_id').change(function(e) {
                $('#total-available').empty();
                var modelterminal = document.getElementById("modelterminal_id").value;
                var company = e.target.value;
                available(modelterminal, company, false);
                $.get('/roles/getrole', function(data) {
                    var user_id = data.user_id;
                    var slug = data.slug;
                    if (slug != 'preafiliation') {
                        $.get('/users/select?slug=' + slug + '&company_id=' + company + '&user_id=' + user_id,
                            function(data) {
                                $('#user_id').empty();
                                if (data.length != 1) {
                                    $('#user_id').append(
                                        "<option value=''>Seleccione Asesor Venta...</option>");
                                }
                                if (data.length > 0) {
                                    $.each(data, function(index, subUserObj) {
                                        $('#user_id').append("<option value='" + subUserObj.id +
                                            "'>" + subUserObj.description + "</option>");
                                    });
                                }
                                $("#user_id option[value=" + {{ old('user_id') }} + "]").attr("selected",
                                    true);

                                $.get('/consultants/select?user_id=' + user_id, function(data) {
                                    $('#consultant_id').empty();
                                    if (data.length > 1) {
                                        $('#consultant_id').append(
                                            "<option value=''>Seleccione Aliado Comercial...</option>"
                                        );
                                        $.each(data, function(index, subUserObj) {
                                            $('#consultant_id').append("<option value='" +
                                                subUserObj.id + "'>" + subUserObj
                                                .description + "</option>");
                                        });
                                        $("#consultant_id option[value=" +
                                            {{ old('consultant_id') }} + "]").attr("selected",
                                            true);
                                    } else {
                                        document.getElementById("consultant_id").readonly = true;
                                        $('#consultant_id').append(
                                            "<option value=''>Ningún Aliado Comercial</option>");
                                    }
                                });
                            });
                    }
                });
            });
            /**************************************************************************/
            $('.user').on('change', function(e) {
                var user_id = e.target.value;
                $.get('/consultants/select?user_id=' + user_id, function(data) {
                    $('#consultant_id').empty();
                    if (data.length > 0) {
                        $('#consultant_id').append("<option value=''>Seleccione Aliado Comercial...</option>");
                        $.each(data, function(index, subUserObj) {
                            $('#consultant_id').append("<option value='" + subUserObj.id + "'>" +
                                subUserObj.description + "</option>");
                            $("#consultant_id option[value=" + {{ old('consultant_id') }} + "]")
                                .attr("selected", true);
                        });
                    } else {
                        document.getElementById("consultant_id").readonly = true;
                        $('#consultant_id').append("<option value=''>Ningún Aliado Comercial</option>");
                    }
                });
            });
            /**************************************************************************/
            $('#company_id').change(function(e) {

            });
            /**************************************************************************/
            $('.terminalvalue').change(function() {
                $('#date_dicom').empty();
                currency_id = document.getElementById("currency_id").value;
                var date_value = document.getElementById("date_value").value;
                $.get('/currencies/find?currency_id=' + currency_id, function(data) {
                    document.getElementById("currency").value = data.abrev;
                });
                /**************************************************************************/
                $.get('/currencyvalues/valueDycon?currency_id=' + currency_id + '&date_value=' + date_value, function(
                    data) {
                    if (data) {
                        document.getElementById("dicom").value = data.dicom;
                        $('#date_dicom').empty();
                        if (currency_id > 1) {
                            $('#date_dicom').append(
                                '<span class="badge badge-pill badge-success p-2 m-1">Fecha: ' + data
                                .date_value + ' (Bs.)</span>');
                        } else {
                            $('#date_dicom').append(
                                '<span class="badge badge-pill badge-dark p-2 m-1">Fecha: No Aplica</span>');
                            document.getElementById("dicom").value = 0;
                        }
                    } else {
                        document.getElementById("dicom").value = 0;
                        if (currency_id > 1) {
                            toastr.info(
                                "No se encuentra Valor Cambio Divisa en el Sistema, Validar con Área encargada"
                            )
                        }
                    }
                });
                amountTotal();
            });
            /**************************************************************************/
            $('.available').on('change', function(e) {
                $('#total-available').empty();
                var modelterminal = e.target.value;
                var company = document.getElementById("company_id").value;
                available(modelterminal, company, true);
            });
            /**************************************************************************/
            $('#type_cont').on('change', function(e) {
                fiscal();
            });
            /**************************************************************************/
            function amountTotal() {
                var modelterminal_id = document.getElementById("modelterminal_id").value;
                var currency_id = document.getElementById("currency_id").value;
                var date_value = document.getElementById("date_value").value;

                $.get('/terminalvalues/get-amount?modelterminal_id=' + modelterminal_id + '&currency_id=' + currency_id +
                    '&date_value=' + date_value,
                    function(data) {
                        if (data.length == 1) {
                            $("#submit").css('display', 'block');
                            $(".amountu_display").css('display', 'block');
                            $(".amountm_display").css('display', 'none');

                            $('.amountu').removeAttr('disabled');
                            $('.amountu').attr('required', true);

                            $('.amountm').attr('disabled', 'disabled');
                            $('.amountm').removeAttr('required');

                            $.each(data, function(index, subAmountObj) {
                                if (currency_id == 1) {
                                    document.getElementById("amount").value = subAmountObj.local;
                                } else if (currency_id > 1) {
                                    document.getElementById("amount").value = subAmountObj.currency;
                                }
                                $('#date_amount').empty();
                                $('#date_amount').append(
                                    '<span class="badge badge-pill badge-success p-2 m-1">Fecha: ' +
                                    subAmountObj.date + ' (' + subAmountObj.currency_denomination + ')</span>');
                            });
                        } else
                        if (data.length > 1) {
                            $("#submit").css('display', 'block');
                            $(".amountu_display").css('display', 'none');
                            $(".amountm_display").css('display', 'block');

                            $('.amountu').attr('disabled', 'disabled');
                            $('.amountu').removeAttr('required');

                            $('.amountm').removeAttr('disabled');
                            $('.amountm').attr('required', true);

                            $('#amountm').empty();
                            $('#amountm').append("<option value=''>Seleccione Valor Equipo...</option>");

                            $.each(data, function(index, subAmountObj) {
                                if (currency_id == 1) {
                                    $('#amountm').append("<option value='" + subAmountObj.local + "'>" +
                                        subAmountObj.local + " - " + subAmountObj.description + "</option>");
                                } else
                                if (currency_id > 1) {
                                    $('#amountm').append("<option value='" + subAmountObj.currency + "'>" +
                                        subAmountObj.currency + " - " + subAmountObj.description + "</option>");
                                }
                                $('#date_amountm').empty();
                                $('#date_amountm').append('<span class="badge badge-pill badge-success p-2 m-1">' +
                                    subAmountObj.date + ' (' + subAmountObj.currency_denomination + ')</span>');
                            });
                        } else {
                            $("#submit").css('display', 'none');
                            $("#amountm option:selected").removeAttr("selected");
                            $(".amountu_display").css('display', 'none');
                            $(".amountm_display").css('display', 'none');

                            $('.amountu').removeAttr('disabled');
                            $('.amountu').attr('required', true);

                            $('.amountm').attr('disabled', 'disabled');
                            $('.amountm').removeAttr('required');
                        }

                        if (modelterminal_id != '' && currency_id != '' && data.length == 0) {
                            $('#date_amount').empty();
                            $('#date_amountm').empty();
                            $("#submit").css('display', 'none');
                            toastr.info(
                                "No se encuentra Valor de Venta de este Modelo y/ó Denominación de Divisa en el Sistema, Validar con Área encargada"
                            )
                        }
                    });
            }
            /************************************************************************/
            function cambiar() {
                var pdrs = document.getElementById('file').files[0].name;
                document.getElementById('info').innerHTML = pdrs;
            }
            /************************************************************************/
            function checkfiscal() {
                if ($('#checkbox')[0].checked == false) {
                    $(".fiscal").css('display', 'block');
                    $('.addressfiscal').removeAttr('disabled');
                    $('.addressfiscal').attr('required', true);
                } else {
                    $(".fiscal").css('display', 'none');
                    $('.addressfiscal').attr('disabled', 'disabled');
                    $('.addressfiscal').removeAttr('required');
                }
            }
            /************************************************************************/
            function fiscal() {
                $('#tax').empty();
                $('#tax').append("<option value=''>Seleccione % Retención</option>");
                if (document.getElementById("type_cont").value == 2) {
                    $('#tax').removeAttr('disabled');
                    $('#tax').attr('required', true);

                    $('#tax').append("<option value='75'>75%</option>");
                    $('#tax').append("<option value='100'>100%</option>");
                } else {
                    $('#tax').attr('disabled', 'disabled');
                    $('#tax').removeAttr('required');
                }
            }
            /************************************************************************/
            function formaRif(rif) {
                if (rif) {
                    var parts = rif.split("-");

                    if (parts.length == 2) {
                        var index = parts[1].substr(-1);
                        parts[2] = index;
                        parts[1] = parts[1].slice(0, -1);
                        parts[1] = parts[1].padStart(8, '0');
                    } else {
                        if (parts.length > 2) {
                            if (parts[2] == "") {
                                var index = parts[1].substr(-1);
                                parts[2] = index;
                                parts[1] = parts[1].slice(0, -1);
                                parts[1] = parts[1].padStart(8, '0');
                            }
                        }
                    }
                }
                document.getElementById("find").value = parts.join("-");
            }
            /**************************************************************************/
            function available(modelterminal, company, available) {
                $.get('/terminals/totalAvailable?modelterminal_id=' + modelterminal + '&company_id=' + company, function(data) {
                    if (data > 0) {
                        $.get('/preafiliations/totalAvailable?modelterminal_id=' + modelterminal + '&company_id=' +
                            company + '&total_terminal=' + data,
                            function(data2) {
                                if (data2 > 0) {
                                    $("#submit").css('display', 'block');
                                    $('#total-available').append(
                                        '<span class="badge badge-pill badge-success p-2 m-1">Equipos Disponibles: ' +
                                        data2 + '</span>');
                                } else {
                                    $("#submit").css('display', 'none');
                                    $('#total-available').append(
                                        '<span class="badge badge-pill badge-danger p-2 m-1">Equipos Disponibles: ' +
                                        data2 + '</span>');
                                }
                            });
                    } else {
                        $("#submit").css('display', 'none');
                        $('#total-available').append(
                            '<span class="badge badge-pill badge-danger p-2 m-1">Equipos Disponibles: ' + 0 +
                            '</span>');
                        if (available == true) {
                            toastr.info(
                                "No se puede realizar Preafiliación, ya que no hay Equipos Disponibles para Reservar"
                            )
                        }
                    }
                });
            }

            /**************************************************************************/
            $.get('/roles/getrole', function(data) {
                var user_id = data.user_id;
                var slug = data.slug;
                /**************************************************************************/
                $.get('/companies/select/zone-valid?wholesaler=0&slug=' + slug, function(data) {
                    $('#company_id').empty();
                    if (data.length != 1) {
                        $('#company_id').append("<option value=''>Seleccione Almacén Venta...</option>");
                    }
                    $.each(data, function(index, subCompanyObj) {
                        document.getElementById("company_id").disabled = false;
                        $('#company_id').append("<option value='" + subCompanyObj.id + "'>" +
                            subCompanyObj.description + "</option>");
                    });
                    $("#company_id option[value=" + {{ old('company_id') }} + "]").attr("selected", true);


                    var company = document.getElementById("company_id").value;
                    $.get('/users/select?slug=' + slug + '&company_id=' + company + '&user_id=' + user_id,
                        function(data) {
                            $('#user_id').empty();
                            if (data.length != 1) {
                                $('#user_id').append(
                                    "<option value=''>Seleccione Asesor Venta...</option>");
                            }

                            if (data.length >= 1 && (slug == 'assistant' || slug == 'preafiliation' ||
                                    slug == 'sales')) {
                                $.each(data, function(index, subUserObj) {
                                    $('#user_id').append("<option value='" + subUserObj.id + "'>" +
                                        subUserObj.description + "</option>");
                                });
                            }

                            $("#user_id option[value=" + {{ old('user_id') }} + "]").attr("selected",
                                true);
                        });
                    /**************************************************************************/
                    $.get('/consultants/select?user_id=' + user_id, function(data) {
                        $('#consultant_id').empty();
                        if (data.length > 1) {
                            $('#consultant_id').append(
                                "<option value=''>Seleccione Aliado Comercial...</option>");
                            $.each(data, function(index, subUserObj) {
                                $('#consultant_id').append("<option value='" + subUserObj.id +
                                    "'>" + subUserObj.description + "</option>");
                            });
                            $("#consultant_id option[value=" + {{ old('consultant_id') }} + "]")
                                .attr("selected", true);
                        } else {
                            document.getElementById("consultant_id").readonly = true;
                            $('#consultant_id').append(
                                "<option value=''>Ningún Aliado Comercial</option>");
                        }
                    });
                });
            });

            /****************************************************************************/
            $('.mayusc').keyup(function() {
                this.value = this.value.toUpperCase();
            });
        </script>
    @endsection
