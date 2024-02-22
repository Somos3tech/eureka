<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12 ">
            <h5 class="mt-0 m-b-20 header-title "><b>Documentos</b></h5>
        </div>
        <?php
        if ($customer->file_document != null) {
            $path = unserialize($customer->file_document);
        } else {
            $path = null;
        }
        ?>
        <div class="col-sm-3 mb-2 ">
            <div class="card text-left">
                <div class="card-body">
                    <center>
                        <h6><b>Documento <br>RIF*</b></h6>
                        <div id="upload-rif">
                            <a href="#" data-toggle="modal" data-target="#uploadRif">
                                <div id="image_rif" name="image_rif" data-toggle="tooltip" data-placement="top"
                                    title="Clic x Cargar Documento RIF">
                                    @if ($path != null && array_key_exists('document_rif', $path) && $path['document_rif'] != null)
                                        <img src='/assets/images/upload-success.png' width='35%'>
                                    @else
                                        <img src="/assets/images/upload-pdf.png" width="35%">
                                    @endif
                                </div>
                            </a>
                            <br>
                            {!! Form::hidden('rif_path', null, ['id' => 'rif_path']) !!}
                            <div id="response-rif">
                                @if ($path != null && array_key_exists('document_rif', $path) && $path['document_rif'] != null)
                                    <button class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                        OnClick="documentFile(this);" value="{!! $path != null ? $path['document_rif'] : null !!}"
                                        data-target="#viewDocument">
                                        <b>Ver</b>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mb-2 ">
            <div class="card">
                <div class="card-body">
                    <center>
                        <h6><b>Documento Registro Mercantíl*</b></h6>
                        <div id="upload-rm">
                            <a href="#" data-toggle="modal" data-target="#uploadMercantil">
                                <div id="image_rm" name="image_rm" data-toggle="tooltip" data-placement="top"
                                    title="Clic x Cargar Documento Registro Mercantíl">
                                    @if ($path != null && array_key_exists('document_mercantil', $path) && $path['document_mercantil'] != null)
                                        <img src='/assets/images/upload-success.png' width='35%'>
                                    @else
                                        <img src="/assets/images/upload-pdf.png" width="35%">
                                    @endif
                                </div>
                            </a>
                            <br>
                            {!! Form::hidden('rm_path', null, ['id' => 'rm_path']) !!}
                            <div id="response-rm">
                                @if ($path != null && array_key_exists('document_mercantil', $path) && $path['document_mercantil'] != null)
                                    <button href="#" class="btn btn-sm btn-info" data-toggle="modal"
                                        OnClick="documentFile(this);" value="{!! $path != null ? $path['document_mercantil'] : null !!}"
                                        data-target="#viewDocument">
                                        <b>Ver</b>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mb-2">
            <div class="card text-left">
                <div class="card-body">
                    <center>
                        <h6><b>Soporte Cuenta Bancaria*</b></h6>
                        <div id="upload-bank">
                            <a href="#" data-toggle="modal" data-target="#uploadBank">
                                <div id="image_bank" name="image_bank" data-toggle="tooltip" data-placement="top"
                                    title="Clic x Cargar Documento Soporte Cuenta Bancaría">
                                    @if ($path != null && array_key_exists('document_bank', $path) && $path['document_bank'] != null)
                                        <img src='/assets/images/upload-success.png' width='35%'>
                                    @else
                                        <img src="/assets/images/upload-pdf.png" width="35%">
                                    @endif
                                </div>
                            </a>
                            <br>
                            {!! Form::hidden('bank_path', null, ['id' => 'bank_path']) !!}
                            <div id="response-bank">
                                @if ($path != null && array_key_exists('document_bank', $path) && $path['document_bank'] != null)
                                    <button href="#" class="btn btn-sm btn-info" data-toggle="modal"
                                        OnClick="documentFile(this);" value="{!! $path != null ? $path['document_bank'] : null !!}"
                                        data-target="#viewDocument">
                                        <b>Ver</b>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
        <div class="col-sm-3 mb-2">
            <div class="card text-left">
                <div class="card-body">
                    <center>
                        <h6><b>Autorización Débito en Cuenta*</b></h6>
                        <div id="upload-auth-bank">
                            <a href="#" data-toggle="modal" data-target="#uploadAuthBank">
                                <div id="image_auth_bank" name="image_auth_bank" data-toggle="tooltip"
                                    data-placement="top" title="Clic x Cargar Documento Autorización Débito en Cuenta"
                                    id="">
                                    @if ($path != null && array_key_exists('autorization_bank', $path) && $path['autorization_bank'] != null)
                                        <img src='/assets/images/upload-success.png' width='35%'>
                                    @else
                                        <img src="/assets/images/upload-pdf.png" width="35%">
                                    @endif
                                </div>
                            </a>
                            <br>
                            {!! Form::hidden('auth_bank_path', null, ['id' => 'auth_bank_path']) !!}
                            <div id="response-auth-bank">
                                @if ($path != null && array_key_exists('autorization_bank', $path) && $path['autorization_bank'] != null)
                                    <button href="#" class="btn btn-sm btn-info" data-toggle="modal"
                                        OnClick="documentFile(this);" value="{!! $path != null ? $path['autorization_bank'] : null !!}"
                                        data-target="#viewDocument">
                                        <b>Ver</b>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </center>
                </div>
            </div>
        </div>
        <div class="col-sm-12 row">
            <div class="col-sm-12">
                <h5><b>Check List Documentación Fisica</b></h5>
                <br>
            </div>

            <div class="col-md-3 form-group mb-2">
                <center>
                    <label class="switch switch-primary">
                        <span><b>Documento RIF</b></span>

                        <center>
                            @if ($path != null && array_key_exists('is_rif', $path))
                                <input id="is_rif" name="is_rif" type="checkbox" class="valid" value="1"
                                    checked>
                            @else
                                <input id="is_rif" name="is_rif" type="checkbox" value="0" class="valid">
                            @endif
                            <span class="slider"></span>
                        </center>
                    </label>
                </center>
            </div>

            <div class="col-md-3 form-group mb-2">
                <center>
                    <label class="switch switch-info">
                        <span><b>Mercantíl</b></span>
                        @if ($path != null && array_key_exists('is_mercantil', $path))
                            <input id="is_mercantil" name="is_mercantil" type="checkbox" class="valid"
                                value="1" checked>
                        @else
                            <input id="is_mercantil" name="is_mercantil" type="checkbox" value="0"
                                class="valid">
                        @endif
                        <span class="slider"></span>
                    </label>
                </center>
            </div>

            <div class="col-md-3 form-group mb-2">
                <center>
                    <label class="switch switch-info">
                        <span><b>Cuenta Bancaria</b></span>
                        @if ($path != null && array_key_exists('is_bank', $path))
                            <input id="is_bank" name="is_bank" type="checkbox" class="valid" value="1"
                                checked>
                        @else
                            <input id="is_bank" name="is_bank" type="checkbox" value="0" class="valid">
                        @endif
                        <span class="slider"></span>
                    </label>
                </center>
            </div>

            <div class="col-md-3 form-group mb-2">
                <center>
                    <label class="switch switch-info">
                        <span><b>Débito Cuenta</b></span>
                        @if ($path != null && array_key_exists('is_auth_bank', $path))
                            <input id="is_auth_bank" name="is_auth_bank" type="checkbox" class="valid"
                                value="1" checked>
                        @else
                            <input id="is_auth_bank" name="is_auth_bank" type="checkbox" value="0"
                                class="valid">
                        @endif
                        <span class="slider"></span>
                    </label>
                </center>
            </div>
        </div>
    </div>
</div>
