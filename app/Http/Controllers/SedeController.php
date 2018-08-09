<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Sede;

class SedeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sedes.create')->only(['create','store']);
        $this->middleware('permission:sedes.index')->only('index');
        $this->middleware('permission:sedes.edit')->only(['edit','update']);
        $this->middleware('permission:sedes.show')->only('show');
        $this->middleware('permission:sedes.destroy')->only('destroy');          
    }       
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sedes = Sede::where('activo',true)->orderBy('id','ASC')->get();
        return $sedes;
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
        $rules = ['nombre_sede'     => 'required',
                    'direccion'     => 'required'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion del nombre sede --*/
        if($request->get('nombre_sede')){
            $nomsed = $request->get('nombre_sede');
            $sed = Sede::where('nombre_sede',$nomsed)->count();
            if($sed > 0){
                return response()->json(['errors'=>['Sede ' => 'Ya existe una sede con este nombre : '.$request->get('nombre_sede')]]);
            }
        }

        $sede = new Sede($request->all());
        $sede->nombre_sede = Str::upper($sede->nombre_sede);
        $sede->direccion = Str::upper($sede->direccion);        
        $sede->save();

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
            $rules = ['nombre_sede'     => 'required',
                        'direccion'     => 'required'];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $sede = Sede::find($id);
            $sede->fill($request->all());
            $sede->nombre_sede = Str::upper($sede->nombre_sede);
            $sede->direccion = Str::upper($sede->direccion);            
            $sede->save();
  
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
            $sede = Sede::findOrFail($id);
            $sede->activo = false;
            $sede->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
