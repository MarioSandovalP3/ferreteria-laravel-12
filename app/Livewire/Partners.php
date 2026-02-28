<?php

namespace App\Livewire;

use App\Models\Partner;
use Livewire\Component;
use Livewire\WithPagination;

class Partners extends Component
{
    use WithPagination;

    public $pageTitle;
    public $componentName;
    public $search;
    public $filterRole;
    public $lastItem;
    public $totalRecord;
    public $selected_id;

    public $name, $tax_id, $address, $phone, $email, $type;
    public $roles = [];
    public $is_active = true;
    public $showForm = false;
    public $editMode = false;
    private $pagination = 48;
    
    public function mount()
    {
        $this->lastItem = 0;
        $this->totalRecord = 0;
        $this->selected_id = 0;
        $this->search = '';
        $this->roles = [];
    }

    // Reset pagination when search is updated
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Reset pagination when filter role is updated
    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->showForm) {
            return view('livewire.partners.component', [
                'partners' => collect(), // Empty collection when showing form
            ]);
        }

        $partners = Partner::query()
            ->with('roles')
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('tax_id', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterRole, function($query) {
                $query->whereHas('roles', function($q) {
                    $q->where('name', $this->filterRole);
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($this->pagination ?? 10);

        return view('livewire.partners.component', [
            'partners' => $partners,
        ]);
    }


    public function create()
    {
        $this->resetUI();
        $this->editMode = false;
        $this->showForm = true;
    }

    public function Edit($id)
    {
        $record = Partner::with('roles')->find($id);
        $this->selected_id = $record->id;
        $this->name = $record->name;
        $this->tax_id = $record->tax_id;
        $this->address = $record->address;
        $this->phone = $record->phone;
        $this->email = $record->email;
        $this->type = $record->type;
        $this->is_active = $record->is_active;
        
        // Get role IDs for the checkboxes
        $this->roles = $record->roles->pluck('id')->toArray();

        $this->showForm = true;
        $this->editMode = true;
    }

    public function Store()
    {
        // Comprehensive backend validation
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'tax_id' => 'required|string|max:50',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            "email" => [
                "required",
                "string",
                "lowercase",
                'regex:/^[\w\.\-]+@([\w\-]+\.)+[\w\-]{2,4}$/',
                "max:255",
                "unique:partners,email",
            ],
            'type' => 'required|in:customer,supplier,both',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ];

        $messages = [
            "email.regex" => __("validation.email_format"),
            'name.required' => 'Partner name is required',
            'name.min' => 'Partner name must be at least 3 characters',
            'name.max' => 'Partner name cannot exceed 255 characters',
            'tax_id.required' => 'Tax ID is required',
            'tax_id.max' => 'Tax ID cannot exceed 50 characters',
            'address.max' => 'Address cannot exceed 500 characters',
            'phone.max' => 'Phone cannot exceed 20 characters',
            'type.required' => 'Partner type is required',
            'type.in' => 'Invalid partner type',
            'roles.required' => 'At least one role is required',
            'roles.min' => 'At least one role is required',
            'roles.*.exists' => 'Selected role does not exist',
        ];

        $this->validate($rules, $messages);

        try {
            \DB::transaction(function () {
                $partner = Partner::create([
                    'name' => $this->name,
                    'tax_id' => $this->tax_id,
                    'address' => $this->address,
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'type' => $this->type,
                    'is_active' => $this->is_active
                ]);

                // Sync roles
                $partner->roles()->sync($this->roles);
            });

            $this->showForm = false;
            $this->resetUI();
            $this->dispatch('msg', __('common.partner_created_successfully'));
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Partner save failed', [
                'name' => $this->name,
                'email' => $this->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show user-friendly error
            $this->dispatch('msg', __('common.partner_save_error'));
        }
    }

    public function Update()
    {
        // Comprehensive backend validation
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'tax_id' => 'required|string|max:50',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:partners,email,' . $this->selected_id,
            'type' => 'required|in:customer,supplier,both',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ];

        $messages = [
            'name.required' => 'Partner name is required',
            'name.min' => 'Partner name must be at least 3 characters',
            'name.max' => 'Partner name cannot exceed 255 characters',
            'tax_id.required' => 'Tax ID is required',
            'tax_id.max' => 'Tax ID cannot exceed 50 characters',
            'address.max' => 'Address cannot exceed 500 characters',
            'phone.max' => 'Phone cannot exceed 20 characters',
            'email.unique' => 'Email already exists',
            'type.required' => 'Partner type is required',
            'type.in' => 'Invalid partner type',
            'roles.required' => 'At least one role is required',
            'roles.min' => 'At least one role is required',
            'roles.*.exists' => 'Selected role does not exist',
        ];

        $this->validate($rules, $messages);

        try {
            \DB::transaction(function () {
                $partner = Partner::findOrFail($this->selected_id);
                
                $partner->update([
                    'name' => $this->name,
                    'tax_id' => $this->tax_id,
                    'address' => $this->address,
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'type' => $this->type,
                    'is_active' => $this->is_active
                ]);

                // Sync roles
                $partner->roles()->sync($this->roles);
            });

            $this->showForm = false;
            $this->resetUI();
            $this->dispatch('msg', __('common.partner_updated_successfully'));
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Partner update failed', [
                'partner_id' => $this->selected_id,
                'name' => $this->name,
                'email' => $this->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show user-friendly error
            $this->dispatch('msg', __('common.partner_save_error'));
        }
        
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->reset([
            'name',
            'tax_id',
            'address',
            'phone',
            'email',
            'type',
            'is_active',
            'roles',
            'selected_id',
        ]);
        
        $this->resetValidation();
    }

    
}
