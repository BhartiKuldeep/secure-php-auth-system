<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User;

final class AdminController
{
    public function users(): void
    {
        View::render('admin/users', [
            'title' => 'User Administration',
            'users' => User::all(),
        ]);
    }
}
