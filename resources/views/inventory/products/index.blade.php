@extends('layouts.app', ['page' => 'List of Products', 'pageSlug' => 'products', 'section' => 'inventory'])


@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-8">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Products</h4>
                        </div>
                        <div class="col-sm text-right">
                            <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">New product</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <div class="card">
                        <table class="table table-sm" id="" style="margin-left: -5px">
                            <thead class=" text-primary">
                                <th scope="col">Category</th>
                                <th scope="col">Product</th>
                                @if (!Auth::guest())
                                @if (Auth::user()->user_type == 'admin')
                                <th scope="col">Base Price</th>
                                <th scope="col">Total Sold</th>
                                @endif
                                @endif
                                <th scope="col">Stock</th>
                                <th scope="col">Faulty</th>
                                <th scope="col">Action</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td><a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a></td>
                                        <td>{{ $product->name }}</td>
                                        @if (!Auth::guest())
                                        @if (Auth::user()->user_type == 'admin')
                                        <td>{{ format_money($product->price) }}</td>
                                        <td>{{ $product->solds->sum('qty') }}</td>
                                        @endif
                                        @endif
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ $product->stock_defective }}</td>
                                        {{-- <td class="td-actions text-right"> --}}
                                        <td class="text-left">
                                            @if (!Auth::guest())
                                            @if (Auth::user()->user_type == 'admin')
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                                <i class="tim-icons icon-zoom-split"></i>
                                            </a>
                                            @endif
                                            @endif
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Product">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Product" onclick="confirm('Are you sure you want to remove this product? The records that contain it will continue to exist.') ? this.parentElement.submit() : ''">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end">
                        {{ $products->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
