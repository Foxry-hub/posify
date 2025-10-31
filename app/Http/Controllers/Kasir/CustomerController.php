<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers
     */
    public function index()
    {
        $customers = User::where('role', 'pelanggan')
            ->latest()
            ->paginate(20);

        return view('kasir.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer
     */
    public function create()
    {
        return view('kasir.customers.create');
    }

    /**
     * Store a newly created customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'pelanggan',
            'is_active' => true,
        ]);

        return redirect()->route('kasir.customers.index')
            ->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    /**
     * Display the specified customer
     */
    public function show(User $customer)
    {
        // Ensure it's a customer
        if ($customer->role !== 'pelanggan') {
            abort(404);
        }

        $transactions = Transaction::where('customer_id', $customer->id)
            ->with(['user', 'items.product'])
            ->latest()
            ->paginate(10);

        return view('kasir.customers.show', compact('customer', 'transactions'));
    }

    /**
     * Show the form for editing the customer
     */
    public function edit(User $customer)
    {
        if ($customer->role !== 'pelanggan') {
            abort(404);
        }

        return view('kasir.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer
     */
    public function update(Request $request, User $customer)
    {
        if ($customer->role !== 'pelanggan') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'is_active' => 'required|boolean',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'is_active' => $validated['is_active'],
        ];

        // Update password only if provided
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $customer->update($updateData);

        return redirect()->route('kasir.customers.show', $customer)
            ->with('success', 'Data pelanggan berhasil diupdate!');
    }

    /**
     * Remove the specified customer
     */
    public function destroy(User $customer)
    {
        if ($customer->role !== 'pelanggan') {
            abort(404);
        }

        $customer->delete();

        return redirect()->route('kasir.customers.index')
            ->with('success', 'Pelanggan berhasil dihapus!');
    }

    /**
     * Search customers for transaction
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $customers = User::where('role', 'pelanggan')
            ->where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('phone', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email', 'phone']);

        return response()->json($customers);
    }
}
