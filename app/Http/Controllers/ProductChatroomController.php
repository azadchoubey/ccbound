<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;
class ProductChatroomController extends Controller
{
    public function tempshow(Product $product){
        return Inertia::render('Product/ChatRoom/TempShow',compact('product'));
    }
}
