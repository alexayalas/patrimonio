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
        $roles = Role::with('permissions','modules')->orderBy('id','ASC')->get();
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
        //$role->permissions()->sync($request->get('permissions'));
        // actualiza modulos
        //$role->modules()->sync($request->get('checkedRol'));
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
        //$role->permissions()->sync($request->get('permissions'));
        // actualiza los modulos
        //$role->modules()->sync($request->get('checkedRol'));
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

    public function updateModules(Request $request, $id)
    {
        $role = Role::find($id);
        // actualiza los modulos
        $role->modules()->sync($request->get('checkedRol'));
    } 
    
    public function cargaModules($id)
    {
        $modules = Role::find($id)->modules()->orderBy('id','ASC')->get();
        //$modules = Module::all();               // cargo todos los modulos de la BD        
        $menus = array();
        $options = array();
        $suboptions = array();
        $content =  array();
        $menucompleto = array();
        $opcioncompleta = array();
        // consulto todos los parent 0
        foreach ($modules as $modul) {
            if($modul->idparent == 0){
                array_push($menus,$modul);      // cargo todos los parent 0 en el array $menus
            }
        }
        // consulto 1 a 1 los parents correspondientes a cada parent 0
        foreach ($menus as $menu) {
            foreach ($modules as $modulo) {
                if($modulo->idparent == $menu->id){
                    $option = array(
                            'name'          => $modulo->name,
                            'id'            => $modulo->id,
                            'idmenu'        => $menu->id,
                            'icono'         => $modulo->icono,
                            'name_router'   => $modulo->name_router,
                            'name_template' => $modulo->name_template,
                            'options'       => $modulo
                    );
                    array_push($options,$option);       // cargo los hijos de cada parent 0 en el array $options

                }
            }
        }
        // consulto 1 a 1 si los hijos tiene mas desendientes
        foreach ($options as $subope) {
            foreach ($modules as $mod) {
                if($subope['options']->id == $mod->idparent){
                    $sub = array(
                        'name'          => $subope['name'] ,
                        'idoption'      => $subope['options']->id,                 
                        'options'       => $mod
                    );
                    array_push($suboptions,$sub);   // lo cargo en el array $suboptions
                }
            }
        }

        // enlazamos menu - option
        foreach ($menus as $menu) {
            foreach ($options as $option) {
                if($option['idmenu'] == $menu->id){
                    foreach ($suboptions as $sop) {     // enlazamos opciones con subopciones
                        if($option['options']->id == $sop['idoption']){
                            array_push($content,$sop);
                        }
                    }   
                    $men_sub = array(
                            'name'          => $option['name'],
                            'id'            => $option['id'],
                            'icono'         => $option['icono'],
                            'name_router'   => $option['name_router'],
                            'name_template' => $option['name_template'],
                            'options'       => $option,
                            'suboptions'    => $content
                    );                 
                    array_push($opcioncompleta,$men_sub);
                    $content = array();
                }

            }
            $mencom = array(
                'name'          => $menu->name,
                'idmenu'        => $menu->id,
                'icono'         => $menu->icono,
                'name_router'   => $menu->name_router,
                'name_template' => $menu->name_template,
                'options'       => $opcioncompleta
            );
            $opcioncompleta = array();
            array_push($menucompleto,$mencom);
        }

        return $menucompleto;        
    }
}
