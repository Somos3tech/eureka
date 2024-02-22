@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
    @toastr_css
    <style>
        .error {
            background-color: #FDCDCD;
        }

        .outlinenone {
            outline: none;
            background-color: #ffffff;
            border: none;
        }
    </style>
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    {!! Form::open([
        'id' => 'form-create',
        'name' => 'form-create',
        'route' => 'atcs.store',
        'method' => 'POST',
        'files' => true,
    ]) !!}
    {{ csrf_field() }}
    <div class="row ">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mt-0 m-b-20 header-title customer"><b>Información Cliente</b></h5>
                        </div>
                        <div class="col-sm-6">
                            <label for="user_name" class="col-sm-12 col-form-label"><b>Usuario</b></label>
                            {!! Form::hidden('type_atc', 'internal', ['id' => 'type_atc']) !!}
                            {!! form::text('first_name', null, [
                                'id' => 'first_name',
                                'class' => 'form-control',
                                'value' => old('first_name'),
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-6">
                            <label for="rif" class="col-sm-12 col-form-label"><b>Contacto</b></label>
                            {!! form::text('email', null, [
                                'id' => 'email',
                                'class' => 'form-control',
                                'value' => old('email'),
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mt-0 m-b-20 header-title"><b>Información SAC</b></h5>
                        </div>

                        <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label"><b>Canal<small>*</small></b></label>
                            {!! Form::select('channel_id', ['' => 'Seleccione Tipo Canal ATC...'], null, [
                                'id' => 'channel_id',
                                'class' => 'form-control',
                                'value' => old('managementtype_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label"><b>Tipo Gestión<small>*</small></b></label>
                            {!! Form::select('managementtype_id', ['internal' => 'Gestión ATC - Canal Interno'], null, [
                                'id' => 'managementtype_id',
                                'class' => 'form-control',
                                'value' => old('managementtype_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label"><b>Item Tipo Gestión<small>*</small></b></label>
                            {!! Form::select('mtypeitem_id', ['' => 'Seleccione Item Tipo Gestión ATC...'], null, [
                                'id' => 'mtypeitem_id',
                                'class' => 'form-control mtypeitem_id',
                                'value' => old('mtypeitem_id'),
                            ]) !!}
                        </div>

                        <div class="col-sm-12">
                            <label class="col-sm-12 col-form-label"><b>Observaciones<small>*</small></b></label>
                            {!! form::textarea('observation', null, [
                                'id' => 'observation',
                                'class' => 'form-control blank',
                                'value' => old('observation'),
                                'placeholder' =>
                                    'Ingrese sus observaciones si existe una prioridad con la gestión del punto de venta en caso contrario puede dejar en blanco',
                                'rows' => 2,
                                'maxlength' => 191,
                                'required' => 'required',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12 mb-4">
                    <br>
                    <center><button id="submit" type="submit" class="btn btn-info" data-toggle="tooltip"
                            data-placement="top" title="Registrar Preafiliación">Registrar</button></center>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('page-js')
    <script src="/assets/js/select2.min.js"></script>
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>

    @toastr_js
    @toastr_render

    <script type="text/javascript">
        /****************************************************************************/
        $("#first_name").val("{{ Auth::user()->name . ' ' . Auth::user()->last_name }}");
        $("#email").val("{{ Auth::user()->email }}");
        /**************************************************************************/
        $.get('/channels/select', function(data) {
            $('#channel_id').empty();
            $('#channel_id').append("<option value=''>Seleccione Canal ATC...</option>");
            $.each(data, function(index, subChannelObj) {
                $('#channel_id').append("<option value='" + subChannelObj.id + "'>" + subChannelObj
                    .description + "</option>");
            });
            $("#channel_id option[value=" + {{ old('channel_id') }} + "]").attr("selected", true);
        });
        /**************************************************************************/
        $.get('/managementtypes/select?slug=internal', function(data) {
            $('#managementtype_id').empty();
            $('#managementtype_id').append("<option value=''>Seleccione Tipo Operación ATC...</option>");
            $.each(data, function(index, subManagementtypeObj) {
                $('#managementtype_id').append("<option value='" + subManagementtypeObj.id + "'>" +
                    subManagementtypeObj.description + "</option>");
            });
            $("#managementtype_id option[value=" + +"]").attr("selected", true);
        });
        /**************************************************************************/
        $.get('/mtypeitems/select?slug=internal', function(data) {
            $('.mtypeitem_id').empty();
            $('.mtypeitem_id').append("<option value=''>Seleccione Item Tipo Gestión ATC...</option>");
            $.each(data, function(index, subMtypeitemObj) {
                $('.mtypeitem_id').append("<option value='" + subMtypeitemObj.id + "'>" + subMtypeitemObj
                    .description + "</option>");
            });
            $(".mtypeitem_id option[value=" + {{ old('mtypeitem_id') }} + "]").attr("selected", true);
        });
        /**************************************************************************/
        $('#managementtype_id').change(function(e) {
            managementtype_id = e.target.value;
            $('.mtypeitem_id').empty();
            $('.mtypeitem_id').append("<option value=''>Seleccione Item Tipo Gestión ATC...</option>");
            if (managementtype_id != '') {
                $('.mtypeitem_id').removeAttr('readonly');
                $.get('/mtypeitems/select?managementtype_id=' + managementtype_id, function(data) {
                    $.each(data, function(index, subMtypeitemObj) {
                        $('.mtypeitem_id').append("<option value='" + subMtypeitemObj.id + "'>" +
                            subMtypeitemObj.description + "</option>");
                    });
                });
            } else {
                $('.mtypeitem_id').attr('readonly', 'readonly');
            }
        });
    </script>
@endsection
