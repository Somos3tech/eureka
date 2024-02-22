<form><input id="preafiliation_id" name="preafiliation_id" type="hidden" /></form>
<div id="uploadRif" name="uploadRif" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
    aria-labelledby="uploadRifLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento RIF</b></h5> <button type="button" class="close"
                    data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('preafiliations.upload') }}" class="dropzone" id="rif-dropzone">
                    @csrf
                    <div class="fallback">
                        <input id="file_rif" name="file_rif" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="detailsRcustomer" name="detailsRcustomer" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
    aria-labelledby="detailsRcustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Carga Documentos Representante(s) Legal(es)</b></h5> <button type="button"
                    class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <table id="rcustomer-detail" name="rcustomer-detail"
                        class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
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
                                    <center>Movíl</center>
                                </th>
                                <th>
                                    <center>Acción</center>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="uploadMercantil" name="uploadMercantil" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
    aria-labelledby="uploadMercantilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento Registro Mercantíl</b></h5> <button type="button"
                    class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('preafiliations.upload') }}" class="dropzone" id="rm-dropzone">
                    @csrf
                    <div class="fallback">
                        <input id="file_rm" name="file_rm" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="uploadBank" name="uploadBank" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
    aria-labelledby="uploadBankLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento Soporte Cuenta Bancaria</b></h5> <button type="button"
                    class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('preafiliations.upload') }}" class="dropzone" id="bank-dropzone"
                    name="bank-dropzone">
                    @csrf
                    <div class="fallback">
                        <input id="file_bank" name="file_bank" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="uploadAuthBank" name="uploadAuthBank" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
    aria-labelledby="uploadAuthBankLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento Autorización Débito en Cuenta</b></h5> <button
                    type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('preafiliations.upload') }}" class="dropzone" id="auth-dropzone">
                    @csrf
                    <div class="fallback">
                        <input id="file_auth" name="file_auth" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="uploadPayment" name="uploadPayment" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
    aria-labelledby="uploadPaymentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento Soporte Pago</b></h5> <button type="button"
                    class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('preafiliations.upload') }}" class="dropzone" id="payment-dropzone">
                    @csrf
                    <div class="fallback">
                        <input id="file_payment" name="file_payment" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="uploadRcustomer" name="uploadRcustomer" class="modal fade" role="dialog"
    aria-labelledby="uploadRcustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento Representante Legal</b></h5> <button type="button"
                    class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('preafiliations.upload') }}" class="dropzone" id="rcustomer-dropzone">
                    @csrf
                    <input type="hidden" id="consec" name="consec">
                    <div class="fallback">
                        <input id="file_rcustomer" name="file_rcustomer" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
