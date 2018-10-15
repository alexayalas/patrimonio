<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;        // facade para saber el usuario autentificado Auth::user() -- Auth::id() -- Auth::check()
use Exception;
use Validator;
use Image;
use DateTime;
use Carbon\Carbon;
use App\Movimiento;
use App\Bien;

class MovimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:traslados.create')->only(['create','store']);
        $this->middleware('permission:traslados.index')->only('index');
        $this->middleware('permission:traslados.edit')->only(['edit','update']);
        $this->middleware('permission:traslados.show')->only('show');
        $this->middleware('permission:traslados.destroy')->only('destroy');          
    }

    public function index()
    {
        $movimientos = Movimiento::with(['bien','ubicacion_actual.area.empresa','ubicacion_actual.area.sede','ubicacion_anterior.area.sede','autorizado','encargado_anterior'])->orderBy('id','ASC')->where('activo',1)->get();
        return $movimientos;
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
            if($request->get('tipomovimiento') == 'Traslado'){
                $rules = ['bien_id'                 => 'required',
                        'ubicacion_id_actual'       => 'required',
                        'autorizado_id'             => 'required',
                        'encargado_id_actual'       => 'required'
                        ];
            }elseif ($request->get('tipomovimiento') == 'Baja') {
                $rules = ['bien_id'                 => 'required',
                        'fecha_movimiento'          => 'required',
                        'numero_resolucion'         => 'required',
                        'motivo_baja'               => 'required',
                        'autorizado_id'             => 'required'
                        ];
            }      

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }       

            $movimiento = new Movimiento($request->all());
      
            //$fecm = explode("/", $movimiento->fecha_movimiento);          
            $movimiento->fecha_movimiento = FormatFecDMY($movimiento->fecha_movimiento);
            $movimiento->user_id = Auth::id();
            $movimiento->save();

            /***  actualizacion en la tabla biens ****/
            $bien = Bien::find($movimiento->bien_id);            
            if($request->get('tipomovimiento') == 'Traslado'){
                $bien->ubicacion_id = $movimiento->ubicacion_id_actual;
                $bien->conservacion = $movimiento->conservacion_actual;
                $bien->en_uso = $movimiento->en_uso_actual;
                $bien->encargado_id = $movimiento->encargado_id_actual;
                $bien->editable = false;
            }elseif ($request->get('tipomovimiento') == 'Baja') {
                $bien->baja = true;
            }
            $bien->save();
            /***  Fin de actualizacion ***/

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
        //
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
