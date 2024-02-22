@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
    <style>
        th,
        td {
            font-size: 13px;
        }

        .outlinenone {
            outline: none;
            background-color: #dfe;
            border: 0;
        }

        .nav-tabs .nav-item .nav-link {
            border: 0;
            padding: 0.5rem;
        }
    </style>
    @toastr_css
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>

    </div>

    <div class="separator-breadcrumb border-top"></div>

    <!-- Content-->
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="customer-icon-pill" data-toggle="pill" href="#customer_item"
                            role="tab" aria-controls="customerPIll" aria-selected="true"><b>Básica</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="documents-icon-pill" data-toggle="pill" href="#documents_item"
                            role="tab" aria-controls="documentsPIll" aria-selected="false"><b>Documentación</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dcustomer-icon-pill" data-toggle="pill" href="#dcustomer_item"
                            role="tab" aria-controls="dcustomerPIll" aria-selected="false"><b>Afiliaciones</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rcustomer-icon-pill" data-toggle="pill" href="#rcustomer_item"
                            role="tab" aria-controls="rcustomerPIll" aria-selected="false"><b>Representantes</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contract-icon-pill" data-toggle="pill" href="#contract_item" role="tab"
                            aria-controls="contractPIll" aria-selected="false"><b>Contratos</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="invoice-icon-pill" data-toggle="pill" href="#invoice_item" role="tab"
                            aria-controls="invoicePIll" aria-selected="false"><b>Cobros</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="operation-icon-pill" data-toggle="pill" href="#operation_item"
                            role="tab" aria-controls="operationPIll" aria-selected="false"><b>Servicios</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="contact-icon-pill" data-toggle="pill" href="#" role="tab"
                            aria-controls="contactPIll" aria-selected="true"><b>Estado Cuenta</b></a>
                    </li>
                </ul>

                <div class="tab-content" id="myPillTabContent">
                    <div class="tab-pane fade show active" id="customer_item" role="tabpanel">
                        <table class="table table-striped" width="100%" border="0">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Código</center>
                                    </th>
                                    <th width="15%">
                                        <center>Profit</center>
                                    </th>
                                    <th width="15%">
                                        <center>RIF</center>
                                    </th>
                                    <th colspan="2">
                                        <center>Nombre Comercial</center>
                                    </th>
                                    <th colspan="2">
                                        <center>Actividad Comercial</center>
                                    </th>
                                    <th>
                                        <center>Tipo Contribuyente</center>
                                    </th>
                                    <th>
                                        <center>% Retención IVA</center>
                                    </th>
                                </tr>
                            </thead>
                            <tr>
                                <td>
                                    <center>{!! $customer->id !!}</center>
                                </td>
                                <td>
                                    <center>{!! $customer->foreign_id !!}</center>
                                </td>
                                <td>
                                    <center>{!! $customer->rif !!}</center>
                                </td>
                                <td colspan="2">
                                    <center>{!! $customer->business_name !!}</center>
                                </td>
                                <td colspan="2">
                                    <center>{!! $customer->com_activity !!}</center>
                                </td>
                                <td>
                                    <center>{!! $customer->type_contd !!}</center>
                                </td>
                                <td>
                                    <center>{!! $customer->tax !!} 0%</center>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-striped" width="100%" border="0">
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        @if ($customer->fiscal == 0)
                                            <center>Dirección Residencia</center>
                                        @else
                                            <center>Dirección Residencia / Dirección Fiscal</center>
                                        @endif
                                    </th>
                                    <th>
                                        <center>Estado</center>
                                    </th>
                                    <th>
                                        <center>Ciudad</center>
                                    </th>
                                    <th>
                                        <center>Municipalidad</center>
                                    </th>
                                    <th>
                                        <center>Código Postal</center>
                                    </th>
                                </tr>
                            </thead>
                            <tr>
                                <td colspan="6">
                                    <center>{!! $customer->address !!}</center>
                                </td>
                                <td>
                                    <center>{!! $customer->state !!}</center>
                                </td>
                                <td>
                                    <center>{!! $customer->city !!}</center>
                                </td>
                                <td>
                                    <center>{!! $customer->municipality !!}</center>
                                </td>
                                <td>
                                    <center>{!! $customer->postal_code !!}</center>
                                </td>
                            </tr>
                            @if ($customer->fiscal)
                                <thead>
                                    <tr>
                                        <th colspan="6">
                                            <center>Dirección Fiscal</center>
                                        </th>
                                        <th>
                                            <center>Estado</center>
                                        </th>
                                        <th>
                                            <center>Ciudad</center>
                                        </th>
                                        <th>
                                            <center>Municipalidad</center>
                                        </th>

                                        <th>
                                            <center>Código Postal</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td colspan="6">
                                        <center>{!! $customer->address_fiscal !!}</center>
                                    </td>
                                    <td>
                                        <center>{!! $customer->state_fiscal !!}</center>
                                    </td>
                                    <td>
                                        <center>{!! $customer->city_fiscal !!}</center>
                                    </td>
                                    <td>
                                        <center>{!! $customer->municipality_fiscal !!}</center>
                                    </td>
                                    <td>
                                        <center>{!! $customer->postal_code_fiscal !!}</center>
                                    </td>
                                </tr>
                            @endif
                        </table>
                        <table class="table table-striped" width="100%" border="0">
                            <thead>
                                <tr>
                                    <th colspan="5">
                                        <center>Registro Mercantil</center>
                                    </th>
                                    <th>
                                        <center>Fecha Registro</center>
                                    </th>
                                    <th>
                                        <center>No. Registro</center>
                                    </th>
                                    <th>
                                        <center>Tomo</center>
                                    </th>
                                    <th>
                                        <center>Cláusula Delegatoria</center>
                                    </th>
                                    <th>
                                        <center>Ciudad Registro</center>
                                    </th>
                                </tr>
                            </thead>
                            <tr>
                                <td colspan="5">
                                    <center>{!! $customer->comercial_register !!}</center>
                                </td>
                                <td>
                                    <center>{!! date('Y-m-d', strtotime($customer->date_register)) !!}</center>
                                </td>
                                <td>
                                    <center>{!! $customer->number_register !!}</center>
                                </td>
                                <td>
                                    <center>{!! $customer->took_register !!}</center>
                                </td>
                                <td>
                                    <center>{!! $customer->clause_register !!}</center>
                                </td>
                                <td>
                                    <center>{!! $customer->city_register !!}</center>
                                </td>
                            </tr>
                        </table>

                        <table class="table table-striped" width="100%" border="0">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <center>Email</center>
                                    </th>
                                    <th colspan="2">
                                        <center>Telefono</center>
                                    </th>
                                    <th colspan="2">
                                        <center>Movíl</center>
                                    </th>
                                    <th colspan="2">
                                        <center>Creado</center>
                                    </th>
                                    <th colspan="2">
                                        <center>Actualizado</center>
                                    </th>
                                </tr>
                            </thead>
                            <tr>
                                <td colspan="2">
                                    <center>{!! $customer->email !!}</center>
                                </td>
                                <td colspan="2">
                                    <center>{!! $customer->telephone !!} </center>
                                </td>
                                <td colspan="2">
                                    <center>{!! $customer->mobile !!}</center>
                                </td>

                                <td colspan="2">
                                    <center>{!! $customer->user !!} - {!! $customer->created_at !!}</center>
                                </td colspan="2">
                                <td>
                                    <center>{!! $customer->userup !!} - {!! $customer->updated_at !!}</center>
                                </td>
                            </tr>
                        </table>
                        <div class="text-right">
                            <a href="javascript:window.history.back();" title="Volver" class="btn btn-sm btn-dark"
                                style="color: white;">&nbsp;&nbsp;Volver&nbsp;&nbsp;</a>
                            @can('customers.edit')
                                <a class="btn btn-sm btn-warning" style="color:white;"
                                    href="/customers/{!! $customer->id !!}/edit" title="Actualizar Información Cliente"><i
                                        class="fa fa-edit"></i> Actualizar</a>
                            @endcan
                        </div>
                    </div>

                    <div class="tab-pane fade" id="dcustomer_item" role="tabpanel">
                        @include('customers::dcustomers.header-datatable')
                    </div>
                    <div class="tab-pane fade" id="rcustomer_item" role="tabpanel">
                        @include('customers::rcustomers.header-datatable')
                    </div>
                    <div class="tab-pane fade" id="contract_item" role="tabpanel">
                        @include('customers::customers.datatables.header-contract')
                    </div>
                    <div class="tab-pane fade" id="invoice_item" role="tabpanel">
                        @include('customers::customers.datatables.header-invoice')
                    </div>
                    <div class="tab-pane fade" id="operation_item" role="tabpanel">
                        @include('customers::customers.datatables.header-order')
                    </div>
                    <div class="tab-pane fade" id="documents_item" role="tabpanel">
                        @include('customers::customers.documents')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection
