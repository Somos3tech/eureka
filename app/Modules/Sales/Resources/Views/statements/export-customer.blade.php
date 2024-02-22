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
            <td>
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

        </tr>
    </table>
    <center>
        <h4 class="text"><b>
                <font>Resumen de Movimientos x Contrato (<font size="13px"><b>Generado: </b>
                        {{ date_format(now(), 'd M. Y') }}</font>)</font><b></h4>
    </center>
    <table id="body" style="width:100%;" border="0" class="hidden">
        <tr>
            <th>
                <font class="text" size="12px" align="center"><b>Descripción</b></font>
            </th>
            <th>
                <font class="text" size="12px" align="center"><b>Cargos</b></font>
            </th>
            <th>
                <font class="text" size="12px" align="center"><b>Abonos</b></font>
            </th>
            <th>
                <font class="text" size="12px" align="center"><b>Balances</b></font>
            </th>
        </tr>
        <?php
      $balance = 0;
      $abonos = 0;
      $cargos = 0;
$cont = 0;
      foreach ($data as $row) {
          $balance = $balance + ($row['amount_pending'] - ($row['amount_collection'] != '' ? $row['amount_collection'] : '0.00'));
          $cargos = $cargos + $row['amount_pending'];
          $abonos = $abonos + ($row['amount_collection'] != '' ? $row['amount_collection'] : '0.00');
      ?>

        <tr>
            <td>
                <p class="text" style="margin:0.2% 0;" align="justify">
                    <font size="11px">No. Contrato: {{ $row['contract_id'] }} - Banco: {{ $row['bank_name'] }} <br>
                        Plan: {{ $row['term_name'] }} - Serial: {{ $row['terminal'] }}</font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">{{ number_format($row['amount_pending'], 2, '.', ',') }}</font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">
                        {{ number_format($row['amount_collection'] != '' ? $row['amount_collection'] : '0.00', 2, '.', ',') }}
                    </font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="11px">
                        {{ number_format($row['amount_pending'] - ($row['amount_collection'] != '' ? $row['amount_collection'] : '0.00'), 2, '.', ',') }}
                    </font>
                </p>
            </td>
        </tr>
        <?php
        }
      ?>
        <tr>

            <td>
                <p class="text" style="margin:0.2% 0;" align="right">
                    <font size="13px"><b>Totales</b></font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="13px"><b>{{ number_format($cargos, 2, '.', ',') }}</b></font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="13px"><b>{{ number_format($abonos, 2, '.', ',') }}</b></font>
                </p>
            </td>
            <td>
                <p class="text" style="margin:0.2% 0;" align="center">
                    <font size="13px"><b>{{ number_format($balance, 2, '.', ',') }}</b></font>
                </p>
            </td>
        </tr>
    </table>
</body>

</html>
