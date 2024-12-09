<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\InvoiceStoreRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
use App\Http\Resources\Invoice\InvoiceIndexResource;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request): View|Factory|Application
    {
        $invoices = Invoice::query()
            ->with('client')
            ->when(
                $request->get('status') !== null,
                fn ($query) => $query->where('status', $request->get('status'))
            )
            ->latest()
            ->paginate(10);

        return view('invoices/index', [
            'invoices' => InvoiceIndexResource::collection($invoices),
        ]);
    }

    public function create(): View|Factory|Application
    {
        $clients = Client::query()
            ->get();

        return view('invoices/create', compact('clients'));
    }

    public function store(InvoiceStoreRequest $request): RedirectResponse
    {
        Invoice::query()
            ->create($request->validated());

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    public function edit(Invoice $invoice): View|Factory|Application
    {
        $clients = Client::query()
            ->get();

        return view('invoices/edit', compact('invoice', 'clients'));
    }

    public function update(InvoiceUpdateRequest $request, Invoice $invoice): RedirectResponse
    {
        $invoice->update($request->validated());

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    public function show(Invoice $invoice): View|Factory|Application
    {
        return view('invoices.show', compact('invoice'));
    }
}
