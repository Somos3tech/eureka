@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
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
    {!! Form::model($data, [
        'id' => 'preafiliation',
        'name' => 'preafiliation',
        'route' => ['preafiliations.update', (int) $data[0]['id']],
        'method' => 'PUT',
        'files' => true,
    ]) !!}
    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mt-0 m-b-20 header-title customer"><b>Información Básica Cliente</b></h5>
                        </div>

                        <div class="col-sm-2">
                            <label class="col-sm-12 col-form-label"><b>RIF<small>*</small></b></label>
                            {!! Form::hidden('type_contract', 'basic', ['id' => 'type_contract']) !!}
                            {!! Form::text('rif', $data[0]['rif'], [
                                'id' => 'rif',
                                'class' => 'form-control mayusc',
                                'value' => old('rif'),
                                'placeholder' => 'Ingrese RIF',
                                'required' => 'required',
                                'readonly' => 'readonly',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2">
                            <label class="col-sm-12 col-form-label"><b>Almacén Venta<small>*</small></b></label>
                            {!! Form::select('company_id', ['' => 'Seleccione Almacén...'], null, [
                                'id' => 'company_id',
                                'class' => 'form-control',
                                'value' => old('company_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-5">
                            <label class="col-sm-12 col-form-label"><b>Razón Social<small>*</small></b></label>
                            {!! Form::text('business_name', $data[0]['business_name'], [
                                'id' => 'business_name',
                                'class' => 'form-control mayusc',
                                'value' => old('business_name'),
                                'placeholder' => 'Ingrese Razón Social',
                                'maxlength' => '191',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label"><b>Actividad Comercial<small>*</small></b></label>
                            <label for="cactivity_id">
                                {!! Form::select('cactivity_id', ['Seleccione Actividad Comercial...'], null, [
                                    'id' => 'cactivity_id',
                                    'class' => 'form-control cactivity_id',
                                    'required' => 'required',
                                ]) !!}
                            </label>
                        </div>

                        <div class="col-sm-4">
                            <label class="col-sm-12 col-form-label"><b>Email<small>*</small></b></label>
                            {!! Form::email('email', $data[0]['email'], [
                                'id' => 'email',
                                'class' => 'email form-control minusc blank',
                                'value' => old('email'),
                                'placeholder' => 'usuario
                                                                                                                            @dominio.com',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2">
                            <label class="col-sm-12 col-form-label"><b>Movíl<small>*</small></b></label>
                            {!! Form::text('mobile', $data[0]['mobile'], [
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

                        <div class="col-sm-2">
                            <label class="col-sm-12 col-form-label"><b>Movíl 2<small>*</small></b></label>
                            {!! Form::text('mobile2', $data[0]['mobile2'], [
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

                        <div class="col-sm-2s">
                            <label class="col-sm-12 col-form-label"><b>Teléfono</b></label>
                            {!! Form::text('telephone', $data[0]['telephone'], [
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
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mt-0 m-b-20 header-title"><b>Dirección Residencia</b></h5>
                        </div>

                        <div class="col-sm-2">
                            <label class="col-sm-12 col-form-label"><b>Estado<small>*</small></b></label>
                            {!! Form::select('state_id', ['' => 'Seleccione Estado...'], null, [
                                'id' => 'state_id',
                                'class' => 'form-control select2',
                                'value' => old('state_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2">
                            <label class="col-sm-12 col-form-label"><b>Ciudad*</b></label>
                            {!! Form::select('city_id', ['' => 'Seleccione Ciudad...'], null, [
                                'id' => 'city_id',
                                'class' => 'form-control select2',
                                'value' => old('city_id'),
                                'required' => 'required',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-2">
                            <label class="col-sm-12 col-form-label"><b>Municipalidad<small>*</small></b></label>
                            {!! Form::text('municipality', $data[0]['municipality'], [
                                'id' => 'municipality',
                                'class' => 'form-control letter',
                                'value' => old('municipality'),
                                'placeholder' => 'Ingrese Municipalidad',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2">
                            <label class="col-sm-12 col-form-label"><b>Dir.Residencia<small>*</small></b></label>
                            {!! Form::text('address', $data[0]['address'], [
                                'id' => 'address',
                                'class' => 'form-control mayusc',
                                'value' => old('address'),
                                'minlength' => 3,
                                'maxlength' => 191,
                                'placeholder' => 'Ingrese Dirección Comercial',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2">
                            <label class="col-sm-12 col-form-label"><b>Postal<small>*</small></b></label>
                            {!! Form::text('postal_code', $data[0]['postal_code'], [
                                'id' => 'postal_code',
                                'class' => 'form-control postal',
                                'value' => old('postal_code'),
                                'placeholder' => 'Digite Codigo Postal',
                                'minlength' => 4,
                                'maxlength' => 4,
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2">
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
                            <label class="col-sm-12 col-form-label"><b>Estado<small>*</small></b></label>
                            {!! Form::select('state_fiscal_id', ['' => 'Seleccione Estado...'], null, [
                                'id' => 'state_fiscal_id',
                                'class' => 'form-control addressfiscal state_fiscal_id',
                                'value' => old('state_fiscal_id'),
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-2   fiscal" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Ciudad<small>*</small></b></label>
                            {!! Form::select('city_fiscal_id', ['' => 'Seleccione Ciudad...'], null, [
                                'id' => 'city_fiscal_id',
                                'class' => 'form-control city_fiscal_id',
                                'value' => old('city_fiscal_id'),
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-2   fiscal" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Municipalidad<small>*</small></b></label>
                            {!! Form::text('municipality_fiscal', null, [
                                'id' => 'municipality_fiscal',
                                'class' => 'form-control addressfiscal letter',
                                'value' => old('municipality_fiscal'),
                                'placeholder' => 'Ingrese Municipalidad',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-4   fiscal" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Dirección Fiscal<small>*</small></b></label>
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
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 row">
                            <div class="col-sm-12">
                                <h5 class="header-title customer"><b>Información Mercantil</b></h5>
                            </div>
                            <div class="col-sm-7">
                                <label class="col-sm-12 col-form-label"><b>Tipo Contribuy.<small>*</small></b></label>
                                {!! Form::select('type_cont', ['1' => 'Ordinario', '2' => 'Especial'], $data[0]['type_cont'], [
                                    'id' => 'type_cont',
                                    'class' => 'form-control',
                                    'value' => old('type_cont'),
                                    'placeholder' => 'Seleccione Contribuyente....',
                                ]) !!}
                            </div>
                            <div class="col-sm-5">
                                <label class="col-sm-12 col-form-label"><b>% Ret.</b></label>
                                {!! Form::select('tax', ['75' => '75%', '100' => '100%'], $data[0]['tax'], [
                                    'id' => 'tax',
                                    'class' => 'form-control',
                                    'value' => old('tax'),
                                    'placeholder' => 'Seleccione % Retención IVA',
                                    'disabled' => true,
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-sm-8 row">
                            <div class="col-sm-12">
                                <h5 class="header-title customer"><b>Información Banco</b></h5>
                            </div>
                            <div class="col-sm-3">
                                <label class="col-sm-12 col-form-label"><b>Banco<small>*</small></b></label>
                                {!! Form::select('bank_id', ['' => 'Seleccione Banco...'], null, [
                                    'id' => 'bank_id',
                                    'class' => 'form-control',
                                    'value' => old('bank_id'),
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-sm-2">
                                <label class="col-sm-12 col-form-label"><b>ID<small>*</small></b></label>
                                {!! Form::text('bank_code', $data[0]['bank_code'], [
                                    'id' => 'bank_code',
                                    'class' => 'form-control',
                                    'value' => old('bank_code'),
                                    'placeholder' => 'ID Bancario',
                                    'required' => 'required',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>
                            <div class="col-sm-4">
                                <label class="col-sm-12 col-form-label"><b>No. Cuenta<small>*</small></b></label>
                                {!! Form::text('account_bank', $data[0]['account_bank'], [
                                    'id' => 'account_bank',
                                    'class' => 'form-control account_bank account',
                                    'value' => old('account_bank'),
                                    'placeholder' => 'No. Cuenta',
                                    'required' => 'required',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>
                            <div class="col-sm-3">
                                <label class="col-sm-12 col-form-label"><b>Afiliación<small>*</small></b></label>
                                {!! Form::text('affiliate_number', null, [
                                    'id' => 'affiliate_number',
                                    'class' => 'form-control mayusc affiliate_number',
                                    'value' => old('affiliate_number'),
                                    'placeholder' => 'No. Afiliación',
                                    'required' => 'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 row">
                            <div class="col-sm-12 customer" style="display:none;">
                                <h5 class="header-title customer"><b>Información Mercantil</b></h5>
                            </div>

                            <div class="col-sm-3">
                                <label for="date_register" class="col-sm-12 col-form-label"><b>Fecha Registro*</b></label>
                                <div class="input-group">
                                    <input id="date_register" name="date_register" type="text" class="form-control"
                                        placeholder="yyyy-mm-dd" data-toggle="datepicker"
                                        value="{{ $data[0]['date_register'] }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div><!-- input-group -->
                            </div>
                            <div class="col-sm-9">
                                <label class="col-sm-12 col-form-label"><b>Registro Mercantíl*</b></label>
                                {!! Form::text('comercial_register', $data[0]['comercial_register'], [
                                    'id' => 'comercial_register',
                                    'class' => 'form-control mayusc',
                                    'placeholder' => 'Ingrese Registro Mercantil',
                                    'maxlength' => '191',
                                    'value' => old('comercial_register'),
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-sm-3">
                                <label class="col-sm-12 col-form-label"><b>Ciudad Registro*</b></label>
                                {!! Form::text('city_register', $data[0]['city_register'], [
                                    'id' => 'city_register',
                                    'class' => 'form-control mayusc',
                                    'placeholder' => 'Ingrese Ciudad Registro Mercantíl',
                                    'maxlength' => '191',
                                    'value' => old('city_register'),
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-sm-3">
                                <label class="col-sm-12 col-form-label"><b>No. Reg.*</b></label>
                                {!! Form::text('number_register', $data[0]['number_register'], [
                                    'id' => 'number_register',
                                    'class' => 'form-control mayusc',
                                    'placeholder' => 'Ingrese No. Registro Mercantíl',
                                    'minlength' => 2,
                                    'value' => old('number_register'),
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-sm-3">
                                <label class="col-sm-12 col-form-label"><b>Tomo*</b></label>
                                {!! Form::text('took_register', $data[0]['took_register'], [
                                    'id' => 'took_register',
                                    'class' => 'form-control mayusc',
                                    'placeholder' => 'Ingrese Tomo Registro Mercantíl',
                                    'minlength' => 2,
                                    'value' => old('took_register'),
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-sm-3">
                                <label class="col-sm-12 col-form-label"><b>Cláusula Delegatoria</b></label>
                                {!! Form::text('clause_register', $data[0]['clause_register'], [
                                    'id' => 'clause_register',
                                    'class' => 'form-control mayusc',
                                    'placeholder' => 'Cláusula Delegatoria....',
                                    'minlength' => 2,
                                    'value' => old('clause_register'),
                                ]) !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12  ">
                            <h5 class="mt-0 m-b-20 header-title"><b>Información General Contrato</b></h5>
                        </div>

                        <div class="col-sm-3  ">
                            <label class="col-sm-12 col-form-label"><b>Modelo Equipo<small>*</small></b></label>
                            {!! Form::select('modelterminal_id', ['' => 'Seleccione Modelo Equipo...'], null, [
                                'id' => 'modelterminal_id',
                                'class' => 'form-control available terminalvalue modelterminal',
                                'value' => old('modelterminal_id'),
                                'required' => 'required',
                            ]) !!}
                            <div id="total-available"></div>
                        </div>

                        <div class="col-sm-3  ">
                            <label class="col-sm-12 col-form-label"><b>Operador</b></label>
                            {!! Form::select('operator_id', ['' => 'Seleccione Operador...'], null, [
                                'id' => 'operator_id',
                                'class' => 'form-control',
                                'value' => old('operator_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-4  ">
                            <label class="col-sm-12 col-form-label"><b>Planes VEPAGOS<small>*</small></b></label>
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

    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="header-title"><b>Observaciones</b></h5>
                        </div>

                        <div class="col-sm-12">
                            {!! form::textarea('observation_initial', $data[0]['observation_initial'], [
                                'id' => 'observation_initial',
                                'class' => 'form-control',
                                'value' => old('observation_initial'),
                                'rows' => 2,
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-sm-12">
                                <h5 class="mt-0 m-b-20 header-title"><b>Información de Pago</b></h5>
                            </div>

                            <div class="col-sm-2  ">
                                <label for="currency_id"
                                    class="col-sm-12 col-form-label"><b>Divisa<small>*</small></b></label>
                                {!! form::hidden('currency', null, ['id' => 'currency']) !!}
                                {!! form::select('currency_id', ['' => 'Seleccione Divisa...'], null, [
                                    'id' => 'currency_id',
                                    'class' => 'form-control terminalvalue',
                                    'value' => old('currency_id'),
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 amountu_display" style="display: none;">
                                <label class="col-sm-12 col-form-label"><b>Tarifa Cambio<small>*</small></b></label>
                                {!! form::text('dicom', $data[0]['dicom'], [
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
                                <label class="col-sm-12 col-form-label"><b>Valor Equipo<small>*</small></b></label>
                                {!! form::text('amount', $data[0]['amount'], [
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
                                <label class="col-sm-12 col-form-label"><b>Valor Equipo<small>*</small></b></label>
                                {!! form::select('amountm', [], null, [
                                    'id' => 'amountm',
                                    'value' => old('amountm'),
                                    'class' => 'form-control amountm',
                                ]) !!}
                                <div id="date_amountm" name="date_amountm"></div>
                            </div>

                            <div class="col-sm-2">
                                <label class="col-sm-12 col-form-label"><b>Forma Pago</b></label>
                                {!! Form::select('pmethod_id', ['' => 'Seleccione Forma de Pago...'], null, [
                                    'id' => 'pmethod_id',
                                    'class' => 'form-control',
                                    'value' => old('payment_id'),
                                ]) !!}
                            </div>

                            <div class="col-sm-4  ">
                                <label class="col-sm-12 col-form-label"><b>Referencia</b></label>
                                {!! Form::text('refere', $data[0]['refere'], [
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
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12 mb-4">
                        <center><br><button id="submit" type="submit" class="btn btn-info" data-toggle="tooltip"
                                data-placement="top" title="Actualizar Preafiliación">Actualizar</button></center>
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

        @include('preafiliations::preafiliations.js-edit')

        @toastr_js
        @toastr_render

        <script type="text/javascript">
            document.getElementById("affiliate_number").value = "{{ $data[0]['affiliate_number'] }}";
            /************************************************************************/

            /************************************************************************/

            $(document).ready(function() {
                $('.cactivity_id').select2();
                flatpickr("#date_register", {
                    locale: {
                        firstDayOfWeek: 1,
                        weekdays: {
                            shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                            longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes',
                                'Sábado'
                            ],
                        },
                        months: {
                            shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct',
                                'Nov', 'Dic'
                            ],
                            longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                                'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                            ],
                        },
                    },
                });
                /**************************************************************************/
                if ({{ isset($data[0]['amount']) }}) {
                    $(".amountu_display").css('display', 'block');
                    $(".amountm_display").css('display', 'none');

                    $('.amountu').removeAttr('disabled');
                    $('.amountu').attr('required', true);

                    $('.amountm').attr('disabled', 'disabled');
                    $('.amountm').removeAttr('required');
                }
                /**************************************************************************/
                $("#type_cont option[value=" + {{ $data[0]['type_cont'] }} + "]").attr("selected", true);
                if ({{ $data[0]['type_cont'] }} > 1) {
                    $('#tax').removeAttr('disabled');
                    $('#tax').attr('required', true);
                    $("#tax option[value=" + {{ $data[0]['tax'] }} + "]").attr("selected", true);
                } else {
                    $('#tax').attr('disabled', 'disabled');
                    $('#tax').removeAttr('required');
                }
                if ("{{ $data[0]['state_fiscal_id'] }}" != "") {
                    $('#checkbox')[0].checked = false;
                    $(".fiscal").css('display', 'block');
                    $('.addressfiscal').removeAttr('disabled');
                    $('.addressfiscal').attr('required', true);

                    $.get('/states/select', function(data) {
                        $('#state_fiscal_id').empty();
                        $('#state_fiscal_id').append("<option value=''>Seleccione Estado...</option>");

                        $.each(data, function(index, substateObj) {
                            $('#state_fiscal_id').append("<option value='" + substateObj.id + "'>" +
                                substateObj.description + "</option>");
                        });
                        $("#state_fiscal_id option[value=" + {{ $data[0]['state_fiscal_id'] }} + "]").attr(
                            "selected", true);

                        $.get('/cities/select?state={{ $data[0]['state_fiscal_id'] }}', function(data) {
                            if (data.length == '') {
                                document.getElementById("city_fiscal_id").disabled = true;
                            } else {
                                document.getElementById("city_fiscal_id").disabled = false;
                                $('#city_fiscal_id').empty();
                                $('#city_fiscal_id').append(
                                    "<option value=''>Seleccione Ciudad...</option>");

                                $.each(data, function(index, subciudObj) {
                                    $('#city_fiscal_id').append("<option value='" + subciudObj
                                        .id + "'>" + subciudObj.description + "</option>");
                                });
                                $("#city_fiscal_id option[value=" +
                                    {{ $data[0]['city_fiscal_id'] }} + "]").attr("selected",
                                    true);
                            }
                        });
                    });

                    $("#city_fiscal_id option[value=" + {{ $data[0]['city_fiscal_id'] }} + "]").attr("selected",
                        true);
                    document.getElementById("municipality_fiscal").value = '{{ $data[0]['municipality_fiscal'] }}';
                    document.getElementById("address_fiscal").value = '{{ $data[0]['address_fiscal'] }}';
                    document.getElementById("postal_code_fiscal").value = '{{ $data[0]['postal_code_fiscal'] }}';
                } else {
                    $(".fiscal").css('display', 'none');
                    $('.addressfiscal').attr('disabled', 'disabled');
                    $('.addressfiscal').removeAttr('required');
                }
            });
            /****************************************************************************/
            $('.find').on('click', function() {
                formaRif(document.getElementById("find").value);
                var find = document.getElementById("find").value;
                if (find != '') {
                    $.get('/customers/find?data_customer=' + find, function(data) {
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
            /**************************************************************************/
            $('#bank_id').change(function(e) {
                var bank_id = e.target.value;
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
                available(modelterminal, company, false)
            });
            /**************************************************************************/
            $('.terminalvalue').change(function() {
                $('#date_dicom').empty();
                currency_id = document.getElementById("currency_id").value;
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

                $.get('/terminalvalues/get-amount?modelterminal_id=' + modelterminal_id + '&currency_id=' + currency_id,
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
                            $('#amountm').append("<option value=''>Seleccione Valor Terminal...</option>");

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
            /************************************************************************/
            $('.numberl').mask('AAAAAAAA', {
                'translation': {
                    A: {
                        pattern: /[0-9]/
                    }
                }
            });
            /************************************************************************/
            $('.numbermercant').mask('AAAAAAAAAAAAA', {
                'translation': {
                    A: {
                        pattern: /[0-9]/
                    }
                }
            });
        </script>
    @endsection
