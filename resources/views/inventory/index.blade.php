@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard Inventario</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <a class="btn btn-primary mb-3" href="{{route('inventories.create')}}" role="button">Agregar</a>
                        @if(isset($inventories) && count($inventories) >  0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Lote</th>
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
                                            <th scope="row" class="text-center">{{$inventory->number_lot}}</th>
                                            <td class="text-center">{{$inventory->product->name}}</td>
                                            <td class="text-center">{{$inventory->price}}</td>
                                            <td class="text-center">{{$inventory->quantity}}</td>
                                            <td class="text-center">{{date("d/m/Y", strtotime($inventory->expiration_date))}}</td>
                                            <td class="text-center">
                                                @if($inventory->state)
                                                    <span class="badge badge-success">ACTIVO</span>
                                                @else
                                                    <span class="badge badge-danger">INACTIVO</span>
                                                @endif

                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-success" href="{{route('inventories.edit', [$inventory->id])}}">Editar</a>
                                                <!-- Button trigger modal -->
                                                <a class="btn btn-warning" data-toggle="modal" data-target="#delete_inventory_{{$inventory->id}}">
                                                    Eliminar
                                                </a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="delete_inventory_{{$inventory->id}}" tabindex="-1" role="dialog" aria-labelledby="delete_inventory_{{$inventory->id}}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Eliminar inventario: {{$inventory->id}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ¿Realmente está seguro?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="POST" action="{{ route('inventories.destroy', [$inventory->id]) }}">
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
