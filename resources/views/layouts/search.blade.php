   <!-- ============ Search UI Start ============= -->
   <div class="search-ui">
       <div class="search-header">
           {!! Form::open(['id' => 'form', 'name' => 'form', 'route' => 'customers.search', 'method' => 'POST']) !!}
           {{ csrf_field() }}
           <img src="{{ asset('assets/images/logo-eureka.png') }}" alt="" class="logo">
           <input id="string" name="string" type="search" placeholder="Buscar Cliente..." class="search-input"
               autofocus>
           <button class="search btn btn-icon bg-transparent float-right mt-2">
               <i class="i-Close-Window text-18 text-muted"></i>
           </button>
           </a>
           {!! Form::close() !!}
       </div>

       <div class="search-title">

       </div>

       <div class="search-results list-horizontal">

       </div>
       <!-- PAGINATION CONTROL -->

   </div>
   <!-- ============ Search UI End ============= -->
