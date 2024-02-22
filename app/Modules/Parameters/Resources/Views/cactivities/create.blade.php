<!-- modal content -->
<div id="cactivitiesCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="cactivitiesCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro Actividad Comercial</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-6 col-form-label">
                        {!! form::hidden('id', null, ['id' => 'id']) !!}
                        <label for="code_cactivity" class="col-sm-6 col-form-label">Código</label>
                        {!! form::text('code_cactivity', null, [
                            'id' => 'code_cactivity',
                            'class' => 'form-control input',
                            'placeholder' => 'Ingrese Código',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6 col-form-label">
                        <label for="description" class="col-sm-12 col-form-label">Nombre Actividad Comercial</label>
                        {!! form::text('description', null, [
                            'id' => 'description',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Nombre Actividad Comercial',
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
