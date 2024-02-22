<!-- modal content -->
<div id="showInvoiceItem" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
    aria-labelledby="showInvoiceItemLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-show']) !!}
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Información Cobro(s) Generados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="invoiceitem">
                        <div class="col-sm-12 p-2">
                            <table id="invoiceitems-detail" name="invoiceitems-detail"
                                class="table table-striped table-bordered table-responsive" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>No. Detalle</center>
                                        </th>
                                        <th>
                                            <center>Creado</center>
                                        </th>
                                        <th>
                                            <center>Item</center>
                                        </th>
                                        <th>
                                            <center>Refer.</center>
                                        </th>
                                        <th>
                                            <center>Divisa</center>
                                        </th>
                                        <th>
                                            <center>Monto</center>
                                        </th>
                                        <th>
                                            <center>Dycom</center>
                                        </th>
                                        <th>
                                            <center>Pago Limite</center>
                                        </th>
                                        <th>
                                            <center>Status</center>
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
