<!-- modal content -->
<div id="preafiliationsUpdate" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="preafiliationsUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-valid']) !!}
            <input name="_token" type="hidden" value="{{ csrf_token() }}" id="token">
            <div class="modal-header">
                <h4 class="modal-title mt-0" id="myModalLabel"><b>Validaciones Pre-Afiliación</span></b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    {!! form::hidden('id', null, ['id' => 'id']) !!}


                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h5 class="mt-0 m-b-20 header-title"><b>Información Básica Cliente</b>
                                                </h5>
                                            </div>
                                            <div class="col-sm-4">
                                                <center><span class="col-sm-12 col-form-label"><b>RIF</b></span><br>
                                                    <span id="document_views" name="document_views"
                                                        class="preafiliations_views"></span>
                                                </center>
                                            </div>
                                            <div class="col-sm-4">
                                                <center><span class="col-sm-12 col-form-label"><b>Almacén</b></span><br>
                                                    <span id="company_views" name="company_views"
                                                        class="preafiliations_views"></span>
                                                </center>
                                            </div>
                                            <div class="col-sm-4">
                                                <center><span class="col-sm-12 col-form-label"><b>Razón
                                                            Social</b></span><br>
                                                    <span id="business_name_views" name="business_name_views"
                                                        class="preafiliations_views"></span>
                                                </center>
                                            </div>
                                            <hr>
                                            <div class="col-sm-4">
                                                <center><span class="col-sm-12 col-form-label"><b>Actividad
                                                            Comercial</b></span><br>
                                                    <span id="cactivity_views" name="cactivity_views"
                                                        class="preafiliations_views"></span>
                                                </center>
                                            </div>
                                            <div class="col-sm-4">
                                                <center><span class="col-sm-12 col-form-label"><b>Email</b></span><br>
                                                    <span id="email_views" name="email_views"
                                                        class="preafiliations_views"></span>
                                                </center>
                                            </div>
                                            <div class="col-sm-4">
                                                <center><span class="col-sm-12 col-form-label"><b>Movíl</b></span><br>
                                                    <span id="mobile_views" name="mobile_views"
                                                        class="preafiliations_views"></span>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 form-group mb-3">
                                            <h5><b>Validación Documentos Representante Legal</b></h5>
                                        </div>
                                        <div class="col-sm-12 p-2">
                                            <center>
                                                <table id="rm-detail-views" name="rm-detail-views"
                                                    class="table table-striped table-bordered" cellspacing="0"
                                                    width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <center>No. Documento</center>
                                                            </th>
                                                            <th>
                                                                <center>Nombre Completo</center>
                                                            </th>
                                                            <th>
                                                                <center>Cargo</center>
                                                            </th>
                                                            <th>
                                                                <center>Email</center>
                                                            </th>
                                                            <th>
                                                                <center>Móvil</center>
                                                            </th>
                                                            <th>
                                                                <center>Documento</center>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </center>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 row">
                        <div class="col-sm-12">
                            <h5><b>Validación Documentación</b></h5>
                            <br>
                        </div>
                        <div class="col-md-1 form-group mb-2">&nbsp;</div>
                        <div class="col-md-2 form-group mb-3">
                            <center>

                                <label class="switch switch-primary">
                                    <span><b>Documento RIF</b></span>
                                    <center><input id="is_rif" name="is_rif" type="checkbox" class="valid">
                                        <span class="slider"></span>
                                    </center>
                                </label><br><br>
                                <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" value=""
                                    onclick="CustomerDocument(this)" class="view-document"><i class="i-File-Cloud"></i>
                                    Doc. RIF</button>
                            </center>
                        </div>

                        <div class="col-md-2 form-group mb-2">
                            <center>
                                <label class="switch switch-primary mr-3">
                                    <span><b>Mercantíl</b></span>
                                    <input id="is_mercantil" name="is_mercantil" type="checkbox" class="valid">
                                    <span class="slider"></span>
                                </label><br><br>
                                <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" value=""
                                    onclick="CustomerDocument(this)" class="view-document"><i
                                        class="i-File-Cloud"></i>Reg.Mercantíl</button>
                            </center>
                        </div>

                        <div class="col-md-2 form-group mb-2">
                            <center>
                                <label class="switch switch-primary mr-3">
                                    <span><b>Cuenta Bancaria</b></span>
                                    <input id="is_bank" name="is_bank" type="checkbox" class="valid">
                                    <span class="slider"></span>
                                </label><br><br>
                                <button class="btn btn-sm btn-danger" type="button" data-toggle="modal"
                                    value="" onclick="CustomerDocument(this)" class="view-document"><i
                                        class="i-File-Cloud"></i>Cuenta Bancaria</button>
                            </center>
                        </div>

                        <div class="col-md-2 form-group mb-2">
                            <center>
                                <label class="switch switch-primary mr-3">
                                    <span><b>Débito Cuenta</b></span>
                                    <input id="is_auth_bank" name="is_auth_bank" type="checkbox" class="valid">
                                    <span class="slider"></span>
                                </label><br><br>
                                <button class="btn btn-sm btn-danger" type="button" data-toggle="modal"
                                    value="" onclick="CustomerDocument(this)" class="view-document"><i
                                        class="i-File-Cloud"></i>Debito Cuenta</button>
                            </center>
                        </div>

                        <div class="col-md-2 form-group mb-2">
                            <center>
                                <label class="switch switch-primary mr-3">
                                    <span><b>Soporte Pago</b></span>
                                    <input id="is_payment" name="is_payment" type="checkbox" class="valid">
                                    <span class="slider"></span>
                                </label><br><br>
                                <button class="btn btn-sm btn-danger" type="button" data-toggle="modal"
                                    value="" onclick="CustomerDocument(this)" class="view-document"><i
                                        class="i-File-Cloud"></i>Soporte Pago</button>
                            </center>
                        </div>


                        {{-- <div class="col-md-12">
                            <h5><b>Observaciones</b></h5>
                            <br>
                        </div>

                        <div class="col-md-9 form-group mb-3">
                            {!! Form::textarea('observations', null, ['id' => 'observations', 'class' => 'form-control', 'placeholder' => 'Ingrese Observaciones', 'disabled' => 'disabled']) !!}
                        </div> --}}

                        <div class="col-sm-3 form-group mb-3 valid-document">
                            <label class="mr-3"><b>Estado Pre-Afiliación</b></label>
                            {!! form::select('status_preafiliation', ['Cargado' => 'Cargado'], null, [
                                'id' => 'status_preafiliation',
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-md-12 row">
                        <div class="col-md-12 form-group mb-3">
                            <center>
                                <a href="#" title="Validar Información" id="valid-preafiliation"
                                    name="valid-preafiliation" class="btn bt-sm btn-info ">Válidar Información</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
