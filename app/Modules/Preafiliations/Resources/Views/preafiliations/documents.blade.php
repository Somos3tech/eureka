<div class="modal fade documentView" tabindex="-1" role="dialog" aria-labelledby="documentViewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="documentViewLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <iframe src="view-document/{!! $customer->id !!}" style="width:100%; height:500px;"
                    frameborder="0"></iframe>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
