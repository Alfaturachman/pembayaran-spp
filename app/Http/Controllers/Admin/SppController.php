<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payments;

class SppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Payments::all();

        return view('pages.admin.payment.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.payment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_spp' => 'nullable|integer',
            'id_user' => 'nullable|integer',
            'nisn' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'month' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'total_payment' => 'required|numeric',
        ]);

        Payments::create($data);

        return redirect()->route('data-spp.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Payments::findOrFail($id);

        return view('pages.admin.payment.detail', [
            'item' => $item
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Payments::findOrFail($id);

        return view('pages.admin.payment.edit', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_spp' => 'nullable|integer',
            'id_user' => 'nullable|integer',
            'nisn' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'month' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'total_payment' => 'required|numeric',
        ]);

        $item = Payments::findOrFail($id);
        $item->update($data);

        return redirect()->route('data-spp.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Payments::findOrFail($id);
        $item->delete();
        return redirect()->route('data-spp.index');
    }
}
