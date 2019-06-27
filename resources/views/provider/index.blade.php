@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard Proveedor</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a class="btn btn-primary mb-3" href="{{route('products.create')}}" role="button">Agregar</a>
                        @if(isset($products) && count($products) >  0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">Producto</th>
                                        <th scope="col" class="text-center">Descripción</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <th scope="row" class="text-center">{{$product->id}}</th>
                                        <td class="text-center">{{$product->name}}</td>
                                        <td class="text-center">{{$product->description}}</td>
                                        <td class="text-center">
                                            <a class="btn btn-success" href="{{route('products.edit', [$product->id])}}">Editar</a>
                                            <!-- Button trigger modal -->
                                            <a class="btn btn-warning" data-toggle="modal" data-target="#delete_product_{{$product->id}}">
                                                Eliminar
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="delete_product_{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="delete_product_{{$product->id}}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Eliminar producto: {{$product->name}}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Realmente está seguro?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="POST" action="{{ route('products.destroy', [$product->id]) }}">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
