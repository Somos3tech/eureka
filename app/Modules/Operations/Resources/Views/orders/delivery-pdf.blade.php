<!DOCTYPE html>
<html>

<head>
    <br><br>
    <title>Nota de Salida No.{{ $receipt_id }}</title>
    <style type="text/css" media="all">
        td,
        .hidden {
            border: hidden;
        }

        table {
            border: 1px solid #000000;
        }
    </style>
</head>

<body>
    <div style="margin: 70px 0;"></div>
    <div style="margin: 70px 0;"></div>
    <table id="header" style="width:100%;" border="0" class="hidden">
        <tr>
            <td colspan="5">
                <!--<img src="{{ public_path('assets/images/header.png') }}" alt="" width="580" class="logo-large">-->
            </td>
        </tr>
        <tr>
            <td colspan="2" width="20%">

                <p>
                    <font size="16px">Caracas, {{ strftime('%A, %d de %B de %Y') }}</font>
                </p>
                <p></p>
                <p>
                    <font size="16px">Señores: </font>
                </p>
            </td>
            <td width="20%">
            </td>
            <td colspan="2">
                <p style="margin:-0.2% 0;" align="right">
                    <font size="16px">No. NS/20-{{ $receipt_id }}</font>
                </p>
                <p>&nbsp;</p>
            </td>
        </tr>
    </table>
    <div>
        <br>
        <center><span><b>NOTA DE SALIDA</b></span></center>
        </br>
    </div>

    <table id="body" style="width: 100%;" border="1" cellspacing="3">
        <tr>
            <td>
                <font size="14px">Código</font>
            </td>
            <td width="50%">
                <font size="14px">{{ $customer_id }}</font>
            </td>
            <td width="16%" align="right">
                <font size="14px"></font>
            </td>
            <td width="30%">
                <font size="14px"></font>
            <td>
        </tr>
        <tr>
            <td>
                <font size="14px">Cliente</font>
            </td>
            <td>
                <font size="14px">{{ $business_name }}</font>
            </td>
            <td align="right">
                <font size="14px">Vendedor</font>
            </td>
            <td>
                <font size="14px">{{ $user_id }} -</font>
            </td>
        </tr>
        <tr>
            <td>
                <font size="14px">RIF</font>
            </td>
            <td>
                <font size="14px">{{ $rif }}</font>
            </td>
            <td></td>
            <td>{{ $user_name }}</td>
        </tr>
        <tr>
            <td>
                <font size="14px">Dirección</font>
            </td>
            <td>
                <font size="14px">{{ $address }} - {{ $city }} ({{ $state }})</font>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <font size="14px">Teléfono
            </td>
            <td>
                <font size="14px">{{ $telephone }} / {{ $mobile }}
            </td>
            <td>
            <td>
            <td>
            <td>
        </tr>
    </table>

    <table id="body2" style="width: 100%;" border="1" class="hidden" padding="10" cellpading="10">
        <tr>
            <th>
                <center>
                    <font size="14px">Código</font>
                </center>
            </th>
            <th width="95%">
                <center>
                    <font size="14px">Descripción</font>
                </center>
            </th>
        </tr>
        <tr>
            <td>
                <center>
                    <font size="14px">TERM</font>
                </center>
            </td>
            <td>
                <font size="14px">{{ $terminal }}</font>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <font size="14px">SIM</font>
                </center>
            </td>
            <td>
                <font size="14px">{{ $simcard }}</font>
            </td>
        </tr>
    </table>
    <br><br><br>
    Atentamente,
    <br><br>
    <br><br>
    <table id="footer" style="width: 100%;" border="0" class="hidden" padding="10" cellpading="10"
        cellspacing="10">
        <tr>
            <th>
                <center>
                    <font size="14px" class="p-2">______________________</font><br>
                    <font size="14px">Usuario Despacho</font>
                </center>
            </th>
            <th>
                <center>
                    <font size="14px" class="p-2">______________________</font><br>
                    <font size="14px">Entregado Por</font>
                </center>
            </th>
        </tr>
    </table>
    <br>
    <center><span><b>Recibido Por</b></span></center>
    <br>
    <table id="footer" style="width: 100%;" border="0" class="hidden" padding="30" cellpading="10"
        cellspacing="10">
        <tr>
            <th>
                <center>
                    <font size="14px" class="p-2">Nombres_________________________</font>
                </center><br><br>
            </th>
            <th>
                <center>
                    <font size="14px" class="p-2">Apellidos_______________________</font>
                </center>
            </th>
        </tr>
        <tr>
            <th>
                <center>
                    <font size="14px" class="p-2">Cédula_________________________</font>
                </center><br><br>
            </th>
            <th>
                <center>
                    <font size="14px" class="p-2">Firma__________________________</font>
                </center>
            </th>
        </tr>
    </table>
    <footer style="margin-top: 7em;">
        <center>
            <font size="12px">
                <b>Consultora Alca, C.A Vepagos</b>
                Dirección: Av. Francisco de Miranda- Chacao, C.C. Lido (Piso 8 oficina B, Vepagos).<br>
                Master: (0212) 8162865<br>
                Correo: info@vepagos.com
            </font>
        </center>
    </footer>
</body>

</html>
