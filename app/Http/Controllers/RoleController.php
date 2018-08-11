<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Caffeinated\Shinobi\Models\Permission;
use Caffeinated\Shinobi\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles.create')->only(['create','store']);
        $this->middleware('permission:roles.index')->only('index');
        $this->middleware('permission:roles.edit')->only(['edit','update']);
        $this->middleware('permission:roles.show')->only('show');
        $this->middleware('permission:roles.destroy')->only('destroy');          
    }
    /**
     * Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('id','ASC')->get();
        return $roles;        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return $permissions; 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create($request->all());

        // actualiza permisos
        $role->permissions()->sync($request->get('permissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $combo_roles = Role::orderBy('id','ASC')->get(['id as value','name as text']); 
        return $combo_roles;   

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
        $role = Role::find($id);

        // actualiza el role
        $role->update($request->all());

        // actualiza los permisos
        $role->permissions()->sync($request->get('permissions'));
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
