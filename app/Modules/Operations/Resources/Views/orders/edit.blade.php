@extends('layouts.compact-master')

@section('page-css')
    <link href="/assets/css/select2.min.css" rel="stylesheet" />

    <style>
        .btn {
            border: none;
        }

        .outlinenone {
            outline: none;
            background-color: #dfe;
            border: 0;
        }
    </style>
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
                    {!! Form::model($data, ['method' => 'PUT', 'route' => ['orders.update', $data->id]]) !!}

                    {{ csrf_field() }}
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="customer" class="col-sm-12 col-form-label"><b>Código</b></label>
                                {!! form::text('customer_id', null, [
                                    'id' => 'customer_id',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'Código Cliente',
                                    'readonly' => 'readonly',
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-sm-2">
                                <label for="customer_id" class="col-sm-12 col-form-label"><b>No. Afiliación</b></label>
                                {!! form::hidden('type_service', null, ['id' => 'type_service', 'class' => 'form-control']) !!}
                                {!! form::hidden('contract_id', null, ['id' => 'contract_id', 'class' => 'form-control']) !!}
                                {!! form::hidden('dcustomer_id', null, ['id' => 'dcustomer_id', 'class' => 'form-control']) !!}
                                {!! form::hidden('company_id', null, ['id' => 'company_id']) !!}
                                {!! form::hidden('journey_id', null, ['id' => 'journey_id']) !!}
                                {!! form::text('affiliate_number', null, [
                                    'id' => 'affiliate_number',
                                    'class' => 'form-control outlinenone',
                                    'placeholder' => 'Ingrese No. Afiliado',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-2">
                                <label for="rif" class="col-sm-12 col-form-label"><b>RIF</b></label>
                                {!! form::text('rif', null, [
                                    'id' => 'rif',
                                    'class' => 'form-control outlinenone',
                                    'minlength' => 5,
                                    'maxlength' => 12,
                                    'placeholder' => 'Ingrese RIF',
                                    'readonly' => 'readonly',
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-sm-6">
                                <label for="business_name" class="col-sm-12 col-form-label"><b>Nombre Comercial</b></label>
                                {!! form::text('business_name', null, [
                                    'id' => 'business_name',
                                    'class' => 'form-control outlinenone blank',
                                    'placeholder' => 'Ingrese Nombre COmercio',
                                    'readonly' => 'readonly',
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-sm-3">
                                <label for="company" class="col-sm-12 col-form-label"><b>Almacén Venta</b></label>
                                {!! form::text('company', null, [
                                    'id' => 'company',
                                    'class' => 'form-control outlinenone',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-3">
                                <label for="bank" class="col-sm-12 col-form-label"><b>Banco</b></label>
                                {!! form::text('bank', null, ['id' => 'bank', 'class' => 'form-control outlinenone', 'readonly' => 'readonly']) !!}
                            </div>

                            <div class="col-sm-6">
                                <label for="address" class="col-sm-12 col-form-label"><b>Dirección</b></label>
                                {!! form::text('address', null, [
                                    'id' => 'address',
                                    'class' => 'form-control outlinenone',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-12">
                                <hr>
                            </div>

                            <div class="col-sm-2">
                                <label for="modelterminal" class="col-sm-12 col-form-label"><b>Modelo*</b></label>
                                {!! form::hidden('mterminal_id', null, ['id' => 'mterminal_id', 'class' => 'form-control']) !!}
                                {!! form::text('modelterminal', null, [
                                    'id' => 'modelterminal',
                                    'class' => 'form-control select',
                                    'required' => 'required',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-3">
                                <label for="terminal_id" class="col-sm-12 col-form-label admin">Serial Equipo*</b></label>
                                {!! form::select('terminal_id', ['' => 'Seleccione Serial Equipo...'], null, [
                                    'id' => 'terminal_id',
                                    'class' => 'form-control terminal_id select2',
                                ]) !!}
                            </div>

                            <div class="col-sm-2 gestion2" style="display:none">
                                <label for="nropos" class="col-sm-12 col-form-label admin">No. Terminal*</b></label>

                                <input id="nropos" name="nropos" type="text" class="form-control numbert blank zero"
                                    placeholder="Ingrese No. Punto de Venta" disabled="disabled" required />
                            </div>

                            <div class="col-sm-2 gestion2" style="display:none">
                                <label for="operator" class="col-sm-12 col-form-label"><b>Operador*</b></label>
                                {!! form::hidden('operator_id', null, ['id' => 'operator_id', 'class' => 'form-control']) !!}
                                {!! form::text('operator', null, [
                                    'id' => 'operator',
                                    'class' => 'form-control operator',
                                    'required' => 'required',
                                    'readonly' => 'readonly',
                                ]) !!}
                            </div>

                            <div class="col-sm-3 gestion2" style="display:none">
                                <label for="simcard_id" class="col-sm-12 col-form-label admin ">Serial Simcard*</b></label>
                                {!! form::select('simcard_id', ['' => 'Seleccione Serial Simcard...'], null, [
                                    'id' => 'simcard_id',
                                    'class' => 'form-control simcard_id select2',
                                    'disabled' => 'disabled',
                                    'data-live-search' => true,
                                ]) !!}
                            </div>

                            <div class="col-sm-6">
                                <label for="observ_credicard" class="col-sm-12 col-form-label"><b>Observación
                                        Inicial*</b></label>
                                {!! form::textarea('observ_credicard', null, [
                                    'id' => 'observ_credicard',
                                    'class' => 'form-control blank',
                                    'placeholder' => 'Ingrese Descripción',
                                    'rows' => 2,
                                    'required' => 'required',
                                ]) !!}
                            </div>

                            <div class="col-sm-6 gestion2" style="display:none">
                                <label for="observ_programmer" class="col-sm-12 col-form-label"><b>Observación
                                        Final*</b></label>
                                {!! form::textarea('observ_programmer', null, [
                                    'id' => 'observ_programmer',
                                    'class' => 'form-control blank',
                                    'placeholder' => 'Ingrese Descripción',
                                    'rows' => 2,
                                    'required' => 'required',
                                    'disabled' => 'disabled',
                                ]) !!}
                            </div>

                        </div>
                    </div>
                    <br />
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <center><a href="javascript:window.history.back();" title="Volver"
                                    class="btn btn-sm btn-warning" style="color:white;">
                                    <i class="fa fa-rotate-left"></i>Volver</a>&nbsp;<button type="submit"
                                    class="btn btn-sm btn-info">Asignar</button></center>
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
    <script src="/assets/js/select2.min.js"></script>
    {{-- Alcides Da Silva - Select2 - Autofill para Simcard y Terminal --}}
    <script type="text/javascript">
        $('.simcard_id, .terminal_id').select2()

        $(document).ready(function() {
            /*************************************************************************/
            var verif = <?php if ($data['terminal_id'] == null) {
                echo 0;
            } else {
                echo 1;
            } ?>;
            if (verif != 0) {
                $(".gestion2").attr("style", "display:block");
                $('#terminal_id').attr('disabled', 'disabled');
                $('#terminal_id').removeAttr('required');

                $('#nropos').removeAttr('disabled');
                $('#nropos').attr('required', true);

                $('#observ_credicard').attr('disabled', 'disabled');
                $('#observ_programmer').removeAttr('disabled');

                $('#observ_credicard').removeAttr('required');
                $('#observ_programmer').attr('required', true);

                var valid_simcard = <?php if ($data['is_simcard'] == 0 || $data['is_simcard'] == null) {
                    echo 1;
                } else {
                    echo 0;
                } ?>;
                if (valid_simcard != 0) {
                    $('.operator').attr('disabled', 'disabled');
                    $('.simcard_id').attr('disabled', 'disabled');

                    $('.operator').removeAttr('required');
                    $('.simcard_id').removeAttr('required');

                    $("#type_service").val('OutSimcard');
                } else {
                    $('.operator').removeAttr('disabled');
                    $('.operator').attr('required', true);

                    $('.simcard_id').removeAttr('disabled');
                    $('.simcard_id').attr('required', true);

                    $("#type_service").val('Simcard');
                }

                var opc = 'update';
            } else {
                $(".gestion2").attr("style", "display:none");
                $('#nropos').attr('disabled', 'disabled');
                $('#operator').attr('disabled', 'disabled');
                $('#terminal_id').removeAttr('disabled');
                $('#simcard_id').attr('disabled', 'disabled');
                $('#observ_credicard').removeAttr('disabled');
                $('#observ_programmer').attr('disabled', 'disabled');

                $('#nropos').removeAttr('required');
                $('#operator').removeAttr('required');
                $('#terminal_id').attr('required', true);
                $('#simcard_id').removeAttr('required');
                $('#observ_credicard').attr('required', true);
                $('#observ_programmer').removeAttr('required');
                $("#type_service").val('Terminal');
                var opc = '';
            }
            $.get('/assignments/select/assigned-programmer?mterminal_id=' + document.getElementById("mterminal_id")
                .value + '&company_id=' + document.getElementById("company_id").value + '&device=T&opc=' + opc,
                function(data) {
                    $('#terminal_id').empty();
                    $('#terminal_id').append("<option value=''>Seleccione Serial Equipo...</option>");
                    $.each(data, function(index, subTerminalObj) {
                        $('#terminal_id').append("<option value='" + subTerminalObj.id + "'>" +
                            subTerminalObj.description + "</option>");
                        if (opc == 'update') {
                            $("#terminal_id option[value=" + {{ $data->terminal_id }} + "]").attr(
                                "selected", true);
                        }
                    });
                });

            $.get('/assignments/select/assigned-programmer?operator_id=' + document.getElementById("operator_id")
                .value + '&company_id=' + document.getElementById("company_id").value + '&device=S',
                function(data) {
                    $('#simcard_id').empty();
                    $('#simcard_id').append("<option value=''>Seleccione Serial Simcard...</option>");
                    $.each(data, function(index, subSimcardObj) {
                        $('#simcard_id').append("<option value='" + subSimcardObj.id + "'>" +
                            subSimcardObj.description + "</option>");
                    });
                });
        });
    </script>
@endsection
