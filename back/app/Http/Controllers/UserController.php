<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function login(Request $request)
     {
         $validated = $request->validate([
             'cuenta' => 'required',
             'password' => 'required',
         ]);
         $user = User::with('permisos')->with('units')->where('cuenta', $request->cuenta)->first();
         if ($user) {
             if (Hash::check($request->password, $user->password)) {
                 $user = User::with('permisos')->with('units')->where('cuenta', $request->cuenta)->first();
                 $token = $user->createToken('authToken')->plainTextToken;
                 return response(['user' => $user, 'token' => $token]);
             } else {
                 return response(['message' => 'Contraseña incorrecta'],500);
             }
         } else {
             return response(['message' => 'Usuario no encontrado'],500);
         }
     }
     public function me(Request $request)
     {
         $user=User::with('permisos')
                    ->with('units')
                     ->where('id',$request->user()->id)
                     ->firstOrFail();
                 return $user;
         //return  $request->user();
     }
     public function logout(Request $request)
     {
         $request->user()->tokens()->delete();
         return response(['message' => 'Sesión cerrada']);
     }
     
     public function index(){
        return User::with('units')->with('permisos')->where('id','<>',1)->get();
     }
     
     public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6',
        ]);
        $request['password']=Hash::make($request['password']);
        $user->update($request->all());
    }

    public function updatepermisos(Request $request,User $user){
        $permisos= array();
        foreach ($request->permisos as $permiso){
            if ($permiso['estado']==true)
                $permisos[]=$permiso['id'];
        }
        $permiso = Permiso::find($permisos);
        $user->permisos()->detach();
        $user->permisos()->attach($permiso);
    }

    public function updatecajero(Request $request,User $user){
        $unit= array();
        foreach ($request->units as $unit){
            if ($unit['estado']==true)
                $units[]=$unit['id'];
        }
        $unit = Unit::find($units);
        $user->units()->detach();
        $user->units()->attach($unit);
    }
     public function show(User $user){return $user;}
 
     public function store(Request $request)
     {
        $validated = $request->validate([
            'cuenta' => 'required|unique:users',
            'name' => 'required',
            'caja' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'state' => 'required'
        ]);
        $validated['password']=Hash::make($validated['password']);
        $user = User::create($validated);
        $permisos= array();
        foreach ($request->permisos as $permiso){
            if ($permiso['estado']==true)
                $permisos[]=$permiso['id'];
        }
        $permiso = Permiso::find($permisos);
        $user->permisos()->attach($permiso);
        
        $unidades= array();
        foreach ($request->units as $unit){
            if ($unit['estado']==true)
                $unidades[]=$unit['id'];
        }
        $unit = Permiso::find($unidades);
        $user->units()->attach($unit);
        return($user);
     }

    public function cambioEstado($id){
        $user=User::find($id);
        if($user->state=='ACTIVO')
            $user->state='INACTIVO';
        else
            $user->state='ACTIVO';
        $user->save();
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required',
            'cuenta' => 'required',
            'caja' => 'required',
        ]);
        $user->update($validated);
        return response(['user' => $user]);
    }


     public function destroy(User $user)
     {
        $user->delete();
        return response(['message' => 'Usuario eliminado']);
     }

     public function atender(Request $request){
        $ticket=Ticket::where('unit_id','=',$request->unit_id)
            ->where('estado','=','CREADO')
            ->orderBy('id','asc')
            ->first();
//        return $ticket->numero;
        $ticket=Ticket::find($ticket->id);
        $ticket->estado='ATENDIDO';
        $ticket->empleado=$request->nombrecaja;
        $ticket->save();

        return $ticket;

//        return "a";
    }

    public function ultificha(Request $request){
        $ticket=Ticket::where('unit_id','=',$request->unit_id)
            ->where('estado','=','ATENDIDO')
            ->whereDate('updated_at',date('Y-m-d'))
            ->orderByDesc('id')
            ->first();
        return Ticket::find($ticket->id);
    }

    public function datosatender(Request $request){
        return Ticket::where('empleado','=',$request->nombrecaja)
            ->whereDate('updated_at','=',date('Y-m-d'))
            ->orderBy('id','desc')
            ->get();
    }
 }
 
