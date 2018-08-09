<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Garantia;

class GarantiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:garantias.create')->only(['create','store']);
        $this->middleware('permission:garantias.index')->only('index');
        $this->middleware('permission:garantias.edit')->only(['edit','update']);
        $this->middleware('permission:garantias.show')->only('show');
        $this->middleware('permission:garantias.destroy')->only('destroy');          
    }       
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $garantias = Garantia::where('activo',true)->orderBy('id','ASC')->get();
        return $garantias;
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
        $rules = ['nombre_garantia'     => 'required'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion del nombre garantia --*/
        if($request->get('nombre_garantia')){
            $nomgar = $request->get('nombre_garantia');
            $gar = Garantia::where('nombre_garantia',$nomgar)->count();
            if($gar > 0){
                return response()->json(['errors'=>['Garantia ' => 'Ya existe una garantia con este nombre : '.$request->get('nombre_garantia')]]);
            }
        }

        $garantia = new Garantia($request->all());
        $garantia->nombre_garantia = Str::upper($garantia->nombre_garantia);
        $garantia->save();

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
            $rules = ['nombre_garantia'     => 'required'];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $garantia = Garantia::find($id);
            $garantia->fill($request->all());
            $garantia->nombre_garantia = Str::upper($garantia->nombre_garantia);
            $garantia->save();
  
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
            $garantia = Garantia::findOrFail($id);
            $garantia->activo = false;
            $garantia->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
