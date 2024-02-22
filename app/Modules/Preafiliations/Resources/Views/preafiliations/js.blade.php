  <script type="text/javascript">
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

      $('.money').mask('000,000,000,000.00', {
          reverse: true
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

      $('.account').mask('-AAAA-AA-AAAAAAAAAA', {
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


      /* Evento para cuando el usuario libera la tecla escrita dentro del input */

      $('.blank').blur(function() {
          /* Obtengo el valor contenido dentro del input */
          var value = $(this).val();

          /* Elimino todos los espacios en blanco que tenga la cadena delante y detrás */
          var value_without_space = $.trim(value);

          /* Cambio el valor contenido por el valor sin espacios */
          $(this).val(value_without_space);
      });

      /****************************************************************************/
      $('#btnDel').attr('disabled', 'disabled');

      $('#btnAdd').click(function() {
          var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
          var newNum = new Number(num + 1); // the numeric ID of the new input field being added
          // create the new element via clone(), and manipulate it's ID using newNum value
          var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);
          // manipulate the name/id values of the input inside the new element
          // Añadir caja de texto.
          newElem.children(':last').attr('id', 'item' + newNum).attr('name', 'item' + newNum).find('input').val(
              "");
          // insert the new element after the last "duplicatable" input field
          $('#input' + num).after(newElem);

          var i = 0;
          // enable the "remove" button
          $('#btnDel').attr('disabled', false);
          // business rule: you can only add 10 names
          if (newNum == 10)
              $('#btnAdd').attr('disabled', 'disabled');
      });

      /****************************************************************************/
      $('#btnDel').click(function() {
          var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
          $('#input' + num).remove(); // remove the last element

          // enable the "add" button
          $('#btnAdd').attr('disabled', false);

          // if only one element remains, disable the "remove" button
          if (num - 1 == 1)
              $('#btnDel').attr('disabled', 'disabled');
      });
      /****************************************************************************/
      $.get('/states/select', function(data) {
          //Select Estado
          $('#state_id').empty();
          $('#state_id').append("<option value=''>Seleccione Estado...</option>");

          $.each(data, function(index, substateObj) {
              $('#state_id').append("<option value='" + substateObj.id + "'>" + substateObj.description +
                  "</option>");
          });

          //Select Estado Fiscal
          $("#state_id option[value=" + {{ old('state_id') }} + "]").attr("selected", true);

          $('#state_fiscal_id').empty();
          $('#state_fiscal_id').append("<option value=''>Seleccione Estado...</option>");

          $.each(data, function(index, substateObj) {
              $('#state_fiscal_id').append("<option value='" + substateObj.id + "'>" + substateObj
                  .description + "</option>");
          });
          $("#state_fiscal_id option[value=" + {{ old('state_fiscal_id') }} + "]").attr("selected", true);
      });
      /****************************************************************************/
      //Select Ciudad
      $.get('/cities/select?state= {{ old('state_id') }}', function(data) {
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
              $("#city_id option[value=" + {{ old('city_id') }} + "]").attr("selected", true);
          }
      });
      /****************************************************************************/
      //Select Ciudad Fiscal
      $.get('/cities/select?state= {{ old('state_fiscal_id') }}', function(data) {
          if (data.length == '') {
              document.getElementById("city_fiscal_id").disabled = true;
          } else {
              document.getElementById("city_fiscal_id").disabled = false;
              $('#city_fiscal_id').empty();
              $('#city_fiscal_id').append("<option value=''>Seleccione Ciudad...</option>");

              $.each(data, function(index, subciudObj) {
                  $('#city_fiscal_id').append("<option value='" + subciudObj.id + "'>" + subciudObj
                      .description + "</option>");
              });
              $("#city_fiscal_id option[value=" + {{ old('city_fiscal_id') }} + "]").attr("selected", true);
          }
      });
      /****************************************************************************/
      //Select Divisa
      $.get('/currencies/select', function(data) {
          $('#currency_id').empty();
          $('#currency_id').append("<option value=''>Seleccione Divisa...</option>");

          $.each(data, function(index, subCurrencyObj) {
              $('#currency_id').append("<option value='" + subCurrencyObj.id + "'>" + subCurrencyObj
                  .abrev + "</option>");
          });
          $("#currency_id option[value=" + {{ old('currency_id') }} + "]").attr("selected", true);
      });
      /****************************************************************************/
      //Select Banco
      $.get('/banks/select', function(data) {
          $('#bank_id').empty();
          $('#bank_id').append("<option value=''>Seleccione Banco...</option>");

          $.each(data, function(index, subBankObj) {
              $('#bank_id').append("<option value='" + subBankObj.id + "'>" + subBankObj.description +
                  "</option>");
          });
          $("#bank_id option[value=" + {{ old('bank_id') }} + "]").attr("selected", true);
      });
      /****************************************************************************/
      $.get('/cactivities/select', function(data) {
          $('#cactivity_id').empty();
          $('#cactivity_id').append("<option value=''>Seleccione Actividad Comercial...</option>");

          $.each(data, function(index, subCactivityObj) {
              $('#cactivity_id').append("<option value='" + subCactivityObj.id + "'>" + subCactivityObj
                  .description + "</option>");
          });
          $("#cactivity_id option[value=" + {{ old('cactivity_id') }} + "]").attr("selected", true);
      });
      /****************************************************************************/
      $.get('/mterminals/select?filter=active', function(data) {
          $('#modelterminal_id').empty();
          $('#modelterminal_id').append("<option value=''>Seleccione Modelo Terminal...</option>");

          $.each(data, function(index, subMterminalObj) {
              $('#modelterminal_id').append("<option value='" + subMterminalObj.id + "'>" +
                  subMterminalObj.description + "</option>");
          });
          $("#modelterminal_id option[value=" + {{ old('modelterminal_id') }} + "]").attr("selected", true);
      });
      /****************************************************************************/
      $.get('/operators/select', function(data) {
          $('#operator_id').empty();
          $('#operator_id').append("<option value=''>Seleccione Operador...</option>");

          $.each(data, function(index, subOperatorObj) {
              $('#operator_id').append("<option value='" + subOperatorObj.id + "'>" + subOperatorObj
                  .description + "</option>");
          });
          $("#operator_id option[value=" + {{ old('operator_id') }} + "]").attr("selected", true);
      });
      /****************************************************************************/

      $.get('/roles/getrole', function(data) {
          var slug = data.slug;
          $.get('/companies/select/zone-valid?slug=' + slug, function(data) {
              $('#company_id').empty();

              if (data.length > 1) {
                  $('#company_id').append("<option value=''>Seleccione Almacén Venta...</option>");
              } else {
                  $('#company_id').attr('readonly', 'readonly');
              }

              $.each(data, function(index, subCompanyObj) {
                  document.getElementById("company_id").disabled = false;
                  $('#company_id').append("<option value='" + subCompanyObj.id + "'>" +
                      subCompanyObj.description + "</option>");
              });
              $("#company_id option[value=" + {{ old('company_id') }} + "]").attr("selected", true);
          });
      });
      /****************************************************************************/
      $.get('/terms/select?type_condition=Fijo', function(data) {
          $('#term_id').empty();
          $('#term_id').append("<option value=''>Seleccione Plan de Servicios VEPAGOS...</option>");

          $.each(data, function(index, subTermObj) {
              $('#term_id').append("<option value='" + subTermObj.id + "'>" + subTermObj.description +
                  "</option>");
          });
          $("#term_id option[value=" + {{ old('term_id') }} + "]").attr("selected", true);
      });
      /****************************************************************************/
      $.get('/pmethods/select', function(data) {
          $('#pmethod_id').empty();
          $('#pmethod_id').append("<option value=''>Seleccione Método Pago...</option>");

          $.each(data, function(index, subPmethodObj) {
              $('#pmethod_id').append("<option value='" + subPmethodObj.id + "'>" + subPmethodObj
                  .description + "</option>");
          });
          $("#pmethod_id option[value=" + {{ old('pmethod_id') }} + "]").attr("selected", true);
      });
  </script>
