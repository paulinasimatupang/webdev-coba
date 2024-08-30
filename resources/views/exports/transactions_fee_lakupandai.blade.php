<table id="deafult_ordering_table" class="display table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th scope="col">TID</th>
            <th scope="col">MID</th>
            <th scope="col">Agent Name</th> 
            <th scope="col">Total Amount Transaction</th>
            <th scope="col">Total Fee</th>
            <th scope="col">Fee Agen</th>
            <th scope="col">Fee BJB</th>
            <th scope="col">Fee Selada</th>
            <th scope="col">Buffer</th>
            <th scope="col">Total Transaction</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{$item->tid}}</td>
            <td>{{$item->mid}}</td>
            <td>{{$item->agent_name}}</td>
            <td>{{$item->total_amount_transaction}}</td>
            <td>{{$item->total_amount_fee}}</td>
            <td>{{$item->fee_agen}}</td>
            <td>{{$item->fee_bjb}}</td>
            <td>{{$item->fee_selada}}</td>
            <td>{{$item->buffer}}</td>
            <td>{{$item->total_transaction}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
