<!-- modal content -->
<div id="dcustomersCreate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dcustomersCreateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-dcustomer']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="dcustomersCreateLabel"><b>Registrar Nro Afiliación Bancaria</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <!--<div class="col-sm-3">
                        <center>
                            {!! form::label('MultiComercio') !!}
                            <label><input type="checkbox" id="checkbox" name="checkbox" class="checkbox" value=""
                                    onclick="checkinput();"></label>
                        </center>
                    </div>

                    <div class="col-sm-4">
                        {!! form::label('RIF*') !!}
                        {!! form::text('rif', null, [
                            'id' => 'rif',
                            'class' => 'form-control rif mayusc',
                            'value' => old('rif'),
                            'placeholder' => 'Ingrese RIF',
                            'disabled' => 'disabled',
                        ]) !!}
                    </div>

                    <div class="col-sm-5">
                        {!! form::label('Nombre Comercio*') !!}
                        {!! form::text('business_name', null, [
                            'id' => 'business_name',
                            'class' => 'form-control business_name mayusc',
                            'value' => old('business_name'),
                            'placeholder' => 'Ingrese Nombre Comercio',
                            'disabled' => 'disabled',
                        ]) !!}
                    </div>-->

                    <div class="col-sm-4">
                        {!! form::hidden('customer_id', $customer->id, ['id' => 'customer_id']) !!}
                        {!! form::hidden('account_number', null, ['id' => 'account_number']) !!}
                        {!! form::hidden('type_contract', 'basic', ['id' => 'type_contract']) !!}
                        {!! form::label('ID Bancario*') !!}
                        {!! form::text('bank_code', null, [
                            'id' => 'bank_code',
                            'class' => 'form-control',
                            'value' => old('bank_code'),
                            'placeholder' => 'ID Bancario',
                            'required' => 'required',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-4">
                        {!! form::label('Tipo Cuenta*') !!}
                        {!! form::select('type_account', ['Ahorro' => 'Ahorro', 'Corriente' => 'Corriente'], null, [
                            'id' => 'type_account',
                            'class' => 'form-control',
                            'value' => old('type_account'),
                            'placeholder' => 'Seleccione Tipo Cuenta...',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4">
                        {!! form::label('Seleccione Banco*') !!}
                        {!! form::select('bank_id', ['' => 'Seleccione Banco...'], null, [
                            'id' => 'bank_id',
                            'class' => 'form-control',
                            'value' => old('bank_id'),
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <center>
                            {!! form::label('Registro F.P.') !!}<br>
                            <label><input type="checkbox" id="personal_signature" name="personal_signature"
                                    class="checkbox personal_signature" value="" onclick="checkSignature();"
                                    data-toggle="tooltip" data-placement="top"
                                    title="Activar Si se registro como Firma Personal o Persona Natural/Rif (Generación Cobranza)"></label>
                        </center>
                    </div>

                    <div class="col-sm-6">
                        {!! form::label('No. Cuenta*') !!}
                        {!! form::text('account_bank', null, [
                            'id' => 'account_bank',
                            'class' => 'form-control  account_bank account',
                            'value' => old('account_bank'),
                            'placeholder' => 'No. Cuenta',
                            'minlength' => 19,
                            'maxlength' => 19,
                            'required' => 'required',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        {!! form::label('No. Afiliación*') !!}
                        {!! form::text('affiliate_number', null, [
                            'id' => 'affiliate_number',
                            'class' => 'form-control text-center mayusc affiliate_number numberl',
                            'value' => old('affiliate_number'),
                            'placeholder' => 'No. Afiliación',
                            'required' => 'required',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!! link_to(
                    '#',
                    $title = 'Registrar',
                    $attributes = ['id' => 'create-dcustomer', 'class' => 'btn bt-sm btn-info'],
                ) !!}
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
