@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
        'id' => 'customer-create',
        'name' => 'customer-create',
        'route' => 'customers.store',
        'method' => 'POST',
        'files' => true,
    ]) !!}
    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-4 offset-4">
            <div class="card mb-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            {!! Form::text('find', null, [
                                'id' => 'find',
                                'class' => 'form-control text-center mayusc rif',
                                'placeholder' => 'Ingrese RIF',
                            ]) !!}
                        </div>
                        <div class="col-sm-4">
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
                            <label class="col-sm-12 col-form-label"><b>RIF<small>*</small></b></label>
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
                            <label class="col-sm-12 col-form-label"><b>Almacén Venta<small>*</small></b></label>
                            {!! Form::select('company_id', ['' => 'Seleccione Almacén...'], null, [
                                'id' => 'company_id',
                                'class' => 'form-control',
                                'value' => old('company_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-5 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Razón Social<small>*</small></b></label>
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
                            <label class="col-sm-12 col-form-label"><b>Actividad Comercial<small>*</small></b></label>
                            <label for="cactivity_id">

                                {!! Form::select('cactivity_id', ['Seleccione Actividad Comercial...'], null, [
                                    'id' => 'cactivity_id',
                                    'class' => 'form-control cactivity_id',
                                    'required' => 'required',
                                ]) !!}
                            </label>
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Código Profit</b></label>
                            {!! Form::text('foreign_id', null, [
                                'id' => 'foreign_id',
                                'class' => 'form-control number',
                                'value' => old('foreign_id'),
                                'minlength' => 1,
                                'maxlength' => 7,
                                'placeholder' => 'Digite Código Profit',
                            ]) !!}
                        </div>

                        <div class="col-sm-4 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Email<small>*</small></b></label>
                            {!! Form::email('email', null, [
                                'id' => 'email',
                                'class' => 'email form-control minusc blank',
                                'value' => old('email'),
                                'placeholder' => 'usuario@dominio.com',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Movíl<small>*</small></b></label>
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
                            <label class="col-sm-12 col-form-label"><b>Movíl 2<small>*</small></b></label>
                            {!! Form::text('telephone', null, [
                                'id' => 'telephone',
                                'class' => 'form-control phone',
                                'value' => old('telephone'),
                                'minlength' => 12,
                                'maxlength' => 12,
                                'placeholder' => 'Digite Nro. Móvil',
                                'maxlength' => 12,
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
                        <div class="col-sm-12 customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title"><b>Dirección Residencia</b></h5>
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Estado<small>*</small></b></label>
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
                            <label class="col-sm-12 col-form-label"><b>Municipalidad<small>*</small></b></label>
                            {!! Form::text('municipality', null, [
                                'id' => 'municipality',
                                'class' => 'form-control letter',
                                'value' => old('municipality'),
                                'placeholder' => 'Ingrese Municipalidad',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Dir.Residencia<small>*</small></b></label>
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
                            <label class="col-sm-12 col-form-label"><b>Postal<small>*</small></b></label>
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
                            <label class="col-sm-12 col-form-label"><b>Estado<small>*</small></b></label>
                            {!! Form::select('state_fiscal_id', ['' => 'Seleccione Estado...'], null, [
                                'id' => 'state_fiscal_id',
                                'class' => 'form-control addressfiscal',
                                'value' => old('state_fiscal_id'),
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-2   fiscal" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Ciudad<small>*</small></b></label>
                            {!! Form::select('city_fiscal_id', ['' => 'Seleccione Ciudad...'], null, [
                                'id' => 'city_fiscal_id',
                                'class' => 'form-control addressfiscal',
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
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 row">
                            <div class="col-sm-12 customer" style="display:none;">
                                <h5 class="header-title customer"><b>Información Mercantil</b></h5>
                            </div>

                            <div class="col-sm-2 customer" style="display:none;">
                                <label class="col-sm-12 col-form-label"><b>Contribuyente<small>*</small></b></label>
                                {!! Form::select('type_cont', ['1' => 'Ordinario', '2' => 'Especial'], null, [
                                    'id' => 'type_cont',
                                    'class' => 'form-control select2',
                                    'value' => old('type_cont'),
                                    'placeholder' => 'Seleccione Contribuyente....',
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 customer" style="display:none;">
                                <label class="col-sm-12 col-form-label"><b>% Ret.</b></label>
                                {!! Form::select('tax', ['75' => '75%', '100' => '100%'], null, [
                                    'id' => 'tax',
                                    'class' => 'form-control',
                                    'value' => old('tax'),
                                    'placeholder' => 'Seleccione % Retención IVA',
                                    'disabled' => true,
                                ]) !!}
                            </div>

                            <div class="col-sm-3 form-group mb-3">
                                <label for="date_register" class="col-sm-12 col-form-label">Fecha Registro*</label>
                                <div class="input-group">
                                    <input id="date_register" name="date_register" type="text" class="form-control"
                                        placeholder="yyyy-mm-dd" data-toggle="datepicker"
                                        value="{{ old('date_register') }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="i i-Calendar"></i></span>
                                    </div>
                                </div><!-- input-group -->
                            </div>
                            <div class="col-sm-5 form-group mb-3">
                                <label class="col-sm-12 col-form-label">Registro Mercantíl*</label>
                                {!! Form::text('comercial_register', null, [
                                    'id' => 'comercial_register',
                                    'class' => 'form-control mayusc',
                                    'placeholder' => 'Ingrese Registro Mercantil',
                                    'maxlength' => '191',
                                    'value' => old('comercial_register'),
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-sm-3 form-group mb-3">
                                <label class="col-sm-12 col-form-label">Ciudad Registro*</label>
                                {!! Form::text('city_register', null, [
                                    'id' => 'city_register',
                                    'class' => 'form-control mayusc',
                                    'placeholder' => 'Ingrese Ciudad Registro Mercantíl',
                                    'maxlength' => '191',
                                    'value' => old('city_register'),
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-sm-3 form-group mb-3">
                                <label class="col-sm-12 col-form-label">No. Reg. Mercantíl*</label>
                                {!! Form::text('number_register', null, [
                                    'id' => 'number_register',
                                    'class' => 'form-control mayusc',
                                    'placeholder' => 'Ingrese No. Registro Mercantíl',
                                    'minlength' => 2,
                                    'value' => old('number_register'),
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-sm-3  form-group mb-3">
                                <label class="col-sm-12 col-form-label">Tomo*</label>
                                {!! Form::text('took_register', null, [
                                    'id' => 'took_register',
                                    'class' => 'form-control mayusc',
                                    'placeholder' => 'Ingrese Tomo Registro Mercantíl',
                                    'minlength' => 2,
                                    'value' => old('took_register'),
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-sm-3 form-group mb-3">
                                <label class="col-sm-12 col-form-label">Cláusula Delegatoria</label>
                                {!! Form::text('clause_register', null, [
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
@endsection

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/dropzone.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    <script src="/assets/js/select2.min.js"></script>
    @include('preafiliations::preafiliations.js')

    @toastr_js
    @toastr_render

    <script type="text/javascript">
        $('.cactivity_id').select2();
        flatpickr("#date_register", {
            minDate: '2001-01-01',
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
            },
        });
        $(document).ready(function() {
            fiscal();
        });
        /**************************************************************************/
        $('.find').on('click', function() {
            formaRif(document.getElementById("find").value);
            var find = document.getElementById("find").value;
            if (find != '') {
                $.get('/customers/find?valid_preafiliation=&data_customer=' + find, function(data) {
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
        $('#company_id').change(function(e) {
            $('#total-available').empty();
            var modelterminal = document.getElementById("modelterminal_id").value;
            var company = e.target.value;
            available(modelterminal, company, false)
        });
        /**************************************************************************/
        $('#type_cont').on('change', function(e) {
            fiscal();
        });
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
    </script>
@endsection
