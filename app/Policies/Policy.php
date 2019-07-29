<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function before($user, $ability)
	{
	    // 如果用户拥有内容管理权限的话，即授权通过
        if ($user->can('manage_contents')) {
            return true;
        }
	}
}
