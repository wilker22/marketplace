<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductPhotoController extends Controller
{
    public function removePhoto(Request $request)
    {
        $photoName = $request->get('photoName');
        
        //remover arquivo do diretório
        if(Storage::disk('public')->exists($photoName)){
            Storage::disk('public')->exists($photoName);
        }

        //remover do banco de dados
        $removePhoto =  ProductPhoto::where('image', $photoName);
        $productId = $removePhoto->first()->product_id;
        $removePhoto->delete();

        flash('Imagem removida com sucesso')->success();
        return redirect()->route('admin.products.edit', ['product' => $productId]);

    }    
}
