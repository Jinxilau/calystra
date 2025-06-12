<x-app-layout> <!-- Applying Blade component named app-layout -->
    <div class="container mt-4">
        <h2>Welcome, {{ auth()->user()->name }}</h2>
        <p>This is your user dashboard.</p>
    </div>
</x-app-layout>
