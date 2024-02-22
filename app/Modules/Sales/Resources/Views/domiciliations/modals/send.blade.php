<!-- modal content -->
<div id="sendDomiciliation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="sendDomiciliationLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      {!! Form::open(['id'=>'form']) !!}

      <input name="_token" type="hidden" value="{{ csrf_token() }}" id="token">

      <div class="modal-header">
        <h5 class="modal-title mt-0" id="myModalLabel">Enviar Gestión Servicio Cobranza Banco (Domiciliación)?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>

      {!!form::hidden('send_id', null,['id'=>'send_id'])!!}

      <div class="modal-footer">
        {!!link_to('#',$title='Enviar archivo', $attributes = ['id'=>'send', 'class'=>'btn bt-sm btn-warning', 'style'=>'color:white;'])!!}
      </div>

      {!!Form::close()!!}

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
