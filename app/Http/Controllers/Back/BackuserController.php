<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;

class BackuserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('admin.users.index', compact('users'));
    }
}
