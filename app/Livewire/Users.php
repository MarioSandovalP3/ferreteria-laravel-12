<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Users extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $pageTitle;
    public $componentName;
    public $search;
    public $filterRole;
    public $lastItem;
    public $totalRecord;
    public $selected_id;

    public $name, $email, $phone, $address, $password, $password_confirmation;
    public $image;
    public $imageFile;
    public $role = '';
    public $account_state = 'Active';
    public $showForm = false;
    public $editMode = false;
    private $pagination = 48;
    
    public function mount()
    {
        $this->lastItem = 0;
        $this->totalRecord = 0;
        $this->selected_id = 0;
        $this->search = '';
        $this->role = '';
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
            return view('livewire.users.component', [
                'users' => collect(),
            ]);
        }

        $users = User::query()
            ->with('roles')
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterRole, function($query) {
                $query->whereHas('roles', function($q) {
                    $q->where('name', $this->filterRole);
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($this->pagination ?? 10);

        return view('livewire.users.component', [
            'users' => $users,
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
        $record = User::with('roles')->find($id);
        $this->selected_id = $record->id;
        $this->name = $record->name;
        $this->email = $record->email;
        $this->phone = $record->phone;
        $this->address = $record->address;
        $this->account_state = $record->account_state;
        
        // Get the first role name (since we are now enforcing single role)
        $this->role = $record->roles->first()?->name ?? '';
        $this->image = $record->image;

        $this->showForm = true;
        $this->editMode = true;
    }

    public function Store()
    {
        // Comprehensive backend validation
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'email' => [
                "required",
                "string",
                "lowercase",
                'regex:/^[\w\.\-]+@([\w\-]+\.)+[\w\-]{2,4}$/',
                "max:255",
                "unique:users,email",
            ],
            'password' => 'required|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'imageFile' => 'nullable|image|max:2048'
        ];

        $messages = [
            "email.regex" => __("validation.email_format"),
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 3 characters',
            'name.max' => 'Name cannot exceed 255 characters',
            'phone.required' => 'Phone is required',
            'phone.max' => 'Phone cannot exceed 20 characters',
            'address.max' => 'Address cannot exceed 500 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'role.required' => 'Role is required',
            'role.exists' => 'Selected role does not exist',
            'imageFile.image' => 'File must be an image',
            'imageFile.max' => 'Image size cannot exceed 2MB',
        ];

        $this->validate($rules, $messages);

        try {
            \DB::transaction(function () {
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'password' => Hash::make($this->password),
                    'account_state' => $this->account_state
                ]);

                if ($this->imageFile) {
                    $imagePath = $this->imageFile->store('users', 'public');
                    $user->image = $imagePath;
                    $user->save();
                }

                // Sync single role
                $user->syncRoles([$this->role]);
            });

            $this->showForm = false;
            $this->resetUI();
            $this->dispatch('msg', __('common.user_created_successfully'));
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('User creation failed', [
                'name' => $this->name,
                'email' => $this->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show user-friendly error
            $this->dispatch('msg', __('common.user_save_error'));
        }
    }



    public function Update()
    {
        // Comprehensive backend validation
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'email' => 'required|email|max:255|unique:users,email,' . $this->selected_id,
            'role' => 'required|exists:roles,name',
            'imageFile' => 'nullable|image|max:2048'
        ];

        if (!empty($this->password)) {
            $rules['password'] = 'min:8|confirmed';
        }

        $messages = [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 3 characters',
            'name.max' => 'Name cannot exceed 255 characters',
            'phone.required' => 'Phone is required',
            'phone.max' => 'Phone cannot exceed 20 characters',
            'address.max' => 'Address cannot exceed 500 characters',
            'email.unique' => 'Email already exists',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'role.required' => 'Role is required',
            'role.exists' => 'Selected role does not exist',
            'imageFile.image' => 'File must be an image',
            'imageFile.max' => 'Image size cannot exceed 2MB',
        ];

        $this->validate($rules, $messages);

        try {
            \DB::transaction(function () {
                $user = User::findOrFail($this->selected_id);

                $updateData = [
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'account_state' => $this->account_state
                ];

                if (!empty($this->password)) {
                    $updateData['password'] = Hash::make($this->password);
                }

                $user->update($updateData);

                if ($this->imageFile) {
                    if ($user->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->image)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($user->image);
                    }
                    $imagePath = $this->imageFile->store('users', 'public');
                    $user->image = $imagePath;
                    $user->save();
                }

                $user->syncRoles([$this->role]);
            });

            $this->showForm = false;
            $this->resetUI();
            $this->dispatch('msg', __('common.user_updated_successfully'));
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('User update failed', [
                'user_id' => $this->selected_id,
                'name' => $this->name,
                'email' => $this->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show user-friendly error
            $this->dispatch('msg', __('common.user_save_error'));
        }
    }

    public function Delete($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->image);
            }
            $user->delete();

            $this->dispatch('msg', __('common.user_deleted_successfully'));
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('User delete failed', [
                'user_id' => $id,
                'error' => $e->getMessage()
            ]);

            // Show user-friendly error
            $this->dispatch('msg', __('common.user_delete_error'));
        }
    }

    public function removeImage($id): void
    {
        $user = User::find($id);

        if ($user->image && Storage::disk("public")->exists($user->image)) {
            Storage::disk("public")->delete($user->image);
        }

        $user->image = null;
        $user->save();

        $this->image = null;
        $this->imageFile = null;

        $this->dispatch("user-updated", name: $user->name, image: "");
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
            'email',
            'phone',
            'address',
            'password',
            'password_confirmation',
            'account_state',
            'role',
            'selected_id',
            'image',
            'imageFile'
        ]);
        
        $this->resetValidation();
    }

    
}
