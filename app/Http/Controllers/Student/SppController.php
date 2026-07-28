<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $items = Payments::where('id_user', $user->id)
            ->orWhere(function ($query) use ($user) {
                if ($user->nisn) {
                    $query->where('nisn', $user->nisn);
                }
            })->get();

        return view('pages.student.payment.index', [
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
        return view('pages.student.payment.create');
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
            'month' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'total_payment' => 'required|numeric',
        ]);

        $user = Auth::user();
        $data['id_user'] = $user->id;
        $data['nisn'] = $user->nisn ?? '';
        $data['name'] = $user->name;

        Payments::create($data);

        return redirect()->route('data-log-spp.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $item = Payments::where(function ($q) use ($user) {
            $q->where('id_user', $user->id);
            if ($user->nisn) {
                $q->orWhere('nisn', $user->nisn);
            }
        })->findOrFail($id);

        return view('pages.student.payment.detail', [
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
        $user = Auth::user();
        $item = Payments::where(function ($q) use ($user) {
            $q->where('id_user', $user->id);
            if ($user->nisn) {
                $q->orWhere('nisn', $user->nisn);
            }
        })->findOrFail($id);

        return view('pages.student.payment.edit', [
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
        $user = Auth::user();
        $item = Payments::where(function ($q) use ($user) {
            $q->where('id_user', $user->id);
            if ($user->nisn) {
                $q->orWhere('nisn', $user->nisn);
            }
        })->findOrFail($id);

        $data = $request->validate([
            'month' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'total_payment' => 'required|numeric',
        ]);

        $item->update($data);

        return redirect()->route('data-log-spp.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $item = Payments::where(function ($q) use ($user) {
            $q->where('id_user', $user->id);
            if ($user->nisn) {
                $q->orWhere('nisn', $user->nisn);
            }
        })->findOrFail($id);

        $item->delete();
        return redirect()->route('data-log-spp.index');
    }
}
