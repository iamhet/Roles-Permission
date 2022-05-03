<?php

namespace App\Http\Controllers;

use App\Models\module2;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class Module2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.module2');
    }
    public function loadData(Request $request)
    {
        if ($request->ajax()) {
            $data = module2::all();
            $user = Auth::user();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($user){
                    $btn = '';
                    if($user->can('module2-edit'))
                    {
                        $btn = '<div class="col"><button id="btn_edit" class="btn_edit btn btn-primary btn-lg btn-sm" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button>';
                        if($user->can('module2-delete'))
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
