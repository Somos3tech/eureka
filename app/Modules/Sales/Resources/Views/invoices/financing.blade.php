@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
    @toastr_css
    <style>
        th,
        td {
            font-size: 13px;
        }

        .btn {
            border: none;
        }
    </style>
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>

    </div>
    <div class="separator-breadcrumb border-top"></div>
    <!-- Content-->
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="col-sm-12 row">
                        <div class="col-sm-2">
                            <div class="btn-group btn-sm">
                                <button type="button" class="btn btn-sm btn-dark">Gestión</button>
                                <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown">
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a id="pending" class="btn btn-sm btn-default filter">Cobros x Conciliar</a></li>
                                    <li><a id="restore" class="btn btn-sm btn-default filter">Cobros Conciliados</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-8">&nbsp;</div>
                        <div class="col-sm-2">
                            <div class="btn-group pull-right">
                                <a id="reset" class="btn btn-sm btn-warning" style="color: white;" title="Actualizar"><i
                                        class="fa fa-rotate-left"></i> Actualizar</a>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div id="invoices" style="display:block;" class="box-body table-responsive">
                                <table id="invoices-table" name="invoices" class="table table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>Acciones</center>
                                            </th>
                                            <th>
                                                <center>No. Item Cobro</center>
                                            </th>
                                            <th>
                                                <center>No. Cobro</center>
                                            </th>
                                            <th>
                                                <center>Creado</center>
                                            </th>
                                            <th>
                                                <center>RIF</center>
                                            </th>
                                            <th>
                                                <center>Nombre Comercio</center>
                                            </th>
                                            <th>
                                                <center>Almacén Venta</center>
                                            </th>
                                            <th>
                                                <center>Tipo Afiliado</center>
                                            </th>
                                            <th>
                                                <center>No. Afiliado</center>
                                            </th>
                                            <th>
                                                <center>Banco</center>
                                            </th>
                                            <th>
                                                <center>Modelo Terminal</center>
                                            </th>
                                            <th>
                                                <center>Método Pago</center>
                                            </th>
                                            <th>
                                                <center>No. Cuota</center>
                                            </th>
                                            <th>
                                                <center>Divisa</center>
                                            </th>
                                            <th>
                                                <center>Monto Cobro</center>
                                            </th>
                                            <th>
                                                <center>Dicom Cobro</center>
                                            </th>
                                            <th>
                                                <center>Total Cobro</center>
                                            </th>
                                            <th>
                                                <center>Monto Cuota</center>
                                            </th>
                                            <th>
                                                <center>Cantidad Cuotas</center>
                                            </th>
                                            <th>
                                                <center>Dicom Hoy</center>
                                            </th>
                                            <th>
                                                <center>Total Cuota Bs.</center>
                                            </th>
                                            <th>
                                                <center>Cuotas Pagadas</center>
                                            </th>
                                            <th>
                                                <center>Cuotas Pendientes</center>
                                            </th>
                                            <th>
                                                <center>Status</center>
                                            </th>
                                            <th>
                                                <center>No. Contrato</center>
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
    </div>
    <!-- Content-->
