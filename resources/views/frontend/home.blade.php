<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RoyalStay Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet"
          href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    <style>
        html {
            scroll-behavior: smooth;
        }

        .hero-slide {
            background-size: cover;
            background-position: center;
            animation: heroZoom 12s ease-in-out infinite alternate;
        }
        .hero-bg {
            background-size: cover;
            background-position: center;
            transition: opacity 1s ease-in-out;
        }

        .stat-number {
            transition: all 0.3s ease;
        }

        @keyframes heroZoom {
            from { transform: scale(1); }
            to { transform: scale(1.06); }
        }

        .glass-nav {
            background: rgba(2, 6, 23, 0.82);
            backdrop-filter: blur(18px);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

@php
    $hero = $contents['hero'] ?? null;
    $about = $contents['about'] ?? null;
    $mission = $contents['mission'] ?? null;
    $vision = $contents['vision'] ?? null;
    $contact = $contents['contact'] ?? null;
    $footer = $contents['footer'] ?? null;

    $heroImage = $hero && $hero->image
        ? asset('storage/' . $hero->image)
        : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80';

    $aboutImage = $about && $about->image
        ? asset('storage/' . $about->image)
        : 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1000&q=80';

    $contactParts = $contact && $contact->content
        ? array_map('trim', explode('|', $contact->content))
        : ['Malabe, Sri Lanka', '+94 77 651 4545', 'info@royalstay.com'];
@endphp

<header class="fixed top-0 left-0 w-full z-50 glass-nav border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <a href="{{ route('home') }}" class="text-2xl font-extrabold text-white">
        {{ $footer->title ?? 'RoyalStay.' }}
        </a>

        <nav class="hidden lg:flex items-center gap-8 text-sm font-bold text-slate-200">
            <a href="#home" class="hover:text-amber-400 transition">Home</a>
            <a href="#about" class="hover:text-amber-400 transition">About</a>
            <a href="#rooms" class="hover:text-amber-400 transition">Rooms</a>
            <a href="#services" class="hover:text-amber-400 transition">Services</a>
            <a href="#gallery" class="hover:text-amber-400 transition">Gallery</a>
            <a href="#contact" class="hover:text-amber-400 transition">Contact</a>
        </nav>

        <div class="hidden lg:flex items-center gap-3">
            <a href="{{ route('login') }}"
               class="text-white hover:text-amber-400 font-semibold transition">
                Login
            </a>

            <a href="{{ route('register') }}"
               class="bg-amber-400 text-slate-950 px-6 py-3 rounded-full font-bold hover:bg-amber-300 transition">
                Register
            </a>
        </div>

        <button id="mobileMenuBtn" class="lg:hidden text-white text-2xl">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <div id="mobileMenu" class="hidden lg:hidden px-6 pb-5 bg-slate-950">
        <div class="flex flex-col gap-4 text-white font-semibold">
            <a href="#home" class="mobile-link">Home</a>
            <a href="#about" class="mobile-link">About</a>
            <a href="#rooms" class="mobile-link">Rooms</a>
            <a href="#services" class="mobile-link">Services</a>
            <a href="#gallery" class="mobile-link">Gallery</a>
            <a href="#contact" class="mobile-link">Contact</a>

            <div class="flex gap-3 pt-3">
                <a href="{{ route('login') }}" class="text-white">Login</a>
                <a href="{{ route('register') }}"
                   class="bg-amber-400 text-slate-950 px-5 py-2 rounded-full font-bold">
                    Register
                </a>
            </div>
        </div>
    </div>
</header>

<section id="home" class="relative min-h-screen overflow-hidden flex items-center">

    <div id="heroSlider"
     class="absolute inset-0 hero-slide hero-bg"
     data-images="{{ json_encode([
        $heroImage,
        'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80',
        'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1800&q=80',
        'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1800&q=80'
     ]) }}"
     style="background-image:
     linear-gradient(rgba(2,6,23,0.72), rgba(2,6,23,0.82)),
     url('{{ $heroImage }}');">
