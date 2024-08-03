<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   public function authToken(Request $request)
    {
        $token = $request->header('Authorization');
        $user = Auth::user();
        $tableName = $user->getTable();
        $rol = $user->role->role_number;
        $user->role = $rol;
        $user->token = $token;
        $user->table = $tableName;
        return $user;
    }

    public function login(Request $request)
    {        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        
        $credentials = $request->only('email', 'password');     
                
        if (Auth::attempt($credentials)) {
            $user = Auth::user();          
            $name = $user->name;
            $token = $user->createToken('api_token')->plainTextToken;
            return response()->json([
                'api_token' => $token,
                'name' => $name,
                'rol' => $user->role_id

            ], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,            
            'password' => Hash::make($request->password),
            'role_id' => 1,    
            'phone' => $request->phone,
            'status' => true
        ]);
        return response()->json([
            'message' => 'Administrador creado exitosamente.',
            'user' => $user,
        ], 201);
    }

    public function index()
    {
        $usuarios = User::all();
        if ($usuarios->isEmpty()) {
            return response()->json(['message' => 'No se encontraron medicos'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Asegura que el correo no se repita
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
        ]);
        
        $user = User::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role_id' => $request->role_id,
            'status' => true
        ]);
        
        return response()->json([
            'message' => 'Usuario creado exitosamente.',
            'user' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $datos = User::where('role_id', 2)->find($id);
        $datos = User::find($id);

        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($datos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json($user);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datos = User::find($id);
        if (!$datos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $datos->delete();
        return response()->json(['message' => 'Registro eliminado']);
    }
}