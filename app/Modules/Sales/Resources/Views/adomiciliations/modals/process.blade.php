<!-- modal content -->
<div id="processAdomiciliation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="processAdomiciliationLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      {!! Form::open(['id'=>'form']) !!}

      <input name="_token" type="hidden" value="{{ csrf_token() }}" id="token">

      <div class="modal-header">
        <h5 class="modal-title mt-0" id="myModalLabel">Desea Procesar Resultados Gestión Afiliación Bancario al Sistema?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>

      {!!form::hidden('process_id', null,['id'=>'process_id'])!!}

      <div class="modal-footer">
        {!!link_to('#',$title='Procesar Resultados', $attributes = ['id'=>'process', 'class'=>'btn bt-sm btn-dark'])!!}
      </div>

      {!!Form::close()!!}

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
