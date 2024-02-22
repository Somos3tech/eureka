@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
                    {!! Form::open(['route' => 'reports.conciliation.export', 'method' => 'GET']) !!}
                    {{ csrf_field() }}
                    <div class="row">

                        <div class="col-sm-3">
                            <label><b>Fecha Rango</b></label>
                            <div>
                                <div class="input-group">
                                    <input type="text" id="date_range" name="date_range" class="form-control daterange"
                                        placeholder="yyyy-mm-dd | yyyy-mm-dd" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <label><b>Banco</b></label>
                            {!! Form::select('bank_id', ['' => 'Seleccione Banco...'], null, ['id' => 'bank_id', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-3">
                            <label><b>Asesor Venta</b></label>
                            {!! form::select('user_id', ['' => 'Seleccione Asesor Venta...'], null, [
                                'id' => 'user_id',
                                'class' => 'form-control',
                                'value' => old('user_id'),
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label><b>Aliado Comercial</b></label>
                            {!! form::select('consultant_id', ['' => 'Seleccione Aliado Comercial'], null, [
                                'id' => 'consultant_id',
                                'class' => 'form-control',
                                'value' => old('consultant_id'),
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label><b>Almacén Venta</b></label>
                            {!! form::select('company_id', ['' => 'Seleccione Almacén Venta...'], null, [
                                'id' => 'company_id',
                                'class' => 'form-control company',
                                'value' => old('company_id'),
                            ]) !!}
                        </div>

                        <div class="col-sm-2">
                            <label><b>Status</b></label>
                            {!! form::select(
                                'statusc',
                                [
                                    '' => 'Seleccione Status...',
                                    'Activo' => 'Activo',
                                    'Pendiente' => 'Pendiente',
                                    'Soporte' => 'Soporte',
                                    'Suspendido' => 'Suspendido',
                                    'Cancelado' => 'Cancelado',
                                    'Anulado' => 'Anulado',
                                ],
                                null,
                                ['id' => 'statusc', 'class' => 'form-control', 'value' => old('statusc')],
                            ) !!}
                        </div>
                    </div>
                    <hr />
                    <div class="form-group row">
                        <div class="col-sm-12 p-3">
                            <center><button type="submit" class="btn btn-sm btn-info">Generar Reporte</button></center>
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
    <script type="text/javascript">
        flatpickr(".daterange", {
            mode: "range",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                instance.element.value = dateStr.replace('to', '|');
            },
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
        /******************************************************************************/
        $('#btnDel').attr('disabled', 'disabled');
        $('#btnAdd').click(function() {
            var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
            var newNum = new Number(num + 1); // the numeric ID of the new input field being added

            // create the new element via clone(), and manipulate it's ID using newNum value
            var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);

            // manipulate the name/id values of the input inside the new element
            // Añadir caja de texto.

            newElem.children(':last').attr('id', 'item' + newNum).attr('name', 'item' + newNum);

            // insert the new element after the last "duplicatable" input field
            $('#input' + num).after(newElem);


            // enable the "remove" button
            $('#btnDel').attr('disabled', false);

            // business rule: you can only add 10 names
            if (newNum == 20)
                $('#btnAdd').attr('disabled', 'disabled');
        });
        $('#btnDel').click(function() {
            var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
            $('#input' + num).remove(); // remove the last element

            // enable the "add" button
            $('#btnAdd').attr('disabled', false);

            // if only one element remains, disable the "remove" button
            if (num - 1 == 1)
                $('#btnDel').attr('disabled', 'disabled');
        });
        /******************************************************************************/

        /******************************************************************************/

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

                var company = document.getElementById("company_id").value;
                $.get('/users/select?slug=' + slug + '&company_id=' + company + '&user_id=' + user_id,
                    function(data) {
                        $('#user_id').empty();
                        $('#user_id').append("<option value=''>Seleccione Asesor Venta...</option>");
                        $.each(data, function(index, subUserObj) {
                            $('#user_id').append("<option value='" + subUserObj.id + "'>" +
                                subUserObj.description + "</option>");
                            if (data.length == 1) {
                                $("#user_id option[value=" + subUserObj.id + "]").attr(
                                    "selected", true);
                            }
                        });
                    });
            });
        });
        /****************************************************************************/
        $('#company_id').on('change', function(e) {
            $.get('/roles/getrole', function(data) {
                var user_id = data.user_id;
                var slug = data.slug;
                var company = document.getElementById("company_id").value;
                $.get('/users/select?slug=' + slug + '&company_id=' + company + '&user_id=' + user_id,
                    function(data) {
                        $('#user_id').empty();
                        $('#user_id').append("<option value=''>Seleccione Usuario Venta...</option>");
                        /****************************************************************************/
                        $.each(data, function(index, subUserObj) {
                            $('#user_id').append("<option value='" + subUserObj.id + "'>" +
                                subUserObj.description + "</option>");
                        });
                    });
            });
        });
        /******************************************************************************/
        $('#user_id').change(function(e) {
            var user = e.target.value;
            $.get('/consultants/select?user_id=' + user, function(data) {
                $('#consultant_id').empty();
                $('#consultant_id').append("<option value=''>Seleccione Asesor Externo...</option>");
                $.each(data, function(index, subConsultantObj) {
                    $('#consultant_id').append("<option value='" + subConsultantObj.id + "'>" +
                        subConsultantObj.description + "</option>");
                });
            });
        });

        /****************************************************************************/
        $.get('/banks/select', function(data) {
            $('#bank_id').empty();
            $('#bank_id').append("<option value=''>Seleccione Banco...</option>");

            $.each(data, function(index, subBankObj) {
                $('#bank_id').append("<option value='" + subBankObj.id + "'>" + subBankObj.description +
                    "</option>");
            });
        });

        $.get('/banks/select', function(data) {
            $('#bank_id_Tow').empty();
            $('#bank_id_Tow').append("<option value=''>Seleccione Banco...</option>");

            $.each(data, function(index, subBankObj) {
                $('#bank_id_Tow').append("<option value='" + subBankObj.id + "'>" + subBankObj.description +
                    "</option>");
            });
        });
    </script>
@endsection
