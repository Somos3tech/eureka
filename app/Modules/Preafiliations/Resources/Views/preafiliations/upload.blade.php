<div id="uploadRif" name="uploadRif" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uploadRifLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento RIF</b></h5> <button type="button" class="close"
                    data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('preafiliations.upload.temp') }}" class="dropzone" id="rif-dropzone">
                    @csrf
                    <div class="fallback">
                        <input id="file_rif" name="file_rif" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="uploadMercantil" name="uploadMercantil" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="uploadMercantilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento Registro Mercantíl</b></h5> <button type="button"
                    class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('preafiliations.upload.temp') }}" class="dropzone" id="rm-dropzone">
                    @csrf
                    <div class="fallback">
                        <input id="file_rm" name="file_rm" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="uploadBank" name="uploadBank" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="uploadBankLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento Soporte Cuenta Bancaria</b></h5> <button type="button"
                    class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('preafiliations.upload.temp') }}" class="dropzone" id="bank-dropzone">
                    @csrf
                    <div class="fallback">
                        <input id="file_bank" name="file_bank" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="uploadAuthBank" name="uploadAuthBank" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="uploadAuthBankLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento Autorización Débito en Cuenta</b></h5> <button
                    type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('preafiliations.upload.temp') }}" class="dropzone" id="auth-bank-dropzone">
                    @csrf
                    <div class="fallback">
                        <input id="file_auth" name="file_auth" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="uploadPayment" name="uploadPayment" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="uploadPaymentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento Soporte Pago</b></h5> <button type="button"
                    class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('preafiliations.upload.temp') }}" class="dropzone" id="payment-dropzone">
                    @csrf
                    <div class="fallback">
                        <input id="file_payment" name="file_payment" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="uploadPaymentSale" name="uploadPayment" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="uploadPaymentSaleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento Soporte Pago</b></h5> <button type="button"
                    class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sales.upload') }}" class="dropzone" id="payment-dropzone">
                    @csrf
                    <div class="fallback">
                        <input id="file_payment" name="file_payment" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
