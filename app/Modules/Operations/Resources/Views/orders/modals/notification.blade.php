<!-- modal content -->
<div id="uncheckOrder" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="uncheckOrderLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      {!! Form::open(['id'=>'form']) !!}

      <input name="_token" type="hidden" value="{{ csrf_token() }}" id="token">

      <div class="modal-header">
        <h5 class="modal-title mt-0" id="myModalLabel"> Solicitud de Parámetros a Credicard Sin Procesar?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>

      {!!form::hidden('id_uncheck', null,['id'=>'id_uncheck'])!!}

      <div class="modal-footer">
        {!!link_to('#',$title='Confirmar', $attributes = ['id'=>'uncheck', 'class'=>'btn bt-sm btn-secondary waves-effect waves-light'])!!}
      </div>

      {!!Form::close()!!}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
