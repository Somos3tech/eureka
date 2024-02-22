  <script type="text/javascript">
      /****************************************************************************/
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
      $.get('/mterminals/select?filter=active', function(data) {
          $('#modelterminal_id').empty();
          $('#modelterminal_id').append("<option value=''>Seleccione Modelo Equipo...</option>");

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

      $('.numbermercant').mask('AAAAAAAAAAAAA', {
          'translation': {
              A: {
                  pattern: /[0-9]/
              }
          }
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

      $('.money').mask('000,000,000,000,000.00', {
          reverse: true
      });

      $('.zero').keyup(function() {
          if (this.value.charAt(0) != 0) {
              this.value = this.value;
          } else {
              this.value = this.value.slice(1);
          }
      });
  </script>
