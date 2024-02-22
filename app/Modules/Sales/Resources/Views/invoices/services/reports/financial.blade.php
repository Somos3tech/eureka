@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                    {!! Form::open(['route' => 'services.report.financial', 'method' => 'GET']) !!}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label"><b>Banco<small>*</small></b></label>
                            {!! Form::select('bank_id', ['' => 'Seleccione Banco...'], null, ['id' => 'bank_id', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label"><b>Modelo Equipo<small>*</small></b></label>
                            {!! Form::select('mterminal_id', ['' => 'Seleccione Modelo Equipo...'], null, ['id' => 'mterminal_id', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-2">
                            <label class="col-sm-12 col-form-label"><b>Plan VEPAGOS<small>*</small></b></label>
                            {!! Form::select('term_id', ['' => 'Seleccione Plan VEPAGOS...'], null, ['id' => 'term_id', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-sm-4">
                            <label class="col-sm-12 col-form-label"><b>Fecha Rango<small>*</small></b></label>
                            <div>
                                <div class="input-group">
                                    <input type="text" id="date_range" name="date_range" class="form-control daterange"
                                        placeholder="yyyy-mm-dd | yyyy-mm-dd" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" align="center">
                            <hr>
                        </div>
                        <div class="col-sm-12" align="center">
                            <label><b>Necesita más Campos?</b></label>
                            <center>
                                <button class="btn btn-sm btn-warning waves-effect waves-light" style="color:white;"
                                    type="button" id="btnAdd" value="+" /><b>+</b></button>
                                <button class="btn btn-sm btn-dark waves-effect waves-light" type="button" id="btnDel"
                                    value="-" /><b>-</b></button>
                            </center>
                        </div>
                        <div class="col-sm-12">
                            <br>
                            <div id="input1" class="col-sm-12 clonedInput">
                                <div class="row" id="item1">
                                    <div class="col-sm-4">
                                        <select id="field[]" name="field[]" class="form-control"
                                            placeholder="Seleccione Campo">
                                            <option selected="selected" value>Seleccionar Campo...</option>
                                            <option value="affiliate_number">No. Afiliación</option>
                                            <option value="customer_id">Código Cliente</option>
                                            <option value="serial">Serial Equipo</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select id="operator[]" name="operator[]" class="form-control">
                                            <option selected="selected" value>Seleccionar...</option>
                                            <option value="="> = </option>
                                            <option value="!="> != </option>
                                            <option value=">"> > </option>
                                            <option value="<">
                                                < </option>
                                            <option value=">="> >=
                                            </option>
                                            <option value="<=">
                                                <= </option>
                                            <option value="LIKE"> LIKE </option>
                                            <option value="NOT LIKE"> NOT LIKE </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="query[]" name="query[]"
                                            placeholder="Consulta" minlength="1" maxlength="30" />
                                    </div>
                                    <div class="col-sm-2">
                                        <select id="conditional[]" name="conditional[]" class="form-control">
                                            <option selected="selected" value>...</option>
                                            <option value="AND"> AND </option>
                                            <option value="OR"> OR </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>&nbsp;</label>
                            <center><button type="submit" class="btn btn-sm btn-info"><i class="dripicons-search"></i>
                                    Generar Reporte</button></center>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <!-- NEW REPORT -->
        <!--
                        <div class="col-md-12">
                          <div class="card mb-4">
                            <div class="card-body">
                              {!! Form::open(['route' => 'services.report.bankmovement', 'method' => 'GET']) !!}
                              {{ csrf_field() }}
                              <div class="row">

                                <div class="col-sm-4">
                                  <label class="col-sm-12 col-form-label"><b>Fecha<small>*</small></b></label>
                                  <div>
                                    <div class="input-group">
                                      <input type="date" data-date-format="YYYY DD MM" id="date_search" name="date_search" class="form-control date_search" placeholder="yyyy-mm-dd" />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-12" align="center">
                                  <hr>
                                </div>

                                <div class="col-sm-12">
                                <label>&nbsp;</label>
                                <center><button type="submit" class="btn btn-sm btn-info"><i class="dripicons-search"></i> Generar Reporte</button></center>
                              </div>
                              </div>
                              {!! Form::close() !!}
                            </div>
                          </div>
                        </div>
                    -->

    </div>
    <!-- Content-->
@endsection

@section('page-js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript">
        flatpickr(".date_search", {
            dateFormat: "Y-m-d",
            locale: {
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
        });
        /**************************************************************************/
        $.get('/companies/select/zone-valid?wholesaler=0', function(data) {
            $('#company_id').empty();
            $('#company_id').append("<option value=''>Seleccione Almacén...</option>");
            $.each(data, function(index, subCompanyObj) {
                $('#company_id').append("<option value='" + subCompanyObj.id + "'>" + subCompanyObj
                    .description + "</option>");
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

        /****************************************************************************/
        $.get('/terms/select', function(data) {
            $('#term_id').empty();
            $('#term_id').append("<option value=''>Seleccione Plan Vepagos......</option>");

            $.each(data, function(index, subTermObj) {
                $('#term_id').append("<option value='" + subTermObj.id + "'>" + subTermObj.description +
                    "</option>");
            });
        });

        /****************************************************************************/
        $.get('/mterminals/select?filter=active', function(data) {
            $('#mterminal_id').empty();
            $('#mterminal_id').append("<option value=''>Seleccione Modelo Equipo...</option>");

            $.each(data, function(index, subMterminalObj) {
                $('#mterminal_id').append("<option value='" + subMterminalObj.id + "'>" + subMterminalObj
                    .description + "</option>");
            });
        });
        /**************************************************************************/
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
    </script>
@endsection
