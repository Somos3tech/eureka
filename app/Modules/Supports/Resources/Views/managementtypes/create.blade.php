<!-- modal content -->
<div id="managementtypesCreate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="managementtypesCreateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro Tipo Gestión ATC</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="slug" class="col-sm-6 col-form-label">Abreviatura</label>
                        {!! form::text('slug', null, [
                            'id' => 'slug',
                            'class' => 'form-control input',
                            'placeholder' => 'Ingrese Abreviatura',
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
