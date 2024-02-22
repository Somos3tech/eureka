<!-- modal content -->
<div id="consultantsUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="consultantsUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Aliado Comercial</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-3">
                        {!! form::label('No. Documento') !!}
                        {!! form::text('document_number', null, [
                            'id' => 'document_number',
                            'class' => 'form-control document ',
                            'placeholder' => 'Ingrese Documento',
                            'minlength' => 5,
                            'maxlength' => 14,
                            'required' => 'required',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        {!! form::label('RIF') !!}
                        {!! form::text('rif', null, [
                            'id' => 'rif',
                            'class' => 'form-control outlinenone rif',
                            'minlength' => 5,
                            'maxlength' => 12,
                            'placeholder' => 'Ingrese RIF',
                            'required' => 'required',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-3">
                        {!! form::label('Nombres*') !!}
                        {!! form::text('first_name', null, [
                            'id' => 'first_name',
                            'class' => 'form-control blank letter',
                            'placeholder' => 'Ingrese Nombres',
                            'maxlength' => '191',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        {!! form::label('Apellidos*') !!}
                        {!! form::text('last_name', null, [
                            'id' => 'last_name',
                            'class' => 'form-control blank letter',
                            'placeholder' => 'Ingrese Apellidos',
                            'maxlength' => '191',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4">
                        {!! form::label('Email*') !!}
                        {!! form::email('email', null, [
                            'id' => 'email',
                            'class' => 'email form-control blank',
                            'placeholder' => 'usuario@dominio.com',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        {!! form::label('Telefono*') !!}
                        {!! form::text('telephone', null, [
                            'id' => 'telephone',
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
                        {!! form::text('observations', null, [
                            'id' => 'observations',
                            'class' => 'form-control letter blank',
                            'placeholder' => 'Ingrese Observaciones',
                            'maxlength' => '191',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-5">
                        {!! form::label('SubZona Venta*') !!}
                        {!! form::text('zone', null, [
                            'id' => 'zone',
                            'class' => 'form-control letter blank',
                            'placeholder' => 'Ingrese SubZona Venta',
                            'maxlength' => '191',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4">
                        {!! form::label('Asesor Asociado*') !!}
                        {!! form::select('user_id', ['0' => 'Seleccione Asesor Asociado...'], null, [
                            'id' => 'user_id',
                            'class' => 'form-control',
                            'value' => old('user_id'),
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        {!! form::label('Status') !!}
                        {!! form::select('statusup', ['Activo' => 'Activo', 'Inactivo' => 'Inactivo'], null, [
                            'id' => 'statusup',
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                {!! link_to('#', $title = 'Actualizar', $attributes = ['id' => 'update', 'class' => 'btn bt-sm btn-info']) !!}
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
