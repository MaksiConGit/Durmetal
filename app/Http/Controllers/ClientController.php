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
        $localidades = City::all();
        $provincias = Province::all();
        $condiciones_IVA = IvaCondition::all();
        $calificaciones_cliente = ClientQualification::all();
        $next_id = Client::max('id') + 1;

        return view('clients.create', compact('localidades', 'provincias', 'condiciones_IVA', 'calificaciones_cliente', 'next_id'));
    }

    public function store(StoreClientRequest $request)
    {
        $user_id = Auth::id();
    
        $data = $request->except('emails');
        $data['CreadoPor'] = $user_id;
        $data['ActualizadoPor'] = $user_id;
        
        $client = Client::create($data);
        
        foreach ($request->emails as $email) {
            if ($email) {
                $client->emails()->create([
                    'Email' => $email,
                    'IdCliente' => $client->id,
                    'CreadoPor' => $user_id,
                    'FechaCreacion' => now(),
                    'ActualizadoPor' => $user_id,
                    'FechaActualizacion' => now(),
                    'Activo' => 1,
                    'IdClienteEmail' => $client->id . ',' . $email,
                ]);
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
        $client_qualifications = ClientQualification::all();
        $client_emails = $client->emails;
        $oldEmails = old('emails', $client_emails->pluck('Email')->toArray());

        return view('clients.edit', compact('client', 'cities', 'provinces', 'iva_conditions', 'client_qualifications', 'client_emails', 'oldEmails'));
    }

    public function update(StoreClientRequest $request, Client $client)
    {
        $user_id = Auth::id();
    
        $data = $request->except('emails');
        $data['ActualizadoPor'] = $user_id;
    
        $client->update($data);
    
        $client->emails()->delete();
    
        foreach ($request->emails as $email) {
            if ($email) {
                $client->emails()->create([
                    'Email' => $email,
                    'IdCliente' => $client->id,
                    'CreadoPor' => $user_id,
                    'FechaCreacion' => now(),
                    'ActualizadoPor' => $user_id,
                    'FechaActualizacion' => now(),
                    'Activo' => 1,
                    'IdClienteEmail' => $client->id . ',' . $email,
                ]);
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
