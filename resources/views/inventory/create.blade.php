@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Inventariar') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('inventories.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="product_id" class="col-md-4 col-form-label text-md-right">{{ __('Producto') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required autocomplete="product_id" autofocus>
                                        <option disabled>Seleccione un producto</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}" @if (old('product_id') == $product->id) {{ 'selected' }} @endif>
                                                {{$product->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="number_lot" class="col-md-4 col-form-label text-md-right">{{ __('Lote') }}</label>

                                <div class="col-md-6">
                                    <input id="number_lot" type="text" class="form-control @error('number_lot') is-invalid @enderror" name="number_lot" value="{{old('number_lot')}}" required autocomplete="number_lot" autofocus>

                                    @error('number_lot')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>

                                <div class="col-md-6">
                                    <input id="quantity" type="text" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" required autocomplete="quantity" autofocus>

                                    @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Precio') }}</label>

                                <div class="col-md-6">
                                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required autocomplete="price" autofocus>

                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="expiration_date" class="col-md-4 col-form-label text-md-right">{{ __('Fecha vencimiento') }}</label>

                                <div class="col-md-6">
                                    <input id="expiration_date" type="text" class="form-control @error('expiration_date') is-invalid @enderror" name="expiration_date" value="{{ old('expiration_date') }}" placeholder="dd/mm/yyyy" required autocomplete="expiration_date" autofocus>

                                    @error('expiration_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Agregar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
