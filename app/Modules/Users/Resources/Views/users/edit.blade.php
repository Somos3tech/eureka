@extends('layouts.compact-master')

@section('page-css')
    <style>
        .error {
            background-color: #FDCDCD;
        }
    </style>
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>

    </div>

    <div class="separator-breadcrumb border-top"></div>

    <!-- Content-->
    {!! Form::model($data, ['id' => 'form-edit', 'route' => ['users.update', $data->id], 'method' => 'PUT']) !!}
    {{ csrf_field() }}

    <div class="form-group row">
        <div class="col-sm-2 p-1">
            <label for="doc" class="col-sm-12 col-form-label"><b>No. Documento*</b></label>
            {!! Form::text('doc', $data->document, [
                'id' => 'doc',
                'class' => 'form-control rif',
                'placeholder' => 'Ingrese Documento',
                'minlength' => 5,
                'maxlength' => 14,
                'required' => 'required',
            ]) !!}
        </div>

        <div class="col-sm-2 p-1">
            <label for="name" class="col-sm-12 col-form-label"><b>Nombres*</b></label>
            {!! Form::text('name', null, [
                'id' => 'name',
                'class' => 'form-control blank',
                'placeholder' => 'Ingrese Nombres',
                'maxlength' => '191',
                'required' => 'required',
            ]) !!}
        </div>

        <div class="col-sm-2 p-1">
            <label for="last_name" class="col-sm-12 col-form-label"><b>Apellidos*</b></label>
            {!! Form::text('last_name', null, [
                'id' => 'last_name',
                'class' => 'form-control blank',
                'placeholder' => 'Ingrese Apellidos',
                'maxlength' => '191',
                'required' => 'required',
            ]) !!}
        </div>

        <div class="col-sm-4 p-1">
            <label for="email" class="col-sm-12 col-form-label"><b>Email*</b></label>
            {!! Form::email('email', null, [
                'id' => 'email',
                'class' => 'form-control email blank',
                'placeholder' => 'usuario@dominio.com',
                'required' => 'required',
            ]) !!}
        </div>

        <div class="col-sm-2 p-1">
            <label for="password" class="col-sm-12 col-form-label"><b>Contraseña*</b></label>
            <input id="password" name="password" type="password" class="form-control" placeholder="Ingrese Contraseña"
                maxlength="20">
        </div>

        <div class="col-sm-4 p-1">
            <label for="jobtitle" class="col-sm-12 col-form-label"><b>Cargo*</b></label>
            {!! Form::text('jobtitle', null, [
                'id' => 'jobtitle',
                'class' => 'form-control blank',
                'placeholder' => 'Ingrese Cargo',
                'maxlength' => '191',
                'required' => 'required',
            ]) !!}
        </div>

        <div class="col-sm-2 p-1">
            <label for="role" class="col-sm-12 col-form-label"><b>Perfíl*</b></label>
            {!! Form::select('role', [], null, ['id' => 'role', 'class' => 'form-control', 'required' => 'required']) !!}
        </div>

        <div class="col-sm-2 p-1 company" style="display:none;">
            <label for="company_id" class="col-sm-12 col-form-label"><b>Compañia*</b></label>
            {!! Form::select('company_id', [], null, [
                'id' => 'company_id',
                'class' => 'form-control select2',
                'disabled' => 'disabled',
            ]) !!}
        </div>

        <div class="col-sm-2 p-1 bank" style="display:none;">
            <label for="banklist" class="col-sm-12 col-form-label"><b>Banco(s)</b></label>
            {!! Form::select('banklist[]', [''], null, [
                'id' => 'banklist',
                'class' => 'select2 form-control select2-multiple',
                'multiple' => 'multiple',
                'disabled' => 'disabled',
            ]) !!}
        </div>

        <div class="col-sm-2 p-1">
            <label for="statusc" class="col-sm-12 col-form-label"><b>Status*</b></label>
            {!! Form::select('statusc', ['Activo' => 'Activo', 'Inactivo' => 'Inactivo'], null, [
                'id' => 'statusc',
                'placeholder' => 'Seleccione Status...',
                'class' => 'form-control',
                'required' => 'required',
            ]) !!}
        </div>
    </div><!-- form group row -->

    <div class="text-center">
        <a href="{{ route('users.index') }}" title="Volver" class="btn btn-sm btn-dark"><i class="fa fa-rotate-left"></i>
            Volver</a>&nbsp;
        <button type="submit" class="btn btn-sm btn-info">Registrar</button>
    </div>

    {!! Form::close() !!}
    <!-- Content-->
@endsection

