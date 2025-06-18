@extends('layout.default')

@section('assets')
{{-- @vite('resources\css\home.css') --}}
@endsection

@section('content')
<div class="container py-5 bg-light hero-content fade-in text-black shadow">
        <h2 class="mb-2">About Calystra Studio</h2>
    <p>
        Calystra Studio is a creative photography studio based in Malaysia, dedicated to capturing life's most meaningful moments with elegance and authenticity. We specialize in wedding photography, corporate events, fashion shoots, and convocation portraits.
    </p>

    <p>
        Our team of experienced photographers and visual storytellers is passionate about turning ordinary moments into extraordinary memories. With a keen eye for detail and a love for creativity, we ensure every shot reflects the personality and story behind it.
    </p>

    <h4 class="mt-5">📸 Our Photography Services</h4>
    <ul>
        <li><strong>Weddings:</strong> Elegant, emotional, and timeless wedding photography to preserve your special day.</li>
        <li><strong>Corporate Events:</strong> Professional and polished coverage of conferences, product launches, and corporate milestones.</li>
        <li><strong>Fashion:</strong> Bold, stylish, and trend-setting photography for fashion brands, models, and designers.</li>
        <li><strong>Convocation:</strong> Studio and outdoor graduation photos that celebrate your achievement.</li>
    </ul>

    <h4 class="mt-5">🎯 Why Choose Calystra Studio?</h4>
    <ul>
        <li>✅ Dedicated and friendly team</li>
        <li>✅ High-quality equipment and editing</li>
        <li>✅ Flexible packages to suit your needs</li>
        <li>✅ Prompt delivery and great customer service</li>
    </ul>

    <h4 class="mt-5">Let’s Work Together</h4>
    <p>
        Whether you're tying the knot, launching a product, walking the graduation stage, or stepping into the fashion scene, we are here to capture your moment with heart and style.
    </p>

    <p class="mt-4">
        📩 <a href="{{ route('contact') }}">Contact us</a> to book your session or inquire about our packages.
    </p>
</div>
@endsection