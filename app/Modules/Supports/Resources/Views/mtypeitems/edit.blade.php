<!-- modal content -->
<div id="mtypeitemsUpdate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mtypeitemsUpdateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Item de Tipo Gestión ATC</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="managementtype_id_up" class="col-sm-12 col-form-label">Tipo Gestión ATC</label>
                        {!! form::select('managementtype_id_up', [], null, [
                            'id' => 'managementtype_id_up',
                            'class' => 'form-control managementtype_id',
                            'maxlength' => 50,
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-8">
                        {!! form::hidden('id', null, ['id' => 'id']) !!}
                        <label for="description_up" class="col-sm-6 col-form-label">Descripción</label>
                        {!! form::text('description_up', null, [
                            'id' => 'description_up',
                            'class' => 'form-control input',
                            'placeholder' => 'Ingrese Descripción',
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
