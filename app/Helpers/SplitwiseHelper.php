<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SplitwiseHelper {
    public function listMembers()
    {
        return [
            [
                'name' => 'Rubén'
            ],
            [
                'name' => 'Marta'
            ]
        ];
    }

    public function listCategories()
    {
        // $response = Http::withToken('IqkLiNcQYjRuopAQSp15QgTKorV696PSQ3uoU9OC')
        //                 ->get('https://secure.splitwise.com/api/v3.0/get_categories');
        
        // $body = $response->json();

        // $categories = collect($body['categories']);
        // $categories = $categories->sortBy('name')->values();
        // $categories->transform(function($item) {
        //     $subcategories = collect($item['subcategories']);
        //     $subcategories->transform(function($subcategory) {
        //         return [
        //             'id' => $subcategory['id'],
        //             'name' => $subcategory['name'],
        //             'icon' => $subcategory['icon_types']['square']['large'],
        //         ];
        //     });
        //     return [
        //         'id' => $item['id'],
        //         'name' => $item['name'],
        //         'subcategories' => $subcategories,
        //     ];
        // });
        
        $path = storage_path('/splitwise/categories.json'); // Adjust path accordingly

        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return json_decode(Storage::disk('local')->get('splitwise/categories.json'), true);
    }

    public function listGroups()
    {
        $groups = Cache::remember('_splitwise_groups', 1000, function() {
            $response = Http::withToken('IqkLiNcQYjRuopAQSp15QgTKorV696PSQ3uoU9OC')
                            ->get('https://secure.splitwise.com/api/v3.0/get_groups');
            
            $body = $response->json();
    
            $groups = collect($body['groups']);
            $groups->forget(0); // Delete first element as is a summary group
            $groups = $groups->sortByDesc('updated_at')->values();
            $groups->transform(function($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name'],
                ];
            });
    
            return $groups;
        });

        return $groups;

        // return [
        //     [
        //         'id' => 70010141,
        //         'name' => 'Nueva vida Almería',
        //     ],
        //     [
        //         'id' => 30183981,
        //         'name' => 'Pisukituki',
        //     ],
        // ];
    }
}