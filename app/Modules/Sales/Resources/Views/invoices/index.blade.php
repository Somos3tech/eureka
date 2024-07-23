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

        .outlinenone {
            outline: none;
            background-color: #dfe;
            border: 0;
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
                        <div class="col-sm-12">
                            <center>
                                <div class="btn-group btn-sm">
                                    <button type="button" class="btn btn-sm btn-warning"
                                        style="color:white;">Filtro(s)</button>
                                    <button type="button" class="btn btn-sm btn-warning dropdown-toggle"
                                        data-toggle="dropdown" style="color:white;"></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a id="all" class="btn btn-sm  btn-default filter">Todos</a></li>
                                        <li><a id="cash" class="btn btn-sm btn-default filter">Efectivo</a></li>
                                        <div id="banks-button"></div>
                                    </ul>
                                </div>
                            </center>
                        </div>
                        <div class="col-sm-2">
                            <div class="btn-group btn-sm">
                                <button type="button" class="btn btn-sm btn-dark">Gestión</button>
                                <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown">
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a id="conciliate" class="btn btn-sm  btn-default filter">Cobros x Conciliar</a>
                                    </li>
                                    <li><a id="processed" class="btn btn-sm btn-default filter">Cobros Conciliados</a></li>
                                    <li><a id="report" class="btn btn-sm btn-default filter">Reporte</a></li>
                                    <div id="banks-button"></div>
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
                                                <center>Acción</center>
                                            </th>
                                            <th>
                                                <center>Documentos</center>
                                            </th>
                                            <th>
                                                <center>No. Cobro</center>
                                            </th>
                                            <th>
                                                <center>Creado</center>
                                            </th>
                                            <th>
                                                Status
                                            </th>
                                            <th>
                                                <center>Tipo Venta</center>
                                            </th>
                                            <th>
                                                <center>RIF</center>
                                            </th>
                                            <th>
                                                <center>Comercio</center>
                                            </th>
                                            <th>
                                                Almacén
                                            </th>
                                            <th>
                                                Banco
                                            </th>
                                            <th>
                                                Afiliado
                                            </th>
                                            <th>
                                                Modelo Terminal
                                            </th>
                                            <th>
                                                Método Pago
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
                                                Tarifa Cambio
                                            </th>
                                            <th>
                                                Monto Bs.
                                            </th>
                                            <th>
                                                Descuento
                                            </th>
                                            <th>
                                                Referencia
                                            </th>
                                            <th>
                                                Vendedor
                                            </th>
                                            <th>
                                                Aliado
                                            </th>
                                            <th>
                                                No. Contrato
                                            </th>
                                            <th>
                                                Observaciones
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

    <div id="invoiceConciliate" name="invoiceConciliate" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="invoiceConciliateLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="form-conciliate" name="form-conciliate"><input name="_token" type="hidden"
                        value="{{ csrf_token() }}" id="token">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="invoiceConciliateLabel"><b>Desea realizar la Conciliación del
                                Cobro?</b></h5> <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×</button>
                    </div>
                    {!! Form::hidden('id', null, ['id' => 'id']) !!}
                    {!! Form::hidden('contract_id_conciliation', null, ['id' => 'contract_id_conciliation']) !!}
                    {!! Form::hidden('payment_method', null, ['id' => 'payment_method']) !!}
                    {!! Form::hidden('statusc', null, ['id' => 'statusc']) !!}
                    <div class="modal-footer"><a href="#" $title="Conciliar" id="conciliation" name="conciliation"
                            class="btn bt-sm btn-info waves-effect waves-light">Conciliar</a></div>
                </form>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection
@include('sales::invoices.show')
@include('sales::invoices.csupport')

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>

    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function() {
            $('#invoices').show();
            var status = 'G';
            var action = 'basic';
            listInvoice(status, action);
            setInterval('$("#invoices-table").dataTable().fnDraw()',
                60000); //Socket Implementar para Actualizar Datatable
        });
        /**************************************************************************/
        var listInvoice = function(status, action) {
            var route = "/invoices/datatable?action=" + action + "&opc=conciliate&status=" + status;
            table = $('#invoices-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                autoWidth: false,
                ajax: route,
                columns: [{
                        data: "actions",
                        "className": "text-center",
                        "width": "10%"
                    },
                    {
                        data: "conciliation_doc",
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
                        data: "status",
                        "className": "text-center",
                    },
                    {
                        data: "type_dcustomer",
                        "className": "text-center"
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
                        data: "bank",
                        "className": "text-left"
                    },
                    {
                        data: "affiliate_number",
                        "className": "text-left"
                    },
                    {
                        data: "modelterminal",
                        "className": "text-left",
                    },
                    {
                        data: "tipnot",
                        "className": "text-left"
                    },
                    {
                        data: "type_sale",
                        "className": "text-left"
                    },
                    {
                        data: "currency_invoice",
                        "className": "text-left"
                    },
                    {
                        data: "amount_invoice",
                        "className": "text-left"
                    },
                    {
                        data: "dicom",
                        "className": "text-left"
                    },
                    {
                        data: "amount_total",
                        "className": "text-left"
                    },
                    {
                        data: "invoice_free",
                        "className": "text-left"
                    },
                    {
                        data: "refere",
                        "className": "text-left"
                    },
                    {
                        data: "user_name",
                        "className": "text-left",
                    },
                    {
                        data: "consultant_name",
                        "className": "text-left",
                    },
                    {
                        data: "contract_id",
                        "className": "text-left",
                    },
                    {
                        data: "obs",
                        "className": "text-left"
                    },

                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [],
                "order": [
                    [2, "asc"]
                ]
            });
            /************************************************************************/
            $('#all').on('click', function() {
                table.search('').columns().search('').draw();
            });
            /************************************************************************/
            $('#conciliate').on('click', function() {
                table.destroy();
                var action = 'basic';
                listInvoice('G', action);
            });
            /************************************************************************/
            $('#processed').on('click', function() {
                table.destroy();
                var action = 'basic';
                listInvoice('C', action);
            });
            /************************************************************************/
            $('#cash').on('click', function() {
                table.search('').columns().search('').draw();
                table.columns(12).search('Efectivo').draw();
            });
            /************************************************************************/
            $('#reset').on('click', function() {
                $('#invoices-table').DataTable().ajax.reload();
            });
            /************************************************************************/
            $.get('/banks/select', function(data) {
                $('#banks-button').empty();
                Object.keys(data).forEach(function(key) {
                    $('<li><a id="' + key + '" class="btn btn-sm btn-default filter">' + data[key]
                        .description + '</a></li>').prependTo('#banks-button');
                    $('#' + key).on('click', function() {
                        table.search('').columns().search('').draw();
                        table.columns(9).search(data[key].description).draw();
                    });
                });
            });
        }
        /**************************************************************************/
        var changeSupport = function(btn) {
            $("#contract_id").val(btn.value);
        }
        /********************Generar Soporte Administrativo************************/
        $("#csupport").click(function() {
            var contract_id = $("#contract_id").val();
            var type_support = $("#type_support").val();
            var observation = $("#observations").val();
            let data = {
                "contract_id": contract_id,
                "observation": observation,
                "type_support": type_support
            };
            var route = "{{ route('csupports.storetow') }}";
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
                    $('#changeSupport').modal('hide');
                    $('#invoices-table').DataTable().ajax.reload();
                    toastr.info("Registro Generado Correctamente")
                },
                error: function(data) {
                    $('#changeSupport').modal('hide');
                    $('#invoices-table').DataTable().ajax.reload();
                    toastr.warning("Error al Generar Registro")
                }
            });
        });
        /**************************************************************************/
        var InvoiceId = function(btn) {
            val = btn.value;
            var route = "/invoices/" + val + '?valid=1';
            $.get(route, function(data) {
                var cont = 0;
                $('#invoices-detail > tbody').empty();
                var tbl = document.getElementById("invoices-detail");
                var tblBody = document.createElement("tbody");
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
                        $("#created_contract").val(subInvoiceObj.fechpro);
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
                    }
                    cont++;
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
        /**************************************************************************/
        var InvoiceDocument = function(btn) {
            var id = btn.value;
            window.open("/invoices/view-document/" + id, 'Documento Soporte', 'width=800, height=400')
        }
        /**************************************************************************/
        var CustomerDocument = function(btn) {
            var id = btn.value;
            window.open("/customers/view-document/" + id, 'Documento Información Cliente', 'width=800, height=400')
        }
        /**************************************************************************/
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
        /**************************************************************************/
        var Conciliate = function(btn) {
            var arrayValue = btn.value;
            var value = arrayValue.split("|");
            $("#id").val(value[0]);
            $("#payment_method").val('Postpago');
            $("#statusc").val(value[2]);
            $("#contract_id_conciliation").val(value[3]);
        }

        $("#conciliation").click(function() {
            var id = $("#id").val();
            var payment_method = $("#payment_method").val();
            var contract_id = $("#contract_id_conciliation").val();
            var statusc = $("#statusc").val();
            let data = {
                "id": id,
                "payment_method": payment_method,
                "contract_id": contract_id,
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
                    toastr.info("Registro Conciliado Correctamente")
                },
                error: function(data) {
                    $('#invoiceConciliate').modal('hide');
                    toastr.error("Error al Conciliar registro")
                }
            });
        });
    </script>
@endsection
