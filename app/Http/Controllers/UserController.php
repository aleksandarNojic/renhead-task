<?php

namespace App\Http\Controllers;

use App\Actions\User\SetTypeAction;
use App\Http\Requests\User\SetTypeRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Change users Type
     *
     * @param SetTypeRequest $request
     * @return JsonResponse
     */
    public function setType(SetTypeRequest $request, User $user): JsonResponse
    {
        $action = new SetTypeAction($request, $user);
        $action->run();

        return response()->json([
            'message' => 'Type changed',
        ]);
    }
}
