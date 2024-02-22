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
                    {!! Form::open(['route' => 'collections.store.masive', 'method' => 'POST', 'files' => true]) !!}
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="bank_id" class="col-sm-12"><b>Banco*</b></label>
                            {!! form::select('bank_id', [], null, [
                                'id' => 'bank_id',
                                'class' => 'form-control select2',
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-4">
                            <label class="col-sm-12"><b>Cargar Documento</b></label>
                            <input id="file" name="file" type="file" class="btn-dark" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <center>
                            <a href="javascript:history.back(-1);" title="Volver" class="btn btn-sm btn-warning"
                                style="color:white;"><i class="fa fa-rotate-left"></i> Volver</a>&nbsp;
                            <button type="submit" class="btn btn-sm btn-dark"><a onchange="modalProcess()"> Cargar
                                    Resultados</a></button>
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
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>

    @toastr_js
    @toastr_render

    <script type="text/javascript">
        $(document).ready(function() {
            flatpickr(".datepicker", {
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
        $.get('/banks/select', function(data) {
            $('#bank_id').empty();
            $('#bank_id').append("<option value=''>Seleccione Banco...</option>");
            $.each(data, function(index, subBankObj) {
                $('#bank_id').append("<option value='" + subBankObj.id + "'>" + subBankObj.description +
                    "</option>");
            });
        });
        /**************************************************************************/
        $('.money').mask('000,000,000,000,000.00', {
            reverse: true
        });
        /**************************************************************************/
        function modalProcess() {
            swal({
                icon: "info",
                title: 'Procesando Conciliación x Servicios, espere por favor',
                allowEscapeKey: false,
                allowOutsideClick: false,
                onOpen: () => {
                    swal.showLoading();
                }
            })
        }
    </script>
@endsection
