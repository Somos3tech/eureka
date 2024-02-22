@extends('layouts.compact-master')

@section('page-css')
<link rel="stylesheet" href="{{asset('/assets/styles/vendor/datatables.min.css')}}">
@toastr_css
<style>
th, td {
	font-size:13px;
}
</style>
@endsection

@section('main-content')
<div class="breadcrumb">
	<h1>{{$identity ?? 'Dashboard'}}</h1>
	<!--  <ul>
        <li><a href="">Starter</a></li>
        <li>Blank Page</li>
    </ul>-->
</div>

<div class="separator-breadcrumb border-top"></div>

<!-- Content-->
<div class="row">
	<div class="col-sm-12">
		<div class="card mb-4">
			<div class="card-body">
				<div class="col-sm-12 row">
					<div class="col-sm-12">
						<center>
							<div class="btn-group btn-sm">
								<button type="button" class="btn btn-sm btn-warning" style="color:white;">Status</button>
								<button type="button" class="btn btn-sm btn-warning dropdown-toggle" style="color:white;" data-toggle="dropdown">
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a id="pending" class="btn btn-sm btn-default filter">Pendiente</a></li>
									<li><a id="finish" class="btn btn-sm btn-default filter">Finalizado</a></li>
								</ul>
							</div>
						</center>
					</div>
					<div class="col-sm-2">
						@can('csupports.create','csupports.edit')
						<div class="btn-group btn-sm">
							<button type="button" class="btn btn-sm btn-dark">Gestión</button>
							<button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown">
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a id="create" class="btn btn-sm btn-default filter" data-toggle="modal" data-target="#csupportsCreate" href="#" style="color:black;"> Registrar</a></li>
								<li><a id="report" class="btn btn-sm btn-default filter" data-toggle="modal" data-target="#"  href="#" style="color:black;"> Reporte</a></li>
						</div>
						@endcan
					</div>
					<div class="col-sm-8">&nbsp;</div>
					<div class="col-sm-2">
						<div class="btn-group btn-sm">
							<a id="reset" class="btn btn-sm btn-warning" style="color: white;" title="Refrescar"><i class="fa fa-rotate-left"></i> Actualizar</a>
						</div>
					</div>
					<hr>
					<div id="csupports" style="display:block;" class="box-body table-responsive">
						<table id="csupports-table" name="csupports-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>
										<center>Acción</center>
									</th>
									<th>
										<center>Estado</center>
									</th>
									<th>
										<center>No. Soporte</center>
									</th>
									<th>
										<center>Fecha</center>
									</th>
									<th>
										<center>No. Contrato</center>
									</th>
									<th>
										<center>RIF</center>
									</th>
									<th>
										<center>Nombre Cliente</center>
									</th>
									<th>
										<center>Tipo Soporte</center>
									</th>
									<th>
										<center>Observaciones</center>
									</th>
									<th>
										<center>Vendedor</center>
									</th>
									<th>
										<center>Generado Por</center>
									</th>

								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Content-->
@endsection

@include('supports::csupports.create')
@include('supports::csupports.edit')
@include('supports::csupports.delete')
@include('supports::csupports.show')

