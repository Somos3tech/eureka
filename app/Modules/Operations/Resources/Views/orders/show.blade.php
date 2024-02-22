<!-- modal content -->
<div id="showOrder" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {!! Form::open(['id' => 'form']) !!}
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="showOrderLabel"><b>Gestión Orden de Servicio | Status: </b></h5>
                <div id="status_order" name="status_order"></div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="customer_id" class="col-sm-12 col-form-label"><b>Código</b></label>
                        {!! form::text('customer_id', null, [
                            'id' => 'customer_id',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="rif" class="col-sm-12 col-form-label"><b>RIF</b></label>
                        {!! form::text('rif', null, ['id' => 'rif', 'class' => 'form-control outlinenone', 'readonly' => 'readonly']) !!}
                    </div>

                    <div class="col-sm-6">
                        <label for="business_name" class="col-sm-12 col-form-label"><b>Nombre Comercio</b></label>
                        {!! form::text('business_name', null, [
                            'id' => 'business_name',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="state" class="col-sm-12 col-form-label"><b>Estado</b></label>
                        {!! form::text('state', null, [
                            'id' => 'state',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="city" class="col-sm-12 col-form-label"><b>Ciudad</b></label>
                        {!! form::text('city', null, ['id' => 'city', 'class' => 'form-control outlinenone', 'readonly' => 'readonly']) !!}
                    </div>

                    <div class="col-sm-6">
                        <label for="address" class="col-sm-12 col-form-label"><b>Dirección</b></label>
                        {!! form::text('address', null, [
                            'id' => 'address',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-2">
                        <label for="postal_code" class="col-sm-12 col-form-label"><b>Postal</b></label>
                        {!! form::text('postal_code', null, [
                            'id' => 'postal_code',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-4">
                        <label for="email" class="col-sm-12 col-form-label"><b>Correo Electrónico*</b></label>
                        {!! form::text('email', null, [
                            'id' => 'email',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="telephone" class="col-sm-12 col-form-label"><b>Teléfono</b></label>
                        {!! form::text('telephone', null, [
                            'id' => 'telephone',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="mobile" class="col-sm-12 col-form-label"><b>Movíl</b></label>
                        {!! form::text('mobile', null, [
                            'id' => 'mobile',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <!--------------------------------------------------------------------------->
                    <div class="col-sm-12">
                        <hr />
                    </div>
                    <!--------------------------------------------------------------------------->
                    <div class="col-sm-12">
                        <h5 class="modal-title mt-0" id="myModalLabel"><b>Información Orden</b></h5>
                    </div>
                    <div class="col-sm-3">
                        <label for="order_id" class="col-sm-12 col-form-label"><b>No. Orden</b></label>
                        {!! form::text('order_id', null, [
                            'id' => 'order_id',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-3">
                        <label for="created_order" class="col-sm-12 col-form-label"><b>Creado</b></label>
                        {!! form::text('created_order', null, [
                            'id' => 'created_order',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-3">
                        <label for="user_created_order" class="col-sm-12 col-form-label"><b>Creado Por</b></label>
                        {!! form::text('user_created_order', null, [
                            'id' => 'user_created_order',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-3">
                        <label for="programmer_finish" class="col-sm-12 col-form-label"><b>Finalizado</b></label>
                        {!! form::text('programmer_finish', null, [
                            'id' => 'programmer_finish',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-4">
                        <label for="modelterminal" class="col-sm-12 col-form-label"><b>Modelo</b></label>
                        {!! form::text('modelterminal', null, [
                            'id' => 'modelterminal',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-5">
                        <label for="terminal" class="col-sm-12 col-form-label"><b>Serial</b></label>
                        {!! form::text('terminal', null, [
                            'id' => 'terminal',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-3">
                        <label for="nropos" class="col-sm-12 col-form-label"><b>No. Terminal*</b></label>
                        {!! form::text('nropos', null, [
                            'id' => 'nropos',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-2">
                        <label for="operator" class="col-sm-12 col-form-label"><b>Operador</b></label>
                        {!! form::text('operator', null, [
                            'id' => 'operator',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-4">
                        <label for="simcard" class="col-sm-12 col-form-label"><b>Serial</b></label>
                        {!! form::text('simcard', null, [
                            'id' => 'simcard',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-3">
                        <label for="programmer_at" class="col-sm-12 col-form-label"><b>Fecha Programación</b></label>
                        {!! form::text('programmer_at', null, [
                            'id' => 'programmer_at',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-3">
                        <label for="user_programmer" class="col-sm-12 col-form-label"><b>Reprogramador</b></label>
                        {!! form::text('user_programmer', null, [
                            'id' => 'user_programmer',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <label for="observ_credicard" class="col-sm-12 col-form-label"><b>Observación
                                Inicial*</b></label>
                        {!! form::textarea('observ_credicard', null, [
                            'id' => 'observ_credicard',
                            'rows' => 1,
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <label for="observ_programmer" class="col-sm-12 col-form-label"><b>Observación
                                Final*</b></label>
                        {!! form::textarea('observ_programmer', null, [
                            'id' => 'observ_programmer',
                            'rows' => 1,
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="date_send" class="col-sm-12 col-form-label"><b>Fecha Envio</b></label>
                        {!! form::text('date_send', null, [
                            'id' => 'date_send',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>


                    <div class="col-sm-3">
                        <label for="posted_at" class="col-sm-12 col-form-label"><b>Fecha Entrega</b></label>
                        {!! form::text('posted_at', null, [
                            'id' => 'posted_at',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="type_posted" class="col-sm-12 col-form-label"><b>Tipo Entrega</b></label>
                        {!! form::text('type_posted', null, [
                            'id' => 'type_posted',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="number_control" class="col-sm-12 col-form-label"><b>No. Control</b></label>
                        {!! form::text('number_control', null, [
                            'id' => 'number_control',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-12">
                        <label for="observ_posted" class="col-sm-12 col-form-label"><b>Observaciones
                                Entrega*</b></label>
                        {!! form::textarea('observ_posted', null, [
                            'id' => 'observ_posted',
                            'rows' => 1,
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="user_posted" class="col-sm-12 col-form-label"><b>Usuario Entrega</b></label>
                        {!! form::text('user_posted', null, [
                            'id' => 'user_posted',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-7">
                        &nbsp;
                    </div>

                    <div class="col-sm-2">
                        <label for="status_contract" class="col-sm-12 col-form-label"><b>Status</b></label>
                        {!! form::text('status_contract', null, [
                            'id' => 'status_contract',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                    <!--------------------------------------------------------------------------->
                    <div class="col-sm-12">
                        <hr />
                    </div>
                    <!--------------------------------------------------------------------------->
                    <div class="col-sm-12">
                        <h5 class="modal-title mt-0"><b>Información Venta</b></h5>
                    </div>

                    <div class="col-sm-3">
                        <label for="contract_id" class="col-sm-12 col-form-label"><b>No. Contrato</b></label>
                        {!! form::text('contract_id', null, [
                            'id' => 'contract_id',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="created_contract" class="col-sm-12 col-form-label"><b>Fecha Contrato</b></label>
                        {!! form::text('created_contract', null, [
                            'id' => 'created_contract',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="user_name" class="col-sm-12 col-form-label"><b>Asesor / Asistente</b></label>
                        {!! form::text('user_name', null, [
                            'id' => 'user_name',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="consultant_name" class="col-sm-12 col-form-label"><b>Aliado Comercial</b></label>
                        {!! form::text('consultant_name', null, [
                            'id' => 'consultant_name',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="company" class="col-sm-12 col-form-label"><b>Almacén Venta</b></label>
                        {!! form::text('company', null, [
                            'id' => 'company',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="bank" class="col-sm-12 col-form-label"><b>Banco</b></label>
                        {!! form::text('bank', null, ['id' => 'bank', 'class' => 'form-control outlinenone', 'readonly' => 'readonly']) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="affiliate_number" class="col-sm-12 col-form-label"><b>No. Afiliación</b></label>
                        {!! form::text('affiliate_number', null, [
                            'id' => 'affiliate_number',
                            'class' => 'form-control outlinenone',
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="term" class="col-sm-12 col-form-label"><b>Cond. Comercial</b></label>
                        {!! form::text('term', null, ['id' => 'term', 'class' => 'form-control outlinenone', 'readonly' => 'readonly']) !!}
                    </div>

                    <div class="col-sm-12">
                        <label for="observation_contract" class="col-sm-12 col-form-label"><b>Observación
                                Venta*</b></label>
                        {!! form::textarea('observation_contract', null, [
                            'id' => 'observation_contract',
                            'class' => 'form-control outlinenone',
                            'rows' => 2,
                            'readonly' => 'readonly',
                        ]) !!}
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
