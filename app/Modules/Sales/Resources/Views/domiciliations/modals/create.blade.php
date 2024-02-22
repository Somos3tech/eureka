<!-- modal content -->
<div id="createDomiciliation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createDomiciliationLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {!! Form::open(['id' => 'form-create']) !!}
            {{ csrf_field() }}

            <div class="modal-header">
                <h4 class="mt-0 m-b-30 header-title"><b>{{ $identity }}</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="bank_id" class="col-sm-12"><b>Banco*</b></label>
                        {!! form::select('bank_id', ['' => 'Seleccione Banco...'], null, ['id' => 'bank_id', 'class' => 'form-control bank_id select2', 'required' => 'required']) !!}
                    </div>

                    <div class="col-sm-3">
                        <label for="type_service" class="col-sm-12"><b>Cobranza*</b></label>
                        {!! form::select('type_service', ['' => 'Seleccione Servicio Cobranza...', 'D' => 'Diaria', 'S' => 'Semanal', 'M' => 'Mensual'], null, ['id' => 'type_service', 'class' => 'form-control select2', 'required' => 'required']) !!}
                    </div>

                    <div class="col-sm-3 field typeday" style="display:none;">
                        <label for="type_date" class="col-sm-12"><b>Tipo Fecha*</b></label>
                        {!! Form::select('type_date', ['' => 'Seleccione Tipo Fecha...', 'date' => 'Fecha única', 'range' => 'Fecha Rango'], null, ['id' => 'type_date', 'class' => 'form-control input']) !!}
                    </div>

                    <div class="col-sm-3 field type_weekly" style="display:none;">
                        <label for="type_weekly" class="col-sm-12"><b>Semana a Cobrar*</b></label>
                        {!! Form::select('type_weekly', ['' => 'Seleccione Nro de Semana...', '1' => '1era Semana', '2' => '2da Semana', '3' => '3era Semana', '4' => '4ta Semana'], null, ['id' => 'type_weekly', 'class' => 'form-control input']) !!}
                    </div>

                    <div class="col-sm-3 field months" style="display:none;">
                        <label for="fechpro" class="col-sm-12"><b>Cobranza<small>*</small></b></label>
                        <div class="input-daterange input-group" id="date-range">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="i i-Calendar"></i></span>
                            </div>
                            <input id="date_invoice" name="date_invoice" type="text"
                                class="form-control input date_invoice" placeholder="yyyy-mm" data-toggle="datepicker"
                                readonly>
                        </div>
                    </div>

                    <div class="col-sm-3 field range" style="display:none;">
                        <label><b>Cobranza - Rango</b></label>
                        <div>
                            <div class="input-daterange input-group" id="date-range">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="i i-Calendar"></i></span>
                                </div>
                                <input type="text" class="form-control input date_range" id="date_range"
                                    name="date_range" placeholder="yyyy-mm-dd | yyyy-mm-dd" data-toggle="datepicker"
                                    readonly />
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 field day" style="display:none;">
                        <div class="col-sm-12">
                            <label for="date_invoice" class="col-sm-12"><b>Cobranza<small>*</small></b></label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="i i-Calendar"></i></span>
                                </div>
                                <input id="fechpro" name="fechpro" type="text"
                                    class="form-control input datepicker" placeholder="yyyy-mm-dd"
                                    data-toggle="datepicker" readonly>
                            </div><!-- input-group -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="col-sm-12">
                    <hr>
                    <center><a href="#" class='btn btn-sm btn-dark' id="create" name="create">Generar
                            Cobranza</a></center>
                </div>
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
