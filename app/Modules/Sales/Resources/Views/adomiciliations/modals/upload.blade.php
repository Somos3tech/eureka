<!-- modal content -->
<div id="uploadResponseAdomiciliation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uploadResponseAdomiciliationLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="mt-0 m-b-30 header-title"><b>Cargar Archivo Respuesta Afiliación Bancaria</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <div class="col-sm-12">

            <form action="{{route('adomiciliations.upload.response')}}" class="dropzone" id="response-dropzone">
              @csrf
              {!!form::hidden('upload_id', null,['id'=>'upload_id'])!!}
              <div class="fallback">
                <input id="file_response" name="file_response" type="file" />
            </form>
          </div>
      </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
