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
            'terms_accepted' => ['accepted'],
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
        $validated = $this->validate(); // rule()

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
    public function getPasswordStrengthProperty(): array // Computed property, automatically recalculated when $this->password changes
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

<div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900">
                {{ __('Create your account') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Join us today and get started in minutes.') }}
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-lg rounded-lg sm:px-10 border border-gray-200">
            <form wire:submit="register" class="space-y-6">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" class="block text-sm font-medium text-gray-700" />
                    <div class="mt-1 relative">
                        <x-text-input 
                            wire:model.live.debounce.300ms="name" 
                            id="name" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                            type="text" 
                            name="name" 
                            placeholder="{{ __('Enter your full name') }}"
                            required 
                            autofocus 
                            autocomplete="name" 
                        />
                        @error('name')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @else
                            @if(strlen($name) > 2)
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        @enderror
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email address')" class="block text-sm font-medium text-gray-700" />
                    <div class="mt-1 relative">
                        <x-text-input 
                            wire:model.live.debounce.500ms="email" 
                            id="email" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                            type="email" 
                            name="email" 
                            placeholder="{{ __('Enter your email address') }}"
                            required 
                            autocomplete="username" 
                        />
                        @error('email')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @else
                            @if(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) > 0)
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        @enderror
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />
                    <div class="mt-1 relative">
                        <x-text-input 
                            wire:model.live.debounce.300ms="password" 
                            id="password" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            type="password"
                            name="password"
                            placeholder="{{ __('Create a strong password') }}"
                            required 
                            autocomplete="new-password" 
                        />
                        @error('password')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    @if(strlen($password) > 0)
                        <div class="mt-2">
                            <div class="text-xs text-gray-600 mb-1">{{ __('Password strength:') }}</div>
                            <div class="grid grid-cols-4 gap-1 mb-2">
                                @php
                                    $strength = $this->passwordStrength;
                                    $score = array_sum($strength);
                                    $colors = ['bg-red-200', 'bg-yellow-200', 'bg-yellow-400', 'bg-green-400', 'bg-green-500'];
                                @endphp
                                @for($i = 0; $i < 4; $i++)
                                    <div class="h-1 rounded {{ $i < $score ? $colors[$score] : 'bg-gray-200' }}"></div>
                                @endfor
                            </div>
                            <div class="text-xs space-y-1">
                                <div class="flex items-center {{ $strength['length'] ? 'text-green-600' : 'text-gray-400' }}">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($strength['length'])
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        @else
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                    {{ __('At least 8 characters') }}
                                </div>
                                <div class="flex items-center {{ $strength['uppercase'] && $strength['lowercase'] ? 'text-green-600' : 'text-gray-400' }}">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        @if($strength['uppercase'] && $strength['lowercase'])
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        @else
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                    {{ __('Mixed case letters') }}
                                </div>
                                <div class="flex items-center {{ $strength['number'] ? 'text-green-600' : 'text-gray-400' }}">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
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
                    @endif
                    
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700" />
                    <div class="mt-1 relative">
                        <x-text-input 
                            wire:model.live.debounce.300ms="password_confirmation" 
                            id="password_confirmation" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            type="password"
                            name="password_confirmation"
                            placeholder="{{ __('Confirm your password') }}"
                            required 
                            autocomplete="new-password" 
                        />
                        @if(strlen($password_confirmation) > 0)
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                @if($password === $password_confirmation)
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                        @endif
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input 
                            wire:model.live="terms_accepted" 
                            id="terms" 
                            type="checkbox" 
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            required
                        >
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700">
                            {{ __('I agree to the') }}
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                {{ __('Terms and Conditions') }}
                            </a>
                            {{ __('and') }}
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                {{ __('Privacy Policy') }}
                            </a>
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('terms_accepted')" class="mt-1" />

                <!-- Submit Button -->
                <div>
                    <x-primary-button 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150 ease-in-out"
                        wire:loading.attr="disabled"
                        wire:target="register"
                    >
                        <span wire:loading.remove wire:target="register">
                            {{ __('Create Account') }}
                        </span>
                        <span wire:loading wire:target="register" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('Creating account...') }}
                        </span>
                    </x-primary-button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        {{ __('Already have an account?') }}
                        <a 
                            href="{{ route('login') }}" 
                            wire:navigate
                            class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition duration-150 ease-in-out"
                        >
                            {{ __('Sign in') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>