@endsection
@include('sales::invoices.show')
@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#invoices').show();
            listinvoice();
            setInterval('$("#invoices-table").dataTable().fnDraw()', 120000);
        });
        var listinvoice = function() {
            var route = "/invoices/datatableFinancing";
            table = $('#invoices-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: route,
                columns: [{
                        data: "actions",
                        "className": "text-center"
                    },
                    {
                        data: "invoiceitem_id",
                        "className": "text-center",
                    },
                    {
                        data: "id",
                        "className": "text-center",
                    },
                    {
                        data: "created_at",
                        "className": "text-center",
                    },
                    {
                        data: "rif",
                        "className": "text-center"
                    },
                    {
                        data: "business_name",
                        "className": "text-left",
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
                        data: "affiliate_number",
                        "className": "text-center"
                    },
                    {
                        data: "bank",
                        "className": "text-center"
                    },
                    {
                        data: "modelterminal",
                        "className": "text-center"
                    },
                    {
                        data: "tipnot",
                        "className": "text-center"
                    },
                    {
                        data: "item",
                        "className": "text-center",
                        "width": "12%"
                    },
                    {
                        data: "abrev",
                        "className": "text-center"
                    },
                    {
                        data: "amount",
                        "className": "text-center"
                    },
                    {
                        data: "dicom",
                        "className": "text-center"
                    },
                    {
                        data: "total_amount",
                        "className": "text-center"
                    },
                    {
                        data: "amount_quota",
                        "className": "text-center"
                    },
                    {
                        data: "quota",
                        "className": "text-center"
                    },
                    {
                        data: "dicom_new",
                        "className": "text-center"
                    },
                    {
                        data: "total_quota",
                        "className": "text-center"
                    },
                    {
                        data: "success",
                        "className": "text-center"
                    },
                    {
                        data: "pending",
                        "className": "text-center"
                    },
                    {
                        data: "status",
                        "className": "text-center"
                    },
                    {
                        data: "contract_id",
                        "className": "text-center"
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [],
                "order": [
                    [2, "asc"],
                    [12, "asc"]
                ]
            });

            $('#reset').on('click', function() {
                $('#invoices-table').DataTable().ajax.reload();
            });
        }

        var DcustomerId = function(btn) {
            var val = btn.value;
            var route = "/dcustomers/find?affiliate_number=" + val;

            $.get(route, function(data) {
                $('#dcustomers-detail > tbody').empty();
                var tbl = document.getElementById("dcustomers-detail");
                var tblBody = document.createElement("tbody");
                $.each(data, function(index, subDcustomerObj) {
                    var fila = document.createElement("tr");

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subDcustomerObj.rif);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subDcustomerObj.business_name);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subDcustomerObj.affiliate_number);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subDcustomerObj.bank);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subDcustomerObj.type_account);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subDcustomerObj.account_number);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    tblBody.appendChild(fila);
                    tbl.appendChild(tblBody);
                    tbl.setAttribute("border", "2");
                });
            });
        }


        var InvoiceId = function(btn) {
            val = btn.value;
            var route = "/invoices/" + val;
            $.get(route, function(data) {
                $('#invoices-detail > tbody').empty();
                var tbl = document.getElementById("invoices-detail");
                var tblBody = document.createElement("tbody");
                var cont = 0;
                $.each(data, function(index, subInvoiceObj) {
                    if (cont == 0) {
                        $("#customer_id").val(subInvoiceObj.customer_id);
                        $("#affiliate_number").val(subInvoiceObj.affiliate_number);
                        $("#rif").val(subInvoiceObj.rif);
                        $("#business_name").val(subInvoiceObj.business_name);
                        $("#bank").val(subInvoiceObj.bank);
                        $("#state").val(subInvoiceObj.state);
                        $("#city").val(subInvoiceObj.city);
                        $("#address").val(subInvoiceObj.address);
                        $("#postal_code").val(subInvoiceObj.postal_code);
                        $("#telephone").val(subInvoiceObj.telephone);
                        $("#mobile").val(subInvoiceObj.mobile);
                        $("#email").val(subInvoiceObj.email);
                        $("#journey").val(subInvoiceObj.journey);
                        $("#created_contract").val(subInvoiceObj.created_contract);
                        $("#contract").val(subInvoiceObj.contract_id)
                        $("#company").val(subInvoiceObj.company);
                        $("#term").val(subInvoiceObj.term);
                        $("#modelterminal").val(subInvoiceObj.modelterminal);
                        $("#operator").val(subInvoiceObj.operator);
                        $("#currency_contract").val(subInvoiceObj.currency_contract);
                        $("#amount_contract").val(subInvoiceObj.amount_contract);
                        $("#status_contract").val(subInvoiceObj.status_contract);
                        $("#observation_contract").val(subInvoiceObj.obs);
                        $("#user_name").val(subInvoiceObj.user_name);
                        $("#consultant_name").val(subInvoiceObj.consultant_name);

                        var fila = document.createElement("tr");

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subInvoiceObj.id);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subInvoiceObj.receipt_id);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subInvoiceObj.created_at);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subInvoiceObj.tipnot);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subInvoiceObj.refere);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subInvoiceObj.currency_invoice);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subInvoiceObj.amount_invoice);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subInvoiceObj.free);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(subInvoiceObj.status_invoice);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        tblBody.appendChild(fila);
                        tbl.appendChild(tblBody);
                        tbl.setAttribute("border", "2");

                        cont++;
                    }
                });

                var route = "/invoiceitems/" + val;

                $.get(route, function(data) {
                    if (data.length > 0) {
                        $(".invoiceitem").css('display', 'block');
                        $('#invoiceitems-detail > tbody').empty();
                        var tbl = document.getElementById("invoiceitems-detail");
                        var tblBody = document.createElement("tbody");

                        $.each(data, function(index, subInvoiceItemObj) {

                            var fila = document.createElement("tr");

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceItemObj.id);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceItemObj.fechpro);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceItemObj.item);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceItemObj.concept);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceItemObj
                                .currency);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceItemObj.amount);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceItemObj
                                .amount_currency);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceItemObj
                                .date_expire);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            var celda = document.createElement("td");
                            var textoCelda = document.createTextNode(subInvoiceItemObj.status);
                            celda.appendChild(textoCelda);
                            fila.appendChild(celda);

                            tblBody.appendChild(fila);
                            tbl.appendChild(tblBody);
                            tbl.setAttribute("border", "2");
                        });
                    } else {
                        $(".invoiceitem").css('display', 'none');
                    }
                });

            });
        }
    </script>
@endsection
