<!-- modal content -->
<div id="businessUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="businessUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Empresa</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-6">
                        {!! form::hidden('id', null, ['id' => 'id']) !!}
                        <label for="rif_up" class="col-sm-12 col-form-label">RIF</label>
                        {!! form::text('rif_up', null, [
                            'id' => 'rif_up',
                            'class' => 'form-control input rif',
                            'placeholder' => 'Ingrese RIF',
                            'maxlength' => 12,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <label for="name_up" class="col-sm-12 col-form-label">Nombre Empresa</label>
                        {!! form::text('name_up', null, [
                            'id' => 'name_up',
                            'class' => 'form-control input title',
                            'placeholder' => 'Ingrese Nombre Empresa',
                            'maxlength' => 50,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-8">
                        <label for="address_up" class="col-sm-12 col-form-label">Dirección</label>
                        {!! form::text('address_up', null, [
                            'id' => 'address_up',
                            'class' => 'form-control input',
                            'placeholder' => 'Ingrese Dirección',
                            'maxlength' => 50,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-4">
                        <label for="phone_up" class="col-sm-12 col-form-label">Teléfono</label>
                        {!! form::text('phone_up', null, [
                            'id' => 'phone_up',
                            'class' => 'input form-control phone',
                            'placeholder' => 'Ingrese Teléfono',
                            'maxlength' => 12,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
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
