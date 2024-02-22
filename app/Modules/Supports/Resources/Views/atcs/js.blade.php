<script>
    function atcsshow(id) {
        $.get('/atcs/' + id.value, function(data) {
            $(".view").empty();

            if (data.slug != 'internal') {
                $(".user").attr("style", "display:block");
                $(".internaluser").attr("style", "display:none");
            } else {
                $(".user").attr("style", "display:none");
                $(".internaluser").attr("style", "display:block");
            }
            $(".atc_id").val(data.id);
            $(".atc_id_view").append(data.id);
            $(".status_view").append(data.status);
            $(".customer_view").append(data.customer_id);
            $(".rif_view").append(data.rif);
            $(".business_name_view").append(data.name);
            $(".telephone_view").append(data.telephone);
            $(".mobile_view").append(data.mobile);
            $(".email_view").append(data.email);
            $(".managementtype_view").append(data.managementtype);
            $(".mtypeitem_view").append(data.mtypeitem);
            $(".channel_view").append(data.channel);
            $(".observation_view").append(data.observation);
            $(".observation_manager_view").append(data.observation_manager);
            $(".created_view").append(data.created);
            $(".created_name_view").append(data.created_name);
            $(".updated_view").append(data.updated);
            $(".updated_name_view").append(data.updated_name);
        });
    }

    $("#update").click(function() {
        var id = $("#atc_id").val();
        var observation_manager = $("#observation_manager_update").val();
        var route = "{{ url('atcs') }}/" + id;
        // var token = $("#token").val();
        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                observation_manager
            },

            success: function(data) {
                $("#atcsUpdate").modal("hide");
                $("#form-atc")[0].reset();
                $('#atcs-table').DataTable().ajax.reload();
                toastr.info("Gestión se ha Procesado Correctamente")
            },
            error: function(data) {
                var notification = '';
                $.each(data.responseJSON.errors, function(index, subMarkObj) {
                    if (notification != '') {
                        notification = notification + '<li>' + subMarkObj[0] + '</li>';
                    } else {
                        notification = '<li>' + subMarkObj[0] + '</li>';
                    }
                });
                toastr.error("Error el los siguientes Campos: </br>" + notification)
            }
        });
    });

    $("#management").click(function() {
        var id = $("#atc_management_id").val();
        var observation_manager = $("#observation_manager").val();
        var management = '';
        var route = "{{ url('atcs') }}/" + id;
        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                management,
                observation_manager
            },

            success: function(data) {
                $("#atcsManagement").modal("hide");
                $("#form-atc-management")[0].reset();
                $('#atcs-table').DataTable().ajax.reload();
                toastr.info("Gestión se encuentra en espera de una respuesta")
            },
            error: function(data) {
                var notification = '';
                $.each(data.responseJSON.errors, function(index, subMarkObj) {
                    if (notification != '') {
                        notification = notification + '<li>' + subMarkObj[0] + '</li>';
                    } else {
                        notification = '<li>' + subMarkObj[0] + '</li>';
                    }
                });
                toastr.error("Error el los siguientes Campos: </br>" + notification)
            }
        });
    });

    $("#change").click(function() {
        var id = $("#atc_id").val();
        var channel_id = $("#channel_id").val();
        var managementtype_id = $("#managementtype_id").val();
        var mtypeitem_id = $("#mtypeitem_id").val();
        var edit = '';
        var route = "{{ url('atcs') }}/" + id;
        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: 'PUT',
            dataType: 'json',
            data: {
                edit,
                channel_id,
                managementtype_id,
                mtypeitem_id
            },

            success: function(data) {
                $("#atcsChange").modal("hide");
                $("#form-atc-change")[0].reset();
                $('#atcs-table').DataTable().ajax.reload();
                toastr.info("Gestión se ha Procesado Correctamente")
            },
            error: function(data) {
                var notification = '';
                $.each(data.responseJSON.errors, function(index, subMarkObj) {
                    if (notification != '') {
                        notification = notification + '<li>' + subMarkObj[0] + '</li>';
                    } else {
                        notification = '<li>' + subMarkObj[0] + '</li>';
                    }
                });
                toastr.error("Error el los siguientes Campos: </br>" + notification)
            }
        });
    });

    $("#delete").click(function() {
        var id = $("#atc_delete_id").val();
        var observation_manager = $("#observation_manager_delete").val();
        var route = "{{ url('atcs') }}/" + id + "";

        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: 'DELETE',
            dataType: 'json',
            data: {
                observation_manager: observation_manager
            },
            success: function(data) {
                $("#atcsDelete").modal("hide");
                $("#form-atc-delete")[0].reset();
                $('#atcs-table').DataTable().ajax.reload();
                toastr.info("Gestión Anulada Correctamente")
            },
            error: function(data) {
                toastr.warning("Error al Anular Registro")
            }
        });
    });
    /****************************************************************************/
    $('.mayusc').keyup(function() {
        this.value = this.value.toUpperCase();
    });
    /****************************************************************************/
    $('.minusc').keyup(function() {
        this.value = this.value.toLowerCase();
    });
    /****************************************************************************/
    $('.rif').keyup(function() {
        this.value = this.value.toUpperCase();
    });
    /****************************************************************************/
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
    /****************************************************************************/
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
</script>
