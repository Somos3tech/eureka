<?php

namespace App\Modules\Sales\Repositories\Traits;

use Carbon\Carbon;

trait GenericClass
{
    public static function generateDocument($data)
    {
        $date = Carbon::now();
        setlocale(LC_ALL, 'es_ES');
        Carbon::setLocale('es');

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->getCompatibility()->setOoxmlVersion(15);
        $phpWord->setDefaultFontName('Calibri');
        $phpWord->setDefaultFontSize(10);
        $phpWord->getSettings()->setThemeFontLang(new \PhpOffice\PhpWord\Style\Language('es-ES'));

        $phpWord->setDefaultParagraphStyle(
            [
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH,
                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),
            ]
        );

        $phpWord->addParagraphStyle(
            'rightTab',
            ['tabs' => [new \PhpOffice\PhpWord\Style\Tab('right', 9090)]]
        );

        $phpWord->addParagraphStyle(
            'centerTab',
            ['tabs' => [new \PhpOffice\PhpWord\Style\Tab('center', 4680)]]
        );

        $phpWord->addParagraphStyle(
            'leftTab',
            ['tabs' => [new \PhpOffice\PhpWord\Style\Tab('left', 300)]]
        );

        $sectionStyle = ['marginLeft' => 1200, 'marginRight' => 1200, 'marginTop' => 1702, 'marginBottom' => 1702];
        $pStyle = ['align' => 'center', 'bold' => true, 'underline' => 'single'];

