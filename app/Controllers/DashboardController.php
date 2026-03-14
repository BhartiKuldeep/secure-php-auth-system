<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;

final class DashboardController
{
    public function index(): void
    {
        View::render('dashboard/index', [
            'title' => 'Dashboard',
            'user' => Auth::user(),
        ]);
    }
}
