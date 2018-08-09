<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Grupo;
use App\Clase;

class ClaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:clases.create')->only(['create','store']);
        $this->middleware('permission:clases.index')->only('index');
        $this->middleware('permission:clases.edit')->only(['edit','update']);
        $this->middleware('permission:clases.show')->only('show');
        $this->middleware('permission:clases.destroy')->only('destroy');          
    }      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clases = Clase::with('grupo')->orderBy('id','ASC')->where('activo',true)->get();
        return $clases;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $combo_grupos = Grupo::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_grupo as text']); 
        return $combo_grupos;   
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
        $rules = ['nombre_clase'     => 'required',
                  'grupo_id' => 'required'
                ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion del Nombre de Area--*/
        if($request->get('nombre_clase')){
            $nomcla = Str::upper($request->get('nombre_clase'));
            $gruid = $request->get('grupo_id');
            $cla = Clase::where(['nombre_clase' => $nomcla,'grupo_id' => $gruid])->count();
            if($cla > 0){
                return response()->json(['errors'=>['Clase ' => 'Ya existe una clase con estos datos']]);
            }
        }

        $clase = new Clase($request->all());
        $clase->nombre_clase = Str::upper($clase->nombre_clase);
        $clase->save();

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
            $rules = ['nombre_clase'     => 'required',
                      'grupo_id' => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $clase = Clase::find($id);
            $clase->fill($request->all());
            $clase->nombre_clase = Str::upper($clase->nombre_clase);
            $clase->save();
  
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
            $clase = Clase::findOrFail($id);
            $clase->activo = false;
            $clase->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