        foreach ($data as $row) {
            $section = $phpWord->addSection($sectionStyle);
            $fieldText = $section->addTextRun();
            $fieldText->addText('Entre, ');
            $fieldText->addText('“DISTRIBUIDORA GLOBAL DE INSUMOS XXI, C.A.” ', ['bold' => true]);
            $fieldText->addText('sociedad mercantil domiciliada en la ciudad de Caracas y debidamente inscrita ante el  Registro Mercantil Quinto de la Circunscripción Judicial del Distrito Capital y Estado Miranda, '
                .'en fecha 13 de junio de 2019, debidamente anotada bajo el N° 35, Tomo 36-A, e inscrita en el Registro de Información Fiscal N° J-41243890-5, representada en este acto por sus Directores, ciudadanos ');
            $fieldText->addText('FRANCESCO LOVAGLIO TAFURI y JUAN CARLOS FERNANDEZ SIERRA', ['bold' => true, 'name' => 'Calibri', 'size' => 10]);
            $fieldText->addText(', venezolanos, mayores de edad, solteros, domiciliados en la ciudad de Caracas y titulares de las cédulas de identidad Nros. V-6.323.967 y V-21.038.707, debidamente facultados por los Estatutos Sociales de la Compañía, '
                .'en lo adelante y a los solos efectos del presente Contrato denominada');
            $fieldText->addText(' EL PROVEEDOR', ['bold' => true]);
            $fieldText->addText(', por una parte;');
            $fieldText = $section->addTextRun();
            $fieldText->addText('Y por la otra: ');
            $fieldText->addText($row->business_name, ['bold' => true]);
            $fieldText->addText(' sociedad mercantil domiciliada en la ciudad de ');
            $fieldText->addText($row->city_register, ['bold' => true]);
            $fieldText->addText(' y debidamente inscrita ante el ');
            $fieldText->addText($row->comercial_register, ['bold' => true]);
            $fieldText->addText(' en fecha ');
            $fieldText->addText($row->date_register, ['bold' => true]);
            $fieldText->addText(', debidamente anotada bajo el N° ');
            $fieldText->addText($row->number_register, ['bold' => true]);
            $fieldText->addText(', Tomo ');
            $fieldText->addText($row->took_register, ['bold' => true]);
            $fieldText->addText(' , e inscrita en el Registro de Información Fiscal ');
            $fieldText->addText($row->rif, ['bold' => true]);
            $fieldText->addText(', representada en este acto por su ');
            $fieldText->addText($row->jobtitle, ['bold' => true]);
            $fieldText->addText(', ciudadano ');
            $fieldText->addText($row->first_name.' '.$row->last_name, ['bold' => true]);
            $fieldText->addText(', venezolano, mayor de edad, domiciliado en la ciudad de ');
            $fieldText->addText($row->city_register, ['bold' => true]);
            $fieldText->addText(' y titular de la Cédula de Identidad ');
            $fieldText->addText($row->document.', ', ['bold' => true]);

            if ($row->clause_register != null) {
                $fieldText->addText('debidamente facultado para este Acto de conformidad con lo establecido ');
                $fieldText->addText('en la Cláusula '.$row->clause_register.',  del ', ['bold' => true]);
            } else {
                $fieldText->addText('debidamente facultado para este Acto de conformidad con lo establecido en el ');
            }

            $fieldText->addText('Documento Constitutivo Estatutario de la Sociedad, en lo adelante y a los solos efectos del presente Contrato denominada ');
            $fieldText->addText('NEGOCIO AFILIADO.', ['bold' => true]);

            $fieldText = $section->addTextRun();
            $fieldText->addText('Denominadas en su conjunto como “Las Partes”');

            $fieldText = $section->addTextRun();
            $fieldText->addText('Se ha convenido en celebrar, como en efecto se celebra, el presente ');
            $fieldText->addText('CONTRATO DE SERVICIO ASOCIADO A PUNTO DE VENTA', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(', el cual se regirá por las siguientes Cláusulas y Estipulaciones:');

            $text = 'CONSIDERACIONES PREVIAS';
            $phpWord->addFontStyle('r2Style', ['bold' => true, 'underline' => 'single', 'size' => 10]);
            $phpWord->addParagraphStyle('p2Style', ['align' => 'center']);
            $section->addText($text, 'r2Style', 'p2Style');

            $fieldText = $section->addTextRun();
            $fieldText->addText('CONSIDERANDO:', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Que EL PROVEEDOR es una sociedad mercantil autorizada por la Superintendencia de las Instituciones del Sector Bancario (SUDEBAN) según Oficio N°  SIB-II-GGR-GNP-05862, de fecha 31 de mayo de 2019, dedicada a ofrecer Puntos de Venta, servicio Post Venta y Soporte Técnico, en lo sucesivo denominado EL EQUIPO, siendo catalogada como Proveedor y no como Institución Financiera o Compañía Emisora o Administradora,  siéndole otorgado el Registro N° 0073 por la SUDEBAN, en atención a la Resolución N° 116.17 que establece las ');
            $fieldText->addText('“Normas que Regulan la Contratación con Proveedores que Efectúen La Comercialización de Puntos de Venta";', ['italic' => true]);
            $fieldText = $section->addTextRun();
            $fieldText->addText('CONSIDERANDO:', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Que EL PROVEEDOR se encuentra inscrito en el Registro Agregado Comercial del Consorcio Credicard, C.A., según comunicación de fecha 05 de junio de 2019;');

            $fieldText = $section->addTextRun();
            $fieldText->addText('CONSIDERANDO:', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Que EL NEGOCIO AFILIADO procedió a adquirir, o ésta en proceso de adquirir, de EL PROVEEDOR EL EQUIPO que se detalla e identifica en el Anexo “A” de presente Contrato;');

            $fieldText = $section->addTextRun();
            $fieldText->addText('CONSIDERANDO:', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Que EL NEGOCIO AFILIADO detenta la necesidad de contratar los servicios de EL PROVEEDOR a los fines de la implementación de EL EQUIPO en su establecimiento comercial;');

            $fieldText = $section->addTextRun();
            $fieldText->addText('EN CONSECUENCIA:', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Las Partes, procediendo de común acuerdo, deciden obligarse bajo los siguientes términos:');

            $phpWord->addFontStyle('r2Style', ['bold' => true, 'underline' => 'single', 'size' => 10]);
            $phpWord->addParagraphStyle('p2Style', ['align' => 'center']);
            $phpWord->addParagraphStyle('tabStyle', ['left' => 360, 'hanging' => 360, 'tabPos' => 360]);

            $text = 'DEFINICIONES PREVIAS';
            $section->addText($text, 'r2Style', 'p2Style');

            $fieldText = $section->addTextRun();
            $fieldText->addText('A los efectos de la interpretación del presente Contrato, se entiende por: ');

            $phpWord->addNumberingStyle(
                'multilevel',
                [
                    'type' => 'multilevel',
                    'levels' => [
                        ['format' => 'decimal', 'text' => '%1.', 'left' => 360, 'hanging' => 360, 'tabPos' => 360],
                        ['format' => 'upperLetter', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720],
                    ],
                ]
            );

            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t1. "));
            $fieldText->addText('Compañías Emisoras o Administradoras', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': Aquellas que prestan servicios financieros o servicios auxiliares a las instituciones bancarias relacionados con la emisión y administración de tarjetas de crédito, débito, prepagadas y demás tarjetas de financiamiento o pago electrónico, sometidas a la supervisión, inspección, control, regulación, vigilancia y sanción de la Superintendencia de las Instituciones del Sector Bancario.');

            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t2. "));
            $fieldText->addText('Registro', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': Representa la inscripción de las personas jurídicas de carácter público o privado y personas naturales con firma personal registrada, que efectúen la comercialización de puntos de venta y la prestación de servicios relacionados con estos, que al efecto lleva esta Superintendencia.');

            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t3. "));
            $fieldText->addText('Proveedor', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': Toda persona jurídica de carácter público o privado y persona natural con firma personal registrada, nacionales o extranjeros, que efectúen la comercialización de puntos de venta y la prestación de servicios relacionados éstos.');

            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t4. "));
            $fieldText->addText('Servicio de Punto de Venta', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': Canal electrónico facilitado por La Institución Bancaria al negocio o persona afiliada con la finalidad que éstos dispongan en su cuenta de los montos cancelados mediante pagos realizados con tarjetas de débitos, crédito y demás tarjetas de financiamiento o pago electrónico, por sus consumidores al momento que adquiera los bienes o servicios que prestan.');

            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t5. "));
            $fieldText->addText('Punto de Venta', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': Dispositivo electrónico suministrado por la institución bancaria, con el fin que sea utilizado por los negocios y personas afiliadas para transmitir y autorizar operaciones de pago que efectúan los consumidores con tarjetas de débito, crédito y demás tarjetas de financiamiento o pago electrónico, por la adquisición de bienes o servicios.');

            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t6. "));
            $fieldText->addText('Negocio Afiliado', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': Persona jurídica expendedora de bienes o prestador de servicios autorizados por una institución bancaria, para procesar los consumos del o la tarjetahabiente en los puntos de venta que se encuentren instalados en dicho establecimiento.');

            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t7. "));
            $fieldText->addText('Persona Afiliada', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': Persona natural constituida en firma personal o profesional de libre ejercicio, expendedor de bienes o prestador de servicios, autorizadas por una instituci6n bancaria, para procesar los consumos del o la tarjetahabiente en los puntos de venta que estas dispongan.');

            $fieldText->addText(htmlspecialchars("\t8. "));
            $fieldText->addText('Tarjeta', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': Instrumento financiero que facilita la adquisición y consumo de bienes y/o servicios mediante el pago en Puntos de Venta. Ésta puede ser una tarjeta de crédito, débito, prepagada y demás tarjetas de financiamiento o pago electrónico.');

            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t9. "));
            $fieldText->addText('Tarjetahabiente', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': Persona natural o jurídica que previo contrato con una institución bancaria, es habilitado para el uso de una Tarjeta.');

            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t10. "));
            $fieldText->addText('Equipo', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': Dispositivo(s) electrónico(s) que permite (n) a el Negocio Afiliado procesar transacciones de crédito y débito en línea, mediante la lectura de la información que contiene las tarjetas de crédito y/o tarjeta de débito y obtener el resultado de las transacciones.');

            $text = 'ESTIPULACIONES CONTRACTUALES';
            $section->addText($text, 'r2Style', 'p2Style');

            $fieldText = $section->addTextRun();
            $fieldText->addText('PRIMERA: OBJETO.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' El objeto del Contrato es la prestación por parte de EL PROVEEDOR a EL NEGOCIO AFILIADO, de los servicios entre los cuales se incluyen servicios de postventa a través de su plataforma tecnológica, Call Center, soporte técnico y de renta telefónica producto de la adquisición de EL EQUIPO por el NEGOCIO AFILIADO, que se detalla en el Anexo “A” del presente Contrato, el cual, suscrito por Las Partes, forma parte integrante del mismo, a los efectos que los Tarjetahabientes puedan efectuar operaciones comerciales en su establecimiento. ');

            $fieldText->addText('PARÁGRAFO ÚNICO: ', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText('En caso de que el NEGOCIO AFILIADO desee cambiar la Operadora de Telefonía asociada al funcionamiento de EL EQUIPO, este deberá correr con los todos gastos y costos asociados a dicho cambio de Operadora.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('SEGUNDA: CONTRAPRESTACION.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' EL NEGOCIO AFILIADO pagará a EL PROVEEDOR por la prestación de los servicios indicados en la Cláusula Primera de este Contrato la cantidad de ');
            $fieldText->addText('CUARENTA DÓLARES DE LOS ESTADOS DE NORTEAMÉRICA ', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText('(US$ 40.00) a la tasa de cambio de referencia promedio emitido por el Banco Central de Venezuela (B.C.V.).');

            $fieldText = $section->addTextRun();
            $fieldText->addText('PARÁGRAFO PRIMERO', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': Para el cabal cumplimiento de esta obligación, EL PROVEEDOR le emitirá a EL NEGOCIO AFILIADO la correspondiente factura, la cual deberá contar con todos los requisitos exigidos por la legislación positiva vigente en la República Bolivariana de Venezuela. Bajo ningún concepto se considerará que EL NEGOCIO AFILIADO se encuentra en mora en el pago de sus obligaciones, cuando dichas facturas adolezcan de cualquier vicio formal y estos hayan sido debidamente notificados a EL PROVEEDOR.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('PARÁGRAFO SEGUNDO', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': La forma de pago por parte del NEGOCIO AFILIADO a EL PROVEEDOR será mediante cobros domiciliados a la Cuenta Corriente del NEGOCIO AFILIADO con débito automático al QUINTO (5) día calendario de cada mes. En caso de que sea imposible hacer el cobro de los servicios descritos en la Cláusula Primera del presente contrato, en dicha oportunidad, EL NEGOCIO AFILIADO pagará a EL PROVEEDOR dichos CUARENTA DÓLARES DE LOS ESTADOS DE NORTEAMÉRICA (US$ 40.00) a la tasa de cambio de referencia promedio emitido por el Banco Central de Venezuela (B.C.V) el día hábil anterior a la fecha de cobro o cargo automático en la cuenta corriente de EL NEGOCIO AFILIADO. Las tarifas aquí establecidas se modificarán mensualmente en atención a los elementos económicos que ocurran el país, tales como, inflación, devaluación de la moneda, creación de nuevos impuestos, aumento del salario mínimo, entre otros; y en atención a la variabilidad del costo de los servicios asociados con la prestación de los servicios aquí indicados; pudiendo, no obstante, ser modificadas en cualquier oportunidad en caso de ocurrir circunstancias económicas que así lo ameriten. ');

            $fieldText = $section->addTextRun();
            $fieldText->addText('PARÁGRAFO TERCERO', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': En caso de que el NEGOCIO AFILIADO no disponga de los fondos suficientes para que se realice el débito automático según lo estipulado en el Parágrafo anterior, por un período mayor a 30 días calendarios, EL PROVEEDOR procederá a notificar a el NEGOCIO AFILIADO a fin de que este proceda a regularizar los pagos y evitar eventuales suspensiones del servicio descrito en la cláusula primera del presente contrato.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('PARÁGRAFO CUARTO', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': En los casos de suspensión y/o desconexión en los términos establecidos en el Parágrafo anterior, el NEGOCIO AFILIADO, para la reactivación del servicio, deberá pagar a EL PROVEEDOR la(s) suma(s) debidas más los correspondientes intereses moratorios calculados a la tasa del Uno Por Ciento (1%) mensual.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('TERCERA: VIGENCIA.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' El presente Contrato tendrá una vigencia de SEIS (6) meses contados a partir de su suscripción por Las Partes, renovándose automáticamente por periodos sucesivos, a menos que el mismo sea terminado en atención y por las causas dispuestas en el presente Contrato.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('CUARTA: GARANTIA DEL PROVEEDOR.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' EL PROVEEDOR concede una garantía a EL NEGOCIO AFILIADO sobre EL EQUIPO en caso de daño de Software o daños de fabricación de tres (3) meses desde el momento de la firma del presente Contrato. EL PROVEEDOR no dará garantía sobre EL EQUIPO en caso de daño por fallas eléctricas, reparación por personal no autorizado, mal uso o manipulación del punto, derrames, desastres naturales entre otros de la misma naturaleza.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('QUINTA: OBLIGACIONES DEL PROVEEDOR.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Sin menoscabo de las obligaciones que EL PROVEEDOR asume en virtud del presente Contrato y de las obligaciones específicas que asume en su relación con las Instituciones Financieras y Compañías Emisoras o Administradoras, estará obligado a lo siguiente: (a) EL PROVEEDOR se obliga a prestar apoyo técnico y soporte a EL NEGOCIO AFILIADO a través de un Call Center, a los fines del correcto funcionamiento y operatividad del Punto de Venta. Asimismo, se obliga a entregar un manual de Uso de EL EQUIPO cuyo contenido y alcance declara EL NEGOCIO AFILIADO haber recibido, conocer y aceptar con la entrega que se le realizó de EL EQUIPO; (b) EL PROVEEDOR se obliga a entregarle a EL NEGOCIO AFILIADO, las normas de seguridad que este debe mantener; así como, las instrucciones respectivas para que EL EQUIPO sea instalado en los lugares adecuados, visible y de fácil acceso al tarjetahabiente a los fines que este durante el procesamiento del pago pueda visualizar su tarjeta e ingresar su clave con facilidad para garantizarle seguridad sobre sus datos frente a tercero; (c) Brindarle a EL NEGOCIO AFILIADO el apoyo operativo y tecnológico para solucionar las consultas sobre el manejo de EL EQUIPO, fallas en los mismos y deficiencias en el servicio, entre otras, en un plazo no mayor de cinco (5) días continuos desde la fecha en que fue notificado el requerimiento; (d) Hacer el mantenimiento preventivo a EL EQUIPO con una periodicidad mínima de una (1) vez al año o cuando sea requerido por EL NEGOCIO AFILIADO; (e) La responsabilidad en la correcta instalación de EL EQUIPO que garantice su adecuado funcionamiento; (f) no cobrar por cuenta propia comisión alguna a EL NEGOCIO AFILIADO por la instalación de EL EQUIPO; (g) Informar a la Institución Bancaria sobre cualquier anormalidad o irregularidad que pueda afectar el funcionamiento de EL EQUIPO; (h) Informar a la Institución Financiera de forma inmediata, mediante escrito, cuando determine que EL EQUIPO no se encuentra en el lugar en el cual fueron instalados; así como cuando observe que éstos no están siendo utilizados adecuadamente por EL NEGOCIO AFILIADO, afectando su funcionalidad; (I) EL PROVEEDOR no podrá activar EL EQUIPO que no sea asignado por las Instituciones Financieras a EL NEGOCIO AFILIADO, sin que medie una solicitud de afiliación ante la Institución Financiera.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('SEXTA: OBLIGACIONES DEL NEGOCIO AFILIADO.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Sin menoscabo de las obligaciones que EL NEGOCIO AFILIADO asume en virtud del presente Contrato y de las obligaciones específicas que asume en su relación cons las Instituciones Financieras, estará obligado a lo siguiente: (a) EL NEGOCIO AFILIADO se obliga a colocar EL EQUIPO en un lugar adecuado, visible y de fácil acceso al tarjetahabiente a los fines que este, durante el procesamiento del pago, pueda visualizar su tarjeta e ingresar su clave con facilidad para garantizarle seguridad sobre sus datos frente a tercero; (b) EL NEGOCIO AFILIADO deberá reportar las fallas o deterioros presentados por EL EQUIPO antes de las veinticuatro (24) horas siguientes a su ocurrencia, teniendo claro que EL EQUIPO solo podrá ser reparado y manipulado por personas autorizadas por EL NEGOCIO AFILIADO, sopena de perder la garantía contenida en la Cláusula Tercera del presente Contrato en adición a las demás acciones que ello originare; (c)  EL NEGOCIO AFILIADO se obliga a usar EL EQUIPO únicamente para transacciones lícitas y acepta expresamente que tanto EL PROVEEDOR como las Instituciones Financieras, puedan efectuar inspecciones en el establecimiento al detectar alguna circunstancia que sugiera uso inapropiado de EL EQUIPO por cuenta de EL NEGOCIO AFILIADO; (d) EL NEGOCIO AFILIADO, en caso de solicitar cambio de Tarjeta SIM de EL EQUIPO; se obliga a pagar a EL  PROVEEDOR todos los gastos que dicho cambio genere.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('SÉPTIMA: NORMATIVA ESPECIAL.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' No obstante, lo establecido en el presente Contrato, Las Partes declaran expresamente estar en conocimiento de la Resolución Número 116.17 emanada de la SUDEBAN, que establece las');
            $fieldText->addText(' “Normas que Regulan la Contratación con Proveedores que Efectúen La Comercialización de Puntos de Venta“', ['italic' => true]);
            $fieldText->addText(', debiendo cumplir a tales efectos, las obligaciones y recomendaciones específicas allí establecidas, en los casos que corresponda; por lo que en todo lo no previsto en el presente Contrato, se aplicará lo allí establecido.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('OCTAVA: LUGAR DE INSTALACIÓN DE EL EQUIPO.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' EL NEGOCIO AFILIADO se obliga a instalar EL EQUIPO en el lugar previamente indicado al momento de su adquisición y que se detalla en el Anexo “A” del presente Contrato. En tal sentido, EL NEGOCIO AFILIADO se obliga a notificar por escrito y de forma inmediata, cualquier cambio en el lugar de instalación a EL PROVEEDOR, a los efectos que éste pueda cumplir a cabalidad con las obligaciones específicas que le impone la citada Resolución Número 116.17.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('NOVENA. CONFIDENCIALIDAD.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Cada una de Las Partes acuerda que toda la información que por cualquier medio o modalidad le sea suministrada, proveída o divulgada por la otra, o por terceros designados por éstas, así como cualesquiera notas, resúmenes, análisis o cualquier material derivado de la mencionada información, será considerado como información confidencial y, en tal condición, no podrá ser revelada por ninguna de Las Partes a terceras personas, a través de ningún medio, modalidad o forma, con excepción de aquellos casos en los cuales sea expresamente autorizado, para tal fin, por la parte que corresponda, lo cual deberá constar necesariamente por escrito. Toda información utilizada por y/o suministrada a una de Las Partes por la otra, permanecerá amparada por la presente Cláusula de Confidencialidad, en los términos aquí establecidos, mientras esté en vigencia el presente Contrato y hasta un período de cinco (5) años contados a partir de la terminación de este. Cada una de Las Partes se compromete a mantener la información suministrada por la otra y/o sus relacionados en general, en absoluta confidencialidad y no podrán hacer uso de ella en una forma diferente a la determinada por los propósitos y fines estipulados por la parte a quien pertenece la información. Asimismo, cada una de Las Partes se compromete a limitar el acceso a la información a la que aquí se hace referencia, únicamente al personal de su absoluta confianza y para los propósitos y fines estipulados en el presente contrato. Esta obligación no se aplicará a la información confidencial que: (a) al momento de ser suministrada esté generalmente disponible al público o después se convierta en información generalmente disponible para el público, siempre y cuando ello no sea producto de la violación del presente Contrato por parte de la empresa que recibió la información confidencial, sus agentes, representantes o empleados; (b) en fecha anterior a la revelación por parte de la empresa propietaria de la información confidencial ya estuviere a la disposición de la otra Parte sobre una base de no confidencialidad; (c) sea disponible por haberla recibido de otra fuente sobre una base de no confidencialidad, la cual no fue prohibida de proporcionar tal información por una obligación legal o contractual. Queda igualmente establecido que cada una de Las Partes se obliga a devolver a la otra, dentro de un lapso de cinco (5) días hábiles siguientes a la terminación del presente Contrato, el total de toda la información y documentación relacionada con los servicios prestados, la cual se encuentra, por lo demás, amparada por las previsiones de confidencialidad establecidas en esta Cláusula.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('DÉCIMA: CONTRATISTA INDEPENDIENTE. ', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' El NEGOCIO AFILIADO declara que actúa como contratista independiente, con autonomía propia y no es, ni pretende en forma alguna ser representante, apoderado, agente comercial o mandatario de EL PROVEEDOR ni empleado de ésta. Por consiguiente, El NEGOCIO AFILIADO será responsable en todo momento de las obligaciones frente a sus empleados, contratistas, clientes, terceros y, en general, frente a cualquier acreedor que tuviere y en ningún caso podrá actuar en nombre de EL PROVEEDOR, no pudiendo representarla, ni comprometerla, en modo alguno, frente a terceros. Queda entendido que El NEGOCIO AFILIADO, como patrono independiente que es del personal de su nómina, es y será la única responsable frente a este personal y ante las autoridades competentes del pago de todas y cada una de las obligaciones previstas en la legislación laboral, tales como salarios, viáticos, horas extraordinarias, utilidades, prestaciones sociales, bonos, etc. De igual modo, El NEGOCIO AFILIADO será el único responsable por cualquier accidente de trabajo que pudiere ocurrirle a cualquiera de sus trabajadores dentro de sus instalaciones, así como de cualquier daño o perjuicio que estos causaren a personas o bienes extraños a la presente negociación.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('DÉCIMA PRIMERA: CASO FORTUITO Y FUERZA MAYOR.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Cada Parte quedará excusada de cumplir con sus obligaciones, en la medida en que tal cumplimiento sea impedido por una causa extraña no imputable, debidamente comprobada, especialmente aquellas que resulten como consecuencia de cualquiera de los factores que, en forma enunciativa y no limitativa, se indican a continuación:  (a) incendio, (b) explosión, (c) disputas laborales, (d) fenómenos naturales, (e) insurrecciones, (f) conmoción civil, (g) bloqueos, (h) promulgación y/o entrada en vigencia de cualquier Ley, Decreto, Reglamento, Acto Administrativo, Resolución Ministerial o cualquier otro tipo de normativa legal, (i) en general, cualquier otra causa, ya sea semejante o diferente de las enunciadas, que esté fuera del control de la Parte involucrada y que no pueda ser vencida por ésta con razonable prontitud. En tales casos, la Parte afectada deberá notificar y dar los detalles por escrito a la otra tan pronto como sea posible y la obligación de la Parte afectada será suspendida mientras dure la causa extraña no imputable, entendiéndose que si la imposibilidad continuase durante un período en el cual Las Partes podrían perder su interés en la continuación del contrato, cualquiera de ellas podrá darlo por terminado, dando notificación escrita a la otra de su voluntad. En estos casos, ninguna de Las Partes será responsable frente a la otra por algún concepto, salvo lo que respecta a su obligación de pagar cualquier deuda que se encontrare pendiente de pago para la fecha en que se produjere dicha terminación.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('DECIMA SEGUNDA: CESIÓN.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' El presente Contrato se celebra en consideración a los atributos de las personas que en éste intervienen y por lo tanto ninguna de estas podrá cederlo total o parcialmente a persona alguna, sea natural o jurídica, ni hacerse sustituir por terceros en el ejercicio de los derechos o en el cumplimiento de las obligaciones que en el mismo constan, sin el consentimiento previo, expreso y por escrito de la otra Parte y el cumplimiento de las formalidades correspondientes.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('DÉCIMA TERCERA: INTEGRIDAD.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' El presente Contrato recoge la integridad de lo convenido entre Las Partes y, por tanto, no existen promesas, acuerdos, garantías, obligaciones o compromisos anteriores al mismo que puedan afectarlo. La invalidez o nulidad de alguna de las disposiciones contenidas en el presente Contrato, no afectará la validez y ejecutabilidad de las restantes disposiciones de este, las cuales continuarán en plena vigencia.  En tal caso, se discutirá la estipulación que habrá de sustituir la disposición declarada inválida o nula.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('DÉCIMA CUARTA: MODIFICACIONES.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Cualquier modificación que Las Partes deseen efectuar al presente Contrato, solo podrá ser realizada de mutuo acuerdo, mediante documento escrito y suscrito por los representantes debidamente autorizados por cada una de estas.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('DÉCIMA QUINTA: ACTIVIDADES ADICIONALES. ', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Cualquier servicio adicional no contenido en el presente Contrato y relacionado con EL EQUIPO, quedarán fijados documentalmente en una Adenda.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('DECIMA SEXTA: TERMINACIÓN ANTICIPADA. ', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Son causas de terminación anticipada del presente Contrato: (a) El incumplimiento de una cualquiera de Las Partes de las obligaciones establecidas en el presente Contrato; (b) La insolvencia manifiesta de una cualquiera de Las Partes, que produzca como consecuencia su sometimiento a procedimientos de cesación de pagos o de quiebra, o cualquier otra circunstancia que afecte sustancialmente su capacidad de cumplir con las obligaciones contractuales; (c) El Hecho del Príncipe; (d) La cesión no autorizada del presente Contrato. La Parte contra quien obre el incumplimiento podrá ejercer todas las acciones tendientes al resarcimiento de los daños y perjuicios que dicho incumplimiento le hubiere ocasionado. (e) EL PROVEEDOR tendrá derecho a rescindir unilateralmente y de pleno derecho, y  en cualquier momento, el presente Contrato en caso que EL NEGOCIO AFILIADO esté en mora por más de sesenta (60) días continuos; (f)  EL PROVEEDOR  puede dar por terminado el presente Contrato, previa notificación a EL NEGOCIO AFILIADO,  otorgando un plazo prudencial para cerrar las operaciones en EL EQUIPO, de manera que EL NEGOCIO AFILIADO no se vea afectado en sus operaciones comerciales; asimismo y a consecuencia de dicha terminación, no generará indemnización alguna por daños o perjuicios a EL NEGOCIO AFILIADO. ');

            $fieldText->addText('PARÁGRAFO PRIMERO', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': En caso de que EL NEGOCIO AFILIADO de por terminado el presente Contrato, de forma anticipada y sin causa alguna, deberá pagar a EL PROVEEDOR una penalidad equivalente a SEIS (6) meses de prestación de servicio o el equivalente a la cantidad de meses que faltaren de vigencia del Contrato, en caso de que estos sean menor a estos SEIS (6) meses. ');

            $fieldText->addText('PARÁGRAFO SEGUNDO', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': En caso de que EL NEGOCIO AFILIADO desee dar por terminado de forma anticipada el presente Contrato, de acuerdo con lo establecido en el Parágrafo Primero, deberá notificar por escrito a EL PROVEEDOR dicha intención con al menos TREINTA (30) calendarios de anticipación a la fecha propuesta para la terminación. ');

            $fieldText->addText('PARÁGRAFO TERCERO', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(': Una vez EL NEGOCIO AFILIADO pague la penalidad por la terminación anticipada en los términos y condiciones aquí establecidos, EL PROVEEDOR procederá a notificar al Consorcio Credicard, C.A., para iniciar los trámites relacionados con la desconexión de EL EQUIPO. EL NEGOCIO AFILIADO reconoce y acepta que hasta tanto no se produzca la notificación de desconexión de EL EQUIPO al Consorcio Credicard, C.A., éste no podrá ser utilizado por ningún otro proveedor.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('DÉCIMA SÉPTIMA: NOTIFICACIONES.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' Toda notificación, informes y/o participaciones que deban ser efectuadas en virtud del presente Contrato, se efectuará mediante carta con acuse de recibo, sin perjuicio de que la misma pueda ser hecha mediante notificación judicial o auténtica. Las notificaciones serán dirigidas a las siguientes direcciones:');

            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t\t"));
            $fieldText->addText(htmlspecialchars('A EL PROVEEDOR:'), ['bold' => true, 'underline' => 'single']);
            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t\tAvenida Venezuela, Edificio Torre La Oriental, Piso PB, Local Oeste, Urbanización El Rosal"));
            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t\tTeléfonos: (0212) 820.5000"));
            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t\tAtención: ".$row->user_created.' - ventas@dis-global.com'));
            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t\t"));
            $fieldText->addText(htmlspecialchars('A EL NEGOCIO AFILIADO:'), ['bold' => true, 'underline' => 'single']);
            $fieldText = $section->addTextRun();
            $fieldText->addText(htmlspecialchars("\t\t".$row->first_name.' '.$row->last_name.' - '.$row->telephone));

            $fieldText = $section->addTextRun();
            $fieldText->addText('DÉCIMA OCTAVA: DOMICILIO ESPECIAL.', ['bold' => true, 'underline' => 'single']);
            $fieldText->addText(' A los efectos del presente Contrato las Partes eligen como domicilio especial y excluyente a la Ciudad de Caracas, a la Jurisdicción de cuyos Tribunales y Juzgados deciden someterse.');
            $fieldText = $section->addTextRun();

            $fieldText->addText('Se hacen dos (2) ejemplares de un mismo tenor y a un solo efecto, en la ciudad de Caracas, a los '.date('d').' DIAS DEL MES DE '.strtoupper($date->formatLocalized('%B')).' '.date('Y').'.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('Por ');
            $fieldText->addText(htmlspecialchars("EL PROVEEDOR,\t\t\t\t\t\t\t"), ['bold' => true]);

            $fieldText->addText('Por ', 'rightTab');
            $fieldText->addText('EL NEGOCIO AFILIADO,', ['bold' => true], 'rightTab');

            $section->addTextBreak(8);

            $phpWord->addParagraphStyle('p2Style1', ['align' => 'center']);

            $section->addText('ANEXO “A”', ['bold' => true], 'p2Style1');
            $section->addTextBreak(1);
            $section->addText('IDENTIFICACIÓN DEL EQUIPO', ['bold' => true], 'p2Style1');
            $section->addTextBreak(1);
            $section->addText($row->modelterminal.' - '.$row->terminal, null, 'p2Style1');
            $section->addTextBreak(1);
            $section->addText('Banco: '.$row->bank, null, 'p2Style1');
            $section->addTextBreak(1);

            $fieldText = $section->addTextRun();
            $fieldText->addText('Se hacen dos (2) ejemplares de un mismo tenor y a un solo efecto, en la ciudad de Caracas, a los '.date('d').' DIAS DEL MES DE '.strtoupper($date->formatLocalized('%B')).' '.date('Y').'.');

            $fieldText = $section->addTextRun();
            $fieldText->addText('Por ');
            $fieldText->addText(htmlspecialchars("EL PROVEEDOR,\t\t\t\t\t\t\t"), ['bold' => true]);

            $fieldText->addText('Por ', 'rightTab');
            $fieldText->addText('EL NEGOCIO AFILIADO,', ['bold' => true], 'rightTab');

            $section->addField('XE', [], [], $fieldText);
        }

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="Contrato.docx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');

        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save('php://output');
    }
}
