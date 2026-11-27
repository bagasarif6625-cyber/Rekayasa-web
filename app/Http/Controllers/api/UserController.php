<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data user berhasil diambil',
                'data' => $users,
            ]

        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:50'],
        ]);

        $validate['password'] = bcrypt($validate['password']);

        $user = User::create($validate);

        return response()->json(
            [
                'success' => true,
                'message' => 'User berhasil dibuat',
                'data' => $user,
            ], 201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        //
        try {
            $user = User::findOrFail($id);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data user berhasil diambil',
                    'data' => $user,
                ], 200
            );
        } catch (ModelNotFoundException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Data user tidak ditemukan',
                ], 404
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        //
        try {
            $user = User::findOrFail($id);

            $validate = $request->validate([
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
                'password' => ['sometimes', 'nullable', 'string', 'min:8'],
                'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
                'address' => ['sometimes', 'nullable', 'string', 'max:255'],
                'role' => ['sometimes', 'nullable', 'string', 'max:50'],
            ]);
            if (! empty($validate['password'])) {
                $validate['password'] = bcrypt($validate['password']);
            } else {
                unset($validate['password']);
            }

            $user->update($validate);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data user berhasil diupdate',
                    'data' => $user,
                ], 200
            );
        } catch (ModelNotFoundException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Data user tidak ditemukan',
                ], 404
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        //
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Data user berhasil dihapus',
                ], 200
            );
        } catch (ModelNotFoundException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Data user tidak ditemukan',
                ], 404
            );
        }
    }
}
