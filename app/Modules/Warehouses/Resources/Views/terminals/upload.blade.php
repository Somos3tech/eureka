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
                        {!! Form::open(['route' => 'terminals.store', 'method' => 'POST', 'files' => true]) !!}
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-2">
                                <div class="col-sm-12">
                                    <label for="fechpro" class="col-sm-12"><b>Registro<small>*</small></b></label>
                                    <input id="fechpro" name="fechpro" type="text" class="form-control datepicker"
                                        value="{{ old('fechpro') }}" placeholder="yyyy-mm-dd" data-toggle="datepicker"
                                        required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <label for="company_id" class="col-sm-12"><b>Almacén*</b></label>
                                {!! form::select('company_id', [], null, [
                                    'id' => 'company_id',
                                    'class' => 'form-control select2',
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-sm-3">
                                <label for="mterm_id" class="col-sm-12"><b>Modelo Equipo*</b></label>
                                {!! form::select('mterm_id', ['' => 'Seleccione Modelo Equipo...'], null, [
                                    'id' => 'mterm_id',
                                    'class' => 'form-control select2',
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-sm-3">
                                <label class="col-sm-12"><b>Equipos</b></label>
                                {!! Form::hidden('statusc', 'Disponible', [
                                    'id' => 'statusc',
                                    'type' => 'form-control',
                                    'required' => 'required',
                                ]) !!}
                                <input name="file_terminal" type="file" class="filestyle">
                                <p>Formatos soportados:<b>xls, xlsx</b> Tamaño Max: <b>5MB</b></p>
                            </div>

                        </div>
                    @endif

                    @if ($action == 'assign')
                        {!! Form::open(['route' => 'terminals.assign.store', 'method' => 'POST', 'files' => true]) !!}
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
                                {!! form::hidden('type_action', $action, ['id' => 'type_action', 'class' => 'form-control']) !!}
                                {!! form::select('company_id', [], null, [
                                    'id' => 'company_id',
                                    'class' => 'form-control select2',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                            <div class="col-sm-2">
                                <center>
                                    <label class="col-sm-12"><b>Cambiar</b></label>
                                    <label class="col-sm-12"><input type="checkbox" id="valid_fechpro" name="valid_fechpro"
                                            class="checkbox" onclick="checkfechpro();"></label>
                                </center>
                            </div>

                            <div class="col-sm-2">
                                <label for="fechpro" class="col-sm-12"><b>Fecha Ingreso<small>*</small></b></label>
                                <input id="fechpro" name="fechpro" type="text" class="form-control datepicker"
                                    value="{{ old('fechpro') }}" placeholder="yyyy-mm-dd" data-toggle="datepicker"
                                    disabled="disabled">
                            </div>

                            <div class="col-sm-2">
                                <center>
                                    <label class="col-sm-12"<b>Cambiar</b></label>
                                    <label class="col-sm-12"><input type="checkbox" id="valid" name="valid"
                                            class="checkbox" onclick="checkinput();"></label>
                                </center>
                            </div>

                            <div class="col-sm-2">
                                <label for="mterm_id" class="col-sm-12"><b>Equipo<small>*</small></b></label>
                                {!! form::select('mterm_id', ['' => 'Seleccione Modelo Equipo...'], null, [
                                    'id' => 'mterm_id',
                                    'class' => 'form-control select2',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                            <div class="col-sm-2">
                                <center>
                                    <label class="col-sm-12"><b>Cambiar</b></label>
                                    <label class="col-sm-12"><input type="checkbox" id="valid_status" name="valid_status"
                                            class="checkbox" onclick="checkstatus();"></label>
                                </center>
                            </div>

                            <div class="col-sm-2">
                                <label for="statusc" class="col-sm-12"><b>Status*</b></label>
                                {!! form::select(
                                    'statusc',
                                    ['Disponible' => 'Disponible', 'Entregado' => 'Entregado', 'Desactivado' => 'Desactivado'],
                                    null,
                                    [
                                        'id' => 'statusc',
                                        'class' => 'form-control select2',
                                        'placeholder' => 'Seleccione Status...',
                                        'disabled' => 'disabled',
                                    ],
                                ) !!}
                            </div>

                            <div class="col-sm-8">
                                <label class="col-sm-12"><b>Equipos</b></label>
                                <input name="file_terminal" type="file" class="filestyle"
                                    data-buttonname="btn btn-md btn-dark">
                                <p>Formatos Soportados:<b>xls, xlsx</b> Tamaño Max: <b>5MB</b></p>
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-12 p-3">
                        <center>
                            <a href="{{ route('terminals.index') }}" title="Volver" class="btn btn-sm btn-warning"
                                style="color:white;">Volver</a>&nbsp;
                            <button type="submit" class="btn btn-sm btn-info"><i class="dripicons-upload"></i> Cargar
                                Equipos</button>
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
        $(document).ready(function() {
            flatpickr(".datepicker", {
                minDate: '2001-01-01',
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

            $.get('/mterminals/select', function(data) {
                $('#mterm_id').empty();
                $('#mterm_id').append("<option value=''>Seleccione Modelo Terminal...</option>");
                $.each(data, function(index, subMterminalObj) {
                    $('#mterm_id').append("<option value='" + subMterminalObj.id + "'>" +
                        subMterminalObj.description + "</option>");
                    $("#mterm_id option[value=" + {{ old('mterm_id') }} + "]").attr("selected",
                        true);
                });
            });

            //ajax
            $.get('/companies/select/zone-valid?slug=store', function(data) {
                $('#company_id').empty();
                $('#company_id').append("<option value=''>Seleccione Almacén Venta...</option>");
                $.each(data, function(index, subCompanyObj) {
                    $('#company_id').append("<option value='" + subCompanyObj.id + "'>" +
                        subCompanyObj.description + "</option>");
                });
                $("#company_id option[value=" + {{ old('company_id') }} + "]").attr("selected", true);
            });
            $('form').parsley();
        });

        /**************************************************************************/
        function checkinput() {
            $.get('/mterminals/select', function(data) {
                $('#mterm_id').empty();
                $('#mterm_id').append("<option value=''>Seleccione Modelo Terminal...</option>");
                $.each(data, function(index, subMterminalObj) {
                    $('#mterm_id').append("<option value='" + subMterminalObj.id + "'>" + subMterminalObj
                        .description + "</option>");
                    $("#mterm_id option[value=" + {{ old('mterm_id') }} + "]").attr("selected", true);
                });
            });
            if ($('#valid')[0].checked == true) {
                $('#mterm_id').removeAttr('disabled');
                $('#mterm_id').attr('required', true);
            } else {
                $('#mterm_id').attr('disabled', 'disabled');
                $('#mterm_id').removeAttr('required');
            }
        }
        /**************************************************************************/
        function checkfechpro() {
            if ($('#valid_fechpro')[0].checked == true) {
                $('#fechpro').removeAttr('disabled');
                $('#fechpro').attr('required', true);
            } else {
                $('#fechpro').attr('disabled', 'disabled');
                $('#fechpro').removeAttr('required');
            }
        }

        /**************************************************************************/
        function checkstatus() {
            if ($('#valid_status')[0].checked == true) {
                $('#statusc').removeAttr('disabled');
                $('#statusc').attr('required', true);
            } else {
                $('#statusc').attr('disabled', 'disabled');
                $('#statusc').removeAttr('required');
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
