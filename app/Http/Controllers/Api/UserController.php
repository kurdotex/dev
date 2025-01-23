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

    /**
     * List all users
     *
     * Get a list of all users in the system.
     *
     * @response 200 {
     *  "status": true,
     *  "message": "List All Users",
     *  "data": [
     *      {
     *          "id": 1,
     *          "name": "John Doe",
     *          "email": "johndoe@example.com",
     *          "phone_number": "123456789"
     *      }
     *  ]
     * }
     */
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

    /**
     * Update a user
     *
     * Update the details of a user.
     *
     * @urlParam id integer required The ID of the user. Example: 1
     * @bodyParam name string required The new name of the user. Example: Jane Doe
     * @bodyParam email string required The new email of the user. Example: janedoe@example.com
     * @bodyParam phone_number string required The new phone number of the user. Example: 987654321
     * @bodyParam password string The new password of the user (optional). Example: new_password123
     *
     * @response 200 {
     *  "status": true,
     *  "message": "User updated successfully!",
     *  "data": {
     *      "id": 1,
     *      "name": "Jane Doe",
     *      "email": "janedoe@example.com"
     *  }
     * }
     */
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

    /**
     * Create a new user
     *
     * Create a new user in the system.
     *
     * @bodyParam name string required The name of the user. Example: John Smith
     * @bodyParam email string required The email of the user. Example: johnsmith@example.com
     * @bodyParam password string required The password of the user. Example: password123
     * @bodyParam phone_number string required The phone number of the user. Example: 123456789
     *
     * @response 201 {
     *  "status": true,
     *  "message": "User created successfully!",
     *  "data": {
     *      "id": 1,
     *      "name": "John Smith",
     *      "email": "johnsmith@example.com",
     *      "phone_number": "123456789"
     *  }
     * }
     */
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

    /**
     * Log exceptions in the log file.
     *
     * @param string $message The exception message.
     * @param array $data Additional data related to the error.
     * @param \Exception $e The caught exception instance.
     * @return void
     */
    private function logException(string $message, array $data, \Exception $e): void
    {
        Log::warning($message, array_merge($data, ['exception' => $e->getMessage()]));
    }

}
