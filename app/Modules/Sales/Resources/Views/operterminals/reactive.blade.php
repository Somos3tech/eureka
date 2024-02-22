<!-- modal content -->
<div id="OperTerminalsReactiveView" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="OperTerminalsReactiveViewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {!! Form::open(['id' => 'form-reactive']) !!}

            <input name="_token" type="hidden" value="{{ csrf_token() }}" id="token">

            <div class="modal-header">
                <h5 class="modal-title mt-0" id="rcustomersDeleteLabel"><b>Desea Reactivar Servicio?</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            {!! form::hidden('reactive_id', null, ['id' => 'reactive_id']) !!}

            <div class="modal-footer">
                {!! link_to(
                    '#',
                    $title = 'Reactivar',
                    $attributes = ['id' => 'reactive', 'class' => 'btn bt-sm btn-warning', 'style' => 'color:white;'],
                ) !!}
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
