<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Documento;

class DocumentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:documentos.create')->only(['create','store']);
        $this->middleware('permission:documentos.index')->only('index');
        $this->middleware('permission:documentos.edit')->only(['edit','update']);
        $this->middleware('permission:documentos.show')->only('show');
        $this->middleware('permission:documentos.destroy')->only('destroy');          
    }     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentos = Documento::where('activo',true)->orderBy('id','ASC')->get();
        return $documentos;
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
        $rules = ['nombre_documento'     => 'required'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        /*-- validacion del Nombre de documento--*/
        if($request->get('nombre_documento')){
            $nomdoc = Str::upper($request->get('nombre_documento'));
            $doc = Documento::where('nombre_documento',$nomdoc)->count();
            if($doc > 0){
                return response()->json(['errors'=>['Documento ' => 'Ya existe un documento con estos datos']]);
            }
        }

        $documento = new Documento($request->all());
        $documento->nombre_documento = Str::upper($documento->nombre_documento);
        $documento->save();

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
            $rules = ['nombre_documento'     => 'required'];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $documento = Documento::find($id);
            $documento->fill($request->all());
            $documento->nombre_documento = Str::upper($documento->nombre_documento);
            $documento->save();
  
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
            $documento = Documento::findOrFail($id);
            $documento->activo = false;
            $documento->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
