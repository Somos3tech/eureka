<!-- modal content -->
<div id="restoreSimcard" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="restoreSimcardLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-restore']) !!}

            <input name="_token" type="hidden" value="{{ csrf_token() }}" id="token">

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel"><b>Desea Restaurar Simcard a Disponibilidad?</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            {!! form::hidden('id', null, ['id' => 'id']) !!}

            <div class="modal-footer">
                {!! link_to(
                    '#',
                    $title = 'Restaurar',
                    $attributes = ['id' => 'restore', 'class' => 'btn bt-sm btn-info waves-effect waves-light'],
                ) !!}
            </div>

            {!! Form::close() !!}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
