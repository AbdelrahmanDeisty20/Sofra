<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('region.city');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        } else {
            $query->whereIn('type', [UserType::CLIENT, UserType::RESTAURANT]);
        }

        $users = $query->paginate(15);
        return UserResource::collection($users);
    }

    public function show($id)
    {
        $user = User::with('region.city')->findOrFail($id);
        return new UserResource($user);
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();

        return response()->json([
            'message' => 'User status updated successfully',
            'status' => (bool) $user->status
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
