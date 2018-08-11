<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Exception;
use Validator;
use Carbon\Carbon;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users.create')->only(['create','store']);
        $this->middleware('permission:users.index')->only('index');
        $this->middleware('permission:users.edit')->only(['edit','update']);
        $this->middleware('permission:users.show')->only('show');
        $this->middleware('permission:users.destroy')->only('destroy');          
    }       
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->where('activo',true)->orderBy('id','ASC')->get();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            $rules = [  'name'      => 'required|unique:users',
                        'roles'     => 'required',
                        'password'  => 'required|min:6'];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            $user = new User($request->all());
            $user->password = bcrypt('secret');
            $user->save();            
            // creamos el usuario
            //$user = User::create($request->all());
            // actualiza los roles
            $user->roles()->sync($request->get('roles'));

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
            $rules = [  'name'      => 'required|unique:users',
                        'roles'     => 'required',
                        'password'  => 'required|min:6'];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $user = User::find($id);

            // actualiza el usuario
            $user->update($request->all());

            // actualiza los roles
            $user->roles()->sync($request->get('roles'));

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
        //
    }

    public function changePassword(Request $request)
    {
        try
        {
            $rules = ['antPass' => 'required',
                    'newPass' => 'required',
                    'repPass' => 'required'
                    ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }       
            if($request->newPass != $request->repPass){
                return response()->json(['errors'=>'La nueva clave y la repeticion de clave no son iguales']);                
            }    
            $input = $request->all();
            $user = User::find(auth()->user()->id);     
            
            if (Hash::check($input['antPass'], $user->password))
            {
                $newPw = $input['newPass'];
                $user->password = bcrypt($newPw);
                $user->save();

                DB::commit();           
                return;
            }else{
                return response()->json(['errors'=>'La clave actual no es correcta']);                                
            }
        } catch (Exception $e) {
            DB::rollback();          
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
        
    }    
}
