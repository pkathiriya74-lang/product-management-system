<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        $totalCategory = Category::count();
        $totalProduct = Product::count();
        $totalStock = Product::sum('stock');
        $lowStockProducts = Product::where('stock','<=',5)->count();
        $activeProducts = Product::where('status','active')->count();
        $outOffStockProduct = Product::where('stock','<=',0)->count();
        $totalInventory = Product::selectRaw('SUM(price * stock) as  total_inventory')->value('total_inventory');

        return view("dashboard",compact('lowStockProducts',
        'totalCategory',
        'totalProduct',
        'totalStock',
        'activeProducts',
        'outOffStockProduct',
        'totalInventory'));
    }
}
