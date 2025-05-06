<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CityController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
    
        $cities = \App\Models\City::where('Nombre', 'like', '%' . $query . '%')
            ->orWhere('CP', 'like', '%' . $query . '%')
            ->orderBy('Nombre')
            ->paginate(10);
    
        return response()->json([
            'items' => $cities->map(function ($city) {
                return [
                    'id' => $city->id,
                    'text' => "{$city->CP} | {$city->Nombre}"
                ];
            }),
            'more' => $cities->hasMorePages()
        ]);
    }
    
}
