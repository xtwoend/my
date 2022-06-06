<div class="modal fade" id="ng-form" tabindex="-1" role="dialog"  aria-hidden="true">
    {{-- {{ Form::open(['route' => 'ng.store']) }} --}}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add No Goods Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- vue components --}}
            <ng-form :report="{{ json_encode($report) }}" url="{{ route('product.return.data', ['inventory_report_id' => $report->id]) }}" />
        </div>
    </div>
    {{-- {{ Form::close() }} --}}
</div>