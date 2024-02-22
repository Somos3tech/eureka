@extends('layouts.compact-master')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('/assets/styles/vendor/sweetalert2.min.css') }}">
@endsection

@section('main-content')
    <div class="breadcrumb">
        <h1>{{ $identity ?? 'Dashboard' }}</h1>

    </div>

    <div class="separator-breadcrumb border-top"></div>

    <!-- Content-->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    {!! Form::open(['id' => 'form', 'route' => 'collections.destroy.collect', 'method' => 'POST']) !!}

                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-sm-2">
                            <label class="col-sm-12">&nbsp;</label>
                            {!! form::text('find', null, [
                                'id' => 'find',
                                'class' => 'form-control text-center rif clear',
                                'placeholder' => 'Ingrese No. Cobro',
                            ]) !!}
                        </div>

                        <div class="col-sm-1">
                            <label class="col-sm-12">&nbsp;</label>
                            <button type="button" name="find"
                                class="btn btn-sm btn-fill btn-dark find">Consultar</button>
                        </div>

                        <div class="col-sm-2 invoice" style="display:none;">
                            <label for="customer_id" class="col-sm-12"><b>Código</b></label>
                            {!! form::hidden('invoice_id', null, ['id' => 'invoice_id']) !!}
                            {!! form::hidden('contract_id', null, ['id' => 'contract_id']) !!}
                            {!! form::text('customer_id', null, [
                                'id' => 'customer_id',
                                'class' => 'form-control',
                                'placeholder' => 'Ingresar Código',
                                'readonly' => 'readonly',
                                'value' => old('customer_id'),
                                'required' => 'required',
                            ]) !!}
                        </div>

                        <div class="col-sm-2 invoice" style="display:none;">
                            <label for="rif" class="col-sm-12"><b>RIF</b></label>
                            {!! form::text('rif', null, [
                                'id' => 'rif',
                                'class' => 'form-control',
                                'placeholder' => 'Ingresar RIF',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-5 invoice" style="display:none;">
                            <label for="bussiness_name" class="col-sm-12"><b>Nombre Comercio</b></label>
                            {!! form::text('business_name', null, [
                                'id' => 'business_name',
                                'class' => 'form-control blank',
                                'placeholder' => 'Ingresar Nombre Comercial',
                                'readonly' => 'readonly',
                            ]) !!}
                        </div>

                        <div class="col-sm-12 invoice" style="display:none;">
                            <hr>
                            <h4><b>Detalle Cobro</b></h4>
                        </div>

                        <div class="col-sm-12 invoice" style="display:none;">
                            <table id="invoices-detail" name="invoices-detail"
                                class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>Fecha Cobro</center>
                                        </th>
                                        <th>
                                            <center>No. Cobro</center>
                                        </th>
                                        <th>
                                            <center>Status</center>
                                        </th>
                                        <th>
                                            <center>Contrato</center>
                                        </th>
                                        <th>
                                            <center>Concepto Cobro</center>
                                        </th>
                                        <th>
                                            <center>Divisa</center>
                                        </th>
                                        <th>
                                            <center>Vl. Divisa</center>
                                        </th>
                                        <th>
                                            <center>Vl.Cambio Divisa</center>
                                        </th>
                                        <th>
                                            <center>Total</center>
                                        </th>
                                        <th>
                                            <center>Generado Por</center>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-sm-12 collect" style="display:none;">
                            <hr>
                            <h4><b>Detalle Pago</b></h4>
                        </div>
                        <div class="col-sm-12 invoice" style="display:none;">
                            <table id="collections-detail" name="collections-detail"
                                class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>Fecha Pago</center>
                                        </th>
                                        <th>
                                            <center>No. Pago</center>
                                        </th>
                                        <th>
                                            <center>Conciliado Por</center>
                                        </th>
                                        <th>
                                            <center>No. Cobro</center>
                                        </th>
                                        <th>
                                            <center>No. Item</center>
                                        </th>
                                        <th>
                                            <center>Cta. Contable</center>
                                        </th>
                                        <th>
                                            <center>Referencia</center>
                                        </th>
                                        <th>
                                            <center>Divisa</center>
                                        </th>
                                        <th>
                                            <center>Vl. Equipo</center>
                                        </th>
                                        <th>
                                            <center>Vl. Cambio</center>
                                        </th>
                                        <th>
                                            <center>Total</center>
                                        </th>
                                        <th>
                                            <center>&nbsp;</center>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-sm-12 collect" style="display:none;">
                            <hr>
                        </div>
                        <div class="col-sm-12 collect" style="display:none;">
                            <center><button type="submit" class='btn btn-sm btn-info' name="Registrar">Anular Pago</button>
                            </center>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- Content-->
@endsection

@section('page-js')
    <script src="{{ asset('/assets/js/vendor/sweetalert2.min.js') }}"></script>

    @toastr_js
    @toastr_render

    <script type="text/javascript">
        $('.find').on('click', function(e) {
            var find = document.getElementById("find").value;
            if (find != '') {
                $.get('/invoices/' + find, function(data) {
                    if (data == '') {
                        $("#find").val('');
                        $(".detail").css('display', 'none');
                        swal('Error en la consulta', 'Por favor verifique No. Cobro e intenté de nuevo',
                            'warning');
                    } else {
                        $(".invoice").css('display', 'block');
                        $("#contract_id").val(data[0].contract_id);
                        $("#invoice_id").val(data[0].id);
                        $("#customer_id").val(data[0].customer_id);
                        $("#rif").val(data[0].rif);
                        $("#business_name").val(data[0].business_name);
                        /******************************************************************/
                        var currency = data[0].currency_invoice;
                        var id = data[0].id;
                        var total = 0;

                        $('#invoices-detail > tbody').empty();
                        var tbl = document.getElementById("invoices-detail");
                        var tblBody = document.createElement("tbody");

                        var fila = document.createElement("tr");
                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].fechpro);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].id);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        let div = document.createElement('div');
                        div.innerHTML = data[0].status;
                        celda.appendChild(div);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].contract_id);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].concept);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].currency_invoice);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].amount_invoice);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        if (data[0].amount_currency != null) {
                            var amount_currency = data[0].amount_currency;
                        } else {
                            var amount_currency = '----';
                        }

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(amount_currency);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].amount_total);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[0].user_name);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        tblBody.appendChild(fila);
                        tbl.appendChild(tblBody);
                        tbl.setAttribute("border", "2");
                        collectionDetail(currency, id);
                    }
                });
            } else {
                $("#find").val('');
                $(".detail").css('display', 'none');
                swal('Error en la consulta', 'Por favor verifique No. Cobro e intenté de nuevo', 'warning');
            }
        });
        /****************************************************************************/
        function collectionDetail(currency, id) {
            $('#collections-detail > tbody').empty();
            $.get('/collections/' + id, function(data) {
                if (data) {
                    $(".collect").css('display', 'block');
                    $('#collections-detail > tbody').empty();
                    var tbl = document.getElementById("collections-detail");
                    var tblBody = document.createElement("tbody");
                    var total = 0;

                    var amount = 0;
                    var dicom = 0;
                    var total_amount = 0;

                    for (var i = 0; i < data.length; i++) {
                        var fila = document.createElement("tr");
                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[i].fechpro);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[i].id);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[i].user);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[i].invoice_id);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        if (data[i].invoiceitem_id) {
                            var invoiceitem_id = data[i].invoiceitem_id;
                        } else {
                            var invoiceitem_id = '----';
                        }

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(invoiceitem_id);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[i].accounting);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[i].refere);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[i].currency);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[i].amount);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var data_amount = data[i].amount;
                        amount = parseFloat(amount) + parseFloat(data_amount.replaceAll(",", ""));

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[i].dicom);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(data[i].total_amount);
                        celda.appendChild(textoCelda);
                        celda.setAttribute('style', 'text-align :center;')
                        fila.appendChild(celda);

                        var data_total_amount = data[i].total_amount;
                        total_amount = parseFloat(total_amount) + parseFloat(data_total_amount.replaceAll(",", ""));

                        var celda = document.createElement("td");
                        var textoCelda = document.createElement("INPUT");
                        textoCelda.setAttribute("collection_id", "[]");
                        textoCelda.setAttribute("name", "collection_id[]");
                        textoCelda.setAttribute("type", "checkbox");
                        textoCelda.setAttribute("class", "checkbox check");

                        //textoCelda.setAttribute("onchange", "comprobar();");
                        textoCelda.setAttribute("checked", true);
                        textoCelda.value = parseFloat(data[i].id);
                        celda.appendChild(textoCelda);
                        fila.appendChild(celda);

                        tbl.setAttribute("border", "2");
                        tblBody.appendChild(fila);
                        tbl.appendChild(tblBody);
                    }

                    var fila = document.createElement("tr");
                    var celda = document.createElement("td");
                    celda.setAttribute('colspan', 7)
                    celda.setAttribute('style', 'text-align :right;')
                    let div = document.createElement('div');
                    div.innerHTML = '<b>Total Pago (Conciliado)</b>';
                    celda.appendChild(div);
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(currency);
                    celda.appendChild(textoCelda);
                    celda.setAttribute('style', 'text-align :center;')
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(number_format(amount, 2));
                    celda.appendChild(textoCelda);
                    celda.setAttribute('style', 'text-align :center;')
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode('----');
                    celda.appendChild(textoCelda);
                    celda.setAttribute('style', 'text-align :center;')
                    fila.appendChild(celda);

                    var celda = document.createElement("td");
                    var textoCelda = document.createTextNode(number_format(total_amount, 2));
                    celda.appendChild(textoCelda);
                    celda.setAttribute('style', 'text-align :center;')
                    fila.appendChild(celda);

                    tbl.setAttribute("border", "2");
                    tblBody.appendChild(fila);
                    tbl.appendChild(tblBody);
                } else {
                    $(".collect").css('display', 'none');
                    swal('Error en la consulta', 'No se registran Pagos por Anular', 'info');
                }
            });
        }

        function number_format(amount, decimals) {
            amount += ''; // por si pasan un numero en vez de un string
            amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

            decimals = decimals || 0; // por si la variable no fue fue pasada

            // si no es un numero o es igual a cero retorno el mismo cero
            if (isNaN(amount) || amount === 0)
                return parseFloat(0).toFixed(decimals);

            // si es mayor o menor que cero retorno el valor formateado como numero
            amount = '' + amount.toFixed(decimals);

            var amount_parts = amount.split('.'),
                regexp = /(\d+)(\d{3})/;

            while (regexp.test(amount_parts[0]))
                amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

            return amount_parts.join('.');
        }
    </script>
@endsection
