<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 * name="Authentication",
 * description="Endpoints para autenticación y obtención de tokens"
 * )
 */
class AuthController extends Controller
{
    use ApiResponder;

    /**
     * @OA\Post(
     * path="/auth/login",
     * summary="Iniciar sesión",
     * tags={"Authentication"},
     * description="Verifica las credenciales del usuario y retorna un Token Bearer para usar en endpoints protegidos.",
     * @OA\RequestBody(
     * required=true,
     * description="Credenciales de acceso",
     * @OA\JsonContent(
     * required={"email", "password"},
     * @OA\Property(property="email", type="string", format="email", example="jose.vivas.ar@gmail.com"),
     * @OA\Property(property="password", type="string", format="password", example="password123")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Login exitoso",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="Login successful"),
     * @OA\Property(
     * property="data",
     * type="object",
     * @OA\Property(property="access_token", type="string", example="1|KbG8..."),
     * @OA\Property(property="token_type", type="string", example="Bearer"),
     * @OA\Property(property="user_id", type="integer", example=1)
     * )
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Credenciales inválidas (Email o contraseña incorrectos)",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Credenciales incorrectas")
     * )
     * ),
     * @OA\Response(response=422, description="Error de validación de datos")
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('Credenciales incorrectas', null, 401);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return $this->success('Login successful', [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user_id' => $user->id
        ]);
    }

    /**
     * @OA\Post(
     * path="/auth/logout",
     * summary="Cerrar sesión",
     * tags={"Authentication"},
     * description="Revoca el token actual del usuario, invalidando la sesión.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Logout exitoso",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="message", type="string", example="Sesión cerrada correctamente")
     * )
     * ),
     * @OA\Response(response=401, description="No autenticado (Token inválido o faltante)")
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success('Sesión cerrada correctamente');
    }
}
