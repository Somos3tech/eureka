<div id="collectionsView" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="collectionsViewLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-show']) !!}
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="collectionsViewLabel"><b>Información Detalle de Cobros</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="collections">
                        <div class="col-sm-12">
                        </div>
                        <div class="col-sm-12 p-2">
                            <table id="collections-detail" name="collections-detail"
                                class="table table-sm table-striped table-bordered table-responsive" cellspacing="1"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>No. Detalle</center>
                                        </th>
                                        <th>
                                            <center>No. Cobro</center>
                                        </th>
                                        <th>
                                            <center>Creado</center>
                                        </th>
                                        <th>
                                            <center>Concepto Contable</center>
                                        </th>
                                        <th>
                                            <center>Referencia</center>
                                        </th>
                                        <th>
                                            <center>Divisa</center>
                                        </th>
                                        <th>
                                            <center>Monto Divisa</center>
                                        </th>
                                        <th>
                                            <center>Cambio Divisa</center>
                                        </th>

                                        <th>
                                            <center>Monto Total</center>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
