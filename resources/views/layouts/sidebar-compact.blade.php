<div class="app-admin-wrap layout-sidebar-compact sidebar-dark-purple sidenav-open clearfix">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">

            <li class="nav-item {{ request()->is('roles*') || request()->is('permissions*') || request()->is('users*') || request()->is('/') ? 'active' : '' }}"
                data-toggle="tooltip" data-placement="right" data-item="dashboard">
                <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                    title="Menú Principal">
                    <i class="nav-icon i-Security-Settings"></i>
                    <span class="nav-text">Menú Principal</span>
                </a>
                <div class="triangle"></div>
            </li>
            <blade>

                @can('preafiliations.index')
                    <li class="nav-item {{ Route::currentRouteName() == 'preafiliations.index' || Route::currentRouteName() == 'preafiliations.create' ? 'active' : '' }}"
                        data-item="preafiliation">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Pre Afiliación">
                            <i class="nav-icon i-Affiliate"></i>
                            <span class="nav-text">Pre-Afiliación</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endcan

                @can('preafiliations.edit')
                    <li class="nav-item {{ Route::currentRouteName() == 'preafiliations.valid' || Route::currentRouteName() == 'customers.datatable.valid.checklist' || Route::currentRouteName() == 'customers.datatable.valid.checkcontract' ? 'active' : '' }}"
                        data-item="backoffice">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Documentos">
                            <i class="nav-icon i-Open-Book"></i>
                            <span class="nav-text">Documentos</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endcan

                @if (auth()->user()->hasAnyPermission(['customers.index', 'customers.create', 'sales.create']))
                    <li class="nav-item {{ Route::currentRouteName() == 'customers.index' || Route::currentRouteName() == 'customers.show' || Route::currentRouteName() == 'customers.create' || request()->is('sales/*') ? 'active' : '' }}"
                        data-item="sales">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Ventas">
                            <i class="nav-icon i-Shopping-Cart"></i>
                            <span class="nav-text">Ventas</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endif

                @can('invoices.index')
                    <li class="nav-item {{ request()->is('invoices/*') || Route::currentRouteName() == 'invoices.index' || Route::currentRouteName() == 'invoices.financing' || Route::currentRouteName() == 'invoices.postpago' || Route::currentRouteName() == 'collections.delete' ? 'active' : '' }}"
                        data-item="invoices">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Conciliación">
                            <i class="nav-icon i-Cash-Register"></i>
                            <span class="nav-text">Conciliación</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endcan

                @can('services.index')
                    <li class="nav-item {{ request()->is('services*') || Route::currentRouteName() == 'operterminals.report' || Route::currentRouteName() == 'collections.service.masive' || Route::currentRouteName() == 'reports.operation' || request()->is('operations*') || request()->is('operterminals*') || request()->is('rcollections*') || request()->is('domiciliations*') || request()->is('adomiciliations*') || Route::currentRouteName() == 'collections.report.service' ? 'active' : '' }}"
                        data-item="services">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Cobranza">
                            <i class="nav-icon i-Coins"></i>
                            <span class="nav-text">Cobranza</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endcan

                @can('services.index')
                    <li class="nav-item {{ request()->is('paymentwallet*') || request()->is('statements*') ? 'active' : '' }}"
                        data-item="paymentwallet">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Modulo Cartera - Gestión Telefónica">
                            <i class="nav-icon i-Wallet"></i>
                            <span class="nav-text">Modulo Cartera - Gestión Telefónica </span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endcan

                @can('billings.index')
                    <li class="nav-item {{ request()->is('billings*') ? 'active' : '' }}" data-item="billing">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Facturación">
                            <i class="nav-icon i-Billing"></i>
                            <span class="nav-text">Facturación</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endcan

                @can('orders.index')
                    <li class="nav-item {{ request()->is('orders*') || request()->is('offices*') ? 'active' : '' }}"
                        data-item="service">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Servicios">
                            <i class="nav-icon i-Box-Full"></i>
                            <span class="nav-text">Servicios</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endcan

                @if (auth()->user()->hasAnyPermission(['terminals.index', 'simcards.index']))
                    <li class="nav-item {{ request()->is('terminals*') || request()->is('simcards*') ? 'active' : '' }}"
                        data-item="store">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Almacén">
                            <i class="nav-icon i-Post-Office"></i>
                            <span class="nav-text">Almacén</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endif

                @can('reports.index')
                    <li class="nav-item {{ Route::currentRouteName() == 'reports.preafiliation' || Route::currentRouteName() == 'reports.sales' || Route::currentRouteName() == 'reports.customer' || Route::currentRouteName() == 'reports.store' || Route::currentRouteName() == 'reports.office' || Route::currentRouteName() == 'reports.programmer' || Route::currentRouteName() == 'reports.collection' || Route::currentRouteName() == 'reports.atc' || Route::currentRouteName() == 'reports.currencyvalue' ? 'active' : '' }}"
                        data-item="reports">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Reportes">
                            <i class="nav-icon i-File-Graph"></i>
                            <span class="nav-text">Reportes</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endcan

                @if (auth()->user()->hasAnyPermission([
                        'csupports.index',
                        'supports.index',
                        'serviceSupport.contract',
                        'serviceSupport.invoice',
                        'managementtypes.index',
                        'mtypeitems.index',
                        'channels.inex',
                    ]))
                    <li class="nav-item {{ request()->is('supports*') || request()->is('csupports*') || Route::currentRouteName() == 'serviceSupport.contract' || Route::currentRouteName() == 'serviceSupport.invoice' ? 'active' : '' }}"
                        data-item="supports">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Soporte">
                            <i class="nav-icon i-Gear-2"></i>
                            <span class="nav-text">Soporte</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endif

                @can('atc.index')
                    <li class="nav-item {{ request()->is('atcs*') || request()->is('mtypeitems*') || request()->is('managementtypes*') || request()->is('channels*') ? 'active' : '' }}"
                        data-item="atcs">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Servicio de Atención al Cliente">
                            <i class="nav-icon i-Support"></i>
                            <span class="nav-text">Servicio de Atención al Cliente</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endcan

                @if (auth()->user()->hasAnyPermission([
                        'acconcepts.index',
                        'typecompanies.index',
                        'typecompanies.index',
                        'operators.index',
                        'apn.index',
                        'marks.index',
                        'business.index',
                        'currency.index',
                        'tipifications.index',
                        'pmethods.index',
                        'company.index',
                        'banks.index',
                        'consultants.index',
                        'mterminal.index',
                        'terminalvalues.index',
                        'currencyvalues.index',
                        'concept.index',
                        'terms.index',
                        'cactivities.index',
                        'zonerole.index',
                    ]))
                    <li class="nav-item {{ request()->is('acconcepts*') || request()->is('typecompanies*') || request()->is('operators*') || request()->is('apn*') || request()->is('marks*') || request()->is('business*') || request()->is('currencies*') || request()->is('tipifications*') || request()->is('pmethods*') || request()->is('companies*') || request()->is('banks*') || request()->is('consultants*') || request()->is('mterminals*') || request()->is('terminalvalues*') || request()->is('currencyvalues*') || request()->is('concepts*') || request()->is('terms*') || request()->is('cactivities*') || request()->is('zoneroles*') || request()->is('payers*') ? 'active' : '' }}"
                        data-item="parameters">
                        <a class="nav-item-hold" href="#" data-toggle="tooltip" data-placement="right"
                            title="Parámetros">
                            <i class="nav-icon i-Gears"></i>
                            <span class="nav-text">Parámetros</span>
                        </a>
                        <div class="triangle"></div>
                    </li>
                @endif
        </ul>
    </div>

    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <i class="sidebar-close i-Close" (click)="toggleSidebar()"></i>
        <header>
            <div>
                <img src="{{ asset('/assets/images/logo-eureka.png') }}" alt="">
            </div>
            <br />
        </header>

        <!-- Submenu Dashboards -->
        <div class="submenu-area" data-parent="preafiliation">
            <header>
                <h6>Módulo Preafiliación</h6>
                <p>Carga Inicial de Venta</p>
            </header>

            <ul class="childNav" data-parent="preafiliation">
                @can('preafiliations.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'preafiliations.index' ? 'open' : '' }}"
                            href="{{ route('preafiliations.index') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                @endcan
                @can('preafiliations.create')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'preafiliations.create' ? 'open' : '' }}"
                            href="{{ route('preafiliations.create') }}">
                            <i class="nav-icon i-Add-User"></i>
                            <span class="item-name">Crear Pre-Afiliación</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>

        <div class="submenu-area" data-parent="dashboard">
            <header>
                <h6>Menú Principal</h6>
                <p>Configuraciones Generales</p>
            </header>

            <ul class="childNav" data-parent="dashboard">
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'dashboard' ? 'open' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>

                @can('permissions.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'permissions.index' ? 'open' : '' }}"
                            href="{{ route('permissions.index') }}">
                            <i class="nav-icon i-Checked-User"></i>
                            <span class="item-name">Permisos</span>
                        </a>
                    </li>
                @endcan

                @can('roles.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'roles.index' ? 'open' : '' }}"
                            href="{{ route('roles.index') }}">
                            <i class="nav-icon i-Network"></i>
                            <span class="item-name">Perfiles</span>
                        </a>
                    </li>
                @endcan

                @can('users.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'users.index' ? 'open' : '' }}"
                            href="{{ route('users.index') }}">
                            <i class="nav-icon i-Male"></i>
                            <span class="item-name">Usuarios</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>

        <div class="submenu-area" data-parent="parameters">
            <header>
                <h6>Parámetros</h6>
                <p>Información Esencial</p>
            </header>

            <ul class="childNav" data-parent="parameters">
                @can('zonerole.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'zoneroles.index' ? 'open' : '' }}"
                            href="{{ route('zoneroles.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Perfiles Sin Zona</span>
                        </a>
                    </li>
                @endcan

                @can('acconcepts.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'acconcepts.index' ? 'open' : '' }}"
                            href="{{ route('acconcepts.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Cuentas Contables</span>
                        </a>
                    </li>
                @endcan

                @can('business.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'business.index' ? 'open' : '' }}"
                            href="{{ route('business.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Empresa</span>
                        </a>
                    </li>
                @endcan

                @can('cactivities.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'cactivities.index' ? 'open' : '' }}"
                            href="{{ route('cactivities.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Actividad Comercial</span>
                        </a>
                    </li>
                @endcan

                @can('consultants.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'consultants.index' ? 'open' : '' }}"
                            href="{{ route('consultants.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Aliado Comercial</span>
                        </a>
                    </li>
                @endcan

                @can('typecompanies.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'typecompanies.index' ? 'open' : '' }}"
                            href="{{ route('typecompanies.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Categoría Almacén</span>
                        </a>
                    </li>
                @endcan

                @can('company.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'companies.index' ? 'open' : '' }}"
                            href="{{ route('companies.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Almacén</span>
                        </a>
                    </li>
                @endcan

                @can('banks.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'banks.index' ? 'open' : '' }}"
                            href="{{ route('banks.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Banco</span>
                        </a>
                    </li>
                @endcan

                @can('payers.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'payers.index' ? 'open' : '' }}"
                            href="{{ route('payers.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">No. Ordenante x Banco</span>
                        </a>
                    </li>
                @endcan

                @can('terms.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'terms.index' ? 'open' : '' }}"
                            href="{{ route('terms.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Planes Servicios</span>
                        </a>
                    </li>
                @endcan

                @can('pmethods.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'pmethods.index' ? 'open' : '' }}"
                            href="{{ route('pmethods.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Método Pago</span>
                        </a>
                    </li>
                @endcan

                @can('marks.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'marks.index' ? 'open' : '' }}"
                            href="{{ route('marks.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Marca</span>
                        </a>
                    </li>
                @endcan

                @can('mterminal.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'mterminals.index' ? 'open' : '' }}"
                            href="{{ route('mterminals.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Modelo Equipo</span>
                        </a>
                    </li>
                @endcan

                @can('operators.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'operators.index' ? 'open' : '' }}"
                            href="{{ route('operators.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Operador</span>
                        </a>
                    </li>
                @endcan

                @can('apn.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'apn.index' ? 'open' : '' }}"
                            href="{{ route('apn.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">APN</span>
                        </a>
                    </li>
                @endcan

                @can('currency.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'currencies.index' ? 'open' : '' }}"
                            href="{{ route('currencies.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Divisas</span>
                        </a>
                    </li>
                @endcan

                @can('currencyvalues.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'currencyvalues.index' ? 'open' : '' }}"
                            href="{{ route('currencyvalues.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Tarifa Divisa</span>
                        </a>
                    </li>
                @endcan

                @can('terminalvalues.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'terminalvalues.index' ? 'open' : '' }}"
                            href="{{ route('terminalvalues.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Tarifa Equipo</span>
                        </a>
                    </li>
                @endcan

                @can('concept.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'concepts.index' ? 'open' : '' }}"
                            href="{{ route('concepts.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Tipificación Venta</span>
                        </a>
                    </li>
                @endcan

                @can('tipifications.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'tipifications.index' ? 'open' : '' }}"
                            href="{{ route('tipifications.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Tipificación Soporte</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>

        <!-- Submenu Dashboards -->
        <div class="submenu-area" data-parent="backoffice">
            <header>
                <h6>Módulo Válidación Documentos</h6>
                <p>Gestión Documentos</p>
            </header>

            <ul class="childNav" data-parent="backoffice">
                @can('preafiliations.edit')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'preafiliations.valid' ? 'open' : '' }}"
                            href="{{ route('preafiliations.valid') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                @endcan
                @can('documents.edit')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'customers.datatable.valid.checklist' ? 'open' : '' }}"
                            href="{{ route('customers.datatable.valid.checklist') }}">
                            <i class="nav-icon i-Add-User"></i>
                            <span class="item-name">Dashboard Validación Documentos Físicos</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'customers.datatable.valid.checkcontract' ? 'open' : '' }}"
                            href="{{ route('customers.datatable.valid.checkcontract') }}">
                            <i class="nav-icon i-Add-User"></i>
                            <span class="item-name">Dashboard Validación Formalización Contrato Físico</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>

        <div class="submenu-area" data-parent="sales">
            <header>
                <h6>Modulo Ventas</h6>
                <p>Registrar Cliente - Ventas</p>
            </header>
            <ul class="childNav" data-parent="sales">

                @can('sales.index', 'sales.create', 'customers.create')
                    @can('customers.create')
                        <li class="nav-item">
                            <a class="{{ Route::currentRouteName() == 'customers.create' ? 'open' : '' }}"
                                href="{{ route('customers.create') }}">
                                <i class="nav-icon i-Add-User"></i>
                                <span class="item-name">Registrar Cliente</span>
                            </a>
                        </li>
                    @endcan

                    @can('sales.create')
                        <li class="nav-item">
                            <a class="{{ Route::currentRouteName() == 'sales.create' ? 'open' : '' }}"
                                href="{{ route('sales.create') }}">
                                <i class="nav-icon i-Add-Cart"></i>
                                <span class="item-name">Registrar Equipo</span>
                            </a>
                        </li>
                    @endcan
                @endcan
            </ul>
        </div>

        <div class="submenu-area" data-parent="invoices">
            <header>
                <h6>Modulo Conciliación</h6>
                <p>Válidación Pagos, Anular Pagos</p>
            </header>

            <ul class="childNav" data-parent="invoices">
                @can('invoices.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'invoices.index' ? 'open' : '' }}"
                            href="{{ route('invoices.index') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Venta Equipos</span>
                        </a>
                    </li>
                @endcan

                @can('invoices.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'invoices.financing' ? 'open' : '' }}"
                            href="{{ route('invoices.financing') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Financiamiento</span>
                        </a>
                    </li>
                @endcan

                @can('invoices.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'invoices.postpago' ? 'open' : '' }}"
                            href="{{ route('invoices.postpago') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Postpago</span>
                        </a>
                    </li>
                @endcan

                @can('collections.destroy')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'collections.delete' ? 'open' : '' }}"
                            href="{{ route('collections.delete') }}">
                            <i class="nav-icon i-Coins"></i>
                            <span class="item-name">Anular Pago</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>

        <div class="submenu-area" data-parent="services">
            <header>
                <h6>Modulo Cobranza</h6>
                <p>Generación Masiva Cobros, Gestión</p>
            </header>

            <ul class="childNav" data-parent="services">

                @can('adomiciliations.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'adomiciliations.index' ? 'open' : '' }}"
                            href="{{ route('adomiciliations.index') }}">
                            <i class="nav-icon i-Affiliate"></i>
                            <span class="item-name">Afiliación Bancaría</span>
                        </a>
                    </li>
                @endcan

                @can('domiciliations.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'domiciliations.index' ? 'open' : '' }}"
                            href="{{ route('domiciliations.index') }}">
                            <i class="nav-icon i-Book"></i>
                            <span class="item-name">Domiciliación Bancaría</span>
                        </a>
                    </li>
                @endcan
                <header>
                    <h6>Gestión</h6>
                </header>

                @can('operations.create')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'operations.create' ? 'open' : '' }}"
                            href="{{ route('operations.create') }}">
                            <i class="nav-icon i-Gears"></i>
                            <span class="item-name">Gestión Cobranza Servicios</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'operations.masive' ? 'open' : '' }}"
                            href="{{ route('operations.masive') }}">
                            <i class="nav-icon i-Gears"></i>
                            <span class="item-name">Gestión Cobranza Servicio Masiva</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'operterminals.index' ? 'open' : '' }}"
                            href="{{ route('operterminals.index') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Dashboard Gestión Terminales</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'operterminals.create' ? 'open' : '' }}"
                            href="{{ route('operterminals.create') }}">
                            <i class="nav-icon i-Gears"></i>
                            <span class="item-name">Gestión Terminal</span>
                        </a>
                    </li>
                @endcan

                <header>
                    <br>
                    <h6>Reportes</h6>
                    <p>Reportes Detallados, etc..</p>
                </header>
                @can('services.edit')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'services.report.affiliate' ? 'open' : '' }}"
                            href="{{ route('services.report.affiliate') }}">
                            <i class="nav-icon i-Affiliate"></i>
                            <span class="item-name">Afiliación Bancaría</span>
                        </a>
                    </li>
                @endcan

                @can('services.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'services.financial' ? 'open' : '' }}"
                            href="{{ route('services.financial') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Cartera Financiera</span>
                        </a>
                    </li>
                @endcan

                @can('services.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'services.bankmovement' ? 'open' : '' }}"
                            href="{{ route('services.bankmovement') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Resumen Bancario</span>
                        </a>
                    </li>
                @endcan

                @can('services.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'services.report.demographic' ? 'open' : '' }}"
                            href="{{ route('services.report.demographic') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Cartera Demográfica</span>
                        </a>
                    </li>
                @endcan

                @can('services.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'services.report.invoices.detail' ? 'open' : '' }}"
                            href="{{ route('services.report.invoices.detail') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Consolidado de Pagos Procesados</span>
                        </a>
                    </li>
                @endcan

                @can('services.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'services.report.active' ? 'open' : '' }}"
                            href="{{ route('services.report.active') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Cobranza Activa</span>
                        </a>
                    </li>
                @endcan

                @can('services.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'rcollections.report' ? 'open' : '' }}"
                            href="{{ route('rcollections.report') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Historial de Domiciliacion</span>
                        </a>
                    </li>
                @endcan

                @can('services.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'collections.report.service' ? 'open' : '' }}"
                            href="{{ route('collections.report.service') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Pagos Diarios</span>
                        </a>
                    </li>
                @endcan

                @can('services.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'reports.operation' ? 'open' : '' }}"
                            href="{{ route('reports.operation') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Operaciones Diarias</span>
                        </a>
                    </li>
                @endcan

                @can('services.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'operterminals.report' ? 'open' : '' }}"
                            href="{{ route('operterminals.report') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Reporte Gestión Terminal</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>

        <div class="submenu-area" data-parent="paymentwallet">
            <header>
                <h6>Modulo Cartera - Gestión Telefónica </h6>
                <p>&nbsp;</p>
            </header>

            <ul class="childNav" data-parent="paymentwallet">
                <header>
                    <h6>Estado de Cuenta</h6>
                </header>

                @can('statements.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'statements.index' ? 'open' : '' }}"
                            href="{{ route('statements.index') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'statements.detail.customer' ? 'open' : '' }}"
                            href="{{ route('statements.detail.customer') }}">
                            <i class="nav-icon i-Find-User"></i>
                            <span class="item-name">Consultar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'statements.banks.customer' ? 'open' : '' }}"
                            href="{{ route('statements.banks.customer') }}">
                            <i class="nav-icon i-Cash-Register"></i>
                            <span class="item-name">Estado Cuenta - Cliente</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'statements.banks.contract' ? 'open' : '' }}"
                            href="{{ route('statements.banks.contract') }}">
                            <i class="nav-icon i-Cash-Register"></i>
                            <span class="item-name">Estado Cuenta - Contrato</span>
                        </a>
                    </li>
                @endcan

                <header>
                    <h6>Cartera</h6>
                </header>

                @can('paymentwallet.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'paymentwallet.index' ? 'open' : '' }}"
                            href="#">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                @endcan
            </ul>


        </div>

        <div class="submenu-area" data-parent="billing">
            <header>
                <h6>Facturación</h6>
                <p>Radicación Factura Electrónica</p>
            </header>

            <ul class="childNav" data-parent="starter">
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'billings.index' ? 'open' : '' }}"
                        href="{{ route('billings.index') }}">
                        <i class="nav-icon i-Clock-3"></i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="{{ Route::currentRouteName() == 'billings.create' ? 'open' : '' }}" href="#">
                        <i class="nav-icon i-Clock-3"></i>
                        <span class="item-name">Generar Factura</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="submenu-area" data-parent="atcs">
            <header>
                <h6>Módulo de Servicio Al Cliente</h6>
                <p>Gestión SAC</p>
            </header>

            <ul class="childNav" data-parent="atcs">
                @can('atcs.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'atcs.index' ? 'open' : '' }}"
                            href="{{ route('atcs.index') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'atcs.create' ? 'open' : '' }}"
                            href="{{ route('atcs.create') }}">
                            <i class="nav-icon i-Pen-5"></i>
                            <span class="item-name">Crear Ticket</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'atcs.create.internal' ? 'open' : '' }}"
                            href="{{ route('atcs.create.internal') }}">
                            <i class="nav-icon i-Pen-5"></i>
                            <span class="item-name">Crear Ticket Canal Interno</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'atcs.internal' ? 'open' : '' }}"
                            href="{{ route('atcs.internal') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Gestión Canales</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'atcs.sale' ? 'open' : '' }}"
                            href="{{ route('atcs.sale') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Gestión Ventas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'atcs.support' ? 'open' : '' }}"
                            href="{{ route('atcs.support') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Gestión Soporte Técnico</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'atcs.operations' ? 'open' : '' }}"
                            href="{{ route('atcs.operations') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Gestión Operaciones</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'atcs.invoice' ? 'open' : '' }}"
                            href="{{ route('atcs.invoice') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Gestión Cobranza</span>
                        </a>
                    </li>
                @endcan

                @can('mtypeitems.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'channels.index' ? 'open' : '' }}"
                            href="{{ route('channels.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Canal Gestión </span>
                        </a>
                    </li>
                @endcan
                @can('managementtypes.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'managementtypes.index' ? 'open' : '' }}"
                            href="{{ route('managementtypes.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Tipo Gestión</span>
                        </a>
                    </li>
                @endcan

                @can('mtypeitems.index')
                    <li class="nav-item ">
                        <a class="{{ Route::currentRouteName() == 'mtypeitems.index' ? 'open' : '' }}"
                            href="{{ route('mtypeitems.index') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Item Tipo Gestión</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>

        <div class="submenu-area" data-parent="store">
            <header>
                <h6>Módulo Almacén</h6>
                <p>Gestión de Inventario, Asignaciones</p>
            </header>

            <ul class="childNav" data-parent="store">
                @can('terminals.index')
                    <li class="nav-item ">
                        <a class="{{ request()->is('terminals*') ? 'open' : '' }}"
                            href="{{ route('terminals.index') }}">
                            <i class="nav-icon i-Orientation"></i>
                            <span class="item-name">Equipos</span>
                        </a>
                    </li>
                @endcan

                @can('simcards.index')
                    <li class="nav-item ">
                        <a class="{{ request()->is('simcards*') ? 'open' : '' }}"
                            href="{{ route('simcards.index') }}">
                            <i class="nav-icon i-Memory-Card"></i>
                            <span class="item-name">Simcards</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
        <div class="submenu-area" data-parent="service">
            <header>
                <h6>Módulo Servicios </h6>
                <p>Gestión de Servicios de Equipo</p>
            </header>

            <ul class="childNav" data-parent="service">
                @can('orders.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'orders.index' ? 'open' : '' }}"
                            href="{{ route('orders.index') }}">
                            <i class="nav-icon i-Dashboard"></i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                @endcan

                @can('orders.edit')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'orders.edit' ? 'open' : '' }}"
                            href="{{ route('orders.programmer') }}">
                            <i class="nav-icon i-Gear"></i>
                            <span class="item-name">Programación</span>
                        </a>
                    </li>
                @endcan

                @can('offices.index')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'offices.index' ? 'open' : '' }}"
                            href="{{ route('orders.office') }}">
                            <i class="nav-icon i-Checkout"></i>
                            <span class="item-name">Despacho</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>

        <div class="submenu-area" data-parent="reports">
            <header>
                <h6>Módulo Reportes</h6>
                <p>Reportes en General</p>
            </header>
            <ul class="childNav" data-parent="reports">
                @can('reports.preafiliation')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'reports.preafiliation' ? 'open' : '' }}"
                            href="{{ route('reports.preafiliation') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Preafiliación</span>
                        </a>
                    </li>
                @endcan

                @can('reports.sales')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'reports.sales' ? 'open' : '' }}"
                            href="{{ route('reports.sales') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Ventas</span>
                        </a>
                    </li>
                @endcan

                @can('reports.customer')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'reports.customer' ? 'open' : '' }}"
                            href="{{ route('reports.customer') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Clientes</span>
                        </a>
                    </li>
                @endcan

                @can('reports.store')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'reports.store' ? 'open' : '' }}"
                            href="{{ route('reports.store') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Almacén</span>
                        </a>
                    @endcan

                    @can('reports.programmer')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'reports.programmer' ? 'open' : '' }}"
                            href="{{ route('reports.programmer') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Programación</span>
                        </a>
                    </li>
                @endcan

                @can('reports.office')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'reports.office' ? 'open' : '' }}"
                            href="{{ route('reports.office') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Despacho</span>
                        </a>
                    </li>
                @endcan

                @can('reports.collection')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'reports.collection' ? 'open' : '' }}"
                            href="{{ route('reports.collection') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Pagos de Ventas</span>
                        </a>
                    </li>
                @endcan

                @can('reports.atc')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'reports.atc' ? 'open' : '' }}"
                            href="{{ route('reports.atc') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Servicio de Atención al Cliente</span>
                        </a>
                    </li>
                @endcan

                @can('reports.businesssale')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'reports.businesssale' ? 'open' : '' }}"
                            href="{{ route('reports.businesssale') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Inteligencia de Negocios</span>
                        </a>
                    </li>
                @endcan

                @can('reports.currencyvalue')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'reports.currencyvalue' ? 'open' : '' }}"
                            href="{{ route('reports.currencyvalue') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Tasa de Cambio</span>
                        </a>
                    </li>
                @endcan
                @can('reports.conciliation')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'reports.conciliation' ? 'open' : '' }}"
                            href="{{ route('reports.conciliation') }}">
                            <i class="nav-icon i-File-Download"></i>
                            <span class="item-name">Administración</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>

        <div class="submenu-area" data-parent="supports">
            <header>
                <h6>Módulo Soporte</h6>
                <p>Gestión Soporte Administrativo - Operativo</p>
            </header>
            <ul class="childNav" data-parent="supports">
                @can('csupports.index', 'csupports.create', 'csupports.edit')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'csupports.index' || Route::currentRouteName() == 'csupports.create' || Route::currentRouteName() == 'csupports.edit' ? 'open' : '' }}"
                            href="{{ route('csupports.index') }}">
                            <i class="nav-icon i-Gears"></i>
                            <span class="item-name">Administrativo</span>
                        </a>
                    </li>
                @endcan

                @can('serviceSupport.contract')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'serviceSupport.contract' ? 'open' : '' }}"
                            href="{{ route('serviceSupport.contract') }}">
                            <i class="nav-icon i-Gears"></i>
                            <span class="item-name">Contrato</span>
                        </a>
                    </li>
                @endcan

                @can('serviceSupport.invoice')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'serviceSupport.invoice' ? 'open' : '' }}"
                            href="{{ route('serviceSupport.invoice') }}">
                            <i class="nav-icon i-Gears"></i>
                            <span class="item-name">Cobro</span>
                        </a>
                    </li>
                @endcan

                @can('supports.index', 'supports.create', 'supports.edit')
                    <li class="nav-item">
                        <a class="{{ Route::currentRouteName() == 'supports.index' ? 'open' : '' }}" href="#">
                            <i class="nav-icon i-Gears"></i>
                            <span class="item-name">Soporte de Equipos - Garantía</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->
