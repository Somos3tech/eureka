<!-- modal content -->
<div id="permissionsCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="permissionsCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0"><b>Crear Registro Permisos Módulos</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-6">
                        {!! form::hidden('id', null, ['id' => 'id']) !!}
                        <label for="description" class="col-sm-12 col-form-label">Nombre</label>
                        {!! form::text('description', null, [
                            'id' => 'description',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Nombre Permiso',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <label for="name" class="col-sm-12 col-form-label">Slug</label>
                        {!! form::text('name', null, [
                            'id' => 'name',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Slug',
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
