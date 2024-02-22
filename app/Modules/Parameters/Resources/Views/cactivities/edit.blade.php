<!-- modal content -->
<div id="cactivitiesUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="cactivitiesUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Actividad Comercial</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-6">
                        {!! form::hidden('id', null, ['id' => 'id']) !!}
                        <label for="code_cactivity_up" class="col-sm-6 col-form-label">Código</label>
                        {!! form::text('code_cactivity_up', null, [
                            'id' => 'code_cactivity_up',
                            'class' => 'form-control input',
                            'placeholder' => 'Ingrese Código',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! form::hidden('id', null, ['id' => 'id']) !!}
                        <label for="description_up" class="col-sm-6 col-form-label">Nombre Actividad Comercial</label>
                        {!! form::text('description_up', null, [
                            'id' => 'description_up',
                            'class' => 'form-control input',
                            'placeholder' => 'Ingrese Nombre Actividad Comercial',
                            'maxlength' => 50,
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
