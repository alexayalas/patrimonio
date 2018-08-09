<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Tipoingreso;

class TipoingresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tipoingresos.create')->only(['create','store']);
        $this->middleware('permission:tipoingresos.index')->only('index');
        $this->middleware('permission:tipoingresos.edit')->only(['edit','update']);
        $this->middleware('permission:tipoingresos.show')->only('show');
        $this->middleware('permission:tipoingresos.destroy')->only('destroy');          
    }       
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoingresos = Tipoingreso::where('activo',true)->orderBy('id','ASC')->get();
        return $tipoingresos;
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
        $rules = ['nombre_tipoingreso'     => 'required'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion del Nombre de tipo--*/
        if($request->get('nombre_tipoingreso')){
            $nomtip = Str::upper($request->get('nombre_tipoingreso'));
            $tip = Tipoingreso::where('nombre_tipoingreso',$nomtip)->count();
            if($tip > 0){
                return response()->json(['errors'=>['Tipo de Ingreso ' => 'Ya existe un tipo con estos datos']]);
            }
        }

        $tipoingreso = new Tipoingreso($request->all());
        $tipoingreso->nombre_tipoingreso = Str::upper($tipoingreso->nombre_tipoingreso);
        $tipoingreso->save();

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
            $rules = ['nombre_tipoingreso'     => 'required'];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $tipoingreso = Tipoingreso::find($id);
            $tipoingreso->fill($request->all());
            $tipoingreso->nombre_tipoingreso = Str::upper($tipoingreso->nombre_tipoingreso);
            $tipoingreso->save();
  
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
            $tipoingreso = Tipoingreso::findOrFail($id);
            $tipoingreso->activo = false;
            $tipoingreso->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
