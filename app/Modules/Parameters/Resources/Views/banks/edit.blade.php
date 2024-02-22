<!-- modal content -->
<div id="banksUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="banksUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Banco</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-8 p-1">
                        <label for="description" class="col-sm-12 col-form-label"><b>Nombre Banco</b></label>
                        {!! form::text('descriptionup', null, [
                            'id' => 'descriptionup',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Nombre de Banco',
                            'maxlength' => 50,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="rif" class="col-sm-12 col-form-label"><b>RIF</b></label>
                        {!! form::text('rifup', null, [
                            'id' => 'rifup',
                            'class' => 'form-control rif mayusc',
                            'placeholder' => 'Ingrese RIF',
                            'maxlength' => 14,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-12 p-1">
                        <label for="address" class="col-sm-12 col-form-label"><b>Dirección</b></label>
                        {!! form::text('addressup', null, [
                            'id' => 'addressup',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Direccion',
                            'maxlength' => 150,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-6 p-1">
                        <label for="bank_codeup" class="col-sm-12 col-form-label"><b>Código Banco</b></label>
                        {!! form::text('bank_codeup', null, [
                            'id' => 'bank_codeup',
                            'class' => 'form-control code',
                            'placeholder' => 'Digíte Código Banco',
                            'maxlength' => 12,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-6 p-1">
                        <center>
                            <label class="col-sm-12 col-form-label"><b>Validación Bancaria</b></label>
                            <label class="col-sm-12 col-form-label"><input type="checkbox" id="is_register_up"
                                    name="is_register_up" class="checkbox"></label>
                        </center>
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
