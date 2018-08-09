<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Empresa;

class EmpresaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:empresas.create')->only(['create','store']);
        $this->middleware('permission:empresas.index')->only('index');
        $this->middleware('permission:empresas.edit')->only(['edit','update']);
        $this->middleware('permission:empresas.show')->only('show');
        $this->middleware('permission:empresas.destroy')->only('destroy');          
    }      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::where('activo',true)->orderBy('id','ASC')->get();
        return $empresas;
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
        $rules = ['nombre_empresa'     => 'required',
                  'direccion' => 'required',
                  'ruc' => 'required'
                ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion del RUC --*/
        if($request->get('ruc')){
            $ruc = $request->get('ruc');
            $emp = Empresa::where('ruc',$ruc)->count();
            if($emp > 0){
                return response()->json(['errors'=>['Empresa ' => 'Ya existe una empresa con este numero de RUC : '.$request->get('ruc')]]);
            }
        }

        $empresa = new Empresa($request->all());
        $empresa->nombre_empresa = Str::upper($empresa->nombre_empresa);
        $empresa->direccion = Str::upper($empresa->direccion);
        $empresa->save();

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
            $rules = ['nombre_empresa'     => 'required',
                      'direccion' => 'required',
                      'ruc' => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $empresa = Empresa::find($id);
            $empresa->fill($request->all());
            $empresa->nombre_empresa = Str::upper($empresa->nombre_empresa);
            $empresa->direccion = Str::upper($empresa->direccion);  
            $empresa->save();
  
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
            $empresa = Empresa::findOrFail($id);
            $empresa->activo = false;
            $empresa->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
