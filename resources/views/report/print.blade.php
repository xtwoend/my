<div id="printJS-form">
    <table class="table">
        <thead>
            <tr>
                <th>DATE</th>
                <th>SHIFT</th>
                <th>LINE</th>
                <th>BARCODE</th>
                <th>SKU</th>
                <th>QTY</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <tr>
                <td>{{ $row->created_at->format('d-m-Y') }}</td>
                <td>{{ $row->schedule->shift->name }}</td>
                <td>{{ $row->product->line }}</td>
                <td>{{ $row->product->gtin }}</td>
                <td>{{ $row->product->name }}</td>
                <td>{{ $row->qty }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>