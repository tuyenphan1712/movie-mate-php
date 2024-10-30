<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function store(Request $request)
    {
        // Xác thực các dữ liệu đầu vào
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            // Không yêu cầu đầu vào cho user_status, vì sẽ đặt mặc định
        ]);

        // Mã hóa mật khẩu người dùng
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Đặt giá trị mặc định cho user_status là "active"
        $validatedData['user_status'] = UserStatus::ACTIVE;

        // Tạo người dùng với các dữ liệu đã được xử lý
        return User::create($validatedData);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,'.$user->id,
            'password' => 'string|min:8',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return $user;
    }

    public function destroy($id)
    {
        // Tìm user theo ID, nếu không tìm thấy sẽ trả về lỗi 404
        $user = User::findOrFail($id);

        // Cập nhật userStatus thành 'deleted'
        $user->user_status = UserStatus::DELETED;

        // Lưu thay đổi vào database
        $user->save();

        // Trả về phản hồi JSON xác nhận thành công
        return response()->json(['message' => 'User status updated to deleted successfully']);
    }
}
