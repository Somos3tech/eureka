<!-- modal content -->
<div id="pmethodsUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="pmethodsUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Método Pago</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="abrev" class="col-sm-6 col-form-label">Abreviatura</label>
                        {!! form::text('slug_up', null, [
                            'id' => 'slug_up',
                            'class' => 'input form-control',
                            'placeholder' => 'Ingrese Abreviatura Método Pago',
                            'maxlength' => 50,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-8">
                        <label for="description" class="col-sm-6 col-form-label">Descripción</label>
                        {!! form::text('description_up', null, [
                            'id' => 'description_up',
                            'class' => 'input form-control',
                            'placeholder' => 'Ingrese Descripción Método Pago',
                            'maxlength' => 50,
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
