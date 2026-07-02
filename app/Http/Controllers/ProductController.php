<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImages;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $products = Product::with('category', 'productImages')
                ->whereHas('category', function ($query) {
                    $query->where('status', 'active');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            $this->storeExportProducts($products->getCollection());
        } else {
            $products = Product::with('category')
                ->where('status', 'active')
                ->whereHas('category', function ($query) {
                    $query->where('status', 'active');
                })
                ->orderBy('id', 'asc')
                ->paginate(10);
            $this->storeExportProducts($products->getCollection());
        }

        $categories = Category::where('status', 'active')->get();

        $stock = 0;
        foreach ($products as $product) {
            $stock += $product->stock;
        }

        return view("products.index", compact('products', 'categories', 'stock'));
    }

    public function showCreateProduct()
    {
        $categories = Category::where('status', 'active')->get();
        return view('products.create', compact('categories'));
    }
    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,webp,png|max:2048',
            'status' => 'required'
        ]);
        try {
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'category_id' => $request->category_id,
                'status' => $request->status

            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('products', 'public');
                    ProductImages::create([
                        'image' => $imagePath,
                        'product_id' => $product->id
                    ]);
                }
            }
            $product->sku = 'PRO-' . str_pad($product->id, 4, '0', STR_PAD_LEFT);
            $product->save();

            return redirect('/product')->with('success', 'Product save successfully');
        } catch (\Exception $e) {
            return redirect('/product')->with('error', $e->getMessage());
        }
    }

    public function showEditProduct($id)
    {

        try {
            $product = Product::findOrFail($id);
            $categories = Category::where('status', 'active')->get();
            $remainingImages = 5 - ProductImages::where('product_id', $id)->count();
            return view('products.edit', compact('product', 'categories', 'remainingImages'));
        } catch (\Exception $e) {
            return redirect('/product')->with('error', 'Unable to edit product');
        }
    }
    public function updateProduct(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:200',
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'status' => 'required'
        ]);
        try {

            $product = Product::findOrFail($id);
            $remainingImages = 5 - ProductImages::where('product_id', $id)->count();

            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'category_id' => $request->category_id,
                'status' => $request->status
            ]);

            $newImages = count($request->file('images') ?? []);
            if ($newImages > $remainingImages) {
                return back()->with('error', "You can Upload Only {$remainingImages} images.");
            }
            if ($request->file('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('products', 'public');
                    ProductImages::create([
                        'image' => $imagePath,
                        'product_id' => $product->id
                    ]);
                }
            }
            return redirect('/product')->with('success', 'Product Updated successfully');
        } catch (\Exception $e) {
            return redirect('/product')->with('error', 'Unable to update product');
        }
    }

    public function destroy($id)
    {

        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect('/product')->with('success', 'Product deleted Successfully');
        } catch (\Exception $e) {
            return redirect('/product')->with('error', 'Unable to delete Product');
        }
    }

    public function searchByName(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);
        try {
            if (Auth::user()->isAdmin()) {
                if (Str::startsWith($request->search, 'PRO')) {
                    $products = Product::with('category', 'productImages')
                        ->where('sku', $request->search)
                        ->whereHas('category', function ($query) {
                            $query->where('status', 'active');
                        })
                        ->orderBy('id', 'asc')->paginate(10);
                    $this->storeExportProducts($products->getCollection());
                } else {
                    $products = Product::with('category', 'productImages')
                        ->where('name', 'like', '%' . $request->search . '%')
                        ->where('status', 'active')
                        ->whereHas('category', function ($query) {
                            $query->where('status', 'active');
                        })
                        ->orderBy('id', 'asc')->paginate(10);
                    $this->storeExportProducts($products->getCollection());
                }
            } else {
                if (Str::startsWith($request->search, 'PRO')) {
                    $products = Product::with('category', 'productImages')
                        ->where('sku', $request->search)
                        ->whereHas('category', function ($query) {
                            $query->where('status', 'active');
                        })
                        ->orderBy('id', 'asc')->paginate(10);
                    $this->storeExportProducts($products->getCollection());
                } else {
                    $products = Product::with('category', 'productImages')
                        ->where('name', 'like', '%' . $request->search . '%')
                        ->where('status', 'active')
                        ->whereHas('category', function ($query) {
                            $query->where('status', 'active');
                        })
                        ->orderBy('id', 'asc')->paginate(10);
                    $this->storeExportProducts($products->getCollection());
                }
            }
            $categories = Category::where('status', 'active')->get();

            if ($products->isEmpty()) {
                return redirect('/product')->with('error', 'No Product found');
            }

            $stock = 0;
            foreach ($products as $product) {
                $stock += $product->stock;
            }
            return view("products.index", compact('products', 'categories', 'stock'));
        } catch (\Exception $e) {
            return redirect('/product')->with('error', 'Unable to search product');
        }
    }

    public function fileterProductByCategory($id)
    {

        try {
            $category = Category::findOrFail($id);
            $categories = Category::where('status', 'active')->get();
            if (Auth::user()->isAdmin()) {
                $products = Product::with('category', 'productImages')
                    ->where('category_id', $id)
                    ->whereHas('category', function ($query) {
                        $query->where('status', 'active');
                    })
                    ->orderBy('id', 'asc')
                    ->paginate(10);
                $this->storeExportProducts($products->getCollection());
            } else {
                $products = Product::with('category', 'productImages')
                    ->where('category_id', $id)
                    ->where('status', 'active')
                    ->whereHas('category', function ($query) {
                        $query->where('status', 'active');
                    })
                    ->orderBy('id', 'asc')
                    ->paginate(10);
                $this->storeExportProducts($products->getCollection());
            }
            if ($products->isEmpty()) {
                return redirect('/product')->with('error', 'No Product found');
            }

            $stock = 0;
            foreach ($products as $product) {
                $stock += $product->stock;
            }
            return view("products.index", compact('products', 'categories', 'stock'));
        } catch (\Exception $e) {
            return redirect('/product')->with('error', 'Unable to filter product');
        }
    }

    public function ProductOrderByAsc()
    {
        try {
            if (Auth::user()->isAdmin()) {
                $products = Product::with('category', 'productImages')
                    ->orderBy('price', 'asc')
                    ->whereHas('category', function ($query) {
                        $query->where('status', 'active');
                    })
                    ->orderBy('id', 'asc')
                    ->paginate(10);
                $this->storeExportProducts($products->getCollection());
            } else {
                $products = Product::with('category', 'productImages')
                    ->where('status', 'active')
                    ->orderBy('price', 'asc')
                    ->whereHas('category', function ($query) {
                        $query->where('status', 'active');
                    })
                    ->orderBy('id', 'asc')
                    ->paginate(10);
                $this->storeExportProducts($products->getCollection());
            }

            $categories = Category::where('status', 'active')->get();
            $stock = 0;
            foreach ($products as $product) {
                $stock += $product->stock;
            }
            return view("products.index", compact('products', 'categories', 'stock'));
        } catch (\Exception $e) {
            return redirect('/product')->with('error', 'Unable to sort product');
        }
    }
    public function ProductOrderByDesc()
    {
        try {
            if (Auth::user()->isAdmin()) {
                $products = Product::with('category', 'productImages')
                    ->orderBy('price', 'desc')
                    ->whereHas('category', function ($query) {
                        $query->where('status', 'active');
                    })
                    ->orderBy('id', 'asc')
                    ->paginate(10);
                $this->storeExportProducts($products->getCollection());
            } else {
                $products = Product::with('category', 'productImages')
                    ->where('status', 'active')
                    ->orderBy('price', 'desc')
                    ->whereHas('category', function ($query) {
                        $query->where('status', 'active');
                    })
                    ->orderBy('id', 'asc')
                    ->paginate(10);
                $this->storeExportProducts($products->getCollection());
            }
            $categories = Category::where('status', 'active')->get();
            $stock = 0;
            foreach ($products as $product) {
                $stock += $product->stock;
            }
            return view("products.index", compact('products', 'categories', 'stock'));
        } catch (\Exception $e) {
            return redirect('/product')->with('error', 'Unable to sort product');
        }
    }

    public function ProductPriceRange(Request $request)
    {
        $request->validate([
            'first' => 'required|min:0',
            'second' => 'required|gte:first'
        ]);
        try {
            if (Auth::user()->isAdmin()) {
                $products = Product::with('category', 'productImages')
                    ->whereBetween('price', [$request->first, $request->second])
                    ->whereHas('category', function ($query) {
                        $query->where('status', 'active');
                    })
                    ->orderBy('id', 'asc')
                    ->paginate(10);
                $this->storeExportProducts($products->getCollection());
            } else {
                $products = Product::with('category', 'productImages')
                    ->where('status', 'active')
                    ->whereBetween('price', [$request->first, $request->second])
                    ->whereHas('category', function ($query) {
                        $query->where('status', 'active');
                    })
                    ->orderBy('id', 'asc')
                    ->paginate(10);
                $this->storeExportProducts($products->getCollection());
            }
            $categories = Category::where('status', 'active')->get();
            $stock = 0;
            foreach ($products as $product) {
                $stock += $product->stock;
            }
            return view("products.index", compact('products', 'categories', 'stock'));
        } catch (\Exception $e) {
            return redirect('/product')->with('error', 'Unable to fetch product');
        }
    }

    public function showProduct($id)
    {
        try {
            $product = Product::with('category', 'productImages')
                ->where('id', $id)
                ->whereHas('category', function ($query) {
                    $query->where('status', 'active');
                })
                ->firstOrFail();
            if (!Auth::user()->isAdmin() && $product->status != 'active') {
                return redirect('/product')->with('error', 'Authorized');
            }
            return view('products.product', compact('product'));
        } catch (\Exception $e) {
            return redirect('/product')->with('error', 'Product is not active');
        }
    }

    public function deleteImage($id)
    {
        try {
            $image = ProductImages::findOrFail($id);
            $image->delete();
            return back()->with('Success', 'Image Deleted Successfully.');
        } catch (\Exception $e) {
            return redirect('/product')->with('error', 'Product is not active');
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required',
            'products' => 'required|array'
        ]);

        switch ($request->action) {
            case 'active':
                Product::whereIn('id', $request->products)->update(['status' => 'active']);
                return back()->with('success', 'Selected products Activated successfully.');
            case 'inactive':
                Product::whereIn('id', $request->products)->update(['status' => 'inactive']);
                return back()->with('success', 'Selected products Inactivated successfully.');
            case 'draft':
                Product::whereIn('id', $request->products)->update(['status' => 'drfat']);
                return back()->with('success', 'Selected products drafted successfully.');
            default:
                return back()->with('error', 'invalid action.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'products' => 'required|array'
        ]);
        try {
            Product::whereIn('id', $request->products)->delete();
            return back()->with('success', 'Selected products deleted successfully.');
        }catch(\Exception $e){
            return back()->with('error', 'Unable to delete selected Product.');
        }

    }
     public function duplicateCreate($id)
    {
        try {
            $oldProduct = Product::findOrFail($id);
            $newProduct = Product::create([
                'name' => $oldProduct->name,
                'price' => $oldProduct->price,
                'stock' => $oldProduct->stock,
                'category_id' => $oldProduct->category_id,
                'status' => $oldProduct->status
            ]);

            $images = ProductImages::where('product_id', $id)->get();
            if (count($images) > 0) {
                foreach ($images as $image) {
                    ProductImages::create([
                        'image' => $image->image,
                        'product_id' => $newProduct->id
                    ]);
                }
            }
            $newProduct->sku = 'PRO-' . str_pad($newProduct->id, 4, 0, STR_PAD_RIGHT);
            $newProduct->save();
            return redirect('/product')->with('success', 'Product Created successfully.');
        } catch (\Exception $e) {
            return redirect('/product')->with('error', $e->getMessage());
        }

    }

    public function showTrash()
    {
        $products = Product::onlyTrashed()->get();
        return view('products.trash', compact('products'));

    }

    public function productRestore($id)
    {
        $product = Product::onlyTrashed()->find($id);
        try {
            $product->restore();
            return redirect('/product_trash')->with('sucess', 'Product Restored succssfully');
        } catch (\Exception $e) {
            return redirect('/product_trash')->with('error', 'Unable to restore Product');
        }
    }

    public function productForceDelete($id)
    {
        $product = Product::onlyTrashed()->find($id);
        try {
            $product->forceDelete();
            return redirect('/product_trash')->with('sucess', 'Product Permanently Deleted succssfully');
        } catch (\Exception $e) {
            return redirect('/product_trash')->with('error', 'Unable to Delete Product');
        }
    }

    public function storeExportProducts($products)
    {
        session([
            'export_ids' => $products->pluck('id')->toArray()
        ]);
    }

    public function export()
    {
        $ids = session('export_ids', []);
        $products = Product::with('category')
            ->whereIn('id', $ids)
            ->get();


        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attechment; filename=product.csv',
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'SKU',
                'Name',
                'Category',
                'Price',
                'Stock',
                'Status',
                'Created At'
            ]);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->sku,
                    $product->name,
                    $product->category,
                    $product->price,
                    $product->stock,
                    $product->status,
                    $product->craeted_at
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function orderByStatus($status)
    {

        try {
            $products = Product::with('category', 'productImages')
                ->where('status', $status)
                ->whereHas('category', function ($query) {
                    $query->where('status', 'active');
                })
                ->orderBy('id', 'asc')
                ->paginate(10);
            $this->storeExportProducts($products->getCollection());
            $categories = Category::where('status', 'active')->get();
            $stock = 0;
            foreach ($products as $product) {
                $stock += $product->stock;
            }
            return view("products.index", compact('products', 'categories', 'stock'));
        } catch (\Exception $e) {
            return redirect('/product')->with('error', 'Unable to fetch product');
        }
    }

}
