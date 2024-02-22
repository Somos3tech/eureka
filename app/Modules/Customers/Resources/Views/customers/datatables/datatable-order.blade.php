<script>
	$(document).ready(function() {
		listorders();
	});

	var listorders = function() {
		var route = "/orders/datatableUser/" + {!! (int)$customer->id !!};
		table = $('#orders-table').DataTable({
			processing: true,
			serverSide: true,
			responsive: true,
			ajax: route,
			columns: [{
					data: "id",
					"className": "text-center"
				},
				{
					data: "created_order",
					"className": "text-center"
				},
				{
					data: "status_order",
					"className": "text-center"
				},
				{
					data: "contract_id",
					"className": "text-center"
				},
				{
					data: "modelterminal",
					"className": "text-left"
				},
				{
					data: "terminal",
					"className": "text-left"
				},
				{
					data: "nropos",
					"className": "text-center"
				},
				{
					data: "operator",
					"className": "text-left",
				},
				{
					data: "simcard",
					"className": "text-left"
				},
				{
					data: "posted",
					"className": "text-center"
				},
				{
					data: "date_send",
					"className": "text-center"
				},
				{
					data: "type_posted",
					"className": "text-center"
				},
				{
					data: "number_control",
					"className": "text-center"
				},
				{
					data: "observ_posted",
					"className": "text-center"
				},
			],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
			},
			dom: 'Bfrtip',
			buttons: [
			]
		});
	}
</script>
