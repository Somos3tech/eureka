@extends('layouts.compact-master')

@section('page-css')
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <!-- Content-->
    <div class="row">
        <div class="col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    {!! Form::model($data, ['id' => 'form', 'route' => ['roles.update', $data->id], 'method' => 'PUT']) !!}
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label for="rif">Nombre<small> *</small></label>
                            {!! form::text('description', null, [
                                'id' => 'description',
                                'class' => 'form-control blank',
                                'placeholder' => 'Ingrese Nombre Role',
                                'minlength' => 5,
                                'maxlength' => 50,
                            ]) !!}
                        </div>

                        <div class="col-sm-4">
                            <label for="rif">Slug<small> *</small></label>
                            {!! form::text('name', null, [
                                'id' => 'name',
                                'class' => 'form-control blank',
                                'placeholder' => 'Ingrese Nombre Role',
                                'minlength' => 5,
                                'maxlength' => 50,
                            ]) !!}
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <h4 class="mt-0 m-b-30 header-title"><b>Lista de Permisos</b></h4>
                            <div><a href="javascript:seleccionar_todo()">Marcar todos</a>|<a
                                    href="javascript:deseleccionar_todo()">Desmarcar Todos</a></div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <h4 class="mt-0 m-b-30 header-title"><b>Permiso(s)</b></h4>
                            <div class="row">
                                @foreach ($titles as $title)
                                    <div class="col-sm-3">
                                        <h6 class="mt-0 m-b-30 header-title"><b>{{ $title->description }}</b></h6>
                                        <div class="form-group">
                                            <div class="list-unstyled">
                                                @foreach ($permissions as $permission)
                                                    @if ($title->slug == implode('.', array_slice(explode('.', $permission->name), 0, 1)))
                                                        <li>
                                                            <label>
                                                                {{ Form::checkbox('permissions[]', $permission->name, null) }}
                                                                {{ $permission->description }}
                                                            </label>
                                                        <li>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <center>
                                <a href="{{ route('roles.index') }}" title="Volver" class="btn btn-sm btn-dark"><i
                                        class="fa fa-rotate-left"></i> Volver</a>&nbsp;
                                <button type="submit" class="btn btn-sm btn-info"> Actualizar</button>
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
    <script type="text/javascript">
        $(document).ready(function() {

            $('.mayusc').keyup(function() {
                this.value = this.value.toUpperCase();
            });

            $('.minusc').keyup(function() {
                this.value = this.value.toLowerCase();
            });

            $('.letter').keyup(function() {
                this.value = this.value.toLowerCase();
                this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
            });
            /* Evento para cuando el usuario libera la tecla escrita dentro del input */
            $('.blank').blur(function() {
                /* Obtengo el valor contenido dentro del input */
                var value = $(this).val();

                /* Elimino todos los espacios en blanco que tenga la cadena delante y detrás */
                var value_without_space = $.trim(value);

                /* Cambio el valor contenido por el valor sin espacios */
                $(this).val(value_without_space);
            });
        });


        // obtenemos el array de valores mediante la conversion a json del
        // array de php
        var array = <?php echo json_encode($permissions); ?>;
        var arrayJS = <?php echo json_encode($permissions_user); ?>;
        var elementos = document.getElementsByName("permissions[]");

        // Mostramos los valores del array
        for (var i = 0; i < arrayJS.length; i++) {
            for (var j = 0; j < array.length; j++) {
                if (arrayJS[i].name == array[j].name) {
                    elementos[j].checked = true;
                }
            }
        }

        function seleccionar_todo() {
            var elementos = document.getElementsByName("permissions[]");
            for (i = 0; i < elementos.length; i++) {
                if (elementos[i].type == "checkbox") {
                    elementos[i].checked = 1;
                }
            }
        }

        function deseleccionar_todo() {
            var elementos = document.getElementsByName("permissions[]");
            for (i = 0; i < elementos.length; i++) {
                if (elementos[i].type == "checkbox") {
                    elementos[i].checked = 0;
                }
            }
        }
    </script>
@endsection
