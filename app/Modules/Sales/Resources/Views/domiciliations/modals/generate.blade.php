<!-- modal content -->
<div id="generateFileDomiciliation" name="generateFileDomiciliation" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="generateFileDomiciliationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-generate']) !!}
            {{ csrf_field() }}
            <div class="modal-header">
                <h4 class="mt-0 m-b-30 header-title"><b>Generar Archivo Bancario</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="bank_id" class="col-sm-12 col-form-label"><b>Banco*</b></label>
                        {!! Form::select('bank_id2', ['' => 'Seleccione Banco...'], null, ['id' => 'bank_id2', 'class' => 'form-control bank_id']) !!}
                    </div>
                    <div class="col-sm-4 type_invoice">
                        <label for="type_format" class="col-sm-12 col-form-label"><b>Tipo Formato*</b></label>
                        <!--, -->
                        {!! Form::select('type_format', ['bank' => 'Formato Bancario'], null, ['id' => 'type_format', 'class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-4">
                        <label for="amount_currency2" class="col-sm-12 col-form-label"><b>Tárifa*</b></label>
                        {!! Form::text('amount_currency2', null, ['id' => 'amount_currency2', 'class' => 'form-control money blank', 'placeholder' => 'Ingrese Tarifa Cambio']) !!}
                    </div>
                    <div class="col-sm-4 type_invoice">
                        <label for="type_manager" class="col-sm-12 col-form-label"><b>Gestión*</b></label>
                        {!! Form::select('type_manager', ['' => 'Seleccionar Tipo Gestión...', 'G' => 'Diario', 'R' => 'Morosidad', 'M' => 'Masivo'], null, ['id' => 'type_manager', 'class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-3 field typeday" style="display:none;">
                        <label for="type_date2" class="col-sm-12  col-form-label"><b>Tipo Fecha*</b></label>
                        {!! Form::select('type_date2', ['' => 'Seleccione Tipo Fecha...', 'date' => 'Fecha única', 'range' => 'Fecha Rango'], null, ['id' => 'type_date2', 'class' => 'form-control input']) !!}
                    </div>
                    <div class="col-sm-5 field range" style="display:none;">
                        <label for="date_range2" class="col-sm-12 col-form-label"><b>Cobranza - Rango</b></label>
                        <div>
                            <div class="input-daterange input-group" id="date-range">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control input date_range" id="date_range2"
                                    name="date_range2" placeholder="aaaa-mm-dd | aaaa-mm-dd" data-toggle="datepicker"
                                    readonly />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 field day" style="display:none;">
                        <div class="col-sm-12">
                            <label for="date_invoice"
                                class="col-sm-12 col-form-label"><b>Cobranza<small>*</small></b></label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input id="fechpro2" name="fechpro2" type="text"
                                    class="form-control input datepicker fechpro" placeholder="aaaa-mm-dd"
                                    data-toggle="datepicker">
                            </div><!-- input-group -->
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="col-sm-12">
                            <label for="date_invoice" class="col-sm-12 col-form-label"><b>Fecha
                                    Operación<small>*</small></b></label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input id="date_operation" name="date_operation" type="text"
                                    class="form-control datepicker" placeholder="aaaa-mm-dd" data-toggle="datepicker">
                            </div><!-- input-group -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <center><a href="#" class='btn btn-sm btn-dark' id="generate" name="generate">Generar Archivo</a>
                    </center>
                </div>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
