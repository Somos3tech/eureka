@extends('layouts.compact-master')

@section('page-css')
    <link href="/assets/css/select2.min.css" rel="stylesheet" />
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
                    {!! Form::open(['route' => 'assignments.store', 'method' => 'POST']) !!}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="form-group">
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="company_id" class="col-sm-12">Almacén Asignar Equipo*</label>
                                            {!! form::hidden('device', 'T', ['id' => 'device']) !!}
                                            {!! form::select('company_id', ['' => 'Seleccione Almacén...'], null, [
                                                'id' => 'company_id',
                                                'class' => 'form-control assignated select2 search',
                                                'required' => 'required',
                                            ]) !!}
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="user_assignated" class="col-sm-12">Programador*</label>
                                            {!! form::select('user_assignated', ['' => 'Seleccione Programador...'], null, [
                                                'id' => 'user_assignated',
                                                'class' => 'form-control assignated select2',
                                                'required' => 'required',
                                            ]) !!}
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="mterminal_id" class="col-sm-12">Modelo Equipo*</label>
                                            {!! form::select('mterminal_id', ['' => 'Seleccione Modelo Equipo...'], null, [
                                                'id' => 'mterminal_id',
                                                'class' => 'form-control search select2',
                                                'required' => 'required',
                                            ]) !!}
                                        </div>
                                        <div class="col-sm-4">&nbsp;</div>
                                        <div id="asignado" class="col-sm-12"></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-5">
                                            <select name="origen[]" id="origen" class="form-control origen"
                                                multiple="multiple" size="8"></select>
                                        </div>

                                        <div class="col-sm-2">
                                            <center>
                                                <input type="button" class="pasar izq btn btn-sm btn-dark count"
                                                    value="Pasar »"><input type="button"
                                                    class="quitar der btn btn-sm btn-dark count" value="« Quitar"><br />
                                                <input type="button" class="quitartodos der btn btn-sm btn-warning count"
                                                    value="« Todos" style="color:white;">
                                            </center>
                                        </div>

                                        <div class="col-sm-5">
                                            <select name="destino[]" id="destino" class="form-control select multiple"
                                                multiple="multiple" size="8" required></select>
                                            <div class="pull-right" id="count"></div>
                                        </div>

                                        <div class="col-sm-12">
                                            <label for="name" class="col-sm-12 col-form-label">Observaciones</label>
                                            {!! form::textarea('observations', null, [
                                                'id' => 'observations',
                                                'class' => 'form-control outlinenone blank',
                                                'rows' => '2',
                                                'placeholder' => 'Ingrese Observaciones',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <center><a href="javascript:window.history.back();" title="Volver"
                                        class="btn btn-sm btn-warning" style="color:white;"><i
                                            class="fa fa-rotate-left"></i> Volver</a>&nbsp;<button type="submit"
                                        class="btn btn-sm btn-info submit">Asignar</button></center>
                            </div>
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

    <script src="/assets/js/select2.min.js"></script>

    <script type="text/javascript">
        $().ready(function() {
            $('.origen').select2();
            $('.pasar').click(function() {
                $('#origen option:selected').remove().appendTo('#destino');
                $("#destino option").each(function() {
                    // Marcamos cada valor como seleccionado
                    $("#destino option[value=" + this.value + "]").prop("selected", true);
                });
                var count = $("#destino :selected").length;
                document.getElementById('count').innerHTML = '';
                $('#count').append("Total: <strong>" + count + "</strong>");
            });

            $('.quitar').click(function() {
                $('#destino option:selected').remove().appendTo('#origen');
                $("#origen option:selected").removeAttr("selected");
                $("#destino option").each(function() {
                    // Marcamos cada valor como seleccionado
                    $("#destino option[value=" + this.value + "]").prop("selected", true);
                });

                var count = $("#destino :selected").length;
                document.getElementById('count').innerHTML = '';
                $('#count').append("Total: <strong>" + count + "</strong>");
            });

            $('.quitartodos').click(function() {
                $('#destino option').each(function() {
                    $(this).remove().appendTo('#origen');
                    $("#origen option:selected").removeAttr("selected");
                    $("#destino option").each(function() {
                        // Marcamos cada valor como seleccionado
                        $("#destino option[value=" + this.value + "]").prop("selected",
                            true);
                    });
                });
            });

            $('.submit').click(function() {
                $('#destino option').prop('selected', 'selected');
            });
        });
        /**************************************************************************/
        $.get('/companies/select/zone-valid?slug=store', function(data) {
            $('#company_id').empty();
            if (data.length > 1) {
                $('#company_id').append("<option value=''>Seleccione Almacén...</option>");
            } else {
                $('#company_id').attr('readonly', 'readonly');
                $.each(data, function(index, subZoneObj) {
                    $.get('/users/select/assignment?company_id=' + subZoneObj.id, function(data) {
                        $('#user_assignated').empty();
                        $('#user_assignated').append(
                            "<option value=''>Seleccione Programador...</option>");
                        $.each(data, function(index, subUserObj) {
                            $('#user_assignated').append("<option value='" + subUserObj.id +
                                "'>" + subUserObj.description + "</option>");
                        });
                    });
                });
            }
            $.each(data, function(index, subCompanyObj) {
                document.getElementById("company_id").disabled = false;
                $('#company_id').append("<option value='" + subCompanyObj.id + "'>" + subCompanyObj
                    .description + "</option>");
            });
            $("#company_id option[value=" + {{ old('company_id') }} + "]").attr("selected", true);
        });
        /**************************************************************************/
        $('#company_id').on('change', function(e) {
            var company_id = e.target.value;
            $.get('/users/select/assignment?company_id=' + company_id, function(data) {
                $('#user_assignated').empty();
                $('#user_assignated').append("<option value=''>Seleccione Programador...</option>");
                $.each(data, function(index, subUserObj) {
                    $('#user_assignated').append("<option value='" + subUserObj.id + "'>" +
                        subUserObj.description + "</option>");
                });
            });
        });
        /**************************************************************************/
        $.get('/mterminals/select', function(data) {
            $('#mterminal_id').empty();
            $('#mterminal_id').append("<option value=''>Seleccione Modelo Equipo...</option>");
            $.each(data, function(index, subMterminalObj) {
                $('#mterminal_id').append("<option value='" + subMterminalObj.id + "'>" + subMterminalObj
                    .description + "</option>");
                $("#mterminal_id option[value=" + {{ old('mterminal_id') }} + "]").attr("selected", true);
            });
        });
        /***********************Cargar Terminales en Origen************************/
        $('.search').on('change', function(e) {
            $("#destino option").each(function() {
                // Marcamos cada valor como seleccionado
                $("#destino option[value=" + this.value + "]").prop("selected", true);
            });

            var company = document.getElementById("company_id").value;
            var mterminal = document.getElementById("mterminal_id").value;
            let selectElement = document.getElementById('destino');
            let destino = Array.from(selectElement.selectedOptions).map(option => option.value);

            $.get('/terminals/select/available?company_id=' + company + '&mterminal_id=' + mterminal + '&destino=' +
                destino,
                function(data) {
                    $('#origen').empty();
                    $.each(data, function(index, subterminalObj) {
                        $('#origen').append("<option value='" + subterminalObj.id + "'>" +
                            subterminalObj.description + "</option>");
                    });
                });
        });
        /**************************************************************************/
        $('.assignated').on('change', function(e) {
            var user_id = e.target.value;
            $.get('/assignments/select/assigned?count=Y&device=T&user_id=' + user_id, function(data) {
                $("#asignado").attr("style", "display:block");
                document.getElementById('asignado').innerHTML = '';
                $('#asignado').append("<p><strong>Puntos de Ventas Asignados:</strong></p>");
                $('#asignado').append("<strong>{Modelo Equipo, Cantidad}</strong> => ");
                $.each(data, function(index, subAssignObj) {
                    $('#asignado').append("<strong>{" + subAssignObj.modelterminal + " ," +
                        subAssignObj.count + "}</strong>");
                });
            });
        });
    </script>
@endsection
