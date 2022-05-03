<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    static public $userid = 8;
    public function index()
    {
        return view('admin.user.userManagement');
    }
    public function loadData(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            $user = Auth::user();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($user){
                    $btn = '';
                    if($user->can('user-edit'))
                    {
                        $btn = '<div class="col"><button id="btn_edit" class="btn_edit btn btn-primary btn-lg btn-sm" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button>';
                        if($user->can('user-delete'))
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
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.user.createUser', compact('roles'));
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

        $roles = Role::where('name', '=', $request->roles)->first();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $roles->id)
            ->pluck('role_has_permissions.permission_id')
            ->all();
        $data1 = [];
        foreach ($rolePermissions as $k => $v) {
            $permission = Permission::whereId($v)->first();
            $data1[] = $permission->name;
        }
        foreach ($request->permission as $key => $value) {
            if (!in_array($value, $data1)) {
                $user->givePermissionTo($value);
            }
        }
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
        self::$userid = $id;
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('admin.user.editUser', compact('user', 'roles', 'userRole'));
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
        DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        $user->assignRole($request->input('roles'));
        $role = Role::where('name', '=', $request->roles)->first();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
            ->pluck('role_has_permissions.permission_id')
            ->all();
        $data1 = [];
        foreach ($rolePermissions as $k => $v) {
            $permission = Permission::whereId($v)->first();
            $data1[] = $permission->name;
        }
        $userPermission = [];
        $modelHasPermission = DB::table('model_has_permissions')->where('model_id', $user->id)->pluck('permission_id')->all();
        foreach ($modelHasPermission as $key => $value) {
            $p = Permission::whereId($value)->first();
            $userPermission[] = $p->name;
        }
        $extraPermission = [];
        foreach ($request->permission as $key => $value) {
            if (!in_array($value, $data1)) {
                $extraPermission[] = $value;
            }
        }
        foreach ($userPermission as $key => $value) {
            if (!in_array($value, $extraPermission)) {
                $user->revokePermissionTo($value);
            }
        }
        foreach ($extraPermission as $key => $value) {
            $user->givePermissionTo($value);
        }

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
        DB::table('model_has_permissions')->where('model_id', $request->id)->delete();
        User::where('id', $request->id)->delete();
        return response()->json("data deleted");
    }

    public function getpermission(Request $request)
    {
        if ($request->userid) {
            $userPermission = DB::table('model_has_permissions')->where('model_id', $request->userid)->pluck('permission_id')->all();
        }
        $role = Role::where('name', '=', $request->roles)->first();
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
            ->pluck('role_has_permissions.permission_id')
            ->all();
        if ($request->userid) {
            return Response::json(['permission' => $permission, 'rolePermissions' => $rolePermissions , 'userPermission' => $userPermission]);;
        }
        else
        {
            return Response::json(['permission' => $permission, 'rolePermissions' => $rolePermissions]);;
        }
    }
}
