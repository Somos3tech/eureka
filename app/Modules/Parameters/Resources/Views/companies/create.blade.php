<!-- modal content -->
<div id="companiesCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="companiesCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro Almacén</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="description" class="col-sm-12 col-form-label">Nombre Almacén</label>
                        {!! form::text('description', null, [
                            'id' => 'description',
                            'class' => 'input form-control',
                            'placeholder' => 'Ingrese Nombre Almacén',
                            'maxlength' => 50,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <label for="business_id" class="col-sm-12 col-form-label">Empresa</label>
                        {!! form::select('business_id', [], null, [
                            'id' => 'business_id',
                            'class' => 'form-control input business',
                            'maxlength' => 50,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <label for="typecompany_id" class="col-sm-12 col-form-label">Tipo Almacén</label>
                        {!! form::select('typecompany_id', [], null, [
                            'id' => 'typecompany_id',
                            'class' => 'form-control input typecompany',
                            'maxlength' => 50,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <center>
                            <label class="col-sm-12 col-form-label">Es Distribuidor</label>
                            <label class="col-sm-12 col-form-label"><input type="checkbox" id="is_wholesaler"
                                    name="is_wholesaler" class="checkbox"></label>
                        </center>
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
