<script>
    $(document).ready(function() {
        $('#rcustomer').show();
        listrcustomer();
    });

    var listrcustomer = function() {

        var route = "/rcustomers/datatable?id=" + {{ (int) $customer->id }};
        rcustomers = $('#rcustomers-table').DataTable({
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
                    data: "document",
                    "className": "text-center",
                    "width": "10%"
                },
                {
                    data: "document_number",
                    "className": "text-center",
                    "width": "10%"
                },
                {
                    data: "first_name",
                    "className": "text-center"
                },
                {
                    data: "jobtitle",
                    "className": "text-center"
                },
                {
                    data: "email",
                    "className": "text-center"
                },
                {
                    data: "telephone",
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
                [0, "asc"],
            ]
        });
    }

    $("#create-rcustomer").click(function() {
        var customer_id = $("#customer_id").val();
        var ident_number = $("#ident_number").val();
        var first_name = $("#first_name").val();
        var jobtitle = $("#jobtitle").val();
        var email = $("#email").val();
        var telephone = $("#telephone").val();
        var route = "{{ route('rcustomers.store') }}";
        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            type: 'POST',
            dataType: 'json',
            data: {
                customer_id: customer_id,
                ident_number: ident_number,
                first_name: first_name,
                jobtitle: jobtitle,
                email: email,
                telephone: telephone,
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                $("#rcustomerCreate").modal("hide");
                $("#form-rcustomer")[0].reset();
                $('#rcustomers-table').DataTable().ajax.reload();
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

    var rcustomer = function(btn) {
        val = btn.value;
        var route = "{{ url('rcustomers') }}/" + val + "/edit";
        $.get(route, function(res) {
            $("#id_up").val(res[0].id);
            $("#customer_id_up").val(res[0].customer_id);
            $("#ident_number_up").val(res[0].document);
            $("#first_name_up").val(res[0].first_name);
            $("#jobtitle_up").val(res[0].jobtitle);
            $("#email_up").val(res[0].email);
            $("#telephone_up").val(res[0].telephone);
        })
    }

    $("#update-rcustomer").click(function() {
        var id = $("#id_up").val();
        var customer_id = $("#customer_id_up").val();
        var ident_number = $("#ident_number_up").val();
        var first_name = $("#first_name_up").val();
        var jobtitle = $("#jobtitle_up").val();
        var email = $("#email_up").val();
        var telephone = $("#telephone_up").val();
        var route = "{{ url('rcustomers') }}/" + id;
        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                customer_id: customer_id,
                ident_number: ident_number,
                first_name: first_name,
                jobtitle: jobtitle,
                email: email,
                telephone: telephone,
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                $("#rcustomerUpdate").modal("hide");
                $("#form-rcustomer-edit")[0].reset();
                $('#rcustomers-table').DataTable().ajax.reload();
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

    var rcustomerDelete = function(btn) {
        $("#id").val(btn.value);
    }

    $("#delete-rcustomer").click(function() {
        var id = $("#id").val();
        var route = "{{ url('rcustomers') }}/" + id + "";

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            type: 'DELETE',
            dataType: 'json',
            success: function(data) {
                $("#rcustomerDelete").modal("hide");
                $('#rcustomers-table').DataTable().ajax.reload();
                toastr.info("Registro Eliminado Correctamente")
            },
            error: function(data) {
                $("#rcustomerDelete").modal("hide");
                toastr.warning("Error al Eliminar Registro")
            }
        });
    });
</script>
