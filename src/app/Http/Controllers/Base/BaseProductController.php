<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class BaseProductController extends Controller
{
    public static function base_show(Request $request, $view, bool $sort_featured, bool $filter_on_sale)
    {
        $search_query = $request->get('search_query') ?? "";
        $subcats = explode(",", $request->get('subcats')) ?? [];
        $page = $request->get('page') ?? 1;


        $validated = $request->validate([
            'sortBy' => 'nullable|string|in:featured,price,name,rating',
            'sortOrder' => 'nullable|string|in:asc,desc',
        ]);

        $sortByMap = [
            'featured' => 'p.is_featured',
            'price' => 'p.price',
            'name' => 'p.product_name',
            'rating' => 'uc.rating'
        ];


        $categories = array_filter($subcats);
        $category_question_marks = implode(", ", array_fill(0, count($categories), "?"));
        $category_selector = count($categories) > 0 ? "and s.subcategory_id in ($category_question_marks)" : "";

        $bindings = $categories;
        array_unshift($bindings, "%" . $search_query . "%");


        $sort_by = $validated['sortBy'] ?? 'featured';
        $sort_order = $validated['sortOrder'] ?? 'desc';
        $sort_by_query = $sortByMap[$sort_by] ?? 'p.is_featured';
        $sort_order_query = $validated['sortOrder'] ?? 'desc';


        // $sort_featured_query = $sort_featured ? 'p.is_featured desc,' : '';
        $filter_on_sale_query = $filter_on_sale ? 'and p.is_on_sale = true' : '';

        $products = DB::select(
            "
            SELECT 
                p.product_id,
                p.product_name,
                s.subcategory_name,
                p.price,
                p.description,
                pi.image_directory,
                pi.image_id,
                COALESCE(SUM(uc.rating), 0) AS sum_rating,
                COALESCE(AVG(uc.rating), 0) AS avg_rating
            FROM products p
            JOIN subcategories s 
                ON s.subcategory_id = p.subcategory_id 
            LEFT JOIN user_comments uc 
                ON uc.product_id = p.product_id
            LEFT JOIN product_images pi 
                ON pi.product_id = p.product_id
                AND pi.image_id = (
                    SELECT MIN(image_id)
                    FROM product_images
                    WHERE product_id = p.product_id
                )
            WHERE p.product_name LIKE ?
            $category_selector
            $filter_on_sale_query
            GROUP BY 
                p.product_id,
                p.product_name,
                s.subcategory_name,
                p.price,
                p.description,
                pi.image_directory,
                pi.image_id
            ORDER BY 
                {$sort_by_query} {$sort_order_query},
                pi.image_id ASC;
            ",
            $bindings
        );

        $collection = collect($products);
        $paginator = new LengthAwarePaginator($collection->forPage($page, 12), count($collection), 12, $page);


        $categories = DB::select(
            "
            select c.category_id, s.subcategory_id, c.category_name, s.subcategory_name from categories c 
            left join subcategories s on c.category_id = s.category_id
            "
        );

        $categories_map = [];

        foreach ($categories as $c) {
            $key = ['key' => $c->category_id, 'value' => $c->category_name];

            if (array_key_exists(serialize($key), $categories_map) === false) {
                $categories_map[serialize($key)] = [['key' => $c->subcategory_id, 'value' => $c->subcategory_name]];
            } else {
                array_push($categories_map[serialize($key)], ['key' => $c->subcategory_id, 'value' => $c->subcategory_name]);
            }
        }

        return view(
            $view,
            [
                'search_query' => $search_query,
                'active_subcats' => $subcats,
                'sort_by' => $sort_by,
                'sort_order' => $sort_order,
                // 'products' => $products,
                'categories_map' => $categories_map,
                'paginator' => $paginator,
                'page' => min($page, $paginator->lastPage())
            ]
        );
    }
}
