<?php

namespace App\Http\Controllers\Provider;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::all();
        $user = User::find(Auth::user()->id);

        return view('product.index')->with(['user' => $user, 'products' => $products]);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $product = $this->add($request->all());

        if($product) {
            return redirect()
                ->back()
                ->with(['status' => 'Se ha agregado correctamente']);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with(['error' => 'Ha ocurrido un error.']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.edit')->with(['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validator_edit($request->all(), $product)->validate();

        $product->name = $request->name;
        $product->description = $request->description;

        if($product->isClean()) {
           return redirect()
               ->back()
               ->withInput()
               ->with(['error' => 'Se debe cambiar al menos un valor para actualizar']);
        }

        $product->save();

        return redirect()->route('home')->with(['status' => 'Información actualizada con exito.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('home')->with(['status' => 'Producto eliminado con exito.']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'name.required' => 'El producto es requerido',
            'name.unique' => 'El producto ya existe',
            'name.string' => 'El producto debe ser un string',
            'name.max' => 'El producto debe tener maximo 255 caracteres',
            'description.required' => 'La descricción es requerido',
            'description.string' => 'La descricción debe ser un string',
            'description.max' => 'La descricción debe tener maximo 255 caracteres',
        ];

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'description' => ['required', 'string', 'max:255'],
        ], $messages);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_edit(array $data, Product $product)
    {
        $messages = [
            'name.required' => 'El producto es requerido',
            'name.unique' => 'El producto ya existe',
            'name.string' => 'El producto debe ser un string',
            'name.max' => 'El producto debe tener maximo 255 caracteres',
            'description.required' => 'La descricción es requerido',
            'description.string' => 'La descricción debe ser un string',
            'description.max' => 'La descricción debe tener maximo 255 caracteres',
        ];

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:products,name,' .$product->id],
            'description' => ['required', 'string', 'max:255'],
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function add(array $data)
    {
        return Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }
}
