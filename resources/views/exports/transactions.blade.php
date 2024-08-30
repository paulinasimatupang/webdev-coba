<table id="deafult_ordering_table" class="display table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th scope="col">Username</th>
            <th scope="col">Agent</th>
            <th scope="col">Transaction Code</th>
            <th scope="col">Product</th>
            <th scope="col">TID</th>
            <th scope="col">MID</th> 
            <th scope="col">Stan</th>
            <th scope="col">Fee</th>
            <th scope="col">Total</th>
            <th scope="col">Date</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{!empty($item->merchant->user) ? $item->merchant->user->username : ''}}</td>
            <td>{{!empty($item->merchant) ? $item->merchant->name : ''}}</td>
            <td>{{$item->code}}</td>
            <td>{{$item->service->product->name}}</td>
            <td>{{!empty($item->merchant->terminal) ? $item->merchant->terminal->tid : ''}}</td>
            <td>{{!empty($item->merchant) ? $item->merchant->mid : ''}}</td>
            <td>{{$item->stan}}</td>
            <td>{{$item->fee}}</td>
            <td>{{$item->price}}</td>
            <td>{{$item->created_at}}</td>
            <td>{{$item->status_text}}</td>
        </tr>
        @endforeach
    </tbody>
</table>



