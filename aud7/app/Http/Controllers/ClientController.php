<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientStoreRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Models\Client;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    public function index(): View|Factory|Application
    {
        $clients = Client::query()
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

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
