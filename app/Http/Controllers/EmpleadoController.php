<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Empleado;

class EmpleadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:empleados.create')->only(['create','store']);
        $this->middleware('permission:empleados.index')->only('index');
        $this->middleware('permission:empleados.edit')->only(['edit','update']);
        $this->middleware('permission:empleados.show')->only('show');
        $this->middleware('permission:empleados.destroy')->only('destroy');          
    }       
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::where('activo',true)->orderBy('id','ASC')->get();
        return $empleados;
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
        $rules =    ['dni'     => 'required',
                      'nombres' => 'required',
                      'apellidos' => 'required'
                    ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion del DNI--*/
        if($request->get('dni')){
            $dnie = $request->get('dni');
            $emp = Empleado::where('dni',$dnie)->count();
            if($emp > 0){
                return response()->json(['errors'=>['DNI ' => 'Ya existe un empleado con estos datos']]);
            }
        }
        /*-- validacion del Nombre de empleado--*/
        if($request->get('nombres')){
            $nom = Str::upper($request->get('nombres'));
            $ape = Str::upper($request->get('apellidos'));            
            $nomcom = Empleado::where('nombre_completo',$nom.' '.$ape)->count();
            if($nomcom > 0){
                return response()->json(['errors'=>['Nombre Completo ' => 'Ya existe un empleado con estos datos']]);
            }
        }        

        $empleado = new Empleado($request->all());
        $empleado->nombres = Str::upper($empleado->nombres);
        $empleado->apellidos = Str::upper($empleado->apellidos);
        $empleado->nombre_completo = Str::upper($empleado->nombres).' '.Str::upper($empleado->apellidos);                
        $empleado->save();

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
            $rules =    ['dni'     => 'required',
                        'nombres' => 'required',
                        'apellidos' => 'required'
                        ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $empleado = Empleado::find($id);
            $empleado->fill($request->all());
            $empleado->nombres = Str::upper($empleado->nombres);
            $empleado->apellidos = Str::upper($empleado->apellidos);
            $empleado->nombre_completo = Str::upper($empleado->nombres).' '.Str::upper($empleado->apellidos); 
            $empleado->save();
  
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
            $empleado = Empleado::findOrFail($id);
            $empleado->activo = false;
            $empleado->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
