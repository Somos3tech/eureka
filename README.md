# **Eureka (LERP)**

Eureka es un Sistema de Planificación de Recursos Empresariales (ERP) desarrollado en Laravel.

![Logo Eureka](http://eureka.vepagos.com/assets/images/logo-eureka.png)

## **Contenido**

-   Dependencias
-   ¿Como Instalar?
-   Funciones
    -   Disponibles
    -   En Desarrollo

## **Dependencias**

La paqueteria necesaria para utilizar este LERP es:

-   php-common
-   php-imagick
-   php-mbstring
-   php-mysql
-   php-xml
-   php-cli
-   php-common
-   php-curl
-   php-fpm
-   php-gd
-   php-imap
-   php-intl
-   php-json
-   php-mbstring
-   php-mysql
-   php-opcache
-   php-readline
-   php-soap
-   php-xml
-   php-xmlrpc
-   php-zip
-   php

## **¿Como Instalar?**

### _**En Proceso**_

### LAMP (Testeado en Ubuntu 20.04)

1. Instala la pila LAMP en tu servidor/maquina, si no sabes como hacerlo sigue esta [_**guia**_](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-20-04-es)

2. Asegurate de instalar los paquetes de PHP mencionados en la sección de [Dependencias]

3. Clona este repositorio en el directorio `/var/www`<br>

_Para clonar usa el comando:_

```bash
git clone
```

4. Instala composer <br>

```bash
sudo apt install composer php-curl php-xml php-gd php-zip -y
```

5. Ingresa en la carpeta que clonaste en `/var/www`

```bash
cd /var/www/eureka
```

6. Instala los modulos de Composer:

```bash
sudo composer install
```

7. Instala los modulos de Composer:

```bash
sudo composer install
```

8. Instala los paquetes de npm:

```bash
sudo npm install
```

9. Instala los modulos de Composer:

```bash
sudo php artisan key:generate
```

### Docker

_**Proximamente**_

## **Funciones**

-   [x] Mantener Sesión Abierta
-   [x] Modulos
    -   [x] Preafiliación
    -   [x] Validación de Documentos
        -   [ ] Toggle de Documentos (No es necesario que todos esten activos para validar el documento)
    -   [x] Ventas
    -   [x] Reporteria
        -   [x] Ventas
        -   [x] Clientes
        -   [x] Inventario
            -   [x] SimCards
            -   [x] Terminales
        -   [x] Pagos (Conciliaciones, Cobros Realizados)
        -   [x] Tasa de Cambio
        -   [x] Preafiliaciones
        -   [x] Despacho
        -   [x] Equipos Programados
-   [x] Generación de Archivos Bancarios
    -   [x] Banco Plaza
    -   [x] Banco de Venezuela
    -   [x] Mercantil
    -   [x] Mi Banco
    -   [x] Banco Fondo Comun
    -   [x] Delsur
    -   [x] Banplus
-   [ ] Chat Empresarial
-   [ ] Notificaciones
    -   [ ] Soporte Administrativo (Notificación que alerta al vendedor que cargue el soporte de pago)
    -   [ ] Internas
    -   [ ] Via Email
-   [x] API SMS
-   [ ] Parametrización de Metodos de Pago
-   [ ] Busqueda
    -   [ ] Por Serial Terminal
    -   [ ] Por Serial SimCard
    -   [ ] Por Serial Afiliado
-   [ ] Errores (Visualizar tipos de errores)
-   [ ] Validaciones Correctas
    -   [ ] Carga en Formato Correcto
-   [ ] Parametrización Correcta de Perfiles
    -   [ ] Listar todas las Permisologias
-   [ ] Dashboards
    -   [ ] Opción de Personalización.
    -   [ ] Dashboards mas visuales
# eureka
