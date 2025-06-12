<x-app-layout> <!-- Applying Blade component named app-layout (app\View\Components\AppLayout.php) -->
    <div class="container mt-4">
        <h2>Hello Admin, {{ auth()->user()->name }}</h2>
        <p>This is the admin dashboard.</p>
    </div>
</x-app-layout>
