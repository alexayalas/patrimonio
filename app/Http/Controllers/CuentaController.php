<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Cuenta;

class CuentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cuentas.create')->only(['create','store']);
        $this->middleware('permission:cuentas.index')->only('index');
        $this->middleware('permission:cuentas.edit')->only(['edit','update']);
        $this->middleware('permission:cuentas.show')->only('show');
        $this->middleware('permission:cuentas.destroy')->only('destroy');          
    }      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuentas = Cuenta::where('activo',true)->orderBy('id','ASC')->get();
        return $cuentas;
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
        $rules = ['nombre_cuenta'     => 'required'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion del Nombre de tipo--*/
        if($request->get('nombre_cuenta')){
            $nomcue = Str::upper($request->get('nombre_cuenta'));
            $cue = Cuenta::where('nombre_cuenta',$nomcue)->count();
            if($cue > 0){
                return response()->json(['errors'=>['Cuenta ' => 'Ya existe una cuenta con estos datos']]);
            }
        }

        $cuenta = new Cuenta($request->all());
        $cuenta->nombre_cuenta = Str::upper($cuenta->nombre_cuenta);
        $cuenta->save();

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
            $rules = ['nombre_cuenta'     => 'required'];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $cuenta = Cuenta::find($id);
            $cuenta->fill($request->all());
            $cuenta->nombre_cuenta = Str::upper($cuenta->nombre_cuenta);
            $cuenta->save();
  
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
            $cuenta = Cuenta::findOrFail($id);
            $cuenta->activo = false;
            $cuenta->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
