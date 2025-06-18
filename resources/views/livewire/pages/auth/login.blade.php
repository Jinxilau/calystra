<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.guest'), Title('Login')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        try{
            $this->form->authenticate();
            Session::regenerate(); // Regenerate session to prevent session fixation attacks
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: false);
        }catch(ValidationException $e) {
            $this->addError('form.email', $e->errors()['form.email'][0]);
            $this->addError('form.password', $e->errors()['form.password'][0] ?? '');
        }

    }

    /**
     * Mount the component with any flash messages
     */
    public function mount(): void // This function is called when the component is initialized
    {
        // Handle any registration success messages
        if (session('registered')) {
            $this->dispatch('show-success', message: __('Registration successful! Please log in.'));
        }
    }
}; 
?>

<div class="d-flex flex-column justify-content-center py-2 px-lg-4 px-sm-2 gap-2" style="height: 66vh;">
    @if(session('registered'))
        <p class="text-success text-center">You have successfully registered! Please log in.</p>
    @endif
    <div class="mx-auto w-sm-100" style="max-width: 400px;">
        <div class="text-center">
            <h2 class="h3 mb-3 fw-bold text-dark">
                {{ __('Sign in to your account') }}
            </h2>
            <p class="text-muted mb-0">
                {{ __('Welcome back! Please enter your credentials.') }}
            </p>
        </div>
    </div>

    <div class="mx-auto w-100" style="max-width: 400px;">
        <div class="bg-white p-4 border-top">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="login" class="needs-validation" novalidate>
                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email address')" class="form-label" />
                    <div class="position-relative">
                        <x-text-input wire:model.blur="form.email" id="email" class="form-control" type="email" name="email" placeholder="{{ __('Enter your email') }}" required autofocus autocomplete="username" />
                        @error('form.email')
                        <div class="position-absolute end-0 translate-middle-y pe-3" style="top: 20px;">
                            <svg width="20" height="20" fill="red" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        @enderror
                    </div>
                    <x-input-error :messages="$errors->get('form.email')" class="text-danger" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label for="password" :value="__('Password')" class="form-label" />
                    <div class="position-relative">
                        <x-text-input wire:model.blur="form.password" id="password" class="form-control" type="password" name="password" placeholder="{{ __('Enter your password') }}" required autocomplete="current-password" />
                        @error('form.password')
                        <div class="position-absolute end-0 translate-middle-y pe-3" style="top: 20px;">
                            <svg width="20" height="20" fill="red" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        @enderror
                    </div>
                    <x-input-error :messages="$errors->get('form.password')" class="text-danger" />
                </div>

                {{-- @error('form.password')
                <div class="d-block">
                    {{ $message }}
                </div>
                @enderror --}}

                <!-- Remember Me & Forgot Password -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input wire:model="form.remember" id="remember" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember" class="form-check-label">
                            {{ __('Remember me') }}
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                    <div>
                        <a class="text-decoration-none" href="{{ route('password.request') }}" wire:navigate>
                            {{ __('Forgot password?') }}
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="mb-3">
                    <x-primary-button class="w-100 btn btn-primary" wire:loading.attr="disabled" wire:target="login">
                        <!-- Visible when not loading -->
                        <span wire:loading.remove wire:target="login">
                            {{ __('Sign in') }}
                        </span>
                        
                        <!-- Loading spinner (hidden by default) -->
                        <span wire:loading wire:target="login">
                            <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                            </div>
                            {{ __('Signing in...') }}
                        </span>
                    </x-primary-button>
                </div>

                <!-- Sign Up Link -->
                <div class="text-center">
                    <p class="text-muted">
                        {{ __("Don't have an account?") }}
                        <a href="{{ route('register') }}" wire:navigate class="text-decoration-none">{{ __('Sign up') }}</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>