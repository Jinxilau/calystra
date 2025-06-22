<div class="container-fluid py-4">
    {{-- Be like water. --}}
    <div class="d-flex justify-content-end align-items-center mb-4">
        <button wire:click="showCreateForm" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Unavailable Period
        </button>
    </div>

    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{--  Form Modal --}}
    @if($showForm)
    <div class="modal show d-block mb-4" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.145);" wire:click.prevent="closeForm">
        <div class="modal-dialog modal-lg modal-dialog-centered" wire:click.stop>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mb-0">{{ $isEditing ? 'Edit' : 'Add' }} Unavailable Period</h5>
                    <button type="button" wire:click.stop="closeForm" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="row">
                            {{-- Photographer Selection  --}}
                            <div class="col-md-6 mb-3">
                                <label for="photographer_id" class="form-label">Photographer <span class="text-danger">*</span></label>
                                <select wire:model="photographer_id" class="form-select @error('photographer_id') is-invalid @enderror" id="photographer_id">
                                    <option value="">Select Photographer</option>
                                    @foreach($photographers as $photographer)
                                    <option value="{{ $photographer->id }}">{{ $photographer->name }}</option>
                                    @endforeach
                                </select>
                                @error('photographer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
        
                            {{-- Reason --}}
                            <div class="col-md-6 mb-3">
                                <label for="reason" class="form-label">Reason <span class="text-danger">*</span></label>
                                <input type="text" wire:model="reason" class="form-control @error('reason') is-invalid @enderror" 
                                       id="reason" placeholder="e.g., Personal leave, Equipment maintenance">
                                @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
        
                        <div class="row">
                            {{-- Start Date & Time --}}
                            <div class="col-md-3 mb-3">
                                <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" wire:model="start_date" class="form-control @error('start_date') is-invalid @enderror" id="start_date">
                                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
        
                            <div class="col-md-3 mb-3">
                                <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                                <input type="time" wire:model="start_time" class="form-control @error('start_time') is-invalid @enderror" id="start_time">
                                @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
        
                            {{-- End Date & Time  --}}
                            <div class="col-md-3 mb-3">
                                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" wire:model="end_date" class="form-control @error('end_date') is-invalid @enderror" id="end_date">
                                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
        
                            <div class="col-md-3 mb-3">
                                <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                                <input type="time" wire:model="end_time" class="form-control @error('end_time') is-invalid @enderror" id="end_time">
                                @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
        
                        {{-- Form Actions --}}
                        <div class="modal-footer d-flex gap-2">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target='save'>
                                <span wire:loading.remove wire:target='save'>{{ $isEditing ? 'Update' : 'Save' }}</span>
                                <span wire:loading wire:target='save'>Saving...</span>
                            </button>
                            <button type="button" wire:click="closeForm" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">                
                <div class="col-md-3">
                    <label for="filterPhotographer" class="form-label">Filter by Photographer</label>
                    <select wire:model="filterPhotographer" class="form-select" id="filterPhotographer">
                        <option value="">All Photographers</option>
                        @foreach($photographers as $photographer)
                        <option value="{{ $photographer->id }}">{{ $photographer->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="filterStartDate" class="form-label">From Date</label>
                    <input type="date" wire:model="filterStartDate" class="form-control" id="filterStartDate">
                </div>
                
                <div class="col-md-3">
                    <label for="filterEndDate" class="form-label">To Date</label>
                    <input type="date" wire:model="filterEndDate" class="form-control" id="filterEndDate">
                </div>
                
                <div class="col-md-3 d-flex align-items-end">
                    <button wire:click="clearFilters" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times me-1"></i>Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Availability Table --}}
    <div class="card">
        <div class="card-body">
            @if($availabilities->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Photographer</th>
                            <th>Period</th>
                            <th>Duration</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($availabilities as $availability)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($availability->photographer->profile_photo)
                                    <img src="{{ Storage::url('images/' . $photographer->profile_photo) }}" alt="{{ $photographer->name }}" class="rounded-circle me-1" width="24" height="24">
                                    @else
                                    <span class="rounded-circle bg-light d-flex align-items-center justify-content-center me-1" style="width: 24px; height: 24px; font-size: 0.7rem">
                                        {{ substr($availability->photographer->name, 0, 1) }}
                                    </span>
                                    @endif
                                    {{ $availability->photographer->name }}
                                </div>
                            </td>
                            <td>
                                <div class="small">
                                    <strong>Start:</strong> {{ \Carbon\Carbon::parse($availability->start_date)->format('M j, Y g:i A') }}<br>
                                    <strong>End:</strong> {{ \Carbon\Carbon::parse($availability->end_date)->format('M j, Y g:i A') }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ number_format(\Carbon\Carbon::parse($availability->start_date)->diffInDays($availability->end_date) + 1,1) }} days
                                </span>
                            </td>
                            <td>{{ $availability->reason }}</td>
                            <td>
                                @if($availability->end_date < now())
                                <span class="badge bg-secondary">Past</span>
                                @elseif($availability->start_date <= now() && $availability->end_date >= now())
                                <span class="badge bg-warning">Active</span>
                                @else
                                <span class="badge bg-primary">Future</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button wire:click="edit({{ $availability->id }})" 
                                            class="btn btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="delete({{ $availability->id }})" 
                                            class="btn btn-outline-danger" 
                                            onclick="return confirm('Are you sure you want to delete this availability record?')"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination  --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Showing {{ $availabilities->firstItem() }} to {{ $availabilities->lastItem() }} 
                    of {{ $availabilities->total() }} results
                </div>
                {{ $availabilities->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No availability records found</h5>
                <p class="text-muted">
                    @if($filterPhotographer || $filterStartDate || $filterEndDate)
                    Try adjusting your filters or search terms.
                    @else
                    Add unavailable periods to manage photographer schedules.
                    @endif
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
