<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <!-- Trigger Button -->
    <div class="my-1 d-md-flex">
        <button wire:click.prevent="openModal" class="btn btn-primary btn-sm py-0 px-2 w-100">
            <span class="d-inline-flex align-items-center text-nowrap">
                <i class="bi bi-person small me-1"></i>
                <span class="small">Assign</span>
            </span>
        </button>
        <button wire:click.prevent="clearAssignment" class="btn btn-danger btn-sm py-0 px-2 w-100">
            <span class="d-inline-flex align-items-center text-nowrap">
                <i class="bi bi-x-circle small"></i>
                <span class="small">Clear</span>
            </span>
        </button>
    </div>

    <!-- Current Assignments Display -->
    @if($booking->photographers->count() > 0)
        <div class="d-flex flex-wrap gap-2 align-items-center">
            @foreach($booking->photographers as $photographer)
                <div class="d-flex align-items-center">
                    @if($photographer->profile_photo)
                        {{-- {{dd(Storage::url('images/' . $photographer->profile_photo))}} --}}
                        <img src="{{ Storage::url('images/' . $photographer->profile_photo) }}" alt="{{ $photographer->name }}" class="rounded-circle me-1" width="24" height="24">
                    @else
                        <span class="rounded-circle bg-light d-flex align-items-center justify-content-center me-1" style="width: 24px; height: 24px; font-size: 0.7rem">
                            {{ substr($photographer->name, 0, 1) }}
                        </span>
                    @endif
                    <span class="small text-nowrap">{{ $photographer->name }}</span>
                </div>
                @if(!$loop->last)
                    <span class="text-muted small">•</span>
                @endif
            @endforeach
        </div>
    @else
        <span class="text-muted small">None assigned</span>
    @endif

    <!-- Modal -->
    @if($showModal)
    <!-- Modal Backdrop -->
    <div class="modal d-block" style="background-color: rgba(0,0,0,0.5)" wire:click.prevent="closeModal">
        <!-- Modal Dialog -->
        <div class="modal-dialog modal-dialog-centered modal-lg" wire:click.stop>
            <div class="modal-content">
                
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Assign Photographers to {{ $booking->event_name ?? 'Booking #' . $booking->id }}</h5>
                    <button type="button" wire:click="closeModal" class="btn-close"></button>
                </div>
                @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif                
                <!-- Event Details -->
                <div class="card m-3">
                    <div class="card-body">
                        <h6 class="card-title">Event Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Date:</strong> {{ Carbon\Carbon::parse($booking->event_date)->format('F j, Y') }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Time:</strong> {{ Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Event Type:</strong> {{ ucfirst($booking->event_type) }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Location:</strong> {{ $booking->event_location }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="px-3" wire:keydown.enter.stop>
                    <div>
                        <form action="" class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Search Photographers</label>
                                <input type="text" wire:model.live="searchTerm" placeholder="Search by name or email..." class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Filter by Specialization</label>
                                <select wire:model.live="specializationFilter" class="form-select">
                                    <option value="">All Specializations</option>
                                    <option value="Wedding">Wedding</option>
                                    <option value="Corporate">Corporate</option>
                                    <option value="Portrait">Portrait</option>
                                    <option value="Event">Event</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Photographers List -->
                <div class="px-3">
                    <div class="mb-4" style="max-height: 400px; overflow-y: auto;">
                        @if(count($availablePhotographers) > 0)
                        <div class="list-group">
                                @foreach($availablePhotographers as $photographer)
                                <div class="list-group-item mb-3 {{ $photographer['is_available'] ? 'border-success bg-success bg-opacity-10' : 'border-danger bg-danger bg-opacity-10' }}">
                                    <div class="d-flex align-items-start">
                                        <!-- Checkbox -->
                                        <div class="form-check pe-3 pt-1">
                                            <input type="checkbox" wire:click="togglePhotographer({{ $photographer['id'] }})" {{ in_array($photographer['id'], $selectedPhotographers) ? 'checked' : '' }} class="form-check-input">
                                        </div>

                                        <!-- Profile Photo -->
                                        <div class="flex-shrink-0 pe-3">
                                            @if($photographer['profile_photo'])
                                            <img src="{{ Storage::url($photographer['profile_photo']) }}" alt="{{ $photographer['name'] }}" class="rounded-circle" width="48" height="48">
                                            @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                <span class="text-muted fw-medium">{{ substr($photographer['name'], 0, 1) }}</span>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Photographer Info -->
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1">{{ $photographer['name'] }}</h6>
                                                <span class="badge {{ $photographer['is_available'] ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $photographer['availability_status'] }}
                                                </span>
                                            </div>
                                            
                                            <div class="text-muted small">
                                                <div>{{ $photographer['email'] }}</div>
                                                @if($photographer['phone'])
                                                <div>{{ $photographer['phone'] }}</div>
                                                @endif
                                                @if($photographer['specialization'])
                                                <div><strong>Specialization:</strong> {{ $photographer['specialization'] }}</div>
                                                @endif
                                            </div>

                                            <!-- Conflicts -->
                                            @if(!$photographer['is_available'] && count($photographer['conflicts']) > 0)
                                            <div class="mt-2">
                                                <button wire:click.prevent="toggleAvailabilityDetails({{ $photographer['id'] }})" class="btn btn-link p-0 text-danger text-decoration-none">
                                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                                    View Conflicts ({{ count($photographer['conflicts']) }})
                                                </button>
                                                
                                                @if(isset($showAvailabilityDetails[$photographer['id']]))
                                                <div class="alert alert-danger mt-2">
                                                    <ul class="mb-0">
                                                        @foreach($photographer['conflicts'] as $conflict)
                                                        <li>{{ $conflict['details'] }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-person-x fs-1"></i>
                            <p class="mt-2">No photographers found matching your criteria.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <div class="text-muted small">
                        {{ count($selectedPhotographers) }} photographer(s) selected
                    </div>
                    <div>
                        <button wire:click.prevent="closeModal" class="btn btn-outline-secondary me-2">Cancel</button>
                        <button wire:click.prevent="assignPhotographers" class="btn btn-primary" {{ count($selectedPhotographers) == 0 ? 'disabled' : '' }}>
                            Assign Photographers
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Flash Messages -->
    @if (session()->has('success'))
    <div class="d-inline-block">
        <div class="d-flex align-items-center text-success small">
            <i class="bi bi-check-circle-fill me-1 text-success"></i>
            <span class="badge bg-success bg-opacity-10 text-success small text-truncate" style="width:150px">
                {{ session('success') }}
            </span>
            {{-- <span class="text-truncate small" style="width:150px">{{ session('success') }}</span> --}}
        </div>
    </div>

    {{-- <span class="badge bg-success bg-opacity-10 text-success small">
        {{ session('success') }}
    </span> --}}
    @endif
    @if (session('error'))
    <div class="d-inline-block">
        <div class="d-flex align-items-center text-danger small">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            <span class="badge bg-danger bg-opacity-10 text-danger small text-truncate" style="width:150px">
                {{ session('error') }}
            </span>

        </div>
    </div>
    @endif

</div>