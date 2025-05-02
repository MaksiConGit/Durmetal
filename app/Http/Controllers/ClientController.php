<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Models\City;
use App\Models\Client;
use App\Models\ClientQualification;
use App\Models\DocumentType;
use App\Models\IvaCondition;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $cities = City::all();
        $provinces = Province::all();
        $iva_conditions = IvaCondition::all();
        $document_types = DocumentType::all();
        $client_qualifications = ClientQualification::all();
        $next_id = Client::max('id') + 1;

        return view('clients.create', compact('cities', 'provinces', 'iva_conditions', 'document_types', 'client_qualifications', 'next_id'));
    }

    public function store(StoreClientRequest $request)
    {
        // dd($request->all());
        $user_id = Auth::id();

        $data = $request->except('emails');
        $data['created_by'] = $user_id;
        $data['updated_by'] = $user_id;
        
        $client = Client::create($data);
        
        foreach ($request->emails as $email) {
            if ($email) {
                $client->emails()->create(['text' => $email]);
            }
        }

        return redirect()->route('clients.index');
    }
    
    // public function show(string $tenant, Product $product)
    // {
    //     $product_tenant = $product->tenant;
    //     $product_categories = $product->productCategories;
    //     // dd($product_categories);

    //     $product_variants = $product->productVariants;

    //     return view('products.show', compact('tenant', 'product', 'product_tenant', 'product_categories', 'product_variants'));
    // }

    public function edit(Client $client)
    {
        $cities = City::all();
        $provinces = Province::all();
        $iva_conditions = IvaCondition::all();
        $document_types = DocumentType::all();
        $client_qualifications = ClientQualification::all();
        $client_emails = $client->emails;
        $oldEmails = old('emails', $client_emails->pluck('text')->toArray());

        return view('clients.edit', compact('client', 'cities', 'provinces', 'iva_conditions', 'document_types', 'client_qualifications', 'client_emails', 'oldEmails'));
    }

    public function update(StoreClientRequest $request, Client $client)
    {
        $user_id = Auth::id();
    
        $data = $request->except('emails');
        $data['updated_by'] = $user_id;
    
        $client->update($data);
    
        $client->emails()->delete();
    
        foreach ($request->emails as $email) {
            if ($email) {
                $client->emails()->create(['text' => $email]);
            }
        }
    
        return redirect()->route('clients.index');
    }
    

    public function destroy(Client $client)
    {
        $client->emails()->delete();

        $client->delete();
    
        return redirect()->route('clients.index');
    }
}    
