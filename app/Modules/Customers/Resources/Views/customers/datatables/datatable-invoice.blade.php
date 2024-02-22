

<script>
  $(document).ready(function() {
    listinvoice();
  });


  var listinvoice = function() {
  var route = "/invoices/datatableUser?customer_id="+{!! (int)$customer->id !!};
  table = $('#invoices-table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: route,
    columns: [
      {
        data: "actions",
        "className": "text-center",
        "width": "20%"
      },
      {
        data: "id",
        "className": "text-center"
      },
      {
        data: "fechpro",
        "className": "text-center"
      },
      {
        data: "status",
        "className": "text-center"
      },
      {
        data: "company",
        "className": "text-center"
      },
      {
        data: "contract_id",
        "className": "text-center"
      },
      {
        data: "type_dcustomer",
        "className": "text-center"
      },
      {
        data: "modelterminal",
        "className": "text-center"
      },
      {
        data: "concept",
        "className": "text-center"
      },
      {
        data: "tipnot",
        "className": "text-center"
      },

      {
        data: "currency_invoice",
        "className": "text-center"
      },
      {
        data: "amount_invoice",
        "className": "text-center"
      },
      {
        data: "invoice_free",
        "className": "text-center"
      },
      {
        data: "amount_currency",
        "className": "text-center"
      },
      {
        data: "refere",
        "className": "text-center",
        "width": "20%"
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
