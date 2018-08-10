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
use App\Bien;
use App\Empleado;
use App\Clase;
use App\Area;
use App\Ubicacion;
use App\Tipoingreso;
use App\Proveedor;
use App\Cuenta;
use App\Documento;
use App\Garantia;

class BienController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:biens.create')->only(['create','store']);
        $this->middleware('permission:biens.index')->only('index');
        $this->middleware('permission:biens.edit')->only(['edit','update']);
        $this->middleware('permission:biens.show')->only('show');
        $this->middleware('permission:biens.destroy')->only('destroy');          
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bienes = Bien::with(['ubicacion.area.empresa','ubicacion.area.sede','ubicacion'])->orderBy('id','ASC')->where('activo',1)->get();
        return $bienes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $combo_responsables = Empleado::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_completo as text']);
        $combo_clases = Clase::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_clase as text','grupo_id']);
        $combo_areas = Area::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_area as text','empresa_id','sede_id']);
        $combo_ubicaciones = Ubicacion::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_ubicacion as text','area_id']);
        $combo_tipoingresos = Tipoingreso::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_tipoingreso as text']);
        $combo_proveedores = Proveedor::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_proveedor as text']);
        $combo_cuentas = Cuenta::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_cuenta as text']);
        $combo_documentos = Documento::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_documento as text']);
        $combo_garantias = Garantia::orderBy('id','ASC')->where('activo',true)->get(['id as value','nombre_garantia as text']);

        return [
              'combo_responsables'        => $combo_responsables,
              'combo_clases'              => $combo_clases, 
              'combo_areas'               => $combo_areas,                           
              'combo_ubicaciones'         => $combo_ubicaciones,
              'combo_tipoingresos'        => $combo_tipoingresos,
              'combo_proveedores'         => $combo_proveedores,
              'combo_cuentas'             => $combo_cuentas,
              'combo_documentos'          => $combo_documentos,
              'combo_garantias'           => $combo_garantias                             
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
            $rules = ['clase_id'            => 'required',
                    'descripcion'           => 'required',
                    'ubicacion_id'          => 'required',
                    'empleado_id'           => 'required',
                    'encargado_id'          => 'required',
                    'modelo'                => 'required',
                    'marca'                 => 'required',
                    'numero_serie'          => 'required',
                    'conservacion'          => 'required',
                    'tipoingreso_id'        => 'required',
                    'cuenta_id'             => 'required',
                    'dias_mantenimiento'    => 'required'
                    ];

            if($request->has('fecha_registro')){
                $rules = array_add($rules, 'fecha_registro', 'date_format:d/m/Y');
            }       

            if($request->has('fecha_compra')){
                $rules = array_add($rules, 'fecha_compra', 'date_format:d/m/Y');
            } 

/*             if($request->get('image')){
                $rules = array_add($rules, 'image', 'mimes:jpeg,jpg,png');
            }   */

            $messages = ['fecha_registro.date_format' => 'Formato de fecha invalido',
                        'fecha_compra.date_format' => 'Formato de fecha invalido'
                        ];            

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            /*-- validacion del Registro --*/

            $claid = $request->get('clase_id');
            $desc = $request->get('descripcion');
            $ubiid = $request->get('ubicacion_id');
            $mode = $request->get('modelo');
            $marc = $request->get('marca');
            $nums = $request->get('numero_serie');

            $bie = Bien::where(['clase_id' => $claid,'descripcion' => $desc, 'ubicacion_id' => $ubiid,'modelo' => $mode, 'marca' => $marc, 'numero_serie' => $nums])->count();
            if($bie > 0){
                return response()->json(['errors'=>['Bien ' => 'Ya existe un registro con estos datos' ]]);
            }

            /*-- Validacion de la imagen --*/
            if($request->get('image')){
                $imageData = $request->get('image');
                $fileName = str_replace("+","-",str_replace(":", "-", Carbon::now()->format(DateTime::ISO8601))) . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/').$fileName);
            }        

            $bien = new Bien($request->all());
            if(isset($fileName)){
                $bien->foto = $fileName;
            }          
            $fecr = explode("/", $bien->fecha_registro);          
            $bien->fecha_registro = empty($bien->fecha_registro) ? null : Carbon::create($fecr[2],$fecr[1],$fecr[0]);

            $fecc = explode("/", $bien->fecha_compra);          
            $bien->fecha_compra = empty($bien->fecha_compra) ? null : Carbon::create($fecc[2],$fecc[1],$fecc[0]);

            $bien->descripcion = Str::upper($bien->descripcion);
            $bien->marca = Str::upper($bien->marca);
            $bien->modelo = Str::upper($bien->modelo);
            $bien->numero_serie = Str::upper($bien->numero_serie);  
            $bien->caracteristicas = Str::upper($bien->caracteristicas);                       
            $bien->save();

            $codbar = Str::substr('0000000000'.$bien->id,-10);
            $codbar39 = '*'.$codbar.'*';

            $bienid = Bien::find($bien->id);
            $bienid->codigo_barra = $codbar;
            $bienid->codBar39 = $codbar39;
            $bienid->save();

            $bienCompleto = Bien::where('id',$bien->id)->with(['ubicacion.area.empresa','ubicacion.area.sede','ubicacion'])->get();

            DB::commit();        
            return $bienCompleto;
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
            $rules = ['clase_id'            => 'required',
                    'descripcion'           => 'required',
                    'ubicacion_id'          => 'required',
                    'empleado_id'           => 'required',
                    'encargado_id'          => 'required',
                    'modelo'                => 'required',
                    'marca'                 => 'required',
                    'numero_serie'          => 'required',
                    'conservacion'          => 'required',
                    'tipoingreso_id'        => 'required',
                    'cuenta_id'             => 'required',
                    'dias_mantenimiento'    => 'required'
                    ];

            if($request->has('fecha_registro')){
                $rules = array_add($rules, 'fecha_registro', 'date_format:d/m/Y');
            }       

            if($request->has('fecha_compra')){
                $rules = array_add($rules, 'fecha_compra', 'date_format:d/m/Y');
            } 

/*             if($request->get('image')){
                $rules = array_add($rules, 'image', 'mimes:jpeg,jpg,png');
            }   */

            $messages = ['fecha_registro.date_format' => 'Formato de fecha invalido',
                        'fecha_compra.date_format' => 'Formato de fecha invalido'
                        ];            

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            /*-- Validacion de la imagen --*/
            if($request->get('image')){
                $imageData = $request->get('image');
                $fileName = str_replace("+","-",str_replace(":", "-", Carbon::now()->format(DateTime::ISO8601))) . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/').$fileName);
            }        

            $bien = Bien::find($id);
            $bien->fill($request->all());  

            if(isset($fileName)){
                $bien->foto = $fileName;
            }          
            $fecr = explode("/", $bien->fecha_registro);          
            $bien->fecha_registro = empty($bien->fecha_registro) ? null : Carbon::create($fecr[2],$fecr[1],$fecr[0]);

            $fecc = explode("/", $bien->fecha_compra);          
            $bien->fecha_compra = empty($bien->fecha_compra) ? null : Carbon::create($fecc[2],$fecc[1],$fecc[0]);

            $bien->descripcion = Str::upper($bien->descripcion);
            $bien->marca = Str::upper($bien->marca);
            $bien->modelo = Str::upper($bien->modelo);
            $bien->numero_serie = Str::upper($bien->numero_serie);  
            $bien->caracteristicas = Str::upper($bien->caracteristicas);                       
            $bien->save();

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $bien = Bien::findOrFail($id);
            $bien->activo = false;
            $bien->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
