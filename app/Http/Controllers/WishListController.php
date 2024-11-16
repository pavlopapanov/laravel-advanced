<?php

namespace App\Http\Controllers;

use App\Enums\WishListEnum;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WishListController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $data = $request->validate([
            'type' => Rule::enum(WishListEnum::class),
        ]);

        auth()->user()->addToWishList($product, WishListEnum::from($data['type']));

        notify()->success('Product added to wish list');

        return redirect()->back();
    }

    public function remove(Request $request, Product $product)
    {
        $data = $request->validate([
            'type' => Rule::enum(WishListEnum::class),
        ]);

        auth()->user()->removeFromWishList($product, WishListEnum::from($data['type']));

        notify()->warning('Product removed from wish list');

        return redirect()->back();
    }
}

