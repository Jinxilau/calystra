<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.guest'), Title('Register')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $terms_accepted = false;
    
    protected $messages = [
        'terms_accepted.accepted' => 'You must accept the terms and conditions to register.',
    ];

    /**
     * Get the validation rules for registration
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'terms_accepted' => ['required','accepted'],
        ];
    }

    /**
     * Real-time validation for better UX
     */
    public function updated($propertyName): void // This method is called whenever a property is updated wire:model
    {
        $this->validateOnly($propertyName);  // Validate only the changed property
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate(rules()); // rule()

        // Remove terms_accepted from validated data before creating user
        unset($validated['terms_accepted']);
        
        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        // Auth::login($user); // Login the user after registration

        session()->flash('registered', true);
        
        $this->redirect(route('login', absolute: false), navigate: true);
    }

    /**
     * Check if password meets requirements
     */
    public function getPasswordStrengthProperty(): array // Computed property get(name)Property
    { // This method is accessed when $this->passwordStrength is referenced in the view
        $password = $this->password;

        $strength = [
            'length' => strlen($password) >= 8,
            'uppercase' => preg_match('/[A-Z]/', $password),
            'lowercase' => preg_match('/[a-z]/', $password),
            'number' => preg_match('/[0-9]/', $password),
            'special' => preg_match('/[^A-Za-z0-9]/', $password),
        ];

        /*[
            'length' => false, // 3 chars < 8
            'uppercase' => true, // has "A"
            'lowercase' => true, // has "b"
            'number' => true, // has "1"
        ] */
        
        return $strength;
    }
}; 
?>

<div class="d-flex flex-column justify-content-start px-2 pt-4 px-lg-4 mb-2" style="height: fit-content;">
    <div class="mx-auto w-100" style="max-width: 480px;">
        <div class="text-center">
            <h2 class="h3 mb-2 fw-bold text-dark">{{ __('Create your account') }}</h2>
            <p class="text-muted">{{ __('Join us today and get started in minutes.') }}</p>
        </div>
    </div>

    <div class=" mx-auto w-100" style="max-width: 420px;">
        <div class="bg-white px-4 py-2 border-top">
            <form wire:submit="register" class="needs-validation" novalidate>
                <!-- Name -->
                <div class="mb-3">
                    <x-input-label for="name" :value="__('Full Name')" class="form-label" />
                    <div class="position-relative">
                        <x-text-input wire:model.live.debounce.300ms="name" id="name" class="form-control" type="text" name="name" placeholder="{{ __('Enter your full name') }}" required autofocus autocomplete="name" />
                        @error('name')
                            <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                                <svg width="20" height="20" fill="red" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @else
                            @if(strlen($name) > 2)
                                <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                                    <svg width="20" height="20" fill="#28a745" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        @enderror
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="text-danger" />
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email address')" class="form-label" />
                    <div class="position-relative">
                        <x-text-input wire:model.live.debounce.500ms="email" id="email" class="form-control" type="email" name="email" placeholder="{{ __('Enter your email address') }}" required autocomplete="username"/>
                        @error('email')
                            <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                                <svg width="20" height="20" fill="red" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @else
                            @if(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) > 0)
                                <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                                    <svg width="20" height="20" fill="#28a745" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        @enderror
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="text-danger" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="form-label" />
                    <div class="position-relative">
                        <x-text-input 
                            wire:model.live.debounce.300ms="password" id="password" class="form-control" type="password" name="password" placeholder="{{ __('Create a strong password') }}" required autocomplete="new-password" />
                        @if($errors->has('password'))
                            <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                                <svg width="20" height="20" fill="red" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    {{-- @if(strlen($password) > 0) --}}
                        <div class="mt-2">
                            <div class="small text-muted mb-1">{{ __('Password strength:') }}</div>
                            <div class="d-flex gap-1 mb-2" style="height: 4px;">
                                @php
                                    $strength = $this->passwordStrength;
                                    $score = array_sum($strength);
                                    $colors = ['bg-danger', 'bg-warning', 'bg-warning', 'bg-success', 'bg-success'];
                                @endphp
                                @for($i = 0; $i < 5; $i++)
                                    <div class="h-1 rounded flex-grow-1 {{ $i < $score ? $colors[$score] : 'bg-light' }}"></div>
                                @endfor
                            </div>
                            <div class="small">
                                <div class="d-flex align-items-center mb-1 {{ $strength['length'] ? 'text-success' : 'text-muted' }}">
                                    <svg class="bi flex-shrink-0 me-1" width="18" height="18" fill="currentColor">
                                        @if($strength['length'])
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        @else
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                    {{ __('At least 8 characters') }}
                                </div>
                                <div class="d-flex align-items-center mb-1 {{ $strength['uppercase'] && $strength['lowercase'] ? 'text-success' : 'text-muted' }}">
                                    <svg class="bi flex-shrink-0 me-1" width="18" height="18" fill="currentColor">
                                        @if($strength['uppercase'] && $strength['lowercase'])
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        @else
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                    {{ __('Mixed case letters') }}
                                </div>
                                <div class="d-flex align-items-center {{ $strength['number'] ? 'text-success' : 'text-muted' }}">
                                    <svg class="bi flex-shrink-0 me-1" width="18" height="18" fill="currentColor">
                                        @if($strength['number'])
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        @else
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                    {{ __('At least one number') }}
                                </div>
                            </div>
                        </div>
                    {{-- @endif --}}
                    
                    <x-input-error :messages="$errors->get('password')" class="text-danger" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-3 mt-2">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="form-label" />
                    <div class="position-relative">
                        <x-text-input wire:model.live.debounce.300ms="password_confirmation" id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="{{ __('Confirm your password') }}" required autocomplete="new-password" />
                        @if(strlen($password_confirmation) > 0)
                            <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                                @if($password === $password_confirmation)
                                    <svg width="20" height="20" fill="#28a745" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg width="20" height="20" fill="red" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                        @endif
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger" />
                </div>

                <!-- Terms and Conditions -->
                <div class="mb-3 form-check">
                    <input wire:model.live="terms_accepted" id="terms" type="checkbox" class="form-check-input" required>
                    <label for="terms" class="form-check-label">{{ __('I agree to the') }}<a href="#" class="text-dark"> {{ __('Terms and Conditions') }}</a> {{ __('and') }}<a href="#" class="text-dark"> {{ __('Privacy Policy') }}</a></label>
                    <x-input-error :messages="$errors->get('terms_accepted')" class="text-danger" style="list-style: none"/>
                </div>

                <!-- Submit Button -->
                <div class="mb-3">
                    <x-primary-button class="w-100 btn btn-dark" wire:loading.attr="disabled" wire:target="register">
                        <span wire:loading wire:target="register" class="">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        </span>
                        <span>{{ __('Create Account') }}</span>
                    </x-primary-button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="small text-muted"> 
                        {{ __('Already have an account?') }}
                        <a href="{{ route('login') }}" wire:navigate class="text-dark">{{ __('Sign in') }}</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>