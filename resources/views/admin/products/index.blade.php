@extends('app')

@section('content')

<div class="container">
	<h3>Produtos</h3>
	<br>
	<a href="{{ route('admin.products.create')}}" class="btn btn-default">Novo Produto</a>
	<br>
	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Produto</th>
				<th>Categoria</th>
				<th>Preço</th>
				<th>Ação</th>
			</tr>
		<tbody>
			@foreach($products as $product)
			<tr>
				<td>{{$product->id}}</td>
				<td>{{$product->name}}</td>
				<td>{{$product->price}}</td>
				<td>{{$product->category->name}}</td>
				<td>
					<a href="{{route('admin.products.edit',['id'=>$product->id])}}" class="btn btn-default btn-sm">Editar</a>
					<a href="{{route('admin.products.delete',['id'=>$product->id])}}" class="btn btn-danger btn-sm">Excluir</a>
				</td>
			</tr>
			@endforeach
		</tbody>
		</thead>
	</table>
	{!! $products->render() !!}

</div>

@endsection
