<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Area;
use App\Empresa;
use App\Ubicacion;

class UbicacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ubicaciones.create')->only(['create','store']);
        $this->middleware('permission:ubicaciones.index')->only('index');
        $this->middleware('permission:ubicaciones.edit')->only(['edit','update']);
        $this->middleware('permission:ubicaciones.show')->only('show');
        $this->middleware('permission:ubicaciones.destroy')->only('destroy');          
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ubicaciones = Ubicacion::with('area','area.empresa')->orderBy('id','ASC')->where('activo',true)->get();
        return $ubicaciones;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $combo_areas = Area::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_area as text','empresa_id','sede_id']); 
        return $combo_areas;    
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
        $rules = ['nombre_ubicacion'     => 'required',
                  'area_id' => 'required' ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion del Nombre de Ubicacion--*/
        if($request->get('nombre_ubicacion')){
            $nomubi = $request->get('nombre_ubicacion');
            $areid = $request->get('area_id');
            $ubi = Ubicacion::where(['nombre_ubicacion' => $nomubi,'area_id' => $areid])->count();
            if($ubi > 0){
                return response()->json(['errors'=>['Ubicacion ' => 'Ya existe una ubicación con estos datos']]);
            }
        }

        $ubicacion = new Ubicacion($request->all());
        $ubicacion->nombre_ubicacion = Str::upper($ubicacion->nombre_ubicacion);
        $ubicacion->save();

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
            $rules = ['nombre_ubicacion'     => 'required',
                      'area_id' => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $ubicacion = Ubicacion::find($id);
            $ubicacion->fill($request->all());
            $ubicacion->nombre_ubicacion = Str::upper($ubicacion->nombre_ubicacion);
            $ubicacion->save();
  
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
        //
    }
}
