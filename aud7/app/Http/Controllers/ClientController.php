<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientStoreRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Models\Client;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request): View|Factory|Application
    {
        $clients = Client::query()
            ->when($request->has('search'),
                fn ($query) => $query->where('full_name', 'like', '%'.$request->get('search').'%'))
            ->latest()
            ->paginate(10);

        return view('clients/index', compact('clients'));
    }

    public function create(): View|Factory|Application
    {
        return view('clients/create');
    }

    public function store(ClientStoreRequest $request): RedirectResponse
    {
        Client::query()
            ->create($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    public function edit(Client $client): View|Factory|Application
    {
        return view('clients/edit', compact('client'));
    }

    public function update(ClientUpdateRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    public function show(Client $client): View|Factory|Application
    {
        $client->loadMissing('invoices');

        return view('clients/show', compact('client'));
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->invoices()->delete();
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
