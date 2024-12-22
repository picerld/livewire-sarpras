<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class Spotlight
{
    public function search(Request $request): JsonResponse
    {
        try {
            // Check authentication
            if (!auth()->check()) {
                return response()->json([], 200);
            }

            $searchTerm = $request->input('search', '');

            // Get results
            $actions = $this->actions($searchTerm);
            Log::info('Actions retrieved:', ['actions' => $actions]);

            $users = $this->users($searchTerm);

            $results = collect()
                ->merge($actions)
                ->merge($users)
                ->values();

            return response()->json($results, 200);
        } catch (\Exception $e) {
            Log::error('Spotlight search error: ' . $e->getMessage(), [
                'search' => $request->input('search'),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Search failed'], 500);
        }
    }

    protected function users(string $search = ''): array
    {
        return User::query()
            ->where('username', 'like', "%{$search}%")
            ->orWhere('role', 'like', "%{$search}%")
            ->orWhereHas('employee', function (Builder $query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->take(5)
            ->get()
            ->map(function (User $user) {
                return [
                    'avatar' => $user->employee->avatar ?? null,
                    'name' => $user->employee->name,
                    'description' => $user->username,
                    'link' => route('users.show', ['user' => $user->id])
                ];
            })
            ->toArray();
    }

    protected function actions(): array
    {
        // string $search = '' , for param if needed
        
        return collect([
            [
                'name' => 'Create user',
                'description' => 'Create a new user',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="p-2 rounded-full w-11 h-11 bg-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>',
                'link' => route('users.index')
            ],
            [
                'name' => 'User list',
                'description' => 'View all users',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="p-2 rounded-full w-11 h-11 bg-blue-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
                'link' => route('users.index')
            ],
            // Add more actions as needed
        ])
            // ->filter(function ($item) use ($search) {
            //     return empty($search) ||
            //         str_contains(strtolower($item['name']), strtolower($search)) ||
            //         str_contains(strtolower($item['description']), strtolower($search));
            // })
            ->values()
            ->toArray();
    }
}
