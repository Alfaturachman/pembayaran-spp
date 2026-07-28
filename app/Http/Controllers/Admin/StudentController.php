<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classes;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = User::where('roles', 'STUDENT')->get();

        return view('pages.admin.student.index', [
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
        $classes = Classes::pluck('class_name', 'class_name');

        return view('pages.admin.student.create', [
            'classes' => $classes,
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
        $data = $request->validate([
            'nisn' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'class' => 'nullable|string',
        ]);

        $data['roles'] = 'STUDENT';

        User::create($data);

        return redirect()->route('data-siswa.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = User::where('roles', 'STUDENT')->findOrFail($id);

        return view('pages.admin.student.detail', [
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
        $item = User::where('roles', 'STUDENT')->findOrFail($id);

        return view('pages.admin.student.edit', [
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
        $item = User::where('roles', 'STUDENT')->findOrFail($id);

        $data = $request->validate([
            'nisn' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'class' => 'nullable|string',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $item->update($data);

        return redirect()->route('data-siswa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = User::where('roles', 'STUDENT')->findOrFail($id);
        $item->delete();
        return redirect()->route('data-siswa.index');
    }
}
