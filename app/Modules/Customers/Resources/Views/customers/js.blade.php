  <script type="text/javascript">
      $.get('/states/select', function(data) {
          //Select Estado
          $('#state_id').empty();
          $('#state_id').append("<option value=''>Seleccione Estado...</option>");

          $.each(data, function(index, substateObj) {
              $('#state_id').append("<option value='" + substateObj.id + "'>" + substateObj.description +
                  "</option>");
          });

          $("#state_id option[value=" + {{ $data['state_id'] ?? old('state_id') }} + "]").attr("selected",
              true);

          $('#state_fiscal_id').empty();
          $('#state_fiscal_id').append("<option value=''>Seleccione Estado...</option>");

          $.each(data, function(index, substateObj) {
              $('#state_fiscal_id').append("<option value='" + substateObj.id + "'>" + substateObj
                  .description + "</option>");
          });
          $("#state_fiscal_id option[value=" + {{ $data['state_fiscal_id'] ?? old('state_fiscal_id') }} + "]")
              .attr("selected", true);
      });
      /****************************************************************************/
      $.get('/cities/select?state= {{ $data['state_id'] }}', function(data) {
          if (data.length == '') {
              document.getElementById("city_id").disabled = true;
          } else {
              document.getElementById("city_id").disabled = false;
              $('#city_id').empty();
              $('#city_id').append("<option value=''>Seleccione Ciudad...</option>");

              $.each(data, function(index, subciudObj) {
                  $('#city_id').append("<option value='" + subciudObj.id + "'>" + subciudObj.description +
                      "</option>");
              });
              $("#city_id option[value=" + {{ $data['city_id'] ?? old('city_id') }} + "]").attr("selected",
                  true);
          }
      });
      /****************************************************************************/
      if ({{ $data['type_cont'] }} > 1) {
          $('#tax').removeAttr('disabled');
          $('#tax').attr('required', true);
          $("#tax option[value=" + {{ $data['tax'] }} + "]").attr("selected", true);
      } else {
          $('#tax').attr('disabled', 'disabled');
          $('#tax').removeAttr('required');
      }
      /****************************************************************************/
      if ("{{ $data['state_fiscal_id'] }}" != "") {
          $('#checkbox')[0].checked = false;
          $(".fiscal").css('display', 'block');
          $('.addressfiscal').removeAttr('disabled');
          $('.addressfiscal').attr('required', true);

          $.get('/states/select', function(data) {
              $('#state_fiscal_id').empty();
              $('#state_fiscal_id').append("<option value=''>Seleccione Estado...</option>");

              $.each(data, function(index, substateObj) {
                  $('#state_fiscal_id').append("<option value='" + substateObj.id + "'>" + substateObj
                      .description + "</option>");
              });

              $("#state_fiscal_id option[value=" + {{ $data['state_fiscal_id'] }} + "]").attr("selected", true);
              $.get('/cities/select?state={{ $data['state_fiscal_id'] }}', function(data) {
                  if (data.length == '') {
                      document.getElementById("city_fiscal_id").disabled = true;
                  } else {
                      document.getElementById("city_fiscal_id").disabled = false;
                      $('#city_fiscal_id').empty();
                      $('#city_fiscal_id').append("<option value=''>Seleccione Ciudad...</option>");

                      $.each(data, function(index, subciudObj) {
                          $('#city_fiscal_id').append("<option value='" + subciudObj.id + "'>" +
                              subciudObj.description + "</option>");
                      });
                      $("#city_fiscal_id option[value=" + {{ $data['city_fiscal_id'] }} + "]").attr(
                          "selected", true);
                  }
              });
          });

          $("#city_fiscal_id option[value=" + {{ $data['city_fiscal_id'] }} + "]").attr("selected", true);
          document.getElementById("municipality_fiscal").value = '{{ $data['municipality_fiscal'] }}';
          document.getElementById("address_fiscal").value = '{{ $data['address_fiscal'] }}';
          document.getElementById("postal_code_fiscal").value = '{{ $data['postal_code_fiscal'] }}';
      } else {
          $(".fiscal").css('display', 'none');
          $('.addressfiscal').attr('disabled', 'disabled');
          $('.addressfiscal').removeAttr('required');
      }
      /****************************************************************************/
      $.get('/cactivities/select', function(data) {
          $('#cactivity_id').empty();
          $('#cactivity_id').append("<option value=''>Seleccione Actividad Comercial...</option>");
          $.each(data, function(index, subCactivityObj) {
              $('#cactivity_id').append("<option value='" + subCactivityObj.id + "'>" + subCactivityObj
                  .description + "</option>");
          });
          $("#cactivity_id option[value=" + {{ $data['cactivity_id'] ?? old('cactivity_id') }} + "]").attr(
              "selected", true);
      });
      /****************************************************************************/
      $.get('/companies/select/zone-valid', function(data) {
          $('#company_id').empty();
          if (data.length > 1) {
              $('#company_id').append("<option value=''>Seleccione Almacén Venta...</option>");
          } else {
              $('#company_id').attr('readonly', 'readonly');
          }
          /****************************************************************************/
          $.each(data, function(index, subCompanyObj) {
              document.getElementById("company_id").disabled = false;
              $('#company_id').append("<option value='" + subCompanyObj.id + "'>" + subCompanyObj
                  .description + "</option>");
          });
          $("#company_id option[value=" + {{ $data['company_id'] ?? old('company_id') }} + "]").attr(
              "selected", true);
      });
      /****************************************************************************/
      $('.document').mask('S-AAAAAAAA', {
          'translation': {
              S: {
                  pattern: /[CVEJPGRcvejpgr]{1}/
              },
              A: {
                  pattern: /[0-9]/
              },
              Y: {
                  pattern: /[0-9]/,
                  optional: true
              }
          }
      });

      $('.zero').keyup(function() {
          if (this.value.charAt(0) != 0) {
              this.value = this.value;
          } else {
              this.value = this.value.slice(1);
          }
      });

      $('.rif').keyup(function() {
          this.value = this.value.toUpperCase();
      });

      $('.rif').mask('S-AAAAAAAA-Y', {
          'translation': {
              S: {
                  pattern: /[CVEJPGRcvejpgr]{1}/
              },
              A: {
                  pattern: /[0-9]/
              },
              Y: {
                  pattern: /[0-9]/,
                  optional: true
              }
          }
      });

      $('.mayusc').keyup(function() {
          this.value = this.value.toUpperCase();
      });

      $('.minusc').keyup(function() {
          this.value = this.value.toLowerCase();
      });

      $('.letter').keyup(function() {
          this.value = this.value.toLowerCase();
          this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
      });

      $('.numberl').mask('AAAAAAAA', {
          'translation': {
              A: {
                  pattern: /[0-9]/
              }
          }
      });

      $('.number').mask('AAAAAAA', {
          'translation': {
              A: {
                  pattern: /[0-9]/
              }
          }
      });

      $('.phone').mask('STAA-AAAAAAA', {
          'translation': {
              S: {
                  pattern: /[0]/
              },
              T: {
                  pattern: /[248]/
              },
              A: {
                  pattern: /[0-9]/
              }
          }
      });

      $('.postal').mask('AAAA', {
          'translation': {
              A: {
                  pattern: /[0-9]/
              }
          }
      });

      $('.blank').blur(function() {
          /* Obtengo el valor contenido dentro del input */
          var value = $(this).val();

          /* Elimino todos los espacios en blanco que tenga la cadena delante y detrás */
          var value_without_space = $.trim(value);

          /* Cambio el valor contenido por el valor sin espacios */
          $(this).val(value_without_space);
      });
  </script>
