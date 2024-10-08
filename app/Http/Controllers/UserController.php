<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $users = User::all();

    $usersWithTaskCounts = $users->map(function ($user) {
        $completedTasksCount = Task::where('user_id', $user->id)
                                   ->where('status', 'completed')
                                   ->count();
                                   
        $nonCompletedTasksCount = Task::where('user_id', $user->id)
                                      ->where('status', '!=', 'completed')
                                      ->count();

        return [
            'id' => $user->id,
            'name'=>$user->name,
            'username' => $user->username,
            'email'=>$user->email,
            'image_path'=>$user->image_path,
            'role'=>$user->role,
            'location'=>$user->location,
            'phone_number'=>$user->phone_number,
            'completed_tasks_count' => $completedTasksCount,
            'non_completed_tasks_count' => $nonCompletedTasksCount,
        ];
    });

    return response()->json([
        'users' => $usersWithTaskCounts
    ]);
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validation = $request->validated();
        $validation['password'] = Hash::make($validation['password']);
        $user = User::create($validation);
        return response()->json([
            'user' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json(["user"=>$user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
    
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
    
        try {
            $user->update($validated);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Update failed'], 500);
        }
    
        return response()->json(['user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null,204);
    }
    public function updateUserImage(Request $request, $userId)
    {
        // Validate the image file
        $validator=Validator::make($request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()){
            return response()->json([
                'error'=>$validator->errors()
            ]);
        };
        // Find the user by ID
        $user = User::findOrFail($userId);
    
        // Delete the old image if it exists
        if ($user->image_path) {
                Storage::disk('public')->delete($user->image_path);
        }
    
        // Handle the new image upload
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('user_image', $imageName, 'public');
    
        // Update the image path in the database
        $user->image_path = $imagePath;
        $user->save();
    
        return response()->json([
            'message' => 'Image updated successfully',
            'image_path' => $imagePath,
            'image_url' => Storage::url($imagePath),
        ], 200);
    }
    public function getUserImage($userId)
    {
        $user = User::findOrFail($userId);
        $imageUrl = $user->image_path;
        return response()->json(['image_url' => $imageUrl]);
    }
    public function deleteUserImage($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->image_path) {{
                Storage::disk('public')->delete($user->image_path);
            }
            $user->image_path = null;
            $user->save();
        }

        return response()->json(['message' => 'Image deleted successfully.']);
    }
    public function getAllUserNames()
    {
        $username = User::pluck("username");
        $formattedUsername = $username->map(function ($username) {
            return ['label' => $username];
        });
                return response()->json($formattedUsername);
    }
    
}