@section('page-js')
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.js">
    </script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            /************************************************************************/
            var slug = 'programmer';
            $.get('/roles/valid-role?role={{ $data->role }}&slug=' + slug, function(data) {
                if (data) {
                    document.getElementById("banklist").disabled = false;
                    $('#banklist').attr('required', true);
                    $(".bank").attr("style", "display:block");
                } else {
                    document.getElementById("banklist").disabled = true;
                    $('#banklist').removeAttr('required');
                    $(".bank").attr("style", "display:none");
                }
            });
            /************************************************************************/
            @if ($data->company_id != null)
                $(".company").attr("style", "display:block");
                $('#company_id').attr('required', true);
                $('#company_id').removeAttr('disabled');
            @else
                $(".company").attr("style", "display:none");
                $("#company_id").attr("disabled", "disabled");
                $('#company_id').removeAttr('required');
            @endif

            /************************************************************************/
            $.get('/banks/select', function(data) {
                $('#banklist').empty();
                $.each(data, function(index, subbankObj) {
                    $('#banklist').append("<option value='" + subbankObj.id + "'>" + subbankObj
                        .description + "</option>");
                });
                @if ($data->banklist != null)
                    bank = {!! $data->banklist !!};
                    $.each(bank, function(index, subbankObj) {
                        $("#banklist option[value=" + subbankObj + "]").attr("selected", true);
                    });
                @endif
            });
            /************************************************************************/
            $.get('/roles/select', function(data) {
                $('#role').empty();
                $('#role').append("<option value=''>Seleccione Perfil...</option>");
                $.each(data, function(index, subroleObj) {
                    $('#role').append("<option value='" + subroleObj.name + "'>" + subroleObj
                        .description + "</option>");
                });
                $("#role option[value={{ $data->role }}]").attr("selected", true);
            });
            /************************************************************************/
            $.get('/companies/select', function(data) {
                $('#company_id').empty();
                $('#company_id').append("<option value=''>Seleccione Almacén...</option>");
                $.each(data, function(index, subCompanyObj) {
                    $('#company_id').append("<option value='" + subCompanyObj.id + "'>" +
                        subCompanyObj.description + "</option>");
                });
                $("#company_id option[value=" + {{ $data->company_id }} + "]").attr("selected", true);
            });

            $("#form-edit").validate({
                rules: {
                    doc: {
                        required: true,
                    },
                    name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    jobtitle: {
                        required: true,
                    },
                    role: {
                        required: true,
                    },
                    status: {
                        required: true,
                    }
                },
                messages: {
                    doc: {
                        required: 'Documento es requerido',
                    },
                    name: {
                        required: 'Nombre es requerido',
                    },
                    last_name: {
                        required: 'Apellidos es requerido',
                    },
                    email: {
                        required: 'Email es requerido',
                    },
                    jobtitle: {
                        required: 'Cargo es requerido',
                    },
                    role: {
                        required: 'Perfíl es requerido',
                    },
                    status: {
                        required: 'Status es requerido',
                    },
                }
            });
        });

        /**************************************************************************/
        $.get('/roles/select', function(data) {
            $('#role').empty();
            $('#role').append("<option value=''>Seleccione Perfil...</option>");
            $.each(data, function(index, subroleObj) {
                $('#role').append("<option value='" + subroleObj.name + "'>" + subroleObj.description +
                    "</option>");
            });
        });
        /**************************************************************************/
        $('#role').on('change', function(e) {
            var role = e.target.value;
            var slug = 'programmer';
            /************************************************************************/
            if (role != '') {
                $.get('/roles/valid-role?role=' + role + '&slug=' + slug, function(data) {
                    if (data) {
                        document.getElementById("banklist").disabled = false;
                        $('#banklist').attr('required', true);
                        $(".bank").attr("style", "display:block");
                        /**************************************************************************/
                        $.get('/banks/select', function(data) {
                            $('#banklist').empty();
                            $.each(data, function(index, subbankObj) {
                                $('#banklist').append("<option value='" + subbankObj.id +
                                    "'>" + subbankObj.description + "</option>");
                            });
                        });
                    } else {
                        document.getElementById("banklist").disabled = true;
                        $('#banklist').removeAttr('required');
                        $(".bank").attr("style", "display:none");
                    }
                });
            } else {
                document.getElementById("banklist").disabled = true;
                $('#banklist').removeAttr('required');
                $(".bank").attr("style", "display:none");

                document.getElementById("company_id").disabled = true;
                $('#company_id').removeAttr('required');
                $(".company").attr("style", "display:none");
            }
            /************************************************************************/
            $.get('/zoneroles/valid-company?role=' + role, function(data) {
                if (data) {
                    document.getElementById("company_id").disabled = false;
                    $('#company_id').attr('required', true);
                    $(".company").attr("style", "display:block");
                    /**************************************************************************/
                    $.get('/companies/select', function(data) {
                        $('#company_id').empty();
                        $('#company_id').append("<option value=''>Seleccione Almacén...</option>");
                        $.each(data, function(index, subCompanyObj) {
                            $('#company_id').append("<option value='" + subCompanyObj.id +
                                "'>" + subCompanyObj.description + "</option>");
                        });
                    });
                } else {
                    document.getElementById("company_id").disabled = true;
                    $('#company_id').removeAttr('required');
                    $(".company").attr("style", "display:none");
                }
            });
        });
        /**************************************************************************/
        $('.rif').keyup(function() {
            this.value = this.value.toUpperCase();
        });
        /**************************************************************************/
        $('.text').keyup(function() {
            this.value = this.value.toUpperCase();
        });
        /**************************************************************************/
        $('.email').keyup(function() {
            this.value = this.value.toLowerCase();
        });
        /**************************************************************************/
        $('.letter').keyup(function() {
            this.value = this.value.toLowerCase();
            this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
        });
        /**************************************************************************/
        $('.blank').blur(function() {
            /* Obtengo el valor contenido dentro del input */
            var value = $(this).val();

            /* Elimino todos los espacios en blanco que tenga la cadena delante y detrás */
            var value_without_space = $.trim(value);


            /* Cambio el valor contenido por el valor sin espacios */
            $(this).val(value_without_space);
        });
    </script>
@endsection
