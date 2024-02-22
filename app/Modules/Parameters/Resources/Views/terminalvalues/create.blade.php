<!-- modal content -->
<div id="terminalvaluesCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="terminalvaluesCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro Valor Terminal</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-6 p-2">
                        <label>Fecha<small>*</small></label>
                        <div class="input-group p-2">
                            <p>&nbsp;</p>
                            <input type="text" class="form-control" id="date_value" name="date_value"
                                class="form-control" placeholder="yyyy-mm-dd" data-toggle="datepicker" readonly />
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="i i-Calendar-2"></i></span>
                            </div>
                        </div><!-- input-group -->
                    </div>


                    <div class="col-sm-6 p-1">
                        <label for="modelterminal_id" class="col-sm-12 col-form-label">Modelo Punto Venta*</label>
                        {!! form::select('modelterminal_id', ['' => 'Seleccione Modelo Punto de Venta...'], null, [
                            'id' => 'modelterminal_id',
                            'class' => 'form-control select',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label for="currency_id" class="col-sm-12 col-form-label">Divisa<small>*</small></label>
                        {!! form::select('currency_id', ['' => 'Seleccione Divisa...'], null, [
                            'id' => 'currency_id',
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label class="col-sm-12 col-form-label">Valor Divisa<small>*</small></label>
                        {!! form::text('amount_currency', null, [
                            'id' => 'amount_currency',
                            'class' => 'form-control money',
                            'placeholder' => 'Ingrese Valor Equipo',
                            'maxlength' => '20',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4 p-1">
                        <label class="col-sm-12 col-form-label">Valor Local<small>*</small></label>
                        {!! form::text('amount_local', null, [
                            'id' => 'amount_local',
                            'class' => 'form-control money',
                            'placeholder' => 'Ingrese Valor Equipo',
                            'maxlength' => '20',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-12 p-1">
                        <label for="description" class="col-sm-6 col-form-label">Observaciones</label>
                        {!! form::text('description', null, [
                            'id' => 'description',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Observaciones Divisa',
                            'maxlength' => 191,
                        ]) !!}
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
