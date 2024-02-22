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
                    {!! Form::open(['route' => 'collections.reportservice.export', 'method' => 'GET']) !!}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-3">
                            <label><b>Fecha Rango</b></label>
                            <div class="input-group">
                                <input type="text" id="date_range" name="date_range" class="form-control daterange"
                                    placeholder="yyyy-mm-dd | yyyy-mm-dd" readonly />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label>&nbsp;</label>
                            <center><button type="submit" class="btn btn-sm btn-info"><i class="dripicons-search"></i>
                                    Generar Reporte</button></center>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
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
                            'Sábado'],
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
    </script>
@endsection
