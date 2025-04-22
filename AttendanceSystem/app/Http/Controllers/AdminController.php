<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            return $query->where('firstName', 'like', "%{$search}%")
                ->orWhere('lastName', 'like', "%{$search}%");
        })->paginate(10);

        return view('admin-dashboard', compact('users'));
    }

    public function enroll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'face_descriptor' => 'required|array',

        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'data' => []], 400);
        }

        User::where('id', $request->user_id)->update([
            'faces' => $request->face_descriptor,
        ]);

        return response()->json(['message' => 'Enrollment Complete.'], 200);

    }

    public function clockIn() {}
}
