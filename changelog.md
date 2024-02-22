# **Lista de Pendientes**

-   Modulo de Facturación [ ]
-   Domiciliación Bancaria:
    -   Banco de Venezuela [ ]
    -   Banplus [ ]
    -   Banco del Tesoro [ ]

# **Changelog**

Todos los cambios notables en el proyecto, serán visualizados en este documento

Basado en [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
y el proyecto busca adherirse al standard [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## **[0.0.2] - 03-2022**

### **Añadido**

-   Reactivación de Equipos via task scheduling
-   Reporte de Inteligencia de Negocios, añadido a la ruta de reportes, interfaz de reportes y repositorio de reportes.
-   Añadido validador de procesado para BFC
-   Añadido leyenda y archivo de ejemplo para la gestión masiva de cobranza
-   Añadido posibilidad de cambio para el canal, tipo de gestion e item de gestion en SAC

### **Cambiado**

-   Modificación Reporte Credicard por solicitud de Operaciones
-   Validación en Cuenta Bancaria para la creación de Preafiliaciones
-   Arreglado el exportador en Gestion Masiva de Cobranza
-   Modificado estado de cuenta en PDF para los clientes, según solicitudes de cobranzas
-   Modificado reporte de Despacho por solicitud de Operaciones
-   Modificado errores gramaticales en create.blade de Despacho para entrega del equipo
-   Modificado reporte de SAC, según solicitudes de Cobranzas
-   Modificado gestión de tickets SAC, para que admitan el ingreso de una observación al estar en proceso

### **Removido**

## **[0.0.1] -**

### **Añadido**

-   Better comments en InvoiceMasiveRepository, con esto se busca detallar la documentación sobre el aplicativo y su mantenimiento.
-   **17-01-2022**. Se agrego la verificación de Firma Personal al generar formato bancario de 100% Banco.
-   **18-01-2022**. Se modifica la BDD y migration correspondiente a la Tabla Contracts, ya que se agrega un nuevo tipo de dcustomer, siendo este "nodom". El cual representa a clientes sin Pago Domiciliado, los cuales realizaran pago de su servicio de manera personal ante la empresa Vepagos. Asi mismo, se hicieron los cambios pertinentes para reajustar toda la funcionalidad del aplicativo con este nuevo status.
-   Busqueda de cliente por Nro Afiliado.

### **Cambiado**

-   **04-01-2022**. A nivel de BDD, se realizo un alter table a la tabla de **atc**.
-   Se modifico la verificación de Firma Personal al generar formato bancario de Bancaribe. El numero de documento asociado a clientes con Firma Personal o Persona Natural, sera una integer, esto con el fin de eliminar ceros a la izquierda.
-   Modificaciones visuales en las vistas de creación para venta y preafiliación
-   **18-01-2022**. El Search UI fue removido de la ecuación para utilizar unicamente la barra de busqueda encontrada en el main header. Asi mismo, se modificaron los css asociados a este item para que su display sea en block.

### **Removido**

-   **04-01-2022**. Se elimina la opción de "Necesita más Campos?" en las vistas de los siguientes reportes:
    -   Programación (ReportAdminProgrammerExport)
    -   Despacho (ReportOfficeExport)
    -   Ventas
    -   Pagos
    -   Clientes
-   **07-01-2022**. Al validar la documentación de una preafiliación, ya no hace falta la verificación de todos los documentos para procesar la preafiliación. Si el caso no posee documentos, igualmente se procesa.

## **[0.0.1-alpha] -**

### **Añadido**

### **Cambiado**

-   Se modifica el controlador de Login y la vista de Login para que el usuario pueda seleccionar si dejar su sesión abierta.

### **Removido**
