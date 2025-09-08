<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BillingController extends Controller
{
    public function invoices()
    {
        $invoices = Invoice::with(['user','lease'])->latest()->paginate(15);
        return view('admin.billing.invoices.index', compact('invoices'));
    }

    public function createInvoice()
    {
        $tenants = User::where('role', User::ROLE_TENANT)->orderBy('name')->get();
        $leases = Lease::with(['user','room'])->get();
        return view('admin.billing.invoices.create', compact('tenants','leases'));
    }

    public function storeInvoice(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'lease_id' => 'nullable|exists:leases,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,paid,overdue,void',
            'notes' => 'nullable|string',
        ]);
        $data['number'] = 'INV-'.Str::upper(Str::random(8));
        Invoice::create($data);
        return redirect()->route('admin.billing.invoices.index')->with('status', 'Invoice created');
    }

    public function editInvoice(Invoice $invoice)
    {
        $tenants = User::where('role', User::ROLE_TENANT)->orderBy('name')->get();
        $leases = Lease::with(['user','room'])->get();
        return view('admin.billing.invoices.edit', compact('invoice','tenants','leases'));
    }

    public function updateInvoice(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'lease_id' => 'nullable|exists:leases,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,paid,overdue,void',
            'notes' => 'nullable|string',
        ]);
        $invoice->update($data);
        return redirect()->route('admin.billing.invoices.index')->with('status', 'Invoice updated');
    }

    public function destroyInvoice(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.billing.invoices.index')->with('status', 'Invoice deleted');
    }

    public function payments(Invoice $invoice)
    {
        $payments = $invoice->payments()->latest()->paginate(15);
        return view('admin.billing.payments.index', compact('invoice','payments'));
    }

    public function storePayment(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'paid_at' => 'nullable|date',
            'method' => 'required|string|max:50',
            'reference' => 'nullable|string|max:100',
        ]);
        $data['received_by'] = auth()->id();
        $payment = $invoice->payments()->create($data);

        $paidTotal = $invoice->payments()->sum('amount');
        if ($paidTotal >= $invoice->amount) {
            $invoice->status = 'paid';
            $invoice->save();
        }

        return redirect()->route('admin.billing.payments.index', $invoice)->with('status', 'Payment recorded');
    }
}
