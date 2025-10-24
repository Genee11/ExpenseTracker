<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        return Inertia::render('accounts/index', [
            'accounts' => $accounts,
        ]);
    }

    public function create()
    {
        return Inertia::render('accounts/create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $accounts = Account::create($validated);
        return to_route('accounts.index');
    }

    public function edit(Account $account)
    {
        return Inertia::render('accounts/edit', [
            'account' => $account, 
        ]);
    }

    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);
        $account->update($validated);
        return to_route('accounts.index');
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return to_route('accounts.index');
    }
}
