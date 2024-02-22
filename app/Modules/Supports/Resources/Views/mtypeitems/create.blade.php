<!-- modal content -->
<div id="mtypeitemsCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="mtypeitemsCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro Item de Tipo Gestión ATC</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="managementtype_id" class="col-sm-12 col-form-label">Tipo Gestión ATC</label>
                        {!! form::select('managementtype_id', [], null, [
                            'id' => 'managementtype_id',
                            'class' => 'form-control managementtype_id',
                            'maxlength' => 50,
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-8">
                        <label for="description" class="col-sm-12 col-form-label">Descripción</label>
                        {!! form::text('description', null, [
                            'id' => 'description',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Descripción',
                            'maxlength' => 50,
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
