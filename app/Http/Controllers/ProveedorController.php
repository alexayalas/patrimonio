<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Proveedor;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:proveedores.create')->only(['create','store']);
        $this->middleware('permission:proveedores.index')->only('index');
        $this->middleware('permission:proveedores.edit')->only(['edit','update']);
        $this->middleware('permission:proveedores.show')->only('show');
        $this->middleware('permission:proveedores.destroy')->only('destroy');          
    }      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Proveedor::where('activo',true)->orderBy('id','ASC')->get();
        return $proveedores;
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
      DB::beginTransaction();    

      try {
        $rules =    ['nombre_proveedor'     => 'required',
                      'direccion' => 'required',
                      'ruc' => 'required'                                          
                    ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion del RUC--*/
        if($request->get('ruc')){
            $ruc = $request->get('ruc');
            $pro = Proveedor::where('ruc',$ruc)->count();
            if($pro > 0){
                return response()->json(['errors'=>['RUC ' => 'Ya existe un proveedor con estos datos']]);
            }
        }
        /*-- validacion del Nombre de empleado--*/
        if($request->get('nombre_proveedor')){
            $nom = Str::upper($request->get('nombre_proveedor'));        
            $pro = Proveedor::where('nombre_proveedor',$nom)->count();
            if($pro > 0){
                return response()->json(['errors'=>['Nombre Proveedor ' => 'Ya existe un proveedor con estos datos']]);
            }
        }        

        $proveedor = new Proveedor($request->all());
        $proveedor->nombre_proveedor = Str::upper($proveedor->nombre_proveedor);
        $proveedor->direccion = Str::upper($proveedor->direccion);                
        $proveedor->save();

        DB::commit();        
        return;
      }
      catch(Exception $e){
        DB::rollback();
        return response()->json(
            ['status' => $e->getMessage()], 422
        );
      }
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
        DB::beginTransaction(); 

        try {
            $rules =    ['nombre_proveedor'     => 'required',
                        'direccion' => 'required',
                        'ruc' => 'required'
                        ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $proveedor = Proveedor::find($id);
            $proveedor->fill($request->all());
            $proveedor->nombre_proveedor = Str::upper($proveedor->nombre_proveedor);
            $proveedor->direccion = Str::upper($proveedor->direccion);
            $proveedor->save();
  
          DB::commit();           
          return;
        } catch (Exception $e) {
          DB::rollback();          
          return response()->json(
              ['status' => $e->getMessage()], 422
          );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->activo = false;
            $proveedor->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
