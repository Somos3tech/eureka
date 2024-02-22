<script>
    $(document).ready(function() {
        /****************************************************************************/
        //Select Banco
        $.get('/banks/select', function(data) {
            $('#bank_id').empty();
            $('#bank_id').append("<option value=''>Seleccione Banco...</option>");

            $.each(data, function(index, subBankObj) {
                $('#bank_id').append("<option value='" + subBankObj.id + "'>" + subBankObj
                    .description + "</option>");
            });
            $("#bank_id option[value=" + {{ old('bank_id') }} + "]").attr("selected", true);
        });
        listdcustomer();
    });

    var listdcustomer = function() {
        var route = "/dcustomers/datatable?id=" + {{ (int) $customer->id }};
        dcustomers = $('#dcustomers-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: true,
            iDisplayLength: 5,
            ajax: route,
            columns: [{
                    data: "actions",
                    "className": "text-center"
                },
                {
                    data: "bank",
                    "className": "text-center",
                    "width": "10%"
                },
                {
                    data: "type_account",
                    "className": "text-center"
                },
                {
                    data: "account_number",
                    "className": "text-center"
                },
                {
                    data: "affiliate_number",
                    "className": "text-center"
                },
                {
                    data: "personal_signature",
                    "className": "text-center",
                    "width": "10%"
                },
                {
                    data: "multicommerce",
                    "className": "text-center"
                },
                {
                    data: "rif",
                    "className": "text-center"
                },
                {
                    data: "business_name",
                    "className": "text-center"
                },
                {
                    data: "user_updated",
                    "className": "text-center"
                },
                {
                    data: "updated_at",
                    "className": "text-center"
                },
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            dom: 'Bfrtip',
            buttons: [],
            "order": [
                [3, "asc"],
            ]
        });
    }

    $("#create-dcustomer").click(function() {
        var customer_id = $("#customer_id").val();
        var checkbox = $("#checkbox").val();
        var rif = $("#rif").val();
        var business_name = $("#business_name").val();
        var bank_id = $("#bank_id").val();
        var affiliate_number = $("#affiliate_number").val();
        var type_account = $("#type_account").val();
        var account_number = $("#bank_code").val() + '' + $("#account_bank").val();
        var type_contract = $("#type_contract").val();
        var personal_signature = $("#personal_signature").val();
        var route = "{{ route('dcustomers.store') }}";

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            type: 'POST',
            dataType: 'json',
            data: {
                customer_id: customer_id,
                checkbox: checkbox,
                rif: rif,
                business_name: business_name,
                bank_id: bank_id,
                affiliate_number: affiliate_number,
                type_account: type_account,
                account_number: account_number,
                type_contract: type_contract,
                personal_signature: personal_signature,
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                $("#dcustomersCreate").modal("hide");
                $("#form-dcustomer")[0].reset();
                $('#dcustomers-table').DataTable().ajax.reload();
                toastr.info("Se ha Registrado Correctamente")
            },
            error: function(data) {
                var notification = '';
                $.each(data.responseJSON.errors, function(index, subDcustomerObj) {
                    if (notification != '') {
                        notification = notification + '<li>' + subDcustomerObj[0] + '</li>';
                    } else {
                        notification = '<li>' + subDcustomerObj[0] + '</li>';
                    }
                });
                toastr.error("Error el los siguientes Campos: </br>" + notification)
            }
        });
    });
    /****************************************************************************/
    /****************************************************************************/
    var dcustomer = function(btn) {
        val = btn.value;
        var route = "{{ url('dcustomers') }}/" + val + "/edit";
        $.get(route, function(data) {
            $.each(data, function(index, res) {
                var account_number = res.account_number;
                $("#id_up").val(res.id);
                $("#customer_id_up").val(res.customer_id);
                $("#rif_up").val(res.rif);
                $("#business_name_up").val(res.business_name);
                $.get('/banks/select', function(data) {
                    $('#bank_id_up').empty();
                    $('#bank_id_up').append(
                        "<option value=''>Seleccione Banco...</option>");
                    $.each(data, function(index, subBankObj) {
                        $('#bank_id_up').append("<option value='" + subBankObj.id +
                            "'>" + subBankObj.description + "</option>");
                        $("#bank_id_up option[value=" + res.bank_id + "]").attr(
                            "selected", true);
                    });
                });
                $("#affiliate_number_up").val(res.affiliate_number);
                $('#type_account_up').append("<option value='Ahorro'>Ahorro</option>");
                $('#type_account_up').append("<option value='Corriente'>Corriente</option>");
                $("#type_account_up option[value=" + res.type_account + "]").attr("selected", true);
                $("#bank_code_up").val(account_number.substr(0, 4));
                $("#account_bank_up").val(account_number.substr(4, 20));
                if (res.multicommerce == 1) {
                    $('#checkbox_up').attr('checked', true);
                } else {
                    $('#checkbox_up').attr('checked', false);
                }
                if (res.personal_signature == 1) {
                    $('#personal_signature_up').attr('checked', true);
                } else {
                    $('#personal_signature_up').attr('checked', false);
                }
                checkUpdateinput();
            })
        });
    }
    /****************************************************************************/
    $("#update-dcustomer").click(function() {
        var id = $("#id_up").val();
        var customer_id = $("#customer_id_up").val();
        var checkbox = $("#checkbox_up").val();
        var rif = $("#rif_up").val();
        var business_name = $("#business_name_up").val();
        var bank_id = $("#bank_id_up").val();
        var affiliate_number = $("#affiliate_number_up").val();
        var type_account = $("#type_account_up").val();
        var account_number = $("#bank_code_up").val() + '' + $("#account_bank_up").val();
        checkSignatureUpdate();
        var personal_signature = $("#personal_signature_up").val();
        var route = "{{ url('dcustomers') }}/" + id;
        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                id: id,
                customer_id: customer_id,
                checkbox: checkbox,
                rif: rif,
                business_name: business_name,
                bank_id: bank_id,
                affiliate_number: affiliate_number,
                type_account: type_account,
                account_number: account_number,
                personal_signature: personal_signature,
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                $("#dcustomerUpdate").modal("hide");
                $("#form-dcustomer-edit")[0].reset();
                $('#dcustomers-table').DataTable().ajax.reload();
                toastr.info("Registro Actualizado Correctamente")
            },
            error: function(data) {
                var notification = '';
                $.each(data.responseJSON.errors, function(index, subDcustomerObj) {
                    if (notification != '') {
                        notification = notification + '<li>' + subDcustomerObj[0] + '</li>';
                    } else {
                        notification = '<li>' + subDcustomerObj[0] + '</li>';
                    }
                });
                toastr.error("Error el los siguientes Campos: </br>" + notification)
            }
        });
    });
    /****************************************************************************/
    $('#bank_id').change(function(e) {
        var bank_id = e.target.value;
        $('.account_bank').val('');
        $('.affiliate_number').val('');
        if (bank_id) {
            $.get('/banks/bankcode?bank_id=' + bank_id, function(data) {
                document.getElementById("bank_code").value = data.bank_code;
                $('.account_bank').removeAttr('readonly');
                $('.affiliate_number').removeAttr('readonly');
            });
        } else {
            document.getElementById("bank_code").value = 'ID Bancario';
            $('.account_bank').attr('readonly', 'readonly');
            $('.affiliate_number').attr('readonly', 'readonly');
        }

        if (bank_id == 9 || bank_id == 14) {
            document.getElementById("affiliate_number").classList.remove('numberl');
            document.getElementById("affiliate_number").classList.add('numbermercant');
        } else {
            document.getElementById("affiliate_number").classList.remove('numbermercant');
            document.getElementById("affiliate_number").classList.add('numberl');
        }

        /************************************************************************/
        $('.numberl').mask('AAAAAAAA', {
            'translation': {
                A: {
                    pattern: /[0-9]/
                }
            }
        });
        /************************************************************************/
        $('.numbermercant').mask('SAAAAAAAAAAAAA', { //Mercantil y Provincial
            'translation': {
                S: {
                    pattern: /[0CVEJPGRcvejpgr]{1}/
                },
                A: {
                    pattern: /[0-9]/
                }
            }
        });
    });
    $('#bank_id_up').change(function(e) {
        var bank_id = e.target.value;
        $('.account_bank').val('');
        $('.affiliate_number').val('');
        if (bank_id) {
            $.get('/banks/bankcode?bank_id=' + bank_id, function(data) {
                document.getElementById("bank_code_up").value = data.bank_code;
                $('.account_bank').removeAttr('readonly');
                $('.affiliate_number').removeAttr('readonly');
            });
        } else {
            document.getElementById("bank_code_up").value = 'ID Bancario';
            $('.account_bank').attr('readonly', 'readonly');
            $('.affiliate_number').attr('readonly', 'readonly');
        }

        if (bank_id == 9 || bank_id == 14) {
            document.getElementById("affiliate_number_up").classList.remove('numberl');
            document.getElementById("affiliate_number_up").classList.add('numbermercant');
        } else {
            document.getElementById("affiliate_number_up").classList.remove('numbermercant');
            document.getElementById("affiliate_number_up").classList.add('numberl');
        }

        /************************************************************************/
        $('.numberl').mask('AAAAAAAA', {
            'translation': {
                A: {
                    pattern: /[0-9]/
                }
            }
        });
        /************************************************************************/
        $('.numbermercant').mask('SAAAAAAAAAAAAA', { //Mercantil
            'translation': {
                S: {
                    pattern: /[0CVEJPGRcvejpgr]{1}/
                },
                A: {
                    pattern: /[0-9]/
                }
            }
        });
    });
    /***************************************************************************/
    var dcustomerDelete = function(btn) {
        $("#id").val(btn.value);
    }

    $("#delete-dcustomer").click(function() {
        var id = $("#id").val();
        var route = "{{ url('dcustomers') }}/" + id + "";

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            type: 'DELETE',
            dataType: 'json',
            success: function(data) {
                $("#dcustomerDelete").modal("hide");
                $('#dcustomers-table').DataTable().ajax.reload();
                toastr.info("Registro Eliminado Correctamente")
            },
            error: function(data) {
                $("#dcustomerDelete").modal("hide");
                toastr.warning("Error al Eliminar Registro")
            }
        });
    });

    /*************************************************************************************************************/
    function checkinput() {
        if ($('#checkbox')[0].checked == true) {
            document.getElementById("checkbox").value = "on";
            $('#rif').removeAttr('disabled');
            $('#rif').attr('required', true);
            $('#business_name').removeAttr('disabled');
            $('#business_name').attr('required', true);
        } else {
            document.getElementById("checkbox").value = "";
            $('#rif').attr('disabled', true);
            $('#rif').removeAttr('required');
            $('#business_name').attr('disabled', true);
            $('#business_name').removeAttr('required');
        }
    }
    /*************************************************************************************************************/
    function checkSignature() {
        if ($('#personal_signature')[0].checked == true) {
            $('#personal_signature').val('on');
        } else {
            $('#personal_signature').val('');
        }
    }
    /*************************************************************************************************************/
    function checkSignatureUpdate() {
        if ($('#personal_signature_up')[0].checked == true) {
            $('#personal_signature_up').val('on');
        } else {
            $('#personal_signature_up').val('');
        }
    }
    /**
    /*************************************************************************************************************/
    function checkUpdateinput() {
        if ($('#checkbox_up')[0].checked == true) {
            document.getElementById("checkbox_up").value = "on";
            $('#rif_up').removeAttr('disabled');
            $('#rif_up').attr('required', true);
            $('#business_name_up').removeAttr('disabled');
            $('#business_name_up').attr('required', true);
        } else {
            document.getElementById("checkbox_up").value = "";
            $('#rif_up').attr('disabled', true);
            $('#rif_up').removeAttr('required');
            $('#business_name_up').attr('disabled', true);
            $('#business_name_up').removeAttr('required');
        }
    }
</script>