</div>

    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/70 via-slate-950/30 to-transparent"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 pt-28">
        <div class="max-w-3xl" data-aos="fade-up">

            <p class="text-amber-400 uppercase tracking-[0.35em] mb-4 font-bold">
                Luxury Hotel Experience
            </p>

            <h1 class="text-5xl md:text-7xl font-extrabold text-white leading-tight mb-6">
                {{ $hero->title ?? 'Enjoy Your Dream Stay With Modern Comfort' }}
            </h1>

            <p class="text-slate-200 text-lg leading-8 mb-8">
                {{ $hero->content ?? 'Book premium rooms, enjoy luxury facilities, and manage your stays easily through RoyalStay.' }}
            </p>

            <div class="flex flex-wrap gap-4 mb-10">
                <a href="#rooms"
                   class="bg-amber-400 text-slate-950 px-8 py-4 rounded-full font-extrabold hover:bg-amber-300 transition">
                    Explore Rooms
                </a>

                <a href="{{ route('register') }}"
                   class="border border-white/60 text-white px-8 py-4 rounded-full font-extrabold hover:bg-white hover:text-slate-950 transition">
                    Book Now
                </a>
            </div>

            <div class="grid grid-cols-3 gap-4 max-w-2xl">
                <div class="bg-white/10 backdrop-blur p-4 rounded-2xl text-white">
            <h3 class="stat-number text-2xl font-extrabold text-amber-400" data-target="50" data-suffix="+">0</h3>                    
            <p class="text-sm text-slate-200">Rooms</p>
                </div>

                <div class="bg-white/10 backdrop-blur p-4 rounded-2xl text-white">
            <h3 class="stat-number text-2xl font-extrabold text-amber-400" data-target="24" data-suffix="/7">0</h3>                    
            <p class="text-sm text-slate-200">Service</p>
                </div>

                <div class="bg-white/10 backdrop-blur p-4 rounded-2xl text-white">
                    <h3 class="stat-number text-2xl font-extrabold text-amber-400" data-target="100" data-suffix="%">0</h3>
                    <p class="text-sm text-slate-200">Secure</p>
                </div>
            </div>

        </div>
    </div>
</section>

