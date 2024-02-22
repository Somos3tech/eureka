<script>
$(document).ready(function() {
  listcontract();
});

var listcontract = function() {
  var route = "/contracts/datatableUser/" + {!! (int)$customer->id !!};
  table = $('#contracts-table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: route,
    columns: [{
        data: "id",
        "className": "text-center"
      },
      {
        data: "created_at",
        "className": "text-center"
      },
      {
        data: "status",
        "className": "text-center"
      },
      {
        data: "document",
        "className": "text-center"
      },
      {
        data: "file_document",
        "className": "text-center"
      },
      {
        data: "company",
        "className": "text-center"
      },
      {
        data: "type_dcustomer",
        "className": "text-center"
      },
      {
        data: "bank_name",
        "className": "text-center",
        "searchable": false,
      },
      {
        data: "affiliate_number",
        "className": "text-center",
        "searchable": false,
      },
      {
        data: "is_affiliate",
        "className": "text-center",
        "searchable": false,
      },
      {
        data: "affiliate_date",
        "className": "text-center",
        "searchable": false,
      },
      {
        data: "mterminal",
        "className": "text-left",
        "width": "15%",
        "searchable": false,
      },
      {
        data: "terminal",
        "className": "text-center",
        "searchable": false,
      },
      {
        data: "operator",
        "className": "text-left",
        "searchable": false,
      },
      {
        data: "simcard",
        "className": "text-center",
        "searchable": false,
      },
      {
        data: "nropos",
        "className": "text-center"
      },
      {
        data: "term",
        "className": "text-center",
        "searchable": false,
      },
      {
        data: "rate_term",
        "className": "text-center",
        "searchable": false,
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
