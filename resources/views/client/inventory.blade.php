@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard Mis Compras</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if(isset($purchases) && count($purchases) >  0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Producto</th>
                                        <th scope="col" class="text-center">Precio</th>
                                        <th scope="col" class="text-center">Cantidad</th>
                                        <th scope="col" class="text-center">Total</th>
                                        <th scope="col" class="text-center">Estado</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($purchases as $purchase)
                                        <tr>
                                            <th  scope="row" class="text-center">{{$purchase->product->name}}</th>
                                            <td class="text-center">{{$purchase->price}}</td>
                                            <td class="text-center">{{$purchase->pivot->quantity}}</td>
                                            <td class="text-center">{{$purchase->pivot->total}}</td>
                                            <td class="text-center">
                                                @if($purchase->pivot->state)
                                                    <span class="badge badge-success">DISPONIBLE</span>
                                                @else
                                                    <span class="badge badge-danger">ANULADA</span>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            Sin compras
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
