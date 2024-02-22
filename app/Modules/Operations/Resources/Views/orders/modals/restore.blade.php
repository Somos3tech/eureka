<div id="restoreManagement" name="restoreManagement" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="restoreManagement" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form id="form-restore" name="form-restore"><input name="_token" type="hidden" value="{{csrf_token() }}" id="token">
				<div class="modal-header">
					<h5 class="modal-title mt-0" id="myModalLabel"><b>Restaurar Gestión Programación</b></h5> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>

					<div class="modal-body">
						{!!form::hidden('contract_id', null,['id'=>'contract_id'])!!}
						{!!form::hidden('order_id', null,['id'=>'order_id'])!!}
						{!!form::hidden('type_service', 'Management',['id'=>'type_service'])!!}
            <div class="col-sm-12">
              {!!form::select('type_support',[''=>'Seleccione Tipo Gestión...','restore'=>'Liberar Equipo'],null,['id'=>'type_support','class'=>'form-control']) !!}
            </div>
          </div>

          <div class="modal-footer">
          <div class="col-sm-12">
             <center><a href="#" title="Restaurar Gestión" id="restore" name="restore" class="btn bt-sm btn-info waves-effect waves-light">Restaurar Gestión</a></div></center>
          </div>
        </div>
    	</form>
		</div>
	</div>
