<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Exceptions\UserNotFoundException;

/**
 * @group User Management
 *
 * APIs for managing users.
 */
class UserController extends Controller
{
    use ApiResponder;

    public function listAllUsers(): JsonResponse
    {
        try {
            return $this->success(
                __('List All Users'),
                User::all()
            );
        } catch (\Exception $e) {
            $this->logException('Exception: listAllUsers - UserController ' . $e->getMessage(), [], $e);
            return $this->error('error.' . strtolower($e->getMessage()), null, $e->getCode());
        }
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        try {
            $user = User::find($request->route('id'));
            if (!$user) throw new UserNotFoundException("USER_NOT_FOUND");

            $validatedData = $request->validated();

            if ($user->email !== $validatedData['email']) $user->email = $validatedData['email'];
            if ($user->phone_number !== $validatedData['phone_number']) $user->phone_number = $validatedData['phone_number'];

            $user->update([
                'name' => $validatedData['name'],
                'password' => isset($validatedData['password']) ? bcrypt($validatedData['password']) : $user->password,
            ]);

            return $this->success(
                __('User updated successfully!'),
                [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email
                ]
            );
        } catch (\Exception $e) {
            $this->logException('Exception: update - UserController ' . $e->getMessage(), $validatedData ?? [], $e);
            return $this->error('error.' . strtolower($e->getMessage()), $validatedData ?? [], $e->getCode());
        }
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            return $this->success(
                __('User created successfully!'),
                User::create([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => bcrypt($validatedData['password']),
                    'phone_number' => $validatedData['phone_number'],
                ])
            );
        } catch (\Exception $e) {
            $this->logException('Exception: store - UserController ' . $e->getMessage(), $validatedData ?? [], $e);
            return $this->error('error.' . strtolower($e->getMessage()), $validatedData ?? [], $e->getCode());
        }
    }

    private function logException(string $message, array $data, \Exception $e): void
    {
        Log::warning($message, array_merge($data, ['exception' => $e->getMessage()]));
    }

}
