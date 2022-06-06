<div class="modal fade" id="reason-form" tabindex="-1" role="dialog"  aria-hidden="true">
    {{ Form::open(['route' => 'reason.store']) }}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="d-block">Reason</label>
                    {{ Form::text('reason', null, ['class' => 'form-control', 'placeholder'=> 'Reason']) }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>