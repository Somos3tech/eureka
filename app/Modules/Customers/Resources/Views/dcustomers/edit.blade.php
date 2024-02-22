<!-- modal content -->
<div id="dcustomerUpdate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dcustomersUpdateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-dcustomer-edit']) !!}
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="dcustomersUpdateLabel"><b>Actualizar No. Afiliación Bancaria</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!--<div class="col-sm-3">
                        <center>
                            {!! form::label('MultiComercio') !!}
                            <label><input type="checkbox" id="checkbox_up" name="checkbox_up" class="checkbox"
                                    value="" onclick="checkUpdateinput();"></label>
                        </center>
                    </div>-->
                    <!--<div class="col-sm-4">
                        {!! form::label('RIF*') !!}
                        {!! form::text('rif_up', null, [
                            'id' => 'rif_up',
                            'class' => 'form-control rif mayusc',
                            'value' => old('rif'),
                            'placeholder' => 'Ingrese RIF',
                            'disabled' => 'disabled',
                        ]) !!}
                    </div>
                    <div class="col-sm-5">
                        {!! form::label('Nombre Comercio*') !!}
                        {!! form::text('business_name_up', null, [
                            'id' => 'business_name_up',
                            'class' => 'form-control business_name mayusc',
                            'value' => old('business_name'),
                            'placeholder' => 'Ingrese Nombre Comercio',
                            'disabled' => 'disabled',
                        ]) !!}
                    </div>-->
                    <div class="col-sm-4">
                        {!! form::hidden('id_up', null, ['id' => 'id_up']) !!}
                        {!! form::hidden('customer_id_up', null, ['id' => 'customer_id_up']) !!}
                        {!! form::hidden('account_number_up', null, ['id' => 'account_number_up']) !!}
                        {!! form::label('ID Bancario*') !!}
                        {!! form::text('bank_code_up', null, [
                            'id' => 'bank_code_up',
                            'class' => 'form-control',
                            'placeholder' => 'ID Bancario',
                            'required' => 'required',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! form::label('Tipo Cuenta*') !!}
                        {!! form::select('type_account_up', ['Corriente' => 'Corriente', 'Ahorro' => 'Ahorro'], null, [
                            'id' => 'type_account_up',
                            'class' => 'form-control',
                            'placeholder' => 'Seleccione Tipo Cuenta...',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! form::label('Seleccione Banco*') !!}
                        {!! form::select('bank_id_up', ['' => 'Seleccione Banco...'], null, [
                            'id' => 'bank_id_up',
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-3">
                        <center>
                            {!! form::label('Registro F.P.') !!}<br>
                            <label><input type="checkbox" id="personal_signature_up" name="personal_signature_up"
                                    class="checkbox personal_signature" value="" onclick="checkSignatureUpdate();"
                                    data-toggle="tooltip" data-placement="top"
                                    title="Activar Si se registro como Firma Personal o Persona Natural/Rif (Generación Cobranza)"></label>
                        </center>
                    </div>
                    <div class="col-sm-6">
                        {!! form::label('No. Cuenta*') !!}
                        {!! form::text('account_bank_up', null, [
                            'id' => 'account_bank_up',
                            'class' => 'form-control account_bank account',
                            'placeholder' => 'No. Cuenta',
                            'minlength' => 19,
                            'maxlength' => 19,
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        {!! form::label('No. Afiliación*') !!}
                        {!! form::text('affiliate_number_up', null, [
                            'id' => 'affiliate_number_up',
                            'class' => 'form-control text-center mayusc affiliate_number numberl',
                            'placeholder' => 'No. Afiliación',
                            'required' => 'required',
                            'autofocus' => 'autofocus',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!! link_to(
                    '#',
                    $title = 'Actualizar',
                    $attributes = ['id' => 'update-dcustomer', 'class' => 'btn bt-sm btn-info waves-effect waves-light'],
                ) !!}
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
