<?php

namespace App\Livewire;

use App\Models\ExchangeRate;
use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;

class ExchangeRates extends Component
{
    use WithPagination;

    // Form properties
    public $exchange_rate_id;
    public $rate;
    public $effective_date;
    public $notes;
    public $is_active = true;
    
    // UI state
    public $showForm = false;
    public $editMode = false;
    
    // Filters
    public $search = '';
    
    protected $queryString = ['search'];

    public function mount()
    {
        $this->effective_date = now()->format('Y-m-d');
    }
    
    // Get store's country ID
    protected function getStoreCountryId()
    {
        $store = \App\Models\Store::first();
        return $store?->regionalSettings?->country_id;
    }

    public function rules()
    {
        $countryId = $this->getStoreCountryId();
        
        $rules = [
            'rate' => 'required|numeric|min:0.0001|max:999999.9999',
            'effective_date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ];
        
        // Add unique validation for create mode
        if (!$this->editMode) {
            $rules['effective_date'] .= '|unique:exchange_rates,effective_date,NULL,id,country_id,' . $countryId;
        }
        
        return $rules;
    }

    protected function messages()
    {
        return [
            'rate.required' => 'Exchange rate is required',
            'rate.min' => 'Exchange rate must be greater than 0',
            'rate.max' => 'Exchange rate is too high',
            'effective_date.required' => 'Effective date is required',
            'effective_date.before_or_equal' => 'Effective date cannot be in the future',
            'effective_date.unique' => 'An exchange rate already exists for this date',
            'notes.max' => 'Notes cannot exceed 500 characters',
        ];
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editMode = false;
        $this->effective_date = now()->format('Y-m-d');
    }

    public function edit($id)
    {
        $exchangeRate = ExchangeRate::findOrFail($id);
        
        $this->exchange_rate_id = $exchangeRate->id;
        $this->rate = $exchangeRate->rate;
        $this->effective_date = $exchangeRate->effective_date->format('Y-m-d');
        $this->notes = $exchangeRate->notes;
        $this->is_active = $exchangeRate->is_active;
        
        $this->showForm = true;
        $this->editMode = true;
    }

    public function save()
    {
        $this->validate($this->rules(), $this->messages());
        
        $countryId = $this->getStoreCountryId();
        
        if (!$countryId) {
            $this->addError('rate', __('common.store_country_not_configured'));
            return;
        }
        
        try {
            \DB::transaction(function () use ($countryId) {
                $data = [
                    'country_id' => $countryId,
                    'rate' => $this->rate,
                    'effective_date' => $this->effective_date,
                    'notes' => $this->notes,
                    'is_active' => $this->is_active,
                ];

                if ($this->editMode) {
                    $exchangeRate = ExchangeRate::findOrFail($this->exchange_rate_id);
                    $exchangeRate->update($data);
                    $message = __('common.exchange_rate_updated_successfully');
                } else {
                    ExchangeRate::create($data);
                    $message = __('common.exchange_rate_created_successfully');
                }

                $this->dispatch('msg', $message);
                $this->resetForm();
                $this->showForm = false;
            });
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Exchange rate save failed', [
                'exchange_rate_id' => $this->exchange_rate_id ?? 'new',
                'country_id' => $countryId,
                'rate' => $this->rate,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Show user-friendly error
            $this->dispatch('msg', __('common.exchange_rate_save_error'));
        }
    }

    public function delete($id)
    {
        try {
            $exchangeRate = ExchangeRate::findOrFail($id);
            $exchangeRate->delete();
            
            $this->dispatch('msg', __('common.exchange_rate_deleted_successfully'));
        } catch (\Exception $e) {
            // Log technical error
            \Log::error('Exchange rate delete failed', [
                'exchange_rate_id' => $id,
                'error' => $e->getMessage()
            ]);

            // Show user-friendly error
            $this->dispatch('msg', __('common.exchange_rate_delete_error'));
        }
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    protected function resetForm()
    {
        $this->reset([
            'exchange_rate_id', 'rate', 'notes', 'is_active'
        ]);
        $this->effective_date = now()->format('Y-m-d');
        $this->resetValidation();
    }

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = ExchangeRate::with('country');
        
        // Search by date or notes
        if ($this->search) {
            $query->where(function($q) {
                $q->where('effective_date', 'like', '%' . $this->search . '%')
                  ->orWhere('notes', 'like', '%' . $this->search . '%');
            });
        }
        
        $rates = $query->latestFirst()->paginate(15);
        
        return view('livewire.exchange-rates.component', [
            'rates' => $rates,
        ]);
    }
}
