@section('contents')
	<div id="sales-analytics-report" class="row">
		<div class="col-md-2">
					<form id="generate-sales-analytics-report-form" method="get" action="/products">
						<div class="form-group"><label for="sa-sku">Filter by Sku</label><input class="form-control" type="text" id="sa-sku" name="sku" value="{{Input::get('sku','')}}"/></div>
						<div class="form-group"><label for="sa-vendor">Filter by Vendor</label><input class="form-control" type="text" id="sa-vendor" name="vendor" value="{{Input::get('vendor','')}}"/></div>
						<div class="form-group"><label for="sa-name">Filter by Name</label><input class="form-control" type="text" id="sa-name" name="name"value="{{Input::get('name','')}}"/></div>
						<div class="form-group">
							<label for="sa-sortby">Sort By</label>
							<select class="form-control" id="sa-sortby" name="sortby">
								<option value="id">Id</option>
								<option value="sku">Sku</option>	
								<option value="name">Name</option>
								<option value="vendor">Vendor</option>
							</select>
						</div>
						<div class="form-group"><label for="sa-perpage">Products Per Page</label><input class="form-control" type="text" id="sa-perpage" name="perpage" value="{{Input::get('perpage',50)}}"/></div>
						<button type="submit" id="sales-analytics-report-submit" class="btn btn-default">Run Report</button>
					
				</form>
		</div>

	@if($products)

	<div class="products-list col-md-10">
		<h3>Found {{$products->getTotal()}} Products</h3>
		<table class="table table-hover table-bordered table-sort">
			<thead>
			<tr>
				<th>Id</th>
				<th>Sku</th>
				<th>Vendor</th>
				<th>Name</th>
				<th>Current Price</th>
				<th>Sold in 30 Days</th>
				<th>Sold in 90 Days</th>
				<th>Sold in 180 Days</th>
				<th>Sold within 1 Year</th>
			</tr>
		</thead>
			@foreach($products as $product)
				<tr>
					<td>{{$product->id}}</td>
					<td>{{link_to_action('ItemsController@show',$product->sku,array($product->id),array('target'=>'_blank'))}}</td>
					<td>{{$product->vendor}}</td>
					<td>{{$product->name}}</td>
					<td>{{$product->current_price}}</td>
					<td>{{$product->sold_in_30}}</td>
					<td>{{$product->sold_in_90}}</td>
					<td>{{$product->sold_in_180}}</td>
					<td>{{$product->sold_in_year}}</td>
				</tr>
			@endforeach
		</table>
		{{ $products->appends(Input::only('sku','vendor','name','sortby','perpage'))->links() }}


	</div>
</div>


	@endif
@stop