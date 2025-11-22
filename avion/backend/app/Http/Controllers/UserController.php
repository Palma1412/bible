<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $p = new User();
        $p->email = $request->email;
        $p->password =  Hash::make($request->password);
        $p->name = $request->name;

        $p->save();
    }

    public function update(Request $request)
    {
        $p = $this->User();
        $p->email = $request->email;
        $p->password =  Hash::make($request->password);
        $p->name = $request->name;
    }

    public function delete(Request $request, $id)
    {
        $p = User::FindOrFail($id);
        $p->delete();
    }

    public function index()
    {
        return response()->json(User::all());
    }
}
