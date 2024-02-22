<!-- modal content -->
<div id="businessCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="businessCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro Empresa</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="rif" class="col-sm-12 col-form-label">RIF</label>
                        {!! form::text('rif', null, [
                            'id' => 'rif',
                            'class' => 'form-control input rif',
                            'placeholder' => 'Ingrese RIF',
                            'maxlength' => 12,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <label for="name" class="col-sm-12 col-form-label">Nombre Empresa</label>
                        {!! form::text('name', null, [
                            'id' => 'name',
                            'class' => 'form-control input mayusc',
                            'placeholder' => 'Ingrese Nombre Empresa',
                            'maxlength' => 50,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-8">
                        <label for="address" class="col-sm-12 col-form-label">Dirección</label>
                        {!! form::text('address', null, [
                            'id' => 'address',
                            'class' => 'form-control input',
                            'placeholder' => 'Ingrese Dirección',
                            'maxlength' => 50,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-4">
                        <label for="phone" class="col-sm-12 col-form-label">Teléfono</label>
                        {!! form::text('phone', null, [
                            'id' => 'phone',
                            'class' => 'form-control input phone',
                            'placeholder' => 'Ingrese Teléfono',
                            'maxlength' => 12,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
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
