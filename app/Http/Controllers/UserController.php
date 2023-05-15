<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Notifications\WelcomeMessage;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    public function __construct(
        protected readonly UserService $userService
    )
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->userService->getAllUserData()
        );
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $user = $this->userService->storeUserData($request->userData());

        Notification::send($user, new WelcomeMessage($user->name));

        return response()->json([
            'message' => 'success',
            'status_code' => '201',
            'data' => $user
        ], 201);
    }

    public function show(User $user): JsonResponse
    {
        $user = $this->userService->getUserData($user->id);

        return response()->json([
            'message' => 'success',
            'status_code' => '200',
            'data' => $user
        ], 200);
    }

    public function update(User $user, UserUpdateRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->userService->updateUserData($user->id, $data);

        return response()->json([
            'message' => 'success',
            'status_code' => '200',
            'data' => $user
        ], 200);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->userService->deleteUserData($user->id);

        return response()->json([
            'message' => 'success',
            'status_code' => '200'
        ], 200);
    }
}
