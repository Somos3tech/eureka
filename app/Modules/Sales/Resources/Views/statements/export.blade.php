<!DOCTYPE html>
<?php
setlocale(LC_TIME, 'es_ES');
?>
<html>

<head>
    <title>Estado de Cuenta - {{ $customer['rif'] }}</title>
    <style type="text/css" media="all">
        td,
        .hidden {
            border: hidden;
        }

        table {
            border: 1px solid #000000;
        }

        .text {
            font-family: Sans-serif;
        }
    </style>
</head>

<body>
    <table id="header" style="width:100%;" border="0" class="hidden">
        <tr>
            <td colspan="4">
                <img src="{{ public_path('assets/images/logo-document.png') }}" alt="" width="180px">
            </td>
            <td colspan="2">
                &nbsp;
            </td>
            <td colspan="4" width="20%">
                <p class="text" style="margin:-0.2% 0;" align="right">
                    <font size="16px">J-41102444-9</b></font>
                </p>
                <p class="text" style="margin:-0.2% 0;" align="right">
                    <font size="14px"><a href="http://www.vepagos.com">www.vepagos.com</a></font>
                </p>
                <p class="text" style="margin:-0.2% 0;" align="right">
                    <font size="14px"><a href="#">cobranzarl@vepagos.com</a></font>
                </p>
            </td>
        </tr>
    </table>
    <table id="header-info" style="width:100%;" border="0" class="hidden">
        <tr>
            <td colspan="4" width="60%">
                <p class="text" style="margin:0% 0;" align="left">
                    <font size="20px">Cliente:</b></font>
                </p>
                <p class="text" style="margin:0% 0;" align="left">
                    <font size="13px">{{ $customer['rif'] }}</font>
                </p>
                <p class="text" style="margin:0% 0;" align="left">
                    <font size="13px">{{ $customer['business_name'] }}</a></font>
                </p>
                <p class="text" style="margin:0% 0;" align="left">
                    <font size="13px">{{ $customer['address'] }}</a></font>
                </p>
                <p class="text" style="margin:0% 0;" align="left">
                    <font size="13px">{{ $customer['mobile'] }}</a></font>
                </p>
            </td>

            <td colspan="4" width="40%">
                <p class="text" style="margin:0% 0;" align="left">
                    <font size="13px"><b>Modelo: </b> {{ $customer['modelterminal'] }}</font>
                </p>
                <p class="text" style="margin:0% 0;" align="left">
                    <font size="13px"><b>Serial: </b> {{ $customer['terminal'] }}</font>
                </p>
                <p class="text" style="margin:0% 0;" align="left">
                    <font size="13px"><b>Plan: </b> {{ $customer['term'] }}(USD &nbsp;{{ $customer['rate'] }}) -
                        {{ $customer['type_invoice'] }}</font>
                </p>
                <p class="text" style="margin:0% 0;" align="left">
                    <font size="13px"><b>Fecha:</b> {{ date_format(now(), 'd M. Y') }}</font>
                </p>
            </td>
        </tr>
    </table>
    <center>
        <h4 class="text"><b>
                <font>Resumen de Movimientos
                    {{ array_key_exists('date', $request) && $request['date'] != '' ? $request['date'] : '' }}
                </font><b></h4>
    </center>
    <table id="body" style="width:100%;" border="0" class="hidden">
        <tr>
            <th>
                <font class="text" size="12px" align="center"><b>Concepto</b></font>
            </th>
            <th>
                <font class="text" size="12px" align="center"><b>Fecha</b></font>
            </th>
            <th>
                <font class="text" size="12px" align="center"><b>Cargos</b></font>
            </th>
            <th>
                <font class="text" size="12px" align="center"><b>Descripción de Pago</b></font>
            </th>
            <th>
                <font class="text" size="12px" align="center"><b>Fecha de Pago</b></font>
            </th>
            <th>
                <font class="text" size="12px" align="center"><b>Abonos</b></font>
            </th>
            <th>
                <font class="text" size="12px" align="center"><b>Balance</b></font>
            </th>
        </tr>
        <tr>
            <th>
                <font class="text" size="11px" align="center"><b>Balance Anterior</b></font< /th>
            <th>
                <font class="text" size="11px" align="center" style="white-space:nowrap;">
                    <b>{{ date('t-m-Y', strtotime($previousmonth)) }}</b>
                </font>
            </th>
            <th>
                <font class="text" size="11px" align="center"><b>$ {{ $previousinvoice['cargos'] }}</b>
                </font>
            </th>
            <th>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">&nbsp;</font>
                </p>
            </th>
            <th>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">&nbsp;</font>
                </p>
            </th>
            <th>
                <font class="text" size="11px" align="center"><b>$
                        {{ $previousinvoice['abonos'] == null ? '0.00' : $previousinvoice['abonos'] }}</b>
                </font>
            </th>
            <th>
                <font class="text" size="11px" align="center">
                    <b>$ {{ $previousinvoice['cargos'] - $previousinvoice['abonos'] }}</b>
                </font>
            </th>
        </tr>
        <?php
      $balance = 0;
      $abonos = 0;
      $cargos = 0;
      foreach ($data as $row) {
        if($row['amount_currency']=='----'){
            $amount_currency = '0,00';
        }else{
            $amount_currency = number_format($row['amount_currency'], 2, '.', ',');
        }
        $balance_individual = 0;
        $abono_individual = 0;
        $payment_date = strtotime($row['payment_date']) > 0 ? date('d-m-Y', strtotime($row['payment_date'])) : '----';
        if($row['type_abrev'] == 'C'||$row['type_abrev'] == 'E'||$row['type_abrev'] == 'N'){
            $cargos += $row['amount'];
            $abono_individual = $row['amount'].' (Bs. '.$amount_currency.')';
            // $balance = $balance + $row['amount'];
            // $abonos = $abonos + $row['amount'];
            $abonos = $abonos + $row['amount'];
        }elseif($row['type_abrev'] == 'P'||$row['type_abrev'] == 'G'||$row['type_abrev'] == 'R'){
            $cargos += $row['amount'];
            // $balance_individual = $row['amount'];
            $balance += $row['amount'];
            $abono_individual = '----';
        }
      ?>

        <tr>
            <td>
                <p class="text" style="margin:0.2% 0; white-space:nowrap;" align="center">
                    <font size="11px">
                        {{ $row['type'] }}
                    </font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">{{ $row['date'] }}</font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">
                        {{ $row['amount'] }}</font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">{{ $row['refere'] }}</font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">{{ $payment_date }}</font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">{{ $abono_individual }}</font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    {{-- <font size="11px">{{ number_format($balance_individual, 2, '.', ',') }}</font> --}}
                    <font size="11px">{{ number_format($balance, 2, '.', ',') }}</font>
                </p>
            </td>
        </tr>
        <?php
        }
      ?>
        <tr>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="12px"><b>Totales</b></font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">&nbsp;</font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="12px"><b>$ {{ number_format($cargos, 2, '.', ',') }}</b></font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">&nbsp;</font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">&nbsp;</font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="12px"><b>$ {{ number_format($abonos, 2, '.', ',') }}</b></font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="12px"><b>$ {{ number_format($balance, 2, '.', ',') }}</b></font>
                </p>
            </td>
        </tr>
    </table>
</body>

</html>
