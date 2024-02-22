<!-- modal content -->
<div id="checkOrder" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="checkOrderLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      {!! Form::open(['id'=>'form-check']) !!}

      <input name="_token" type="hidden" value="{{ csrf_token() }}" id="token">

      <div class="modal-header">
        <h5 class="modal-title mt-0" id="myModalLabel"><b>Confirmar Solicitud de Parámetros a Credicard Procesada?</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>

      {!!form::hidden('id_check', null,['id'=>'id_check'])!!}

      <div class="modal-footer">
        {!!link_to('#',$title='Confirmar', $attributes = ['id'=>'check', 'class'=>'btn bt-sm btn-dark'])!!}
      </div>

      {!!Form::close()!!}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
