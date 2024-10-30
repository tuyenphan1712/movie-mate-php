<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    // Inject UserService vào Controller
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return response()->json($this->userService->getAllUsers());
    }

    public function show($id)
    {
        return response()->json($this->userService->getUserById($id));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:15',
            'birthday' => 'required|date',
            'gender' => 'required|in:male,female',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        return response()->json($this->userService->createUser($validatedData));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,'.$id,
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:male,female',
            'birthday' => 'required|date',
            'password' => 'string|min:6',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        return response()->json($this->userService->updateUser($id, $validatedData));
    }

    public function destroy($id)
    {
        return response()->json(['message' => 'User status updated to deleted successfully', 'user' => $this->userService->deleteUser($id)]);
    }
}
