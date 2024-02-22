<div id="uploadRcustomer" name="uploadRcustomer" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="uploadRcustomerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Cargar Documento Representante</b></h5> <button type="button" class="close"
                    data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rcustomers.upload') }}" class="dropzone" id="rcustomer-dropzone">
                    @csrf
                    <input id="rcustomer_id" name="rcustomer_id" class="rcustomer_id" type="hidden" />
                    <div class="fallback">
                        <input id="file_rcustomer" name="file_rcustomer" type="file" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
