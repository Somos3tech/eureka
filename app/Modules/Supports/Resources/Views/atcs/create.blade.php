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
    <div class="row">
        <div class="col-sm-4 offset-4">
            <div class="card mb-8">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8  ">
                            {!! Form::text('find', null, [
                                'id' => 'find',
                                'class' => 'form-control text-center mayusc rif',
                                'placeholder' => 'Ingrese RIF',
                            ]) !!}
                        </div>

                        <div class="col-sm-4  ">
                            <button type="button" name="find" class="btn btn-sm btn-dark find">Consultar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title customer"><b>Información Cliente</b></h5>
                        </div>
                        <div class="col-sm-3 customerdetail" style="display:none;">
                            <label for="customer_id" class="col-sm-12 col-form-label"><b>Código</b></label>
                            {!! Form::hidden('type_atc', 'customer', ['id' => 'type_atc']) !!}
                            {!! form::text('customer_id', null, [
                                'id' => 'customer_id',
                                'class' => 'form-control customerinput blank',
                                'value' => old('customer_id'),
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 customerdetail newuser" style="display:none;">
                            <label for="rif" class="col-sm-12 col-form-label"><b>RIF</b></label>
                            {!! form::text('rif', null, [
                                'id' => 'rif',
                                'class' => 'form-control rif customerinput newinput',
                                'value' => old('rif'),
                                'placeholder' => 'Ingrese RIF',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-7 customerdetail" style="display:none;">
                            <label for="bussiness_name" class="col-sm-12 col-form-label"><b>Nombre Comercial</b></label>
                            {!! form::text('business_name', null, [
                                'id' => 'business_name',
                                'class' => 'form-control customerinput mayusc blank',
                                'value' => old('business_name'),
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 newuser" style="display:none;">
                            <label for="first_name" class="col-sm-12 col-form-label"><b>Nombres</b></label>
                            {!! form::text('first_name', null, [
                                'id' => 'first_name',
                                'class' => 'form-control mayusc newinput blank',
                                'value' => old('first_name'),
                                'placeholder' => 'Ingrese Nombres',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 newuser" style="display:none;">
                            <label for="last_name" class="col-sm-12 col-form-label"><b>Apellidos</b></label>
                            {!! form::text('last_name', null, [
                                'id' => 'last_name',
                                'class' => 'form-control mayusc newinput blank',
                                'value' => old('last_name'),
                                'placeholder' => 'Ingrese Apellidos',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 newuser customerdetail" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Movíl<small>*</small></b></label>
                            {!! Form::text('mobile', null, [
                                'id' => 'mobile',
                                'class' => 'form-control customerinput newinput phone',
                                'value' => old('mobile'),
                                'minlength' => 12,
                                'maxlength' => 12,
                                'placeholder' => 'Ingrese Teléfono',
                                'placeholder' => 'Digite Nro. Móvil',
                                'maxlength' => 12,
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 newuser customerdetail" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Movíl 2<small>*</small></b></label>
                            {!! Form::text('telephone', null, [
                                'id' => 'telephone',
                                'class' => 'form-control customerinput newinput phone',
                                'value' => old('telephone'),
                                'minlength' => 12,
                                'maxlength' => 12,
                                'placeholder' => 'Digite Nro. Móvil',
                                'placeholder' => 'Ingrese Móvil',
                                'maxlength' => 12,
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-4 newuser customerdetail" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Email<small>*</small></b></label>
                            {!! Form::email('email', null, [
                                'id' => 'email',
                                'class' => 'email form-control minusc customerinput newinput blank',
                                'value' => old('email'),
                                'placeholder' => 'usuario@dominio.com',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12  customer" style="display:none;">
                            <h5 class="mt-0 m-b-20 header-title"><b>Información SAC</b></h5>
                        </div>

                        <div class="col-sm-3 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Canal<small>*</small></b></label>
                            {!! Form::select('channel_id', ['' => 'Seleccione Tipo Canal ATC...'], null, [
                                'id' => 'channel_id',
                                'class' => 'form-control',
                                'value' => old('managementtype_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="col-sm-3 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Tipo Gestión<small>*</small></b></label>
                            {!! Form::select('managementtype_id', ['' => 'Seleccione Tipo Gestión ATC...'], null, [
                                'id' => 'managementtype_id',
                                'class' => 'form-control',
                                'value' => old('managementtype_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 contract" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Contratos Activos<small>*</small></b></label>
                            {!! Form::select('contract_id', ['' => 'Seleccione Contrato Activo..'], null, [
                                'id' => 'contract_id',
                                'class' => 'form-control contract_id',
                                'value' => old('contract_id'),
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>

                        <div class="col-sm-3 customer" style="display:none;">
                            <label class="col-sm-12 col-form-label"><b>Item Tipo Gestión<small>*</small></b></label>
                            {!! Form::select('mtypeitem_id', ['' => 'Seleccione Item Tipo Gestión ATC...'], null, [
                                'id' => 'mtypeitem_id',
                                'class' => 'form-control mtypeitem_id',
                                'value' => old('mtypeitem_id'),
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-12 customer" style="display:none;">
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
    <div class="row customer" style="display:none;">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12 mb-4 customer" style="display:none;">
                    <br>
                    <center><button id="submit" type="submit" class="btn btn-info" data-toggle="tooltip"
                            data-placement="top" title="Registrar Gestión ATC">Registrar</button></center>
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
        $('.find').on('click', function() {
            formaRif(document.getElementById("find").value);
            var find = document.getElementById("find").value;
            if (find != '') {
                $.get('/customers/find?data_customer=' + find, function(data) {
                    if (!data) {
                        $(".customerdetail").attr("style", "display:none");
                        $(".newuser").attr("style", "display:block");
                        $(".customer").attr("style", "display:block");

                        $("#customer_id").val('');
                        $("#contract_id").val('');
                        $("#rif").val(find);
                        $("#business_name").val('');
                        $("#first_name").val('');
                        $("#last_name").val('');
                        $("#mobile").val('');
                        $("#telephone").val('');
                        $("#email").val('');

                        $('.customerinput').attr('disabled', 'disabled');
                        $('.customerinput').removeAttr('required');

                        $('.newinput').removeAttr('disabled');
                        $('.newinput').attr('required', true);

                        $('.customerinput').removeAttr('readonly');

                        $('.rif').attr('readonly', true);
                    } else {
                        $(".newuser").attr("style", "display:none");
                        $(".customerdetail").attr("style", "display:block");
                        $(".customer").attr("style", "display:block");

                        $('.newinput').attr('disabled', 'disabled');
                        $('.newinput').removeAttr('required');

                        $('.customerinput').removeAttr('disabled');
                        $('.customerinput').attr('required', true);
                        $('.customerinput').attr('readonly', 'readonly');

                        $("#customer_id").val(data.id);
                        $("#rif").val(data.rif);
                        $("#business_name").val(data.business_name);
                        $("#mobile").val(data.mobile);
                        $("#telephone").val(data.telephone);
                        $("#email").val(data.email);

                        $.get('/managementtypes/select?slug=', function(data) {
                            $('#managementtype_id').empty();
                            $('#managementtype_id').append(
                                "<option value=''>Seleccione Tipo Gestión ATC...</option>");
                            $.each(data, function(index, subManagementtypeObj) {
                                $('#managementtype_id').append("<option value='" +
                                    subManagementtypeObj.id + "'>" +
                                    subManagementtypeObj.description + "</option>");
                            });
                            $("#managementtype_id option[value=" +
                                {{ old('managementtype_id') }} + "]").attr("selected", true);
                        });
                    }
                });
            } else {
                $(".customerdetails").attr("style", "display:block");
                $(".newuser").attr("style", "display:none");

                $('.customerinput').attr('disabled', 'disabled');
                $('.customerinput').removeAttr('required');

                $('.newinput').attr('disabled', 'disabled');
                $('.newinput').removeAttr('required');

                swal('', 'Por favor Ingresar RIF de Comercio', 'info');
            }
        });
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
        $.get('/managementtypes/select', function(data) {
            $('#managementtype_id').empty();
            $('#managementtype_id').append("<option value=''>Seleccione Tipo Operación ATC...</option>");
            $.each(data, function(index, subManagementtypeObj) {
                $('#managementtype_id').append("<option value='" + subManagementtypeObj.id + "'>" +
                    subManagementtypeObj.description + "</option>");
            });
            $("#managementtype_id option[value=" + {{ old('managementtype_id') }} + "]").attr("selected", true);
        });
        /**************************************************************************/
        <?php
      if(isset($_GET['managementtype_id']) && isset($_GET['mtypeitem_id'])){
    ?>
        $('.mtypeitem_id').removeAttr('readonly');
        $.get('/mtypeitems/select?managementtype_id=' + {{ old('managementtype_id') }}, function(data) {
            $('.mtypeitem_id').empty();
            $('.mtypeitem_id').append("<option value=''>Seleccione Item Tipo Gestión ATC...</option>");
            $.each(data, function(index, subMtypeitemObj) {
                $('.mtypeitem_id').append("<option value='" + subMtypeitemObj.id + "'>" + subMtypeitemObj
                    .description + "</option>");
            });
            $(".mtypeitem_id option[value=" + {{ old('mtypeitem_id') }} + "]").attr("selected", true);
        });
        <?php
    }
    ?>
        /**************************************************************************/
        $('#managementtype_id').change(function(e) {
            managementtype_id = e.target.value;

            $.get('/managementtypes/' + managementtype_id, function(data) {
                if (data.slug == 'supports' || data.slug == 'invoices') {
                    $.get('/contracts/select?customer_id=' + $("#customer_id").val(), function(data) {
                        $(".contract").attr("style", "display:block");
                        $('.contract_id').removeAttr('disabled');
                        $('.contract_id').attr('required', true);

                        $('.contract_id').empty();
                        $('.contract_id').append(
                            "<option value=''>Seleccione Contracto Activo...</option>");
                        $.each(data, function(index, subContractObj) {
                            $('.contract_id').append("<option value='" + subContractObj.id +
                                "'>" + subContractObj.description + "</option>");
                        });
                    });
                } else {
                    $(".contract").attr("style", "display:none");
                    $('.contract_id').removeAttr('required');
                    $('.contract_id').attr('disabled', 'disabled');
                }
            });
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
        /************************************************************************/
        function formaRif(rif) {
            if (rif) {
                var parts = rif.split("-");

                if (parts.length == 2) {
                    var index = parts[1].substr(-1);
                    parts[2] = index;
                    parts[1] = parts[1].slice(0, -1);
                    parts[1] = parts[1].padStart(8, '0');
                } else {
                    if (parts.length > 2) {
                        if (parts[2] == "") {
                            var index = parts[1].substr(-1);
                            parts[2] = index;
                            parts[1] = parts[1].slice(0, -1);
                            parts[1] = parts[1].padStart(8, '0');
                        }
                    }
                }
            }
            document.getElementById("find").value = parts.join("-");
        }
    </script>

    @include('supports::atcs.js')
@endsection
