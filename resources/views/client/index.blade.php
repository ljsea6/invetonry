@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard Cliente</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            @if(isset($inventories) && count($inventories) >  0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center">Producto</th>
                                            <th scope="col" class="text-center">Precio</th>
                                            <th scope="col" class="text-center">Cantidad</th>
                                            <th scope="col" class="text-center">Fecha Vencimiento</th>
                                            <th scope="col" class="text-center">Estado</th>
                                            <th scope="col" class="text-center">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($inventories as $inventory)
                                            <tr>
                                                <th  scope="row" class="text-center">{{$inventory->product->name}}</th>
                                                <td class="text-center">{{$inventory->price}}</td>
                                                <td class="text-center">{{$inventory->quantity}}</td>
                                                <td class="text-center">{{date("d/m/Y", strtotime($inventory->expiration_date))}}</td>
                                                <td class="text-center">
                                                    @if($inventory->state)
                                                        <span class="badge badge-success">DISPONIBLE</span>
                                                    @else
                                                        <span class="badge badge-danger">AGOTADO</span>
                                                    @endif

                                                </td>
                                                <td class="text-center">
                                                    @if(!$inventory->state)
                                                        <a class="btn btn-warning">Comprar</a>
                                                    @else
                                                    <a class="btn btn-success" href="{{route('users.inventories.create', [$user->id,$inventory->id])}}">Comprar</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                Nada para comprar
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
