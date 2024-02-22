<!-- modal content -->
<div id="mterminalUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="mterminalsUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Modelo Terminal</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12 p-1">
                        {!! form::hidden('id', null, ['id' => 'id']) !!}
                        <label for="mark_id" class="col-sm-12 col-form-label">Marca</label>
                        {!! form::select('markup_id', ['' => 'Seleccione Marca...'], null, [
                            'id' => 'markup_id',
                            'class' => 'form-control mark_id',
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-12 p-1">
                        <label for="description" class="col-sm-12 col-form-label">Modelo Terminal</label>
                        {!! form::text('descriptionup', null, [
                            'id' => 'descriptionup',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Modelo Terminal',
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
