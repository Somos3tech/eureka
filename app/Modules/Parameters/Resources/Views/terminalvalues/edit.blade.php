<!-- modal content -->
<div id="terminalvaluesUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="terminalvaluesUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Valor Terminal</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-6 p-2">
                        <label>Fecha<small>*</small></label>
                        <div class="input-group p-2">
                            <p>&nbsp;</p>
                            <input type="text" id="date_value_up" name="date_value_up" class="form-control"
                                placeholder="yyyy-mm-dd" data-toggle="datepicker" readonly />
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="i i-Calendar-2"></i></span>
                            </div>
                        </div><!-- input-group -->
                    </div>

                    <div class="col-sm-6">
                        <label class="col-sm-12 col-form-label">Modelo Terminal<small>*</small></label>
                        {!! form::text('modelterminal', null, [
                            'id' => 'modelterminal',
                            'class' => 'form-control',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="currency_id_up" class="col-sm-12 col-form-label">Divisa<small>*</small></label>
                        {!! form::text('currency_id_up', null, [
                            'id' => 'currency_id_up',
                            'class' => 'form-control',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label class="col-sm-12 col-form-label">Valor Divisa<small>*</small></label>
                        {!! form::text('amount_currency_up', null, [
                            'id' => 'amount_currency_up',
                            'class' => 'form-control money',
                            'placeholder' => 'Ingrese Valor Equipo',
                            'maxlength' => '20',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label class="col-sm-12 col-form-label">Valor Local<small>*</small></label>
                        {!! form::text('amount_local_up', null, [
                            'id' => 'amount_local_up',
                            'class' => 'form-control money',
                            'placeholder' => 'Ingrese Valor Equipo',
                            'maxlength' => '20',
                            'required' => 'required',
                        ]) !!}
                    </div>


                    <div class="col-sm-12 p-1">
                        <label for="description_up" class="col-sm-6 col-form-label">Descripción</label>
                        {!! form::text('description_up', null, [
                            'id' => 'description_up',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Descripción',
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
