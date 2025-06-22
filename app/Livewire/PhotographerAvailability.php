<?php

namespace App\Livewire;

use App\Models\Photographer;
use App\Models\PhotographerAvailability as ModelsPhotographerAvailability;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class PhotographerAvailability extends Component
{
    use WithPagination;

    public $showPhotographerForm = false;
    public $photographer_name = '';
    public $photographer_email = '';
    public $photographer_phone = '';

    // Form properties
    public $photographer_id = '';
    public $start_date = '';
    public $start_time = '';
    public $end_date = '';
    public $end_time = '';
    public $reason = '';
    
    // Component state
    public $isEditing = false;
    public $editingId = null;
    public $showForm = false;
    
    // Filters
    public $filterPhotographer = '';
    public $filterStartDate = '';
    public $filterEndDate = '';
    
    protected $paginationTheme = 'bootstrap';

    public function showAddPhotographerForm(){
        $this->resetPhotographerForm();
        $this->showPhotographerForm = true;
    }

    public function closePhotographerForm(){
        $this->showPhotographerForm = false;
    }

    public function resetPhotographerForm(){
        $this->photographer_name = '';
        $this->photographer_email = '';
        $this->photographer_phone = '';
        $this->resetErrorBag(['photographer_name', 'photographer_email', 'photographer_phone']);
    }

    public function savePhotographer(){
        $this->validate([
            'photographer_name' => 'required|string|max:255',
            'photographer_email' => 'required|email|unique:photographers,email',
            'photographer_phone' => 'required|string|max:20',
        ]);

        Photographer::create([
            'name' => $this->photographer_name,
            'email' => $this->photographer_email,
            'phone' => $this->photographer_phone,
        ]);

        session()->flash('message', 'Photographer added successfully.');
        $this->showPhotographerForm = false;
        $this->mount();
    }

    public function rules() // this method is automatically run when you invoke $this->validate
    {
        return [
            'photographer_id' => 'required|exists:photographers,id',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required',
            'reason' => 'required|string|max:255',
        ];
    }

    public function validationAttributes()
    {
        return [
            'photographer_id' => 'photographer',
            'start_date' => 'start date',
            'start_time' => 'start time',
            'end_date' => 'end date',
            'end_time' => 'end time',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->resetForm();
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->isEditing = false;
    }

    public function edit($id)
    {
        $availability = ModelsPhotographerAvailability::findOrFail($id);
        
        $this->editingId = $id;
        $this->photographer_id = $availability->photographer_id;
        $this->start_date = Carbon::parse($availability->start_date)->format('Y-m-d');
        $this->start_time = Carbon::parse($availability->start_date)->format('H:i');
        $this->end_date = Carbon::parse($availability->end_date)->format('Y-m-d');
        $this->end_time = Carbon::parse($availability->end_date)->format('H:i');
        $this->reason = $availability->reason;
        
        $this->isEditing = true;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        // Additional validation for overlapping periods
        $this->validateOverlap();

        $startDateTime = Carbon::parse($this->start_date . ' ' . $this->start_time);
        $endDateTime = Carbon::parse($this->end_date . ' ' . $this->end_time);

        // Validate that end time is after start time
        if ($endDateTime <= $startDateTime) {
            $this->addError('end_time', 'End time must be after start time.');
            return;
        }

        $data = [
            'photographer_id' => $this->photographer_id,
            'start_date' => $startDateTime,
            'end_date' => $endDateTime,
            'reason' => $this->reason,
        ];

        if ($this->isEditing) {
            ModelsPhotographerAvailability::findOrFail($this->editingId)->update($data);
            session()->flash('message', 'Photographer availability updated successfully.');
        } else {
            ModelsPhotographerAvailability::create($data);
            session()->flash('message', 'Photographer availability created successfully.');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    private function validateOverlap()
    {
        $startDateTime = Carbon::parse($this->start_date . ' ' . $this->start_time);
        $endDateTime = Carbon::parse($this->end_date . ' ' . $this->end_time);

        $query = ModelsPhotographerAvailability::where('photographer_id', $this->photographer_id)
            ->where(function ($q) use ($startDateTime, $endDateTime) {
                $q->where(function ($subQ) use ($startDateTime, $endDateTime) {
                    $subQ->where('start_date', '<', $endDateTime)
                         ->where('end_date', '>', $startDateTime);
                });
            });

        if ($this->isEditing) {
            $query->where('id', '!=', $this->editingId);
        }

        if ($query->exists()) {
            $this->addError('start_date', 'This time period overlaps with an existing unavailable period.');
        }
    }

    public function delete($id)
    {
        ModelsPhotographerAvailability::findOrFail($id)->delete();
        session()->flash('message', 'Photographer availability deleted successfully.');
    }

    public function resetForm()
    {
        $this->photographer_id = '';
        $this->start_date = '';
        $this->start_time = '';
        $this->end_date = '';
        $this->end_time = '';
        $this->reason = '';
        $this->isEditing = false;
        $this->editingId = null;
        $this->resetErrorBag();
    }

    public function closeForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function clearFilters()
    {
        $this->filterPhotographer = '';
        $this->filterStartDate = '';
        $this->filterEndDate = '';
        $this->resetPage();
    }

    public function render()
    {
        $photographers = Photographer::orderBy('name')->get();
        
        $availabilities = ModelsPhotographerAvailability::with('photographer')
            ->when($this->filterPhotographer, function ($query) {
                $query->where('photographer_id', $this->filterPhotographer);
            })
            ->when($this->filterStartDate, function ($query) {
                $query->whereDate('start_date', '>=', $this->filterStartDate);
            })
            ->when($this->filterEndDate, function ($query) {
                $query->whereDate('end_date', '<=', $this->filterEndDate);
            })
            ->orderBy('start_date', 'asc')
            ->paginate(10);

        return view('livewire.photographer-availability', [
            'availabilities' => $availabilities,
            'photographers' => $photographers,
        ]);
    }
}
