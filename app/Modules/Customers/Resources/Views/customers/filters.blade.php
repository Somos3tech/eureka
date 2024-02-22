<script>
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
    /****************************************************************************/
    $('.money').mask(' 000,000,000,000.00', {
        reverse: true
    });
    /****************************************************************************/
    $('.zero').keyup(function() {
        if (this.value.charAt(0) != 0) {
            this.value = this.value;
        } else {
            this.value = this.value.slice(1);
        }
    });
    /****************************************************************************/
    $('.porcentage').mask('AA', {
        'translation': {
            A: {
                pattern: /[0-9]/
            }
        }
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
    $('.number').mask('AAAA', {
        'translation': {
            A: {
                pattern: /[0-9]/
            }
        }
    });
    /****************************************************************************/
    $('.account').mask('-AAAA-AA-AAAAAAAAAA', {
        'translation': {
            A: {
                pattern: /[0-9]/
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
    /****************************************************************************/
    $('.postal').mask('AAAA', {
        'translation': {
            A: {
                pattern: /[0-9]/
            }
        }
    });
    /****************************************************************************/
    $('.letter').keyup(function() {
        this.value = this.value.toLowerCase();
        this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
    });
    /****************************************************************************/
    $('.blank').keyup(function(e) {
        var string = e.target.value;
        e.target.value = string.replace(" ", "");
    });
    /****************************************************************************/
    $('#ident_number').on('blur', function(e) {
        var number_doc = e.target.value;
        if (number_doc) {
            var parts = number_doc.split("-");
            parts[1] = parts[1].padStart(8, '0');
            document.getElementById("ident_number").value = parts.join("-");
        }
    });
    /****************************************************************************/
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
    /****************************************************************************/
    $('#find').on('blur', function(e) {
        var number_doc = e.target.value;
        if (number_doc) {
            var parts = number_doc.split("-");

            if (parts.length == 2) {
                var index = parts[1].substr(-1);
                parts[2] = index;
                parts[1] = parts[1].slice(0, -1);
                parts[1] = parts[1].padStart(8, '0');
            } else {
                if (parts.length > 2) {
                    if (parts[2] == "") {
                        var index = parts[1].substr(-1);
                        parts[2] = index;
                        parts[1] = parts[1].slice(0, -1);
                        parts[1] = parts[1].padStart(8, '0');
                    }
                }
            }
        }
        document.getElementById("find").value = parts.join("-");
    });
    /****************************************************************************/
    $('#btnDel').attr('disabled', 'disabled');
    /****************************************************************************/
    $('#btnAdd').click(function() {
        var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
        var newNum = new Number(num + 1); // the numeric ID of the new input field being added

        // create the new element via clone(), and manipulate it's ID using newNum value
        var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);

        // manipulate the name/id values of the input inside the new element
        // Añadir caja de texto.

        newElem.children(':last').attr('id', 'item' + newNum).attr('name', 'item' + newNum);

        // insert the new element after the last "duplicatable" input field
        $('#input' + num).after(newElem);
        // enable the "remove" button
        $('#btnDel').attr('disabled', false);

        // business rule: you can only add 10 names
        if (newNum == 4)
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
</script>
