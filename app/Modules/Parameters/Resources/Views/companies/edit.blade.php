<!-- modal content -->
<div id="companyUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="companiesUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-edit']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Actualizar Registro Almacén</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-6">
                        {!! form::hidden('id', null, ['id' => 'id']) !!}
                        <label for="description_up" class="col-sm-12 col-form-label">Nombre Almacén</label>
                        {!! form::text('description_up', null, [
                            'id' => 'description_up',
                            'class' => 'form-control input',
                            'placeholder' => 'Ingrese Nombre Almacén',
                            'maxlength' => 50,
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <label for="business_id_up" class="col-sm-12 col-form-label">Empresa</label>
                        {!! form::select('business_id_up', [], null, [
                            'id' => 'business_id_up',
                            'class' => 'form-control input business',
                            'maxlength' => 50,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <label for="typecompany_id_up" class="col-sm-12 col-form-label">Tipo Almacén</label>
                        {!! form::select('typecompany_id_up', [], null, [
                            'id' => 'typecompany_id_up',
                            'class' => 'form-control input typecompany',
                            'maxlength' => 50,
                            'autofocus' => 'autofocus',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="col-sm-6">
                        <center>
                            <label class="col-sm-12 col-form-label">Es Distribuidor</label>
                            <label class="col-sm-12 col-form-label"><input type="checkbox" id="is_wholesaler_up"
                                    name="is_wholesaler_up" class="checkbox"></label>
                        </center>
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