<section id="about" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-14 items-center">

        <div data-aos="fade-right">
            <img src="{{ $aboutImage }}"
            class="rounded-[2rem] shadow-2xl w-full h-[430px] object-cover hover:scale-[1.02] transition duration-500"
            alt="Hotel">
        </div>

        <div data-aos="fade-left">
            <p class="text-amber-500 font-bold uppercase tracking-widest mb-3">
                About Us
            </p>

            <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6">
            {{ $about->title ?? 'A Modern Hotel Designed For Comfort' }}            
        </h2>

            <p class="text-slate-600 leading-8 mb-6">
                {{ $about->content ?? 'RoyalStay is a modern hotel platform designed to provide easy room booking, 
                comfortable stays, secure payments, and excellent services.' }}
            </p>

            <div class="flex flex-wrap gap-3 mb-6">
                <span class="bg-amber-100 text-amber-700 px-4 py-2 rounded-full font-bold text-sm">
                    Easy Booking
                </span>
                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-bold text-sm">
                    Secure Payments
                </span>
                <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-bold text-sm">
                    Premium Rooms
                </span>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-slate-100 p-6 rounded-3xl hover:shadow-xl transition">
                    <h3 class="font-extrabold text-slate-900 mb-2">{{ $mission->title ?? 'Mission' }}</h3>
                    <p class="text-sm text-slate-600">
                    {{ $mission->content ?? 'Provide excellent hotel service with simple digital access.' }}                    
                </p>
                </div>

                <div class="bg-slate-100 p-6 rounded-3xl hover:shadow-xl transition">
                    <h3 class="font-extrabold text-slate-900 mb-2">{{ $vision->title ?? 'Vision' }}</h3>
                    <p class="text-sm text-slate-600">
                    {{ $vision->content ?? 'Become a trusted modern hotel booking platform.' }}                    
                </p>
                </div>
            </div>
        </div>

    </div>
</section>

<section id="rooms" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="text-amber-500 font-bold uppercase tracking-widest">
                Our Rooms
            </p>

            <h2 class="text-5xl font-extrabold text-slate-900 mt-3">
                Featured Rooms
            </h2>
        </div>

        <div class="relative">

            <div class="overflow-hidden">
                <div id="roomSlider"
                     class="flex transition-transform duration-500 ease-out">

                    @forelse($rooms as $room)

                    <div class="shrink-0 basis-full md:basis-1/2 lg:basis-1/3 px-4">                            
                    <div data-aos="fade-up"
                            class="bg-white rounded-[2rem] overflow-hidden shadow-lg hover:-translate-y-2 hover:shadow-2xl transition duration-500">

                                <div class="overflow-hidden">
                                    <img src="{{ $room->image ? asset('storage/'.$room->image) : 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=900&q=80' }}"
                                         class="h-52 w-full object-cover hover:scale-110 transition duration-500"                                        
                                          alt="{{ $room->room_type }}"
                                         loading="lazy"
                                         decoding="async">
                                </div>

                                <div class="p-5">
                                    <div class="flex justify-between items-center mb-4">

        <h3 class="text-2xl font-black text-slate-900">
            {{ $room->room_type }}
        </h3>

        <span class="px-4 py-2 rounded-full text-sm font-bold
            {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : '' }}
            {{ $room->status == 'occupied' ? 'bg-red-100 text-red-700' : '' }}
            {{ $room->status == 'maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}">
            {{ ucfirst($room->status) }}
        </span>

                </div>

                                    <p class="text-slate-600 mb-5">
                                        {{ $room->description ?? 'Luxury room with premium comfort and facilities.' }}
                                    </p>

                                    <div class="flex flex-wrap gap-2 mb-6">
                                        <span class="bg-slate-100 px-3 py-2 rounded-full text-sm">WiFi</span>
                                        <span class="bg-slate-100 px-3 py-2 rounded-full text-sm">TV</span>
                                        <span class="bg-slate-100 px-3 py-2 rounded-full text-sm">Air Conditioning</span>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="text-2xl font-extrabold text-amber-500 hover:text-amber-600 transition">
                                                Rs. {{ number_format($room->price_per_night, 2) }}
                                            </h4>
                                            <span class="text-slate-500">/ night</span>
                                        </div>

                                        <a href="{{ route('rooms.details', $room->id) }}"
                                           class="bg-slate-950 text-white px-6 py-3 rounded-full font-bold hover:bg-amber-500 hover:text-black hover:scale-105 transition">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty

                        <p class="w-full text-center text-slate-500">
                            No featured rooms available.
                        </p>

                    @endforelse

                </div>
            </div>

            <button id="roomPrev"
                    type="button"
                    class="absolute top-1/2 -left-4 -translate-y-1/2 bg-slate-950 text-white w-12 h-12 rounded-full shadow-lg hover:bg-amber-400 hover:text-slate-950 transition">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <button id="roomNext"
                    type="button"
                    class="absolute top-1/2 -right-4 -translate-y-1/2 bg-slate-950 text-white w-12 h-12 rounded-full shadow-lg hover:bg-amber-400 hover:text-slate-950 transition">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

        </div>

        <div class="text-center mt-12">
            <a href="{{ route('rooms') }}"
               class="inline-block bg-amber-400 text-slate-950 px-8 py-4 rounded-full font-extrabold hover:bg-amber-300 transition">
                View All Rooms
            </a>
        </div>

    </div>
</section>

<section id="services" class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="text-amber-500 font-bold uppercase tracking-widest">
                Services
            </p>

            <h2 class="text-5xl font-extrabold text-slate-900 mt-3">
                Hotel Facilities
            </h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse($services as $service)

<div
    data-aos="zoom-in"
    class="group bg-slate-100 hover:bg-slate-950 hover:text-white rounded-[2rem] p-10 transition duration-500 hover:-translate-y-2 hover:shadow-2xl">

    @if($service->image)
        <img src="{{ asset('storage/' . $service->image) }}"
            alt="{{ $service->title ?? 'Service Image' }}"
            loading="lazy"
            decoding="async"
            class="w-full h-48 object-cover rounded-2xl mb-6">
    @endif

    <i class="{{ $service->icon }} text-amber-500 text-5xl mb-6"></i>

    <h3 class="text-3xl font-bold mb-4">
        {{ $service->title }}
    </h3>

    <p class="text-slate-500 group-hover:text-white">
        {{ $service->description }}
    </p>

</div>

@empty

<p class="col-span-3 text-center text-slate-500">
    No services available.
</p>

@endforelse

        </div>

    </div>

</section>

<section id="gallery" class="py-24 bg-slate-50">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <p class="text-amber-500 font-bold uppercase tracking-widest">
                Gallery
            </p>

            <h2 class="text-5xl font-extrabold text-slate-900 mt-3">
                Hotel Moments
            </h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

        @forelse($galleries as $gallery)

<div
    data-aos="fade-up"
    class="group relative rounded-[2rem] overflow-hidden shadow-lg h-72">

    <img src="{{ asset('storage/' . $gallery->image) }}"
         alt="{{ $gallery->title ?? 'Gallery Image' }}"
         loading="lazy"
         decoding="async"
         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">

    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end">

        <div class="p-5 text-white">

            <h3 class="text-2xl font-extrabold">
                {{ $gallery->title }}
            </h3>

            <p class="text-sm text-slate-200">
                {{ $gallery->category }}
            </p>

        </div>

    </div>

</div>

@empty

<div class="lg:col-span-4 bg-white rounded-3xl p-10 text-center shadow">

    <h3 class="text-2xl font-bold text-slate-900">
        No gallery images yet
    </h3>

    <p class="text-slate-500 mt-2">
        Gallery images will appear here after admin uploads them.
    </p>

</div>

@endforelse         


        </div>

    </div>

</section>

<section id="contact" class="bg-slate-950 py-24">

    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16">

        <div data-aos="fade-right">

            <p class="text-amber-400 font-bold uppercase tracking-widest mb-3">
                Contact
            </p>

            <h2 class="text-5xl font-extrabold text-white mb-8">
                {{ $contact->title ?? 'Get In Touch' }}
            </h2>

            <div class="space-y-6 text-slate-300">

                <p><i class="fa-solid fa-location-dot text-amber-400 mr-3"></i>{{ $contactParts[0] ?? 'Malabe, Sri Lanka' }}</p>

                <p><i class="fa-solid fa-phone text-amber-400 mr-3"></i>{{ $contactParts[1] ?? '+94 77 651 4545' }}</p>

                <p><i class="fa-solid fa-envelope text-amber-400 mr-3"></i>{{ $contactParts[2] ?? 'info@royalstay.com' }}</p>

            </div>

            <div class="mt-10 bg-white/10 p-6 rounded-3xl">
                <h4 class="text-white font-bold mb-3">Opening Hours</h4>
                <p class="text-slate-300">{{ $contactParts[3] ?? 'Mon - Sun : 24 Hours' }}</p>
            </div>

        </div>

        <div data-aos="fade-left">

            <div class="bg-white/10 backdrop-blur rounded-[2rem] p-8">

                @if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-5">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-5">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
    @csrf

    <input type="text"
           name="name"
           placeholder="Your Name"
           required
           class="w-full p-4 rounded-2xl border-2 border-transparent focus:border-amber-400 outline-none">

    <input type="email"
           name="email"
           placeholder="Your Email"
           required
           class="w-full p-4 rounded-2xl border-2 border-transparent focus:border-amber-400 outline-none">

    <textarea
        name="message"
        rows="5"
        placeholder="Message"
        required
        class="w-full p-4 rounded-2xl border-2 border-transparent focus:border-amber-400 outline-none"></textarea>

    <button
        type="submit"
        class="bg-amber-400 px-8 py-4 rounded-full font-extrabold hover:bg-amber-300 transition">
        Send Message
    </button>

</form>
            </div>

        </div>

    </div>

</section>

<footer class="bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950 border-t border-slate-800">

    <div class="max-w-7xl mx-auto px-6 py-20">

        <div class="grid lg:grid-cols-5 gap-12">

            {{-- Brand --}}
            <div class="lg:col-span-2">

                <h3 class="text-4xl font-extrabold text-white mb-4">
                {{ $footer->title ?? 'RoyalStay Hotel & Resort' }}
                    <span class="text-amber-400">.</span>
                </h3>

                <div class="w-20 h-1 bg-amber-400 rounded-full mb-6"></div>

                <p class="text-slate-400 leading-relaxed mb-6">
                    {{ $footer->content ?? 'Experience luxury, comfort and exceptional hospitality with RoyalStay. Book your dream stay with premium facilities and world-class service.' }}
                </p>

                <div class="flex items-center gap-8 text-slate-300">

                    <div>
                        <h5 class="text-2xl font-bold text-amber-400">50+</h5>
                        <p class="text-sm">Luxury Rooms</p>
                    </div>

                    <div>
                        <h5 class="text-2xl font-bold text-amber-400">24/7</h5>
                        <p class="text-sm">Support</p>
                    </div>

                    <div>
                        <h5 class="text-2xl font-bold text-amber-400">5★</h5>
                        <p class="text-sm">Service</p>
                    </div>

                </div>

            </div>

            {{-- Quick Links --}}
            <div>

                <h4 class="text-white font-bold text-lg mb-5">
                    Quick Links
                </h4>

                <div class="space-y-3">

                    <a href="#about"
                        class="block text-slate-400 hover:text-amber-400 transition duration-300">
                        About Us
                    </a>

                    <a href="#rooms"
                        class="block text-slate-400 hover:text-amber-400 transition duration-300">
                        Rooms
                    </a>

                    <a href="#services"
                        class="block text-slate-400 hover:text-amber-400 transition duration-300">
                        Services
                    </a>

                    <a href="#gallery"
                        class="block text-slate-400 hover:text-amber-400 transition duration-300">
                        Gallery
                    </a>

                    <a href="#contact"
                        class="block text-slate-400 hover:text-amber-400 transition duration-300">
                        Contact
                    </a>

                </div>

            </div>

            {{-- Why Choose Us --}}
            <div>

                <h4 class="text-white font-bold text-lg mb-5">
                    Why Choose Us
                </h4>

                <div class="space-y-3 text-slate-400">

                    <p>
                        <i class="fa-solid fa-bed text-amber-400 mr-2"></i>
                        Luxury Rooms
                    </p>

                    <p>
                        <i class="fa-solid fa-headset text-amber-400 mr-2"></i>
                        24/7 Service
                    </p>

                    <p>
                        <i class="fa-solid fa-shield-halved text-amber-400 mr-2"></i>
                        Secure Booking
                    </p>

                    <p>
                        <i class="fa-solid fa-utensils text-amber-400 mr-2"></i>
                        Premium Dining
                    </p>

                </div>

            </div>

            {{-- Contact --}}
            <div>

                <h4 class="text-white font-bold text-lg mb-5">
                    Contact
                </h4>

                <div class="space-y-4 text-slate-400">

    {{-- Location --}}
    <p>
        <i class="fa-solid fa-location-dot text-amber-400 mr-2"></i>
        {{ $contactParts[0] ?? 'Malabe, Sri Lanka' }}
    </p>

    {{-- Phone --}}
    <p>
        <i class="fa-solid fa-phone text-amber-400 mr-2"></i>

        <a href="tel:{{ preg_replace('/\s+/', '', $contactParts[1] ?? '+94765614545') }}"
           class="hover:text-amber-400 transition">
            {{ $contactParts[1] ?? '+94 76 561 4545' }}
        </a>
    </p>

    {{-- Email --}}
    <p>
        <i class="fa-solid fa-envelope text-amber-400 mr-2"></i>

        <a href="mailto:{{ $contactParts[2] ?? 'info@royalstay.com' }}"
           class="hover:text-amber-400 transition">
            {{ $contactParts[2] ?? 'info@royalstay.com' }}
        </a>
    </p>

</div>

            </div>

        </div>

    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-slate-800">

        <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row justify-between items-center gap-4">

            <p class="text-slate-500 text-center md:text-left">
                © {{ date('Y') }} RoyalStay Hotel & Resort. All Rights Reserved.
            </p>

            <div class="flex gap-5 text-xl">

                <a href="https://www.facebook.com/share/1DqCn5Ubdz/"
                    class="text-slate-400 hover:text-amber-400 hover:scale-125 transition duration-300">
                    <i class="fab fa-facebook"></i>
                </a>

                <a href="https://www.instagram.com/_.lakiyaaa?igsh=MXA5MGs5ZXJsaHFiaQ=="
                    class="text-slate-400 hover:text-amber-400 hover:scale-125 transition duration-300">
                    <i class="fab fa-instagram"></i>
                </a>

                <a href="https://www.youtube.com/@LakinduRansika-sw2mc"
                    class="text-slate-400 hover:text-amber-400 hover:scale-125 transition duration-300">
                    <i class="fab fa-youtube"></i>
                </a>

                <a href="https://www.linkedin.com/in/lakindu-ransika-?lipi=urn%3Ali%3Apage%3Ad_flagship3_profile_view_base_contact_details%3BXJ6vf0c%2BQ5mp0iiURnxibA%3D%3D"
                    class="text-slate-400 hover:text-amber-400 hover:scale-125 transition duration-300">
                    <i class="fab fa-linkedin"></i>
                </a>

            </div>

        </div>

    </div>

</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
AOS.init({
    duration: 700,
    once: true,
    offset: 80,
    easing: 'ease-out'
});

const btn = document.getElementById('mobileMenuBtn');
const menu = document.getElementById('mobileMenu');

btn?.addEventListener('click', () => {
    menu?.classList.toggle('hidden');
});

document.querySelectorAll('.mobile-link').forEach(link => {
    link.addEventListener('click', () => {
        menu?.classList.add('hidden');
    });
});

// Hero Slider
const heroSlider = document.getElementById('heroSlider');

if (heroSlider) {
    const heroImages = JSON.parse(heroSlider.dataset.images);
    let currentHero = 0;

    setInterval(() => {
        currentHero = (currentHero + 1) % heroImages.length;

        heroSlider.style.opacity = 0;

        setTimeout(() => {
            heroSlider.style.backgroundImage =
                `linear-gradient(rgba(2,6,23,0.72), rgba(2,6,23,0.82)), url('${heroImages[currentHero]}')`;

            heroSlider.style.opacity = 1;
        }, 600);
    }, 5000);
}

// Animated Stats Counter
const statNumbers = document.querySelectorAll('.stat-number');
let statsStarted = false;

function animateStats() {
    if (statsStarted) return;

    const statsSection = statNumbers[0]?.closest('.grid');

    if (!statsSection) return;

    const position = statsSection.getBoundingClientRect().top;

    if (position < window.innerHeight - 100) {
        statsStarted = true;

        statNumbers.forEach(stat => {
            const target = Number(stat.dataset.target);
            const suffix = stat.dataset.suffix || '';
            let current = 0;
            const increment = Math.ceil(target / 50);

            const counter = setInterval(() => {
                current += increment;

                if (current >= target) {
                    current = target;
                    clearInterval(counter);
                }

                stat.textContent = current + suffix;
            }, 30);
        });
    }
}

window.addEventListener('scroll', animateStats);
window.addEventListener('load', animateStats);

// Room Slider
const roomSlider = document.getElementById('roomSlider');
const roomPrev = document.getElementById('roomPrev');
const roomNext = document.getElementById('roomNext');

let roomIndex = 0;

function getVisibleRooms() {
    if (window.innerWidth >= 1024) return 3;
    if (window.innerWidth >= 768) return 2;
    return 1;
}

function updateRoomSlider() {
    if (!roomSlider) return;

    const totalRooms = roomSlider.children.length;
    const visibleRooms = getVisibleRooms();
    const maxIndex = Math.max(totalRooms - visibleRooms, 0);

    if (roomIndex > maxIndex) {
        roomIndex = maxIndex;
    }

    const slideWidth = 100 / visibleRooms;
    roomSlider.style.transform = `translateX(-${roomIndex * slideWidth}%)`;
}

roomNext?.addEventListener('click', () => {
    const totalRooms = roomSlider.children.length;
    const visibleRooms = getVisibleRooms();
    const maxIndex = Math.max(totalRooms - visibleRooms, 0);

    roomIndex = roomIndex >= maxIndex ? 0 : roomIndex + 1;
    updateRoomSlider();
});

roomPrev?.addEventListener('click', () => {
    const totalRooms = roomSlider.children.length;
    const visibleRooms = getVisibleRooms();
    const maxIndex = Math.max(totalRooms - visibleRooms, 0);

    roomIndex = roomIndex <= 0 ? maxIndex : roomIndex - 1;
    updateRoomSlider();
});

window.addEventListener('resize', updateRoomSlider);
window.addEventListener('load', updateRoomSlider);

</script>

</body>
</html>