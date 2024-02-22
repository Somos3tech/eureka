<!-- modal content -->
<div id="contractsStatement" name="contractsStatement" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="contractsStatementsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-show']) !!}
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="showInvoiceLabel"><b>Estado de Cuenta x Contratos</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div id="statements-contracts" style="display:block;" class="box-body table-responsive">
                    <table id="statements-contracts-table" name="statements-contracts-table"
                        class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>
                                    <center>Acción</center>
                                </th>
                                <th>
                                    <center>No. Contrato</center>
                                </th>
                                <th>
                                    <center>Status Servicio</center>
                                </th>
                                <th>
                                    <center>Plan Servicio</center>
                                </th>
                                <th>
                                    <center>Serial Terminal</center>
                                </th>
                                <th>
                                    <center>Banco</center>
                                </th>
                                <th>
                                    <center>Balance</center>
                                </th>
                                <th>
                                    <center>Cargos</center>
                                </th>
                                <th>
                                    <center>Total Cargos ($)</center>
                                </th>
                                <th>
                                    <center>Abonos</center>
                                </th>
                                <th>
                                    <center>Total Abonos ($)</center>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
