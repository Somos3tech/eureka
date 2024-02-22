<!-- modal content -->
<div id="typecompaniesUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="typecompaniesUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Marca</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12">
                        {!! form::hidden('id', null, ['id' => 'id']) !!}
                        <label for="description_up" class="col-sm-6 col-form-label">Nombre Marca</label>
                        {!! form::text('description_up', null, [
                            'id' => 'description_up',
                            'class' => 'form-control',
                            'placeholder' => 'Ingrese Nombre Marca',
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
