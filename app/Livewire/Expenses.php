<?php

namespace App\Livewire;

use App\Models\Expense;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Expenses extends Component
{
    use WithPagination;

    // Form properties
    public $showForm = false;
    public $editMode = false;
    public $selected_id;

    // Expense fields
    public $category;
    public $description;
    public $amount;
    public $expense_date;
    public $payment_method = 'cash';
    public $invoice_number;
    public $notes;

    // Search and filters
    public $search = '';
    public $filterCategory = '';
    public $filterPaymentMethod = '';

    // Common expense categories
    public $categories = [
        'utilities' => 'Servicios Públicos (Luz, Agua, Gas)',
        'rent' => 'Alquiler',
        'salaries' => 'Nómina',
        'cleaning' => 'Limpieza',
        'maintenance' => 'Mantenimiento',
        'office_supplies' => 'Útiles de Oficina',
        'marketing' => 'Marketing y Publicidad',
        'transportation' => 'Transporte',
        'insurance' => 'Seguros',
        'taxes' => 'Impuestos',
        'other' => 'Otros',
    ];

    protected $listeners = ['refreshExpenses' => '$refresh'];

    public function mount()
    {
        $this->expense_date = now()->format('Y-m-d');
    }

    public function create()
    {
        $this->resetUI();
        $this->showForm = true;
        $this->editMode = false;
    }

    public function submitForm()
    {
        // Comprehensive backend validation
        $rules = [
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'amount' => 'required|numeric|min:0.01|max:9999999.99',
            'expense_date' => 'required|date|before_or_equal:today',
            'payment_method' => 'required|in:cash,transfer,check,card',
            'invoice_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ];

        // Custom validation messages
        $messages = [
            'category.required' => 'Category is required',
            'description.required' => 'Description is required',
            'description.max' => 'Description cannot exceed 500 characters',
            'amount.required' => 'Amount is required',
            'amount.min' => 'Amount must be greater than 0',
            'amount.max' => 'Amount is too high',
            'expense_date.required' => 'Expense date is required',
            'expense_date.before_or_equal' => 'Expense date cannot be in the future',
            'payment_method.required' => 'Payment method is required',
            'payment_method.in' => 'Invalid payment method',
            'invoice_number.max' => 'Invoice number cannot exceed 100 characters',
            'notes.max' => 'Notes cannot exceed 1000 characters',
        ];

        $this->validate($rules, $messages);

        try {
            DB::transaction(function () {
                if ($this->editMode && $this->selected_id) {
                    $expense = Expense::findOrFail($this->selected_id);
                    $expense->update([
                        'category' => $this->category,
                        'description' => $this->description,
                        'amount' => $this->amount,
                        'expense_date' => $this->expense_date,
                        'payment_method' => $this->payment_method,
                        'invoice_number' => $this->invoice_number,
                        'notes' => $this->notes,
                    ]);
                } else {
                    Expense::create([
                        'user_id' => auth()->id(),
                        'category' => $this->category,
                        'description' => $this->description,
                        'amount' => $this->amount,
                        'expense_date' => $this->expense_date,
                        'payment_method' => $this->payment_method,
                        'invoice_number' => $this->invoice_number,
                        'notes' => $this->notes,
                    ]);
                }
            });

            $message = $this->editMode ? __('common.expense_updated_successfully') : __('common.expense_created_successfully');
            session()->flash('message', $message);
            $this->resetUI();
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Expense save failed', [
                'expense_id' => $this->selected_id ?? 'new',
                'category' => $this->category,
                'amount' => $this->amount,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show user-friendly error
            session()->flash('error', __('common.expense_save_error'));
        }
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        
        $this->selected_id = $id;
        $this->category = $expense->category;
        $this->description = $expense->description;
        $this->amount = $expense->amount;
        $this->expense_date = $expense->expense_date->format('Y-m-d');
        $this->payment_method = $expense->payment_method;
        $this->invoice_number = $expense->invoice_number;
        $this->notes = $expense->notes;
        
        $this->showForm = true;
        $this->editMode = true;
    }

    public function destroy($id)
    {
        try {
            Expense::findOrFail($id)->delete();
            session()->flash('message', __('common.expense_deleted_successfully'));
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Expense delete failed', [
                'expense_id' => $id,
                'error' => $e->getMessage()
            ]);

            // Show user-friendly error
            session()->flash('error', __('common.expense_delete_error'));
        }
    }

    public function cancel()
    {
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->showForm = false;
        $this->editMode = false;
        $this->selected_id = null;
        $this->category = null;
        $this->description = null;
        $this->amount = null;
        $this->expense_date = now()->format('Y-m-d');
        $this->payment_method = 'cash';
        $this->invoice_number = null;
        $this->notes = null;
        $this->resetValidation();
    }

    public function render()
    {
        if ($this->showForm) {
            return view('livewire.expenses.form');
        }

        $query = Expense::with('user');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                  ->orWhere('invoice_number', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterCategory) {
            $query->where('category', $this->filterCategory);
        }

        if ($this->filterPaymentMethod) {
            $query->where('payment_method', $this->filterPaymentMethod);
        }

        $expenses = $query->latest('expense_date')->paginate(10);

        return view('livewire.expenses.component', [
            'expenses' => $expenses,
        ]);
    }
}
