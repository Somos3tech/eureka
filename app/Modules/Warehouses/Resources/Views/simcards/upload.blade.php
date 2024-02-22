@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @toastr_css
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>

    </div>

    <div class="separator-breadcrumb border-top"></div>

    <!-- Content-->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">

                    @if ($action == 'create')
                        {!! Form::open(['route' => 'simcards.store', 'method' => 'POST', 'files' => true]) !!}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="company_id" class="col-sm-12"><b>Almacén*</b></label>
                                {!! form::select('company_id', [], null, [
                                    'id' => 'company_id',
                                    'class' => 'form-control select2',
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-sm-3">
                                <label for="operator_id" class="col-sm-12"><b>Operador Móvil*</b></label>
                                {!! form::select('operator_id', ['' => 'Seleccione Operador...'], null, [
                                    'id' => 'operator_id',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-sm-2">
                                <label for="apn_id" class="col-sm-12"><b>APN</b></label>
                                {!! form::select('apn_id', ['' => 'Seleccione APN..'], null, [
                                    'id' => 'apn_id',
                                    'class' => 'form-control select2',
                                ]) !!}
                            </div>

                            <div class="col-sm-4">
                                <label class="col-sm-12"><b>Simcard</b></label>
                                {!! Form::hidden('statusc', 'Disponible', [
                                    'id' => 'statusc',
                                    'type' => 'form-control',
                                    'required' => 'required',
                                ]) !!}
                                <input name="file_simcard" type="file" class="filestyle"
                                    data-buttonname="btn btn-md btn-secondary">
                                <p>Los formatos soportados:<b>xls, xlsx</b> Tamaño Max: <b>5MB</b></p>
                            </div>
                        </div>
                    @endif

                    @if ($action == 'assign')
                        {!! Form::open(['route' => 'simcards.assign.store', 'method' => 'POST', 'files' => true]) !!}
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-2">
                                <center>
                                    <label class="col-sm-12"><b>Cambiar</b></label>
                                    <label class="col-sm-12"><input type="checkbox" id="valid_zone" name="valid_zone"
                                            class="checkbox" onclick="checkzone();"></label>
                                </center>
                            </div>
                            <div class="col-sm-2">
                                <label for="company_id" class="col-sm-12"><b>Almacén*</b></label>
                                {!! form::select('company_id', [], null, [
                                    'id' => 'company_id',
                                    'class' => 'form-control select2',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                            <div class="col-sm-2">
                                <center>
                                    <label class="col-sm-12"><b>Cambiar</b></label>
                                    <label class="col-sm-12"><input type="checkbox" id="valid" name="valid"
                                            class="checkbox" onclick="checkinput();"></label>
                                </center>
                            </div>

                            <div class="col-sm-2">
                                <label for="operator_id" class="col-sm-12"><b>Operador*</b></label>
                                {!! form::select('operator_id', ['' => 'Seleccione Operador...'], null, [
                                    'id' => 'operator_id',
                                    'class' => 'form-control',
                                    'parsley-type' => 'description',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                            <div class="col-sm-2">
                                <label for="apn_id" class="col-sm-12"><b>APN</b></label>
                                {!! form::select('apn_id', ['' => 'Seleccione APN..'], null, [
                                    'id' => 'apn_id',
                                    'class' => 'form-control select2',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                            <div class="col-sm-2">
                                <label for="statusc" class="col-sm-12"><b>Status*</b></label>
                                {!! form::select('statusc', ['Disponible' => 'Disponible', 'Inactivo' => 'Inactivo'], null, [
                                    'id' => 'statusc',
                                    'class' => 'form-control select2',
                                    'placeholder' => 'Seleccione Status...',
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-12"><b>Simcard</b></label>
                                <input name="file_simcard" type="file" class="filestyle"
                                    data-buttonname="btn btn-md btn-secondary">
                                <p>Los formatos soportados:<b>xls, xlsx</b> Tamaño Max: <b>5MB</b></p>
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-12 p-3">
                        <center>
                            <a href="{{ route('simcards.index') }}" title="Volver" class="btn btn-sm btn-warning"
                                style="color:white;">Volver</a>&nbsp;
                            <button type="submit" class="btn btn-sm btn-info">Cargar Simcard's</button>
                        </center>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
    </div>
    <!-- Content-->
@endsection

@section('page-js')
    @toastr_js
    @toastr_render
    <script type="text/javascript">
        flatpickr(".datepicker", {
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
        /**************************************************************************/
        $(document).ready(function() {
            $.get('/operators/select', function(data) {
                $('#operator_id').empty();
                $('#operator_id').append("<option value=''>Seleccione Operador...</option>");
                $.each(data, function(index, subOperatorObj) {
                    $('#operator_id').append("<option value='" + subOperatorObj.id + "'>" +
                        subOperatorObj.description + "</option>");
                });
                $("#operator_id option[value=" + {{ old('operator_id') }} + "]").attr("selected", true);
            });
            $.get('/companies/select/zone-valid?slug=store', function(data) {
                $('#company_id').empty();
                $('#company_id').append("<option value=''>Seleccione Almacén Venta...</option>");
                $.each(data, function(index, subCompanyObj) {
                    $('#company_id').append("<option value='" + subCompanyObj.id + "'>" +
                        subCompanyObj.description + "</option>");
                });
                $("#company_id option[value=" + {{ old('company_id') }} + "]").attr("selected", true);
            });
        });
        /**************************************************************************/
        $('#operator_id').on('change', function(e) {
            var operator_id = document.getElementById("operator_id").value;
            $.get('/apn/select?operator_id=' + operator_id, function(data) {
                $('#apn_id').empty();
                $('#apn_id').append("<option value=''>Seleccione APN...</option>");
                $.each(data, function(index, subApnObj) {
                    $('#apn_id').append("<option value='" + subApnObj.id + "'>" + subApnObj
                        .description + "</option>");
                });
                $("#apn_id option[value=" + {{ old('apn_id') }} + "]").attr("selected", true);
            });
        });
        /**************************************************************************/
        function checkinput() {
            $.get('/operators/select', function(data) {
                $('#operator_id').empty();
                $('#operator_id').append("<option value=''>Seleccione Operador...</option>");
                $.each(data, function(index, subOperatorObj) {
                    $('#operator_id').append("<option value='" + subOperatorObj.id + "'>" + subOperatorObj
                        .description + "</option>");
                });
            });

            $.get('/apn/select?operator_id=' + operator_id, function(data) {
                $('#apn_id').empty();
                $('#apn_id').append("<option value=''>Seleccione APN...</option>");
                $.each(data, function(index, subApnObj) {
                    $('#apn_id').append("<option value='" + subApnObj.id + "'>" + subApnObj.description +
                        "</option>");
                });
            });

            if ($('#valid')[0].checked == true) {
                $('#operator_id').removeAttr('disabled');
                $('#operator_id').attr('required', true);
                $('#apn_id').removeAttr('disabled');
            } else {
                $('#operator_id').attr('disabled', 'disabled');
                $('#operator_id').removeAttr('required');
                $('#apn_id').attr('disabled', 'disabled');
            }
        }
        /**************************************************************************/
        function checkzone() {
            $.get('/companies/select/zone-valid?slug=store', function(data) {
                $('#company_id').empty();
                $('#company_id').append("<option value=''>Seleccione Almacén Venta...</option>");
                $.each(data, function(index, subCompanyObj) {
                    $('#company_id').append("<option value='" + subCompanyObj.id + "'>" + subCompanyObj
                        .description + "</option>");
                });
                $("#company_id option[value=" + {{ old('company_id') }} + "]").attr("selected", true);
            });
            if ($('#valid_zone')[0].checked == true) {
                $('#company_id').removeAttr('disabled');
                $('#company_id').attr('required', true);
            } else {
                $('#company_id').attr('disabled', 'disabled');
                $('#company_id').removeAttr('required');
            }
        }
    </script>
@endsection
