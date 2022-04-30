<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Json;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.userManagement');
    }
    public function loadData(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                        $btn = '<div class="col"><button id="btn_edit" class="btn_edit btn btn-primary btn-lg btn-sm" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button>';
                        $btn = $btn . '<button id="btn-delete" class="btn-delete btn-primary btn btn-danger btn-sm" data-id="' . $row->id . '" ><i class="fas fa-trash"></i></button>';
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('admin.user.createUser',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user->assignRole($request->input('roles'));
        return response()->json("data inserted");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('admin.user.editUser',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $user = User::find($request->id);
        $user->update($data);
        DB::table('model_has_roles')->where('model_id',$request->id)->delete();
        $user->assignRole($request->input('roles'));
        return response()->json("data updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::where('id', $request->id)->delete();
        return response()->json("data deleted");
    }
}
