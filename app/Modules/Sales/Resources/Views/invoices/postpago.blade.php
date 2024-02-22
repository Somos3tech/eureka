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
                                            <center>Tipo Afiliación</center>
                                        </th>
                                        <th>
                                            <center>Nombre Banco</center>
                                        </th>
                                        <th>
                                            <center>No. Afiliado</center>
                                        </th>
                                        <th>
                                            Modelo Terminal
                                        </th>
                                        <th>
                                            Método Pago>
                                        </th>
                                        <th>
                                            Tipo Venta
                                        </th>
                                        <th>
                                            Divisa
                                        </th>
                                        <th>
                                            Monto
                                        </th>
                                        <th>
                                            Tassa Cambio
                                        </th>
                                        <th>
                                            Monto Bs.
                                        </th>
                                        <th>
                                            Descuento
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Referencia
                                        </th>
                                        <th>
                                            Observaciones
                                        </th>
                                        <th>
                                            No. Contrato
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
@include('sales::invoices.show')
@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#invoices').show();
            var status = 'G';
            listinvoice(status);
        });

        var listinvoice = function(status) {
            var route = "/invoices/datatable?action=postpago&opc=conciliate&status=P";
            table = $('#invoices-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: route,
                columns: [{
                        data: "actions",
                        "className": "text-center",
                        "width": "10%"
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
                        "className": "text-center",
                    },
                    {
                        data: "business_name",
                        "className": "text-left",
                    },
                    {
                        data: "company",
                        "className": "text-left",
                    },
                    {
                        data: "type_dcustomer",
                        "className": "text-left",
                    },
                    {
                        data: "bank",
                        "className": "text-center"
                    },
                    {
                        data: "affiliate_number",
                        "className": "text-center"
                    },
                    {
                        data: "modelterminal",
                        "className": "text-left",
                    },
                    {
                        data: "tipnot",
                        "className": "text-center"
                    },
                    {
                        data: "type_sale",
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
                        data: "dicom",
                        "className": "text-center"
                    },
                    {
                        data: "amount_total",
                        "className": "text-center"
                    },
                    {
                        data: "invoice_free",
                        "className": "text-center"
                    },
                    {
                        data: "status",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "refere",
                        "className": "text-center"
                    },
                    {
                        data: "obs",
                        "className": "text-center"
                    },
                    {
                        data: "contract_id",
                        "className": "text-center",
                    },
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [],
                "order": [
                    [2, "desc"]
                ]
            });

            $('#restore').on('click', function() {
                table.destroy();
                listinvoice('C');
            });
            $('#pending').on('click', function() {
                table.destroy();
                listinvoice('P');
            });
            $('#reset').on('click', function() {
                $('#invoices-table').DataTable().ajax.reload();
            });
            /******************************************************************************/
            $.get('/banks/select', function(data) {
                $('#banks-button').empty();
                Object.keys(data).forEach(function(key) {
                    $('<li><a id="' + key + '" class="btn btn-sm btn-default filter">' + data[key]
                        .description + '</a></li>').prependTo('#banks-button');
                    $('#' + key).on('click', function() {
                        table.search('').columns().search('').draw();
                        table.columns(7).search(data[key].description).draw();
                    });
                });
            });
        }
        var InvoiceDocument = function(btn) {
            var id = btn.value;
            window.open("/invoices/view-document/" + id, 'Documento Soporte', 'width=800, height=400')
        }
        var Conciliate = function(btn) {
            var arrayValue = btn.value;
            var value = arrayValue.split("|");
            $("#id").val(value[0]);
        }
        $("#conciliation").click(function() {
            var id = $("#id").val();
            var payment_method = $("#payment_method").val();
            var statusc = $("#statusc").val();
            let data = {
                "id": id,
                "payment_method": payment_method,
                "statusc": statusc
            }

            var route = '/invoices/api/' + id + '';
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
                    $('#invoiceConciliate').modal('hide');
                    $('#invoices-table').DataTable().ajax.reload();
                    var alert = document.getElementById('info');
                    document.getElementById("info").innerHTML = "";
                    $('<strong>' + data.message + '</strong>').prependTo('#info');
                    alert.style.display = 'block';
                    $("#info").fadeIn(1500);
                    $("#info").fadeOut(5000);
                },
                error: function(data) {
                    $('#invoiceConciliate').modal('hide');
                    $('#invoices-table').DataTable().ajax.reload();
                }
            });
        });
        var CustomerDocument = function(btn) {
            var id = btn.value;
            window.open("/customers/view-document/" + id, 'Documento Información Cliente', 'width=800, height=400')
        }
        var InvoiceId = function(btn) {
            val = btn.value;
            var route = "/invoices/" + val + '?valid=1';
            $.get(route, function(data) {
                $('#invoices-detail > tbody').empty();
                var tbl = document.getElementById("invoices-detail");
                var tblBody = document.createElement("tbody");
                $.each(data, function(index, subInvoiceObj) {
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
                    $("#currency_invoice").val(subInvoiceObj.currency_invoice);
                    $("#amount_invoice").val(subInvoiceObj.amount_invoice);
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
                    var textoCelda = document.createTextNode(subInvoiceObj.invoice_free);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subInvoiceObj.status_invoice);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    tblBody.appendChild(fila);
                    tbl.appendChild(tblBody);
                    tbl.setAttribute("border", "2");
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
