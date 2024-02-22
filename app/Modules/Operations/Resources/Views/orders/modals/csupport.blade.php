<div id="csupportManagement" name="csupportManagement" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="csupportManagement" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form id="form-csupport" name="form-csupport"><input name="_token" type="hidden" value="{{csrf_token() }}" id="token">
				<div class="modal-header">
					<h5 class="modal-title mt-0" id="myModalLabel"><b>Gestión Notificación x Cambios</b></h5> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>

					<div class="modal-body">
						{!!form::hidden('contract_id', null,['id'=>'contract_id'])!!}
						{!!form::hidden('order_id', null,['id'=>'order_id'])!!}
						{!!form::hidden('service_csupport', 'Csupport',['id'=>'service_csupport'])!!}

						<div class="col-sm-12">
							<label for="user" class="col-sm-12 col-form-label">Nombre Usuario*</label>
							{!!form::text('user',NULL,['id'=>'user','class'=>'form-control outlinenone','placeholder'=>'Ingrese Nombre Usuario','readonly' => true])!!}
						</div>

						<div class="col-sm-12">
							<label for="observation_request" class="col-sm-12 col-form-label">Observación Inicial*</label>
							{!!form::textarea('observation_request',NULL,['id'=>'observation_request','class'=>'form-control outlinenone','placeholder'=>'Ingrese Observación','rows' => 2,'readonly' => true])!!}
						</div>

					  <div class="col-sm-12">
								<label for="observation_response" class="col-sm-12 col-form-label">Observación Final*</label>
								{!!form::textarea('observation_response',NULL,['id'=>'observation_response','class'=>'form-control outlinenone blank','placeholder'=>'Ingrese Observación','rows' => 2,'required' => 'required'])!!}
            </div>

          </div>
          <div class="modal-footer">
          <div class="col-sm-12">
             <center><a href="#" title="Restaurar Gestión" id="csupport" name="csupport" class="btn bt-sm btn-info waves-effect waves-light">Notificar Ajustes</a></div></center>
          </div>
        </div>
    	</form>
		</div>
	</div>