<!--------------------------------------------------------------------------->
@include('customers::dcustomers.create')
@include('customers::dcustomers.edit')
@include('customers::dcustomers.delete')
<!--------------------------------------------------------------------------->
@include('customers::rcustomers.create')
@include('customers::rcustomers.edit')
@include('customers::rcustomers.delete')
<!--------------------------------------------------------------------------->
@section('page-js')
    <script src="{{ asset('/assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    @toastr_js
    @toastr_render
    <!--------------------------------------------------------------------------->
    @include('customers::rcustomers.datatable')
    <!--------------------------------------------------------------------------->
    @include('customers::dcustomers.datatable')
    <!--------------------------------------------------------------------------->
    @include('customers::customers.datatables.datatable-contract')
    <!--------------------------------------------------------------------------->
    @include('customers::customers.datatables.datatable-invoice')
    @include('customers::customers.show-invoiceitems')
    @include('sales::collections.show')
    <!--------------------------------------------------------------------------->
    @include('customers::customers.datatables.datatable-order')

    @include('customers::customers.filters')
    @include('customers::customers.upload')
    @include('customers::rcustomers.upload')

    <script src="{{ asset('/assets/js/vendor/dropzone.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>

    <script>
        Dropzone.options.rifDropzone = {
            autoProcessQueue: true,
            maxFilesize: 1,
            maxFiles: 1,
            addRemoveLinks: true,
            dictRemoveFile: "Eliminar",
            dictCancelUpload: "Eliminar",
            dictDefaultMessage: "<h4 class='sbold'>Suelte los archivos PDF aquí  o haga clic para cargar los documentos<h4>",
            init: function() {
                var submitBtn = document.querySelector("#rif-dropzone");
                myDropzone = this;

                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('rif', "{!! $customer->rif !!}");
                    formData.append('type_document', 'rif');
                });

                this.on("success",
                    function(file, result) {
                        file.serverId = result;
                        $("#uploadRif").modal("hide");
                        $("#image_rif").empty();
                        $("#image_rif").prepend("<img src='/assets/images/upload-success.png' width='35%'>");
                        $("#response-rif").empty();
                        $("#response-rif").prepend(
                            '<button class="btn btn-sm btn-info" href="#" data-toggle="modal" OnClick="documentFile(this);" value="' +
                            result + '" data-target="#viewDocument"><b>Ver</b></button>');
                        toastr.info("Documento Rif Cargado Correctamente al Sistema")
                        Dropzone.removeAllFiles(true);
                    }
                );

                this.on("removedfile", function(file) {
                    if (!file.serverId) {
                        return;
                    }
                    $.get('/customers/remove?type_document=rif&path=' + file.serverId);
                    $("#uploadRif").modal("hide");
                    $("#image_rif").empty();
                    $("#image_rif").prepend("<img src='/assets/images/upload-pdf.png' width='35%'>");
                    $("#response-rif").empty();
                    toastr.info("Documento Rif Removido Correctamente")
                });
            }
        };
        Dropzone.options.rmDropzone = {
            autoProcessQueue: true,
            maxFilesize: 1,
            maxFiles: 1,
            addRemoveLinks: true,
            dictRemoveFile: "Eliminar",
            dictCancelUpload: "Eliminar",
            dictDefaultMessage: "<h4 class='sbold'>Suelte los archivos PDF aquí  o haga clic para cargar los documentos<h4>",
            init: function() {
                var submitBtn = document.querySelector("#rm-dropzone");
                myDropzone = this;
                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('rif', "{!! $customer->rif !!}");
                    formData.append('type_document', 'rm');
                });
                this.on("success",
                    function(file, result) {
                        file.serverId = result;
                        document.getElementById("rm_path").value = result;
                        $("#uploadMercantil").modal("hide");
                        $("#image_rm").empty();
                        $("#image_rm").prepend("<img src='/assets/images/upload-success.png' width='35%'>");
                        $("#response-rm").empty();
                        $("#response-rm").prepend(
                            '<button class="btn btn-sm btn-info" href="#" data-toggle="modal" OnClick="documentFile(this);" value="' +
                            result + '" data-target="#viewDocument"><b>Ver</b></button>');
                        toastr.info("Documento Registro Mercantíl Cargado Correctamente al Sistema")
                    });
                this.on("removedfile", function(file) {
                    if (!file.serverId) {
                        return;
                    }
                    $.get('/customers/remove?type_document=rm&path=' + file.serverId);
                    $("#uploadMercantil").modal("hide");
                    $("#image_rm").empty();
                    $("#image_rm").prepend("<img src='/assets/images/upload-pdf.png' width='35%'>");
                    $("#response-rm").empty();
                    toastr.info("Documento Registro Mercantíl Removido Correctamente")
                });
            }
        };
        Dropzone.options.bankDropzone = {
            autoProcessQueue: true,
            maxFilesize: 1,
            maxFiles: 1,
            addRemoveLinks: true,
            dictRemoveFile: "Eliminar",
            dictCancelUpload: "Eliminar",
            dictDefaultMessage: "<h4 class='sbold'>Suelte los archivos PDF aquí  o haga clic para cargar los documentos<h4>",
            init: function() {
                var submitBtn = document.querySelector("#bank-dropzone");
                myDropzone = this;

                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('rif', "{!! $customer->rif !!}");
                    formData.append('type_document', 'bank');
                });
                this.on("success",
                    function(file, result) {
                        file.serverId = result;
                        $("#uploadBank").modal("hide");
                        $("#image_bank").empty();
                        $("#image_bank").prepend("<img src='/assets/images/upload-success.png' width='35%'>");
                        $("#response-bank").empty();
                        $("#response-bank").prepend(
                            '<button class="btn btn-sm btn-info" href="#" data-toggle="modal" OnClick="documentFile(this);" value="' +
                            result + '" data-target="#viewDocument"><b>Ver</b></button>');
                        toastr.info("Documento Soporte Bancario Cargado Correctamente al Sistema")
                    });
                this.on("removedfile", function(file) {
                    if (!file.serverId) {
                        return;
                    }
                    $.get('/customers/remove?type_document=bank&path=' + file.serverId);
                    $("#uploadBank").modal("hide");
                    $("#image_bank").empty();
                    $("#image_bank").prepend("<img src='/assets/images/upload-pdf.png' width='35%'>");
                    $("#response-bank").empty();
                    toastr.info("Documento Soporte Bancario Removido Correctamente")
                });
            }
        };
        Dropzone.options.authBankDropzone = {
            autoProcessQueue: true,
            maxFilesize: 1,
            maxFiles: 1,
            addRemoveLinks: true,
            dictRemoveFile: "Eliminar",
            dictCancelUpload: "Eliminar",
            dictDefaultMessage: "<h4 class='sbold'>Suelte los archivos PDF aquí  o haga clic para cargar los documentos<h4>",
            init: function() {
                var submitBtn = document.querySelector("#auth-bank-dropzone");
                myDropzone = this;

                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('rif', "{!! $customer->rif !!}");
                    formData.append('type_document', 'auth-bank');
                });
                this.on("success", function(file, result) {
                    file.serverId = result;
                    $("#uploadAuthBank").modal("hide");
                    $("#image_auth_bank").empty();
                    $("#image_auth_bank").prepend(
                        "<img src='/assets/images/upload-success.png' width='35%'>");
                    $("#response-auth-bank").empty();
                    $("#response-auth-bank").prepend(
                        '<button class="btn btn-sm btn-info" href="#" data-toggle="modal" OnClick="documentFile(this);" value="' +
                        result + '" data-target="#viewDocument"><b>Ver</b></button>');
                    toastr.info("Documento Autorización Débito en Cuenta Cargado Correctamente al Sistema")
                });
                this.on("removedfile", function(file) {
                    if (!file.serverId) {
                        return;
                    }
                    $.get('/customers/remove?type_document=auth-bank&path=' + file.serverId);
                    $("#uploadAuthBank").modal("hide");
                    $("#image_auth_bank").empty();
                    $("#image_auth_bank").prepend("<img src='/assets/images/upload-pdf.png' width='35%'>");
                    $("#response-auth-bank").empty();
                    toastr.info("Documento  Autorización Débito en Cuenta Removido Correctamente")
                });
            }
        };

        Dropzone.options.contractDropzone = {
            autoProcessQueue: true,
            maxFilesize: 1,
            maxFiles: 20,
            addRemoveLinks: true,
            dictRemoveFile: "Eliminar",
            dictCancelUpload: "Eliminar",
            dictDefaultMessage: "<h4 class='sbold'>Suelte los archivos PDF aquí  o haga clic para cargar los documentos<h4>",
            init: function() {
                var submitBtn = document.querySelector("#contract-dropzone");
                myDropzone = this;

                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('rif', "{!! $customer->rif !!}");
                    formData.append('type_document', 'contract');
                    formData.append('contract_id', document.getElementById("contract_id").value);
                });

                this.on("success",
                    function(file, result) {
                        file.serverId = result;
                        $("#uploadContract").modal("hide");
                        $("#rif-dropzone")[0].reset();
                        $('#contracts-table').DataTable().ajax.reload();
                        toastr.info("Documento Contrato Formalizado Cargado Correctamente al Sistema")
                    }
                );
                this.on("complete", function(file) {
                    $(".dz-preview").remove();
                });
                this.on("removedfile", function(file) {
                    if (!file.serverId) {
                        return;
                    }
                    $.get('/customers/remove?type_document=contract&path=' + file.serverId);
                    $("#uploadRif").modal("hide");
                    toastr.info("Documento Contrato Formalizado Removido Correctamente")
                });
            }
        };

        Dropzone.options.rcustomerDropzone = {
            autoProcessQueue: true,
            maxFilesize: 1,
            maxFiles: 1,
            addRemoveLinks: true,
            dictRemoveFile: "Eliminar",
            dictCancelUpload: "Eliminar",
            dictDefaultMessage: "<h4 class='sbold'>Suelte los archivos PDF aquí  o haga clic para cargar los documentos<h4>",
            init: function() {
                var submitBtn = document.querySelector("#rcustomer-dropzone");
                myDropzone = this;

                submitBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on('sending', function(file, xhr, formData) {
                    formData.append('rif', "{!! $customer->rif !!}");
                    formData.append('rcustomer_id', $(".rcustomer_id").val());
                });
                this.on("success", function(file, result) {
                    file.serverId = result;
                    $("#uploadRcustomer").modal("hide");
                    $('#rcustomers-table').DataTable().ajax.reload();
                    toastr.info("Documento de Representante Cargado Correctamente al Sistema")
                });
                this.on("removedfile", function(file) {
                    $('#rcustomers-table').DataTable().ajax.reload();
                    $.get("/rcustomers/remove?rif={!! $customer->rif !!}&rcustomer_id=" + $(
                        ".rcustomer_id").val());
                    $("#uploadRcustomer").modal("hide");
                    toastr.info("Documento Representante Removido Correctamente")
                });
            }
        };
        /****************************************************************************/
        var collectionsShow = function(btn) {
            var id = btn.value;
            $.get('/collections/' + id, function(data) {
                $(".collections").css('display', 'block');
                $('#collections-detail > tbody').empty();
                var tbl = document.getElementById("collections-detail");
                var tblBody = document.createElement("tbody");
                $.each(data, function(index, subCollectionObj) {
                    var fila = document.createElement("tr");
                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subCollectionObj.id);
                    celda.setAttribute('style', 'text-align :center;')
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subCollectionObj.invoice_id);
                    celda.setAttribute('style', 'text-align :center;')
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subCollectionObj.fechpro);
                    celda.setAttribute('style', 'text-align :center;')
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subCollectionObj.accounting);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subCollectionObj.refere);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subCollectionObj.currency);
                    celda.setAttribute('style', 'text-align :center;')
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subCollectionObj.amount);
                    celda.setAttribute('style', 'text-align :center;');
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subCollectionObj.dicom);
                    celda.setAttribute('style', 'text-align :center;');
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subCollectionObj.total_amount);
                    celda.setAttribute('style', 'text-align :center;');
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    tblBody.appendChild(fila);
                    tbl.appendChild(tblBody);
                    tbl.setAttribute("border", "2");
                });
            });
        }
        /****************************************************************************/
        var invoiceitemsShow = function(btn) {
            var id = btn.value;
            $.get('/invoiceitems/' + id, function(data) {
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
                    var textoCelda = document.createTextNode(subInvoiceItemObj.currency);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subInvoiceItemObj.amount);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subInvoiceItemObj.amount_currency);
                    celda.appendChild(textoCelda);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(subInvoiceItemObj.date_expire);
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
            });
        }
        /****************************************************************************/
        var InvoiceDocument = function(btn) {
            var id = btn.value;
            window.open("/invoices/view-document/" + id, 'Documento Soporte', 'width=800, height=400')
        }
        /****************************************************************************/
        var documentFile = function(btn) {
            var path_file = btn.value;
            window.open("/customers/view-document/" + path_file, 'Documento Cliente', 'width=800, height=400')
        }
        /****************************************************************************/
        var documentRcustomer = function(btn) {
            $(".rcustomer_id").val(btn.value);
        }
        /*******************************Check List***********************************/
        $('.valid').on('change', function(e) {
            var type_document = e.target.name;
            var customer_id = {!! (int) $customer->id !!};
            if (e.target.checked) {
                var check = 1;
            } else {
                var check = 0;
            }
            swal({
                title: "Válidación Documentos(Físico)",
                text: "Desea procesar validación CheckList Documento Físico?",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#003473",
                confirmButtonText: "Validar",
                cancelButtonText: "Cancelar"
            }).then(function(isConfirm) {
                /* Read more about isConfirmed, isDenied below */
                if (isConfirm) {
                    swal({
                        text: "<center><h3><b>Por favor espera un momento....</b></h3><h4>Estamos válidando en nuestro Sistema</h4><p><div class='spinner-bubble spinner-bubble-primary m-5'></div></p></center>",
                        content: true,
                        showCancelButton: false, //There won't be any cancle button
                        showConfirmButton: false //There won't be any confirm butt
                    });

                    var route = "{{ route('customers.checklist') }}";
                    var token = "{{ csrf_token() }}";
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        type: 'POST',
                        url: route,
                        dataType: 'json',
                        data: {
                            customer_id: customer_id,
                            type_document: type_document,
                            check: check
                        },
                        success: function(data) {
                            if (data) {
                                swal.close();
                                e.target.value = 1;
                                toastr.info("Documento  con Válidación Confirmada ó Inactivada")
                            } else {
                                swal.close();
                                e.target.checked = false;
                                e.target.value = 0;
                                toastr.warning(
                                    "Documento sin Válidación Confirmada ó Inactivada")
                            }
                        },
                        error: function(data) {
                            swal.close();
                            e.target.checked = false;
                            e.target.value = 0;
                            toastr.warning("Documento sin Válidación Confirmada ó Inactivada")
                        }
                    });
                }
            }, function(dismiss) {
                if (dismiss === 'cancel' || dismiss === 'close') {
                    e.target.checked = false;
                    e.target.value = 0;
                    toastr.warning("Documento sin Válidación Confirmada ó Inactivada")
                }
            });
        });

        /****************************************************************************/
        var uploadContract = function(btn) {
            document.getElementById("contract_id").value = btn.value;
        }
    </script>
@endsection
