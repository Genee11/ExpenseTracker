<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index()
    {
        $expense = Expense::with( 'category', 'account')->get();
        return Inertia::render('expenses/index', [
            'expenses' => $expense,
        ]);
    }

    public function create()
    {
        $accounts = Account::all();
        $categories = Category::all();
        return Inertia::render('expenses/create', [
            'accounts' => $accounts,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => ['required', 'exists:accounts,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required'],
            'amount' => ['required'],
        ]);

        $expense = Expense::create($validated);
        return to_route('expenses.index');
    }

    public function edit(Expense $expense)
    {
        $accounts = Account::all();
        $categories = Category::all();
        return Inertia::render('expenses/edit', [
            'expense' => $expense,
            'accounts' => $accounts,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'account_id' => ['required', 'exists:accounts,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required'],
            'amount' => ['required'],
        ]);

        $expense->update($validated);
        return to_route('expenses.index');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete(); // safe
        return to_route('expenses.index')->with('success', 'Expense deleted.');
    }

}
