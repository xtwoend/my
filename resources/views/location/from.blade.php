<div class="modal fade" id="location-form" tabindex="-1" role="dialog"  aria-hidden="true">
    {{ Form::open(['route' => 'location.store']) }}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add/Edit Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="d-block">LOCATION CODE</label>
                    <div class="input-group mg-b-10">
                        {{ Form::text('gln', null, ['class' => 'form-control', 'placeholder'=> 'Location code', 'id' => 'gtin', 'autofocus' => true]) }}
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">
                                <i class="fa-solid fa-barcode"></i>
                            </span>
                        </div>
                    </div>                      
                </div>
                <div class="form-group">
                    <label class="d-block">Name</label>
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder'=> 'Enter product name']) }}
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