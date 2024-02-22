<!-- modal content -->
<div id="rcustomerCreate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rcustomersCreateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-rcustomer']) !!}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="rcustomersCreateLabel"><b>Registrar Representante Legal</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        {!! form::label('No. Documento*') !!}
                        {!! form::text('ident_number', null, [
                            'id' => 'ident_number',
                            'class' => 'form-control text-center document mayusc',
                            'placeholder' => 'No. Documento',
                            'required' => 'required',
                            'autofocus' => 'autofocus',
                        ]) !!}
                    </div>

                    <div class="col-sm-8">
                        {!! form::label('Nombre Completo*') !!}
                        {!! form::text('first_name', null, [
                            'id' => 'first_name',
                            'class' => 'form-control mayusc',
                            'placeholder' => 'Ingrese Nombre',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4">
                        {!! form::label('Cargo*') !!}
                        {!! form::text('jobtitle', null, [
                            'id' => 'jobtitle',
                            'class' => 'form-control letter',
                            'placeholder' => 'Ingrese Cargo Empresa',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4">
                        {!! form::label('Email*') !!}
                        {!! form::text('email', null, [
                            'id' => 'email',
                            'class' => 'form-control blank minusc',
                            'placeholder' => 'Ingrese email',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-4">
                        {!! form::label('telephone*') !!}
                        {!! form::text('telephone', null, [
                            'id' => 'telephone',
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
                    $title = 'Registrar',
                    $attributes = ['id' => 'create-rcustomer', 'class' => 'btn bt-sm btn-info waves-effect waves-light'],
                ) !!}
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
