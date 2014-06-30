@section('contents')

	@if($product)
	<h1>Orders : {{count($product->itemsSold)}} </h1>
<table class="table table-hover table-bordered">
			
			@foreach($product->toArray() as $key => $info)
				@if(!is_array($info))
					<tr>
						<td>{{$key}}</td>
						<td>{{$info}}</td>
					</tr>
				@endif
			@endforeach
		</table>

		<table class="table table-hover table-bordered">
			<tr>
				<th>Order Id</th>
				<th>Order Date</th>
				<th>Order Status</th>
			</tr>
			@foreach($product->itemsSold as $order)
				<tr>
					<td>{{$order->order->shipworks_order_id}}</td>
					<td>{{$order->order->order_date}}</td>
					<td>{{($order->order->status ? 'Shipped' : 'Canceled')}}</td>
				</tr>
			@endforeach
		</table>

	@endif
@stop