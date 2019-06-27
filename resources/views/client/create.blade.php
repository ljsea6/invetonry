
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Comprar:') }} {{$inventory->product->name}}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('users.inventories.store', [$user->id, $inventory->id]) }}">
                            @csrf

                            <input type="hidden" id="price" name="price" value="{{$inventory->price}}">
                            <input type="hidden" id="stock" name="stock" value="{{$inventory->quantity}}">
                            
                            <div class="form-group row">
                                <label for="quantity" class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>

                                <div class="col-md-6">
                                    <input id="quantity" type="number" min="1" max="{{$inventory->quantity}}" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity',$inventory->quantity) }}" required autocomplete="quantity" autofocus readonly>

                                    @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="total" class="col-md-4 col-form-label text-md-right">{{ __('Total') }}</label>

                                <div class="col-md-6">
                                    <input id="total" type="text" class="form-control @error('total') is-invalid @enderror" name="total" value="{{ old('total') }}" required autocomplete="total" readonly="true">

                                    @error('total')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Comprar') }}
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
@section('scripts')
    <script>
        $(document).ready(function(){
            let  price = $('#price').val();
            let quantity = $('#quantity').val();
            $('#total').val(price * quantity);
        });
    </script>
@endsection
