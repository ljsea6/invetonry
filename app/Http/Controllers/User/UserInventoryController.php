<?php

namespace App\Http\Controllers\User;

use App\Inventory;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $purchases = $user->purchases;

        return view('client.inventory')->with(['user' => $user, 'purchases' => $purchases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user, Inventory $inventory)
    {
        return view('client.create')->with(['user' => $user, 'inventory' => $inventory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Inventory $inventory)
    {
        $this->validator($request->all())->validate();

        $inventory->state = false;

        $inventory->save();

        DB::table('sales')->insert([
            'user_id' => $user->id,
            'inventory_id' => $inventory->id,
            'total' => $request->total,
            'quantity' => $request->quantity,
            'state' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()
            ->route('users.inventories.index', [$user->id])
            ->with(['status' => 'Se ha hecho la compra correctamente']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
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
            'total.required' => 'El total es requerido',
            'total.numeric' => 'El total debe ser numerico',
            'quantity.numeric' => 'La cantidad es requerida',
            'quantity.required' => 'La cantidad debe ser numerica',
        ];

        return Validator::make($data, [
            'total' => ['required', 'numeric',],
            'quantity' => ['required', 'numeric'],
        ], $messages);
    }
}
