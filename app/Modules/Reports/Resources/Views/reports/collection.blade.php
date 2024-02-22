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
                    {!! Form::open(['route' => 'reports.collection.export', 'method' => 'GET']) !!}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-3">
                            <label><b>Almacén</b></label>
                            {!! form::select('company_id', ['' => 'Seleccione Almacén...'], null, [
                                'id' => 'company_id',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="col-sm-4">
                            <label><b>Fecha Rango</b></label>
                            <div class="input-group">
                                <input type="text" id="date_range" name="date_range" class="form-control daterange"
                                    placeholder="yyyy-mm-dd | yyyy-mm-dd" readonly />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <hr>
                        </div>
                        <div class="col-sm-12">
                            <center><button type="submit" class="btn btn-sm btn-info"><i class="dripicons-search"></i>
                                    Generar Reporte</button></center>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script type="text/javascript">
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
        $.get('/companies/select/zone-valid?wholesaler=0', function(data) {
            $('#company_id').empty();
            $('#company_id').append("<option value=''>Seleccione Almacén...</option>");
            $.each(data, function(index, subCompanyObj) {
                $('#company_id').append("<option value='" + subCompanyObj.id + "'>" + subCompanyObj
                    .description + "</option>");
            });
        });
    </script>
@endsection
