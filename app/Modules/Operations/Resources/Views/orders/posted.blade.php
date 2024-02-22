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
                    {!! Form::model($data, ['method' => 'PUT', 'route' => ['orders.manage.posted', (int) $data->id]]) !!}
                    {{ csrf_field() }}
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-2">
                                {!! form::hidden('id', null, ['id' => 'id']) !!}
                                <label><b>No. Afiliación <small>*</small></b></label>
                                {!! form::hidden('type_service', 'Posted', ['id' => 'type_service']) !!}
                                {!! form::text('affiliate_number', $data->affiliate_number, [
                                    'id' => 'affiliate_number',
                                    'class' => 'form-control',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-2">
                                <label for="rif"><b>RIF <small>*</small></b></label>
                                {!! form::text('rif', $data->rif, ['id' => 'rif', 'class' => 'form-control', 'readonly' => 'readonly']) !!}
                            </div>

                            <div class="col-sm-4">
                                <label for="business_name"><b>Razón Social <small>*</small></b></label>
                                {!! form::text('business_name', $data->business_name, [
                                    'id' => 'business_name',
                                    'class' => 'form-control',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-2">
                                <label for="state"><b>Estado <small>*</small></b></label>
                                {!! form::text('state', $data->state, ['id' => 'state', 'class' => 'form-control', 'readonly' => 'readonly']) !!}
                            </div>

                            <div class="col-sm-2">
                                <label for="city"><b>Ciudad <small>*</small></b></label>
                                {!! form::text('city', $data->city, ['id' => 'city', 'class' => 'form-control', 'readonly' => 'readonly']) !!}
                            </div>
                            <div class="col-sm-12"><br></div>
                            <div class="col-sm-5">
                                <label for="address"><b>Dirección Comercial <small>*</small></b></label>
                                {!! form::text('address', $data->address, [
                                    'id' => 'address',
                                    'class' => 'form-control',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>
                            <div class="col-sm-2">
                                <label for="postal_code"><b>Código Postal <small>*</small></b></label>
                                {!! form::text('postal_code', $data->postal_code, [
                                    'id' => 'postal_code',
                                    'class' => 'form-control',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-3">
                                <label for="email"><b>Email <small>*</small></b></label>
                                {!! form::text('email', $data->email, ['id' => 'email', 'class' => 'form-control', 'readonly' => 'readonly']) !!}
                            </div>

                            <div class="col-sm-2">
                                <label for="mobile"><b>Celular / Movíl <small>*</small></b></label>
                                {!! form::text('mobile', $data->mobile, ['id' => 'mobile', 'class' => 'form-control', 'readonly' => 'readonly']) !!}
                            </div>
                        </div>

                        <hr />

                        <h4 class="mt-0 m-b-30 header-title"><b>Detalles Punto de Venta</b></h4>
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="mterminal"><b>Modelo Terminal <small>*</small></b></label>
                                {!! form::text('mterminal', $data->modelterminal, [
                                    'id' => 'mterminal',
                                    'class' => 'form-control',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-3">
                                <label for="terminal"><b>Serial Equipo <small>*</small></b></label>
                                {!! form::text('serial_terminal', $data->terminal, [
                                    'id' => 'serial_terminal',
                                    'class' => 'form-control',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-2">
                                <label for="operator"><b>Operador <small>*</small></b></label>
                                {!! form::text('operator', $data->operator, [
                                    'id' => 'operator',
                                    'class' => 'form-control',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-3">
                                <label for="serial_sim"><b>Serial Simcard <small>*</small></b></label>
                                {!! form::text('serial_sim', $data->simcard, [
                                    'id' => 'serial_sim',
                                    'class' => 'form-control',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-2">
                                <label for="serial_sim"><b>No. Terminal<small>*</small></b></label>
                                {!! form::text('nropos', $data->nropos, ['id' => 'nropos', 'class' => 'form-control', 'readonly' => 'readonly']) !!}
                            </div>

                            <div class="col-sm-12"><br></div>
                            <div class="col-sm-3 gestion" style="display: none;">
                                <label for="date_send"><b>Fecha Envío <small>*</small></b></label>
                                <div class="input-group">
                                    <input name="date_send" type="text" class="form-control datepicker" value=""
                                        placeholder="yyyy-mm-dd" data-toggle="datepicker" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="i-Calendar"></i></span>
                                    </div>
                                </div><!-- input-group -->
                            </div>

                            <div class="col-sm-3">
                                <label for="type_posted"><b>Tipo Entrega<small>*</small></b></label>
                                {!! form::select('type_posted', ['Presencial' => 'Presencial', 'Courier' => 'Courier'], null, [
                                    'id' => 'type_posted',
                                    'class' => 'form-control',
                                    'value' => old('type_doc'),
                                    'placeholder' => 'Seleccione Tipo Entrega...',
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-sm-3">
                                <label for="date_send"><b>Fecha Entrega <small>*</small></b></label>
                                <div class="input-group">
                                    <input name="date" type="text" class="form-control datepicker" value=""
                                        placeholder="yyyy-mm-dd" data-toggle="datepicker" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="i-Calendar"></i></span>
                                    </div>
                                </div><!-- input-group -->
                            </div>

                            <div class="col-sm-3 gestion" style="display: none;">
                                <label for="number_control"><b>No. Control <small>*</small></b></label>
                                {!! form::text('number_control', null, [
                                    'id' => 'number_control',
                                    'class' => 'form-control',
                                    'placeholder' => 'No. Control',
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-sm-12"><br></div>
                            <div class="col-sm-12 gestion" style="display: none;">
                                <label for="observation"><b>Observaciones<small>*</small></b></label>
                                {!! form::textarea('observation', null, [
                                    'id' => 'observation',
                                    'class' => 'form-control blank',
                                    'value' => old('observations'),
                                    'placeholder' => 'Ingrese sus observaciones',
                                    'rows' => 2,
                                    'maxlength' => 191,
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <center><a href="javascript:window.history.back();" title="Volver" class="btn btn-sm btn-warning"
                                style="color:white;"><i class="fa fa-rotate-left"></i> Volver</a>&nbsp;<button
                                type="submit" class="btn btn-sm btn-info">Entregar Equipo</button></center>
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

            $('#type_posted').on('change', function(e) {
                var type_posted = e.target.value;
                if (type_posted == 'Presencial') {
                    $(".gestion").attr("style", "display:none");
                    $('#date_send').attr('disabled', 'disabled');
                    $('#date_send').removeAttr('required');
                    $('#number_control').attr('disabled', 'disabled');
                    $('#number_control').removeAttr('required');
                    $('#observation').attr('disabled', 'disabled');
                    $('#observation').removeAttr('required');
                } else
                if (type_posted == 'Courier') {
                    $(".gestion").attr("style", "display:block");
                    $('#observation').removeAttr('disabled');
                    $('#observation').attr('required', true);
                }
            });
        });
    </script>
@endsection
