<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Grupo;

class GrupoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:grupos.create')->only(['create','store']);
        $this->middleware('permission:grupos.index')->only('index');
        $this->middleware('permission:grupos.edit')->only(['edit','update']);
        $this->middleware('permission:grupos.show')->only('show');
        $this->middleware('permission:grupos.destroy')->only('destroy');          
    }      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grupos = Grupo::where('activo',true)->orderBy('id','ASC')->get();
        return $grupos;
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
        $rules = ['nombre_grupo'     => 'required'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion del Nombre de grupo--*/
        if($request->get('nombre_grupo')){
            $nomgru = Str::upper($request->get('nombre_grupo'));
            $gru = Grupo::where('nombre_grupo',$nomgru)->count();
            if($gru > 0){
                return response()->json(['errors'=>['Grupo ' => 'Ya existe un grupo con estos datos']]);
            }
        }

        $grupo = new Grupo($request->all());
        $grupo->nombre_grupo = Str::upper($grupo->nombre_grupo);
        $grupo->save();

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
            $rules = ['nombre_grupo'     => 'required'];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $grupo = Grupo::find($id);
            $grupo->fill($request->all());
            $grupo->nombre_grupo = Str::upper($grupo->nombre_grupo);
            $grupo->save();
  
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
            $grupo = Grupo::findOrFail($id);
            $grupo->activo = false;
            $grupo->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
