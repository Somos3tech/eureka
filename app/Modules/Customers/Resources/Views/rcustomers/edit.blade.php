<!-- modal content -->
<div id="rcustomerUpdate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rcustomersUpdateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-rcustomer-edit']) !!}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="rcustomersUpdateLabel"><b>Actualizar Representante Legal</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div id="errors-rcustomer-update" style="display: none;" name="errors" data-dismiss="alert"
                    class="alert alert-danger bg-danger text-white alert-dismissible">x</div>
                <div class="form-group row">
                    <div class="col-sm-4">
                        {!! form::hidden('id_up', null, ['id' => 'id_up']) !!}
                        {!! form::hidden('customer_id_up', null, ['id' => 'customer_id_up']) !!}
                        {!! form::label('No. Documento*') !!}
                        {!! form::text('ident_number_up', null, [
                            'id' => 'ident_number_up',
                            'class' => 'form-control text-center document mayusc',
                            'placeholder' => 'No. Documento',
                            'required' => 'required',
                            'autofocus' => 'autofocus',
                        ]) !!}
                    </div>

                    <div class="col-sm-8">
                        {!! form::label('Nombre Completo*') !!}
                        {!! form::text('first_name_up', null, [
                            'id' => 'first_name_up',
                            'class' => 'form-control mayusc',
                            'placeholder' => 'Ingrese Nombre',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4">
                        {!! form::label('Cargo*') !!}
                        {!! form::text('jobtitle_up', null, [
                            'id' => 'jobtitle_up',
                            'class' => 'form-control letter',
                            'placeholder' => 'Ingrese Cargo Empresa',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4">
                        {!! form::label('Email*') !!}
                        {!! form::text('email_up', null, [
                            'id' => 'email_up',
                            'class' => 'form-control blank minusc',
                            'placeholder' => 'Ingrese email',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! form::label('telephone*') !!}
                        {!! form::text('telephone_up', null, [
                            'id' => 'telephone_up',
                            'class' => 'form-control phone',
                            'placeholder' => 'Ingrese Telefono',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!! link_to(
                    '#',
                    $title = 'Actualizar',
                    $attributes = ['id' => 'update-rcustomer', 'class' => 'btn bt-sm btn-info'],
                ) !!}
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
