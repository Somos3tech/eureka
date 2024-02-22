<!-- modal content -->
<div id="deleteAdomiciliation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteAdomiciliationLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      {!! Form::open(['id'=>'form']) !!}

      <input name="_token" type="hidden" value="{{ csrf_token() }}" id="token">

      <div class="modal-header">
        <h5 class="modal-title mt-0" id="myModalLabel">Desea Anular Gestión Servicio Afiliación?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>

      {!!form::hidden('id', null,['id'=>'id'])!!}

      <div class="modal-footer">
        {!!link_to('#',$title='Eliminar', $attributes = ['id'=>'delete', 'class'=>'btn bt-sm btn-danger'])!!}
      </div>

      {!!Form::close()!!}

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
