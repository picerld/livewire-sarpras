<?php

namespace App\Support;

use App\Models\Item;
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
            $items = $this->items($searchTerm);

            $results = collect()
                ->merge($actions)
                ->merge($users)
                ->merge($items)
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

    protected function items(string $search = ''): array
    {
        return Item::query()
            ->where('name', 'like', "%{$search}%")
            ->orWhere('merk', 'like', "%{$search}%")
            ->orWhere('price', 'like', "%{$search}%")
            ->take(5)
            ->get()
            ->map(function (Item $item) {
                return [
                    'avatar' => asset('storage/' . $item->images) ?? null,
                    'name' => $item->name,
                    'description' => $item->merk,
                    'link' => route('items.show', ['item' => $item->id])
                ];
            })
            ->toArray();
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
                'name' => 'User list',
                'description' => 'View all users',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="p-2 rounded-full w-11 h-11 bg-blue-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
                'link' => route('users.index')
            ],
            [
                'name' => 'Item list',
                'description' => 'View all items',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="p-2 rounded-full w-11 h-11 bg-blue-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
                        </svg>
                        ',
                'link' => route('items.index')
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
