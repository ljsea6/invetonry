<?php

namespace App\Http\Controllers\Inventory;

use DB;
use App\Product;
use App\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories =  Inventory::with('product')->get();

        return view('inventory.index')->with(['inventories' => $inventories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();

        return view('inventory.create')->with(['products' => $products]);
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

        $inventory = $this->add($request->all());

        if($inventory) {
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
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        $products  = Product::all();

        return view('inventory.edit')->with(['inventory' => $inventory, 'products' => $products]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        $this->validator($request->all())->validate();
        $ok = ($request->state == 'true') ? 1 : 0;
        $old_state = $inventory->state;


        $inventory->quantity = $request->quantity;
        $inventory->number_lot = $request->number_lot;
        $inventory->price = $request->price;
        $inventory->product_id = $request->product_id;
        $inventory->expiration_date =date("Y-m-d", strtotime($request->expiration_date));
        $inventory->state = $ok;

        if($inventory->isClean()) {
            return redirect()
                ->back()
                ->withInput()
                ->with(['error' => 'Para actualizar se debe modificar al menos un valor.']);
        }

        if($old_state != $ok) {

            if($old_state == 0 && $ok == 1) {
                DB::table('sales')
                    ->where('inventory_id', $inventory->id)
                    ->update(['state' => false]);
            }
        }

        $inventory->save();

        return redirect()
            ->route('inventories.index')
            ->with(['status' => 'Se ha actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()
            ->back()
            ->with(['status' => 'Se ha eliminado correctamente']);
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
            'quantity.required' => 'El lote es requerido',
            'quantity.numeric' => 'El lote debe ser un  número',
            'number_lot.required' => 'El lote es requerido',
            'number_lot.numeric' => 'El lote debe ser un número',
            'price.required' => 'El precio es requerido',
            'price.numeric' => 'El precio debe ser un número y puede contener un punto para la parte decimal',
            'expiration_date.required' => 'La fecha de vencimiento es requerida',
            'expiration_date.date_format' => 'La fecha de vencimiento debe tener el formato mm/dd/yyyy',
            'product_id.required' => 'El producto es requerido',
            'product_id.exists' => 'El producto debe exisitir en base de datos.',
            'state.required' =>'El estado es requerido',
            'state.in' => 'El estado debe ser activo o inactivo'
        ];

        return Validator::make($data, [
            'state' => ['required', 'in:true,false'],
            'quantity' => ['required', 'numeric'],
            'number_lot' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'expiration_date' => ['required','date_format:d/m/Y'],
            'product_id' => ['required', 'exists:products,id']
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
        return Inventory::create([
            'quantity' => $data['quantity'],
            'number_lot' => $data['number_lot'],
            'price' => $data['price'],
            'expiration_date' => date("Y-m-d", strtotime($data['expiration_date']) ),
            'product_id' => $data['product_id']
        ]);
    }
}
