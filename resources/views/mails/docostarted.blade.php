<!DOCTYPE html>
<html lang="es">

<head>
    <title>Notificación de Domiciliación {{ $data }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <style type="text/css">
        #outlook a {
            padding: 0;
        }


        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }

        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }


        body {
            margin: 0;
            padding: 0;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }

        .appleBody a {
            color: #68440a;
            text-decoration: none;
        }

        .appleFooter a {
            color: #999999;
            text-decoration: none;
        }

        @media screen and (max-width: 525px) {

            table[class="wrapper"] {
                width: 100% !important;
            }

            td[class="logo"] {
                text-align: left;
                padding: 20px 0 20px 0 !important;
            }

            td[class="logo"] img {
                margin: 0 auto !important;
            }

            td[class="mobile-hide"] {
                display: none;
            }

            img[class="mobile-hide"] {
                display: none !important;
            }

            img[class="img-max"] {
                max-width: 100% !important;
                height: auto !important;
            }

            table[class="responsive-table"] {
                width: 100% !important;
            }

            td[class="padding"] {
                padding: 10px 5% 15px 5% !important;
            }

            td[class="padding-copy"] {
                padding: 10px 5% 10px 5% !important;
                text-align: center;
            }

            td[class="padding-meta"] {
                padding: 30px 5% 0px 5% !important;
                text-align: center;
            }

            td[class="no-pad"] {
                padding: 0 0 20px 0 !important;
            }

            td[class="no-padding"] {
                padding: 0 !important;
            }

            td[class="section-padding"] {
                padding: 50px 15px 50px 15px !important;
            }

            td[class="section-padding-bottom-image"] {
                padding: 50px 15px 0 15px !important;
            }

            /* ADJUST BUTTONS ON MOBILE */
            td[class="mobile-wrapper"] {
                padding: 10px 5% 15px 5% !important;
            }

            table[class="mobile-button-container"] {
                margin: 0 auto;
                width: 100% !important;
            }

            a[class="mobile-button"] {
                width: 80% !important;
                padding: 15px !important;
                border: 0 !important;
                font-size: 16px !important;
            }

        }
    </style>
</head>

<body style="margin: 0; padding: 0;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td bgcolor="#ffffff">
                <div align="center" style="padding: 0px 15px 0px 15px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="500" class="wrapper">
                        <tr>
                            <td style="padding: 50px 0px 20px 0px;" class="logo">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td bgcolor="#ffffff" width="100" align="left"><a
                                                href="http://eureka.vepagos.com/" target="_blank"><img alt="Logo"
                                                    src="https://i0.wp.com/vepagos.com/wp-content/uploads/2020/07/cropped-LOGO-vepagos-TU-NEGOCIO-VENDE-MAS.png"
                                                    width="400" height="100"
                                                    style="display: block; font-family: Helvetica, Arial, sans-serif; color: #666666; font-size: 16px;   margin-left: auto;
                                                    margin-right: auto;"
                                                    border="0"></a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td bgcolor="#ffffff" align="center" style="padding: 50px 15px 20px 15px;" class="section-padding">
                <table border="0" cellpadding="0" cellspacing="0" width="500" class="responsive-table">
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center"
                                                    style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333;"
                                                    class="padding-copy">Su archivo de {{ $data }} ha
                                                    comenzado el proceso de Domiciliación.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><br></td>
                                            </tr>
                                            <tr>
                                                <td align="center"
                                                    style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #333333;"
                                                    class="padding-copy">Total de Registros: {{ $totales }}.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center"
                                                    style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #333333;"
                                                    class="padding-copy">Total de Registros a Conciliar:
                                                    {{ $procesados }}.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center"
                                                    style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #333333;"
                                                    class="padding-copy">Total de Registros Rechazados:
                                                    {{ $noProcesados }}.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                            class="mobile-button-container">
                                            <tr>
                                                <td align="center" style="padding: 25px 0 0 0;" class="padding-copy">
                                                    <table border="0" cellspacing="0" cellpadding="0"
                                                        class="responsive-table">
                                                        {{-- <tr>
                                                            <td align="center"><a
                                                                    href="http://eureka.vepagos.com/horizon/batches/{{ $batchid }}"
                                                                    target="_blank"
                                                                    style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #5D9CEC; border-top: 15px solid #5D9CEC; border-bottom: 15px solid #5D9CEC; border-left: 25px solid #5D9CEC; border-right: 25px solid #5D9CEC; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;"
                                                                    class="mobile-button">Ver Progreso &rarr;</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><br></td>
                                                        </tr> --}}
                                                        <tr>
                                                            <td align="center"><a
                                                                    href="http://eureka.vepagos.com/horizon/batches"
                                                                    target="_blank"
                                                                    style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #5D9CEC; border-top: 15px solid #5D9CEC; border-bottom: 15px solid #5D9CEC; border-left: 25px solid #5D9CEC; border-right: 25px solid #5D9CEC; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;"
                                                                    class="mobile-button">Ver Trabajos en Progreso
                                                                    &rarr;</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td bgcolor="#ffffff" align="center">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                        <td style="padding: 20px 0px 20px 0px;">
                            <table width="500" border="0" cellspacing="0" cellpadding="0" align="center"
                                class="responsive-table">
                                <tr>
                                    <td align="center" valign="middle"
                                        style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                                        <span class="appleFooter" style="color:#666666;">© Copyright VePagos 2021<br>
                                            Consultora Alca C.A. RIF: J-411024449.<br> Todos los derechos
                                            reservados.</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>
