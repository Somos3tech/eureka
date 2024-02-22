{{-- Jorge Thomas - Cambios visuales en los modales para mejorar UX --}}
<!-- modal content -->
<div id="consultantsCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="consultantsCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro Aliado Comercial</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-5">
                        {!! form::label('No. Documento') !!}
                        {!! form::text('document_number_c', null, [
                            'id' => 'document_number_c',
                            'class' => 'form-control document ',
                            'placeholder' => 'Ingrese Documento',
                            'minlength' => 5,
                            'maxlength' => 14,
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-5">
                        {!! form::label('RIF') !!}
                        {!! form::text('rif_c', null, [
                            'id' => 'rif_c',
                            'class' => 'form-control outlinenone rif',
                            'minlength' => 5,
                            'maxlength' => 12,
                            'placeholder' => 'Ingrese RIF',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-5">
                        {!! form::label('Nombres*') !!}
                        {!! form::text('first_name_c', null, [
                            'id' => 'first_name_c',
                            'class' => 'form-control blank',
                            'placeholder' => 'Ingrese Nombres',
                            'maxlength' => '191',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-5">
                        {!! form::label('Apellidos*') !!}
                        {!! form::text('last_name_c', null, [
                            'id' => 'last_name_c',
                            'class' => 'form-control blank',
                            'placeholder' => 'Ingrese Apellidos',
                            'maxlength' => '191',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-5">
                        {!! form::label('Email*') !!}
                        {!! form::email('email_c', null, [
                            'id' => 'email_c',
                            'class' => 'email form-control blank',
                            'placeholder' => 'usuario@dominio.com',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-5">
                        {!! form::label('Telefono*') !!}
                        {!! form::text('telephone_c', null, [
                            'id' => 'telephone_c',
                            'class' => 'form-control phone',
                            'value' => old('telephone'),
                            'minlength' => 12,
                            'maxlength' => 12,
                            'placeholder' => 'Digite Nro. Telefono',
                            'maxlength' => 12,
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-5">
                        {!! form::label('Observaciones') !!}
                        {!! form::text('observation_c', null, [
                            'id' => 'observation_c',
                            'class' => 'form-control letter blank',
                            'placeholder' => 'Ingrese Observaciones',
                            'maxlength' => '191',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-5">
                        {!! form::label('SubZona Venta*') !!}
                        {!! form::text('zone_c', null, [
                            'id' => 'zone_c',
                            'class' => 'form-control letter blank',
                            'placeholder' => 'Ingrese SubZona Venta',
                            'maxlength' => '191',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-5">
                        {!! form::label('Asesor Asociado*') !!}
                        {!! form::select('user_id_c', ['0' => 'Seleccione Asesor Asociado...'], null, [
                            'id' => 'user_id_c',
                            'class' => 'form-control select',
                            'value' => old('user_id'),
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-5">
                        {!! form::label('Status') !!}
                        {!! form::select('status_c', ['Activo' => 'Activo', 'Inactivo' => 'Inactivo'], null, [
                            'id' => 'status_c',
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                {!! link_to('#', $title = 'Registrar', $attributes = ['id' => 'create', 'class' => 'btn bt-sm  btn-info']) !!}
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
