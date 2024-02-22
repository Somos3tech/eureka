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
                    {!! Form::open(['route' => 'services.report.detail', 'method' => 'POST']) !!}
                    {{ csrf_field() }}
                    <div class="row">

                        <div class="col-sm-3">
                            <label><b>Banco</b></label>
                            {!! form::select('bank_id', ['' => 'Seleccione Banco...'], null, [
                                'id' => 'bank_id',
                                'class' => 'form-control',
                                'value' => old('bank_id'),
                            ]) !!}
                        </div>

                        <div class="col-sm-2">
                            <label><b>Status</b></label>
                            {!! form::select(
                                'statusc',
                                [
                                    '' => 'Seleccione Status...',
                                    'G' => 'Generado',
                                    // 'P' => 'Pendiente',
                                    'E' => 'Exonerado',
                                    'C' => 'Conciliado',
                                    'N' => 'Negociación',
                                    // 'R' => 'Rezagado',
                                ],
                                null,
                                ['id' => 'statusc', 'class' => 'form-control', 'value' => old('statusc')],
                            ) !!}
                        </div>

                        <div class="col-sm-3">
                            <label><b>Fecha Rango</b></label>
                            <div>
                                <div class="input-group">
                                    <input type="text" id="date_range" name="date_range" class="form-control daterange"
                                        placeholder="yyyy-mm-dd | yyyy-mm-dd" readonly />
                                </div>
                            </div>
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
        $.get('/banks/select', function(data) {
            $('#bank_id').empty();
            $('#bank_id').append("<option value=''>Seleccione Banco...</option>");
            $.each(data, function(index, subBankObj) {
                $('#bank_id').append("<option value='" + subBankObj.id + "'>" + subBankObj.description +
                    "</option>");
            });
        });
    </script>
@endsection
