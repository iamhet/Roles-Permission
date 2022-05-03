<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.Role.roleManagement');
    }
    public function loadData(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::all();
            $user = Auth::user();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($user){
                    $btn = '';
                    if($user->can('role-edit'))
                    {
                        $btn = '<div class="col"><button id="btn_edit" class="btn_edit btn btn-primary btn-lg btn-sm" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button>';
                        if($user->can('role-delete'))
                        {
                            $btn = $btn . '<button id="btn-delete" class="btn-delete btn-primary btn btn-danger btn-sm" data-id="' . $row->id . '" ><i class="fas fa-trash"></i></button>';
                        }
                    
                    }
                    else{
                        $btn = $btn . "<label> You don't have action Permission</label>";
                    }
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
        $permission = Permission::all();
        return view('admin.Role.createForm', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        return response()->json("role Created");
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
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id')
            ->all();

        return view('admin.Role.editRole', compact('role', 'permission', 'rolePermissions'));
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
        if($request->change == true)
        {
            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($request->input('permission'));
        }
        else{
            $role = Role::find($request->id);
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
            ->pluck('role_has_permissions.permission_id')
            ->all();
            foreach ($rolePermissions as $k => $v) {
                $permission = Permission::whereId($v)->first();
                $data1[] = $permission->name;
            }
            $userPermissions = DB::table("model_has_roles")->where("role_id", $role->id)->pluck('model_id')->all();
        
            foreach ($userPermissions as $key => $value) {
                $user = User::whereId($value)->get();
                $data = [];
                foreach ($data1 as $k => $v) {
                    $data[] = $v;
                }
                $user->givePermissionTo($data);
                $userRole = $user->getRoleNames();
                $user->removeRole($userRole);
            }
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($request->input('permission'));
        }
        return response()->json('data updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Role::where('id', $request->id)->delete();
        return response()->json("data deleted");
    }
}
