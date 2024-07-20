<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

abstract class BaseController extends Controller
{
    protected function getUser(): User
    {
        $user = Auth::user();
        abort_if($user === null, 403, 'Unauthorized action.');

        /**
         * @var User $user
         */
        return $user;
    }
}
