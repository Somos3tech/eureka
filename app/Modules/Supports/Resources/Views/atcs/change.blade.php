<div id="atcsChange" name="atcsChange" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="atcsChangeLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form-atc-change" name="form-atc-change">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel"><b>Editar Gestión ATC No. &nbsp;&nbsp;&nbsp; </b>
                    </h5><span class="atc_id_view view"></span> &nbsp;&nbsp;|&nbsp;&nbsp; <span
                        class="status_view view"></span><button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×</button>
                </div>

                <div class="modal-body row">
                    {!! Form::hidden('atc_id', null, ['id' => 'atc_id', 'class' => 'atc_id']) !!}
                    <div class="col-sm-6 user">
                        <label for="customer_view" class="col-sm-12"><b>Código</b><br>
                            <center><span class="customer_view view"></span></center>
                        </label>
                    </div>

                    <div class="col-sm-6 user">
                        <label for="rif_view" class="col-sm-12"><b>RIF</b><br>
                            <span class="rif_view view"></span></label>
                    </div>

                    <div class="col-sm-12 user">
                        <label for="business_name_view" class="col-sm-12"><b>Nombre Comercio / Usuario</b><br>
                            <span class="business_name_view view"></span></label>
                    </div>

                    <div class="col-sm-6 user">
                        <label for="telephone_view" class="col-sm-12"><b>Teléfono</b><br>
                            <span class="telephone_view view"></span></label>
                    </div>

                    <div class="col-sm-6 user">
                        <label for="mobile_view" class="col-sm-12"><b>Movíl</b><br>
                            <span class="mobile_view view"></span></label>
                    </div>

                    <div class="col-sm-12 user">
                        <label for="email_view" class="col-sm-12"><b>Email</b><br>
                            <span class="email_view view"></span></label>
                    </div>

                    <div class="col-sm-6 internaluser">
                        <label for="business_name_view" class="col-sm-12"><b>Usuario</b><br>
                            <span class="business_name_view view"></span></label>
                    </div>

                    <div class="col-sm-6 internaluser">
                        <label for="email_view" class="col-sm-12"><b>Email</b><br>
                            <span class="email_view view"></span></label>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-sm-12 col-form-label"><b>Canal<small>*</small></b></label>
                        {!! Form::select('channel_id', ['' => 'Seleccione Tipo Canal ATC...'], null, [
                            'id' => 'channel_id',
                            'class' => 'form-control',
                            'value' => old('channel_id'),
                        ]) !!}
                    </div>

                    <div class="col-sm-6">
                        <label class="col-sm-12 col-form-label"><b>Tipo Gestión<small>*</small></b></label>
                        {!! Form::select('managementtype_id', ['' => 'Seleccione Tipo Gestión ATC...'], null, [
                            'id' => 'managementtype_id',
                            'class' => 'form-control',
                            'value' => old('managementtype_id'),
                        ]) !!}
                    </div>

                    <div class="col-sm-6">
                        <label class="col-sm-12 col-form-label"><b>Item Tipo Gestión<small>*</small></b></label>
                        {!! Form::select('mtypeitem_id', ['' => 'Seleccione Item Tipo Gestión ATC...'], null, [
                            'id' => 'mtypeitem_id',
                            'class' => 'form-control mtypeitem_id',
                            'value' => old('mtypeitem_id'),
                            'required' => 'required',
                        ]) !!}
                    </div>

                    <div class="col-sm-12">
                        <label for="observation_view" class="col-sm-12"><b>Observación Inicial*</b><br>
                            <span class="observation_view view"></span></label>
                    </div>

                    <div class="col-sm-6">
                        <label for="created_view" class="col-sm-12"><b>Generado</b><br>
                            <span class="created_view view"></span></label>
                    </div>

                    <div class="col-sm-6">
                        <label for="managementtype_view" class="col-sm-12"><b>Generado Por</b><br>
                            <span class="created_name_view view"></span></label>
                    </div>

                    <div class="col-sm-6">
                        <label for="updated_view" class="col-sm-12"><b>Procesado</b><br>
                            <span class="updated_view view"></span></label>
                    </div>

                    <div class="col-sm-6">
                        <label for="updated_name_view" class="col-sm-12"><b>Procesado Por</b><br>
                            <span class="updated_name_view view"></span></label>
                    </div>

                    <div class="col-sm-12">
                        <label for="observation_manager_view" class="col-sm-12"><b>Observación Gestión*</b><br>
                            <span class="observation_manager_view view"></span></label>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-sm-12">
                        <center>
                            <a href="#" title="Editar" id="change" name="change"
                                class="btn bt-sm btn-info">Editar</a>
                        </center>
                    </div>
                </div>
        </div>

        </form>
    </div>
</div>
