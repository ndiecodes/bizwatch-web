<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'item_name' => ['required', 'string', 'max:255'],
            'unit_price' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(array $data)
    {
        return Inventory::create([
            'user_id' => $data['user_id'],
            'item_name' => $data['item_name'],
            'description' => $data['description'],
            'unit_price' => $data['unit_price'],
            'category' => $data['category'],
            'quantity' => $data['quantity'],
        ]);
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
        
        $data = $request->all();

        $data['user_id'] = Auth::id();
        $data['description'] = $request->description ? $request->description : "" ;

        try{
            $account = $this->create($data);
    
            $request->session()->flash('success', 'Inventory added successfully!');
    
            return redirect()->back();
    
        }catch (\Exception $e) {
    
            $request->session()->flash('error', 'Something went wrong! Please try again!'. $e->getMessage());
    
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function sell(Request $request, Inventory $inventory)
    {
        $inventory->sold = $request->sold;
        $inventory->quantity = $inventory->quantity - $request->sold;

        $inventory->save();

        
        $request->session()->flash('success', 'Congrats on your sale!');
    
        return redirect()->back();
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
