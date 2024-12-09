<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('admin.users.index', compact('users'));
    }

    public function show(int $id)
    {
        $user = $this->userService->getUser($id);
        $orders = $this->userService->getUserOrders($user);
        return view('admin.users.show', compact('user', 'orders'));
    }

    public function toggleAdmin(int $id)
    {
        $user = $this->userService->getUser($id);
        $this->userService->toggleAdminStatus($user);
        return redirect()->back()->with('success', 'User status updated');
    }
}
