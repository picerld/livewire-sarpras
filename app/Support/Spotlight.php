<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class Spotlight
{
    public function search(Request $request)
    {
        // Ensure only authenticated users can search
        if (!auth()->check()) {
            return [];
        }

        // Use a collection to merge user and action results
        return collect()
            ->merge($this->actions($request->input('search', '')))
            ->merge($this->users($request->input('search', '')));
    }

    // Database search for users
    public function users(string $search = '')
    {
        return User::query()
            ->where('username', 'like', "%$search%")
            ->take(5)
            ->get()
            ->map(function (User $user) {
                return [
                    'avatar' => $user->employee->avatar ?? null, // Use null coalescing to avoid errors
                    'name' => $user->username,
                    'description' => $user->username,
                    'link' => route('users.show', ['user' => $user->id]) // Use route helper for links
                ];
            });
    }

    // Static search for actions
    public function actions(string $search = '')
    {
        $icon = Blade::render("<x-icon name='o-bolt' class='p-2 rounded-full w-11 h-11 bg-yellow-50' />");

        return collect([
            [
                'name' => 'Create user',
                'description' => 'Create a new user',
                'icon' => $icon,
                'link' => route('users.create') // Use route helper for links
            ],
            // Add more actions as needed
        ])->filter(fn(array $item) => str($item['name'] . $item['description'])->contains($search, true));
    }
}
