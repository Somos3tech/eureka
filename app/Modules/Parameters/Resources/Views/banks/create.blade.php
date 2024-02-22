<!-- modal content -->
<div id="banksCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="banksCreateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro Banco</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-8 p-1">
                        <label for="description" class="col-sm-12 col-form-label"><b>Nombre Banco</b></label>
                        {!! form::text('description', null, [
                            'id' => 'description',
                            'class' => 'form-control blank',
                            'placeholder' => 'Ingrese Nombre de Banco',
                            'minlength' => 3,
                            'maxlength' => 191,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="rif" class="col-sm-12 col-form-label"><b>RIF</b></label>
                        {!! form::text('rif', null, [
                            'id' => 'rif',
                            'class' => 'form-control rif mayusc',
                            'placeholder' => 'Ingrese RIF',
                            'minlength' => 10,
                            'maxlength' => 12,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-12 p-1">
                        <label for="address" class="col-sm-12 col-form-label"><b>Direccion</b></label>
                        {!! form::text('address', null, [
                            'id' => 'address',
                            'class' => 'form-control blank',
                            'placeholder' => 'Ingrese Direccion',
                            'minlength' => 3,
                            'maxlength' => 191,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-6 p-1">
                        <label for="bank_code" class="col-sm-12 col-form-label"><b>Código Banco</b></label>
                        {!! form::text('bank_code', null, [
                            'id' => 'bank_code',
                            'class' => 'form-control code',
                            'placeholder' => 'Digite Codigo de Banco',
                            'minlength' => 3,
                            'maxlength' => 4,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-6  p-1">
                        <center>
                            <label class="col-sm-12 col-form-label"><b>Validación Bancaria</b></label>
                            <label class="col-sm-12 col-form-label"><input type="checkbox" id="is_register"
                                    name="is_register" class="checkbox"></label>
                        </center>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                {!! link_to('#', $title = 'Registrar', $attributes = ['id' => 'create', 'class' => 'btn bt-sm btn-info']) !!}
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
