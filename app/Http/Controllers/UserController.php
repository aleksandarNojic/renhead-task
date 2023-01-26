<?php

namespace App\Http\Controllers;

use App\Actions\User\ReportAction;
use App\Actions\User\DeleteAction;
use App\Actions\User\SetTypeAction;
use App\Http\Requests\User\SetTypeRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Change users Type
     *
     * @param SetTypeRequest $request
     * @param User $user
     */
    public function setType(SetTypeRequest $request, User $user)
    {
        $action = new SetTypeAction($request, $user);
        $action->run();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @param  Request  $request
     */
    public function destroy(Request $request, User $user)
    {
        $action = new DeleteAction($request, $user);
        return $action->run();
    }

    /**
     * Get report
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function report(Request $request, User $user)
    {
        $action = new ReportAction($request, $user);
        $action->run();

        return $action->getReportQuery()->get();
    }
}
