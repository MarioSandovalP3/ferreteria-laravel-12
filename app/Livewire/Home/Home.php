<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;

class Home extends Component
{
    public function render()
    {
        $store = Store::first();
        $featuredCategories = Category::active()
            ->featured()
            ->parents()
            ->ordered()
            ->limit(4)
            ->get();

        $featuredProducts = Product::active()
            ->featured()
            ->inStock()
            ->with('category')
            ->limit(6)
            ->get();

        return view('livewire.home.component', [
            'featuredCategories' => $featuredCategories,
            'featuredProducts' => $featuredProducts,
            'store' => $store,
        ])->extends('components.layouts.home.app')
            ->section('content');
    }
}
