<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Notifications\WelcomeMessage;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    public function __construct(
      protected readonly UserService $userService
    ){}

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
}
