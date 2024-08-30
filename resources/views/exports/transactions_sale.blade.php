<table id="deafult_ordering_table" class="display table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th scope="col">Stan</th>
            <th scope="col">Request Time</th>
            <th scope="col">Tx Time</th>
            <th scope="col">TID</th>
            <th scope="col">MID</th>
            <th scope="col">Agent Name</th> 
            <th scope="col">Bill ID</th>
            <th scope="col">Proc Code</th>
            <th scope="col">Message Status</th>
            <th scope="col">RC</th>
            <th scope="col">Status</th>
            <th scope="col">Reversal Stan</th>
            <th scope="col">Reversal RC</th>
            <th scope="col">Host Ref</th>
            <th scope="col">Tx Pan</th>
            <th scope="col">Product Name</th>
            <th scope="col">Transaction Name</th>
            <th scope="col">Nominal</th>
            <th scope="col">Fee</th>
            <th scope="col">Fee Agen</th>
            <th scope="col">Fee BJB</th>
            <th scope="col">Fee Selada</th>
            <th scope="col">Buffer</th>
            <th scope="col">Total</th>
            <th scope="col">Src Account</th>
            <th scope="col">Dst Account</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{$item->stan}}</td>
            <td>{{$item->request_time}}</td>
            <td>{{$item->tx_time}}</td>
            <td>{{$item->tid}}</td>
            <td>{{$item->mid}}</td>
            <td>{{$item->agent_name}}</td>
            <td>{{$item->billid}}</td>
            <td>{{$item->proc_code}}</td>
            <td>{{$item->message_status}}</td>
            <td>{{$item->rc}}</td>
            <td>{{$item->status}}</td>
            <td>{{$item->reversal_stan}}</td>
            <td>{{$item->reversal_rc}}</td>
            <td>{{$item->host_ref}}</td>
            <td>{{$item->tx_pan}}</td>
            <td>{{$item->product_name}}</td>
            <td>{{$item->transaction_name}}</td>
            <td>{{$item->nominal}}</td>
            <td>{{$item->fee}}</td>
            <td>{{$item->agent_fee}}</td>
            <td>{{$item->bjb_fee}}</td>
            <td>{{$item->selada_fee}}</td>
            <td>{{$item->buffer_14}}</td>
            <td>{{$item->total}}</td>
            <td>{{$item->src_account}}</td>
            <td>{{$item->dst_account}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
