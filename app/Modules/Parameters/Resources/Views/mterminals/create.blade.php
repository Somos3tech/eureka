<!-- modal content -->
<div id="mterminalsCreate" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="mterminalsCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Crear Registro Modelo Terminal</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12 p-1">
                        <label for="mark_id" class="col-sm-12 col-form-label">Marca</label>
                        {!! form::select('mark_id', ['' => 'Seleccione Marca...'], null, [
                            'id' => 'mark_id',
                            'class' => 'form-control select mark_id',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-12 p-1">
                        <label for="description" class="col-sm-12 col-form-label">Modelo Terminal</label>
                        {!! form::text('description', null, [
                            'id' => 'description',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Modelo Terminal',
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
