<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="">
    <header class="mb-4">
        <h2 class="h4 fw-medium text-dark">
            {{ __('Delete Account') }}
        </h2>
        <p class="text-muted small mt-2">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
        {{ __('Delete Account') }}
    </button>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true" 
         wire:ignore.self {{ $errors->isNotEmpty() ? 'data-bs-show="true"' : '' }}>
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit="deleteUser">
                    <div class="modal-body p-4">
                        <h3 class="h5 fw-medium text-dark mb-3">
                            {{ __('Are you sure you want to delete your account?') }}
                        </h3>
                        <p class="text-muted small mb-4">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>

                        <div class="mb-4">
                            <x-input-label for="password" value="{{ __('Password') }}" class="visually-hidden" />
                            <x-text-input
                                wire:model="password"
                                id="password"
                                name="password"
                                type="password"
                                class="form-control"
                                placeholder="{{ __('Password') }}"
                            />
                            <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>