@section('page-js')
<script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
<script src="{{asset('/assets/js/vendor/datatables.min.js')}}"></script>
@toastr_js
@toastr_render
<script>
	$(document).ready(function() {

		$('#csupports').show();
		listinvoice();
		table.search('').columns().search('').draw();
		table.columns(1).search('Generado').draw();
		setInterval('$("#csupports-table").dataTable().fnDraw()', 60000);
	});

	var listinvoice = function() {
		var route = "/csupports/datatable";
		table = $('#csupports-table').DataTable	({
			processing: true,
			serverSide: true,
    	responsive: true,
			pageLength: 10,
			ajax: route,
			columns: [
				{
					data: "actions",
					"className": "text-center"
				},
				{
					data: "status",
					"className": "text-center"
				},
				{
					data: "id",
					"className": "text-center"
				},
				{
					data: "created_at",
					"className": "text-center"
				},
				{
					data: "contract_id",
					"className": "text-center"
				},
				{
					data: "rif",
					"className": "text-center",
					"width": "15%"
				},
				{
					data: "business_name",
					"className": "text-left",
					"width": "15%"
				},
				{
					data: "type_support",
					"className": "text-center"
				},
				{
					data: "observation",
					"className": "text-left",
					"width": "15%"
				},
				{
					data: "user_sale",
					"className": "text-center"
				},
				{
					data: "user_support",
					"className": "text-center"
				},

			],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
			},
			dom: 'Bfrtip',
			buttons: [
			],
			"order": [
				[0, "desc"]
			]
		});
	}
	$('#pending').on('click', function() {
		table.search('').columns().search('').draw();
		table.columns(1).search('Generado').draw();
	});

	$('#finish').on('click', function() {
		table.search('').columns().search('').draw();
		table.columns(1).search('Finalizado').draw();
	});

	$('#reset').on('click', function () {
		$('#csupports-table').DataTable().ajax.reload();
	});

	/**********************Generar Soporte Administrativo************************/
	$("#create").click(function() {
		var contract_id = $("#contract_id").val();
		var type_support = $("#type_support").val();
		var observation = $("#observation").val();
		let data = {
			contract_id: contract_id,
			observation: observation,
			type_support: type_support
		};
		var route = "{{route('csupports.store')}}";
		var token = $("#token").val();

		$.ajax({
			headers: {
				'X-CSRF-TOKEN': token
			},
			type: 'POST',
			url: route,
			contentType: 'application/json',
			data: JSON.stringify(data), // access in body
			success: function(data) {
				$('#csupportsCreate').modal('hide');
				$("#form-create")[0].reset();
				$('#csupports-table').DataTable().ajax.reload();
			  toastr.info("Se ha Registrado Correctamente")
			},
			error: function(data) {
				var notification = '';
				$.each(data.responseJSON.errors, function(index, subOperatorObj) {
					if(notification != ''){
						notification = notification +'<li>'+subOperatorObj[0]+'</li>';
					}else{
						notification = '<li>'+subOperatorObj[0]+'</li>';
					}
				});
				toastr.error("Error el los siguientes Campos: </br>"+notification)
				$('#csupports-table').DataTable().ajax.reload();
			}
		});
	});
	/****************************************************************************/
	 var csupports = function(btn) {
			val = btn.value;
			var route = "{{url('csupports')}}/" + val;
			$.get(route, function(data) {

				$("#id").val(val);
				$("#contract_id_up option[value=" + data.contract_id + "]").attr("selected", true);
	      $("#type_support_up option[value=" + data.type + "]").attr("selected", true);
				$("#observation_up").val(data.observation);
			})
		}
		$("#update").click(function() {
			var id = $("#id").val();
			var observation_response = $("#observation_response").val();
			let data = {
				observation_response: observation_response,
			};
			var route = "/csupports/"+id;
			var token = $("#token").val();

			$.ajax({
				headers: {
					'X-CSRF-TOKEN': token
				},
				type: 'PUT',
				url: route,
				contentType: 'application/json',
				data: JSON.stringify(data), // access in body
				success: function(data) {
					$('#csupportsUpdate').modal('hide');
					$("#form-edit")[0].reset();
					$('#csupports-table').DataTable().ajax.reload();
					toastr.info("Gestión Realizada Correctamente")
				},
				error: function(data) {
					var notification = '';
					$.each(data.responseJSON.errors, function(index, subOperatorObj) {
						if(notification != ''){
							notification = notification +'<li>'+subOperatorObj[0]+'</li>';
						}else{
							notification = '<li>'+subOperatorObj[0]+'</li>';
						}
					});
					$('#csupports-table').DataTable().ajax.reload();
					toastr.error("Error el los siguientes Campos: </br>"+notification)
				}
			});
		});
	/****************************************************************************/
	var csupportsDelete = function(btn) {
	  $("#id").val(btn.value);
	}
	/****************************************************************************/
	$("#delete").click(function() {
	  var id = $("#id").val();
	  var route = "csupports/" + id + "";
	  var token = $("#token").val();

	  $.ajax({
	    url: route,
	    headers: {
	      'X-CSRF-TOKEN': token
	    },
	    type: 'DELETE',
	    dataType: 'json',
			success: function(data) {
				$("#csupportsDelete").modal("hide");
				toastr.info("Registro Eliminado Correctamente")
				$('#csupports-table').DataTable().ajax.reload();
			},
			error: function(data) {
				$("#csupportsDelete").modal("hide");
        toastr.warning("Error al Eliminar Registro")
				$('#csupports-table').DataTable().ajax.reload();
			}
	  });
	});
  /****************************************************************************/
  /*var contract_id_up = $("#contract_id_up").val();
        $('.contract_id').empty();
            $('.contract_id').append("<option value='"+contract_id_up+"'>"+contract_id_up+"</option>");*/
</script>
<script>
    jQuery(document).ready(function () {
	$('.only-number').on('input', function () {
		this.value = this.value.replace(/[^0-9]/g, '');
	});
});

</script>
@endsection
