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
use App\Sede;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:areas.create')->only(['create','store']);
        $this->middleware('permission:areas.index')->only('index');
        $this->middleware('permission:areas.edit')->only(['edit','update']);
        $this->middleware('permission:areas.show')->only('show');
        $this->middleware('permission:areas.destroy')->only('destroy');          
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::with('empresa','sede')->orderBy('id','ASC')->where('activo',true)->get();
        return $areas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $combo_empresas = Empresa::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_empresa as text']); 
        $combo_sedes = Sede::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_sede as text']); 

        return [
              'combo_empresas'        => $combo_empresas,
              'combo_sedes'           => $combo_sedes              
          ];     
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
        $rules = ['nombre_area'     => 'required',
                  'empresa_id' => 'required'
                ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion del Nombre de Area--*/
        if($request->get('nombre_area')){
            $nomare = Str::upper($request->get('nombre_area'));
            $empid = $request->get('empresa_id');
            $sedid = $request->get('sede_id');
            $are = Area::where(['nombre_area' => $nomare,'empresa_id' => $empid,'sede_id' => $sedid])->count();
            if($are > 0){
                return response()->json(['errors'=>['Area ' => 'Ya existe una area con estos datos']]);
            }
        }

        $area = new Area($request->all());
        $area->nombre_area = Str::upper($area->nombre_area);
        $area->save();

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
            $rules = ['nombre_area'     => 'required',
                      'empresa_id' => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $area = Area::find($id);
            $area->fill($request->all());
            $area->nombre_area = Str::upper($area->nombre_area);
            $area->save();
  
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
            $area = Area::findOrFail($id);
            $area->activo = false;
            $area->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
