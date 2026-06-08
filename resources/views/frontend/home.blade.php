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

<header class="fixed top-0 left-0 w-full z-50 glass-nav border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <a href="{{ route('home') }}" class="text-2xl font-extrabold text-white">
            RoyalStay<span class="text-amber-400">.</span>
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

    <div class="absolute inset-0 hero-slide"
         style="background-image:
         linear-gradient(rgba(2,6,23,0.72), rgba(2,6,23,0.82)),
         url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80');">
    </div>

    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/70 via-slate-950/30 to-transparent"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 pt-28">
        <div class="max-w-3xl" data-aos="fade-up">

            <p class="text-amber-400 uppercase tracking-[0.35em] mb-4 font-bold">
                Luxury Hotel Experience
            </p>

            <h1 class="text-5xl md:text-7xl font-extrabold text-white leading-tight mb-6">
                Enjoy Your Dream Stay With Modern Comfort
            </h1>

            <p class="text-slate-200 text-lg leading-8 mb-8">
                Book premium rooms, enjoy luxury facilities, and manage your stays easily through RoyalStay.
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
                    <h3 class="text-2xl font-extrabold text-amber-400">50+</h3>
                    <p class="text-sm text-slate-200">Rooms</p>
                </div>

                <div class="bg-white/10 backdrop-blur p-4 rounded-2xl text-white">
                    <h3 class="text-2xl font-extrabold text-amber-400">24/7</h3>
                    <p class="text-sm text-slate-200">Service</p>
                </div>

                <div class="bg-white/10 backdrop-blur p-4 rounded-2xl text-white">
                    <h3 class="text-2xl font-extrabold text-amber-400">100%</h3>
                    <p class="text-sm text-slate-200">Secure</p>
                </div>
            </div>

        </div>
    </div>
</section>

<section id="about" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-14 items-center">

        <div data-aos="fade-right">
            <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1000&q=80"
                 class="rounded-[2rem] shadow-2xl w-full h-[430px] object-cover"
                 alt="Hotel Lobby">
        </div>

        <div data-aos="fade-left">
            <p class="text-amber-500 font-bold uppercase tracking-widest mb-3">
                About Us
            </p>

            <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6">
                A Modern Hotel Designed For Comfort
            </h2>

            <p class="text-slate-600 leading-8 mb-6">
                RoyalStay is a modern hotel platform designed to provide easy room booking,
                comfortable stays, secure payments, and excellent services.
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
                    <h3 class="font-extrabold text-slate-900 mb-2">Mission</h3>
                    <p class="text-sm text-slate-600">
                        Provide excellent hotel service with simple digital access.
                    </p>
                </div>

                <div class="bg-slate-100 p-6 rounded-3xl hover:shadow-xl transition">
                    <h3 class="font-extrabold text-slate-900 mb-2">Vision</h3>
                    <p class="text-sm text-slate-600">
                        Become a trusted modern hotel booking platform.
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

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse($rooms as $room)

            <div
                data-aos="fade-up"
                class="bg-white rounded-[2rem] overflow-hidden shadow-lg hover:-translate-y-2 hover:shadow-2xl transition duration-500">

                <img src="{{ $room->image ? asset('storage/'.$room->image) : 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=900&q=80' }}"
                     class="h-64 w-full object-cover"
                     alt="{{ $room->room_type }}">

                <div class="p-7">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-3xl font-extrabold text-slate-900">
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
                            <h4 class="text-3xl font-extrabold text-amber-500">
                                Rs. {{ number_format($room->price_per_night, 2) }}
                            </h4>
                            <span class="text-slate-500">/ night</span>
                        </div>

                        <a href="{{ route('rooms.details', $room->id) }}"
                           class="bg-slate-950 text-white px-6 py-3 rounded-full font-bold hover:bg-amber-500 hover:text-black transition">
                            View
                        </a>
                    </div>

                </div>

            </div>

            @empty
            <p class="col-span-3 text-center text-slate-500">
            No featured rooms available.
            </p>
            @endforelse

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

            @php
            $services = [
                ['Restaurant','fa-utensils'],
                ['Swimming Pool','fa-person-swimming'],
                ['Gym','fa-dumbbell'],
                ['Spa','fa-spa'],
                ['Conference Hall','fa-building'],
                ['Room Service','fa-bell-concierge']
            ];
            @endphp

            @foreach($services as $service)

            <div
                data-aos="zoom-in"
                class="group bg-slate-100 hover:bg-slate-950 hover:text-white rounded-[2rem] p-10 transition duration-500 hover:-translate-y-2 hover:shadow-2xl">                     
                <i class="fa-solid {{ $service[1] }} text-amber-500 text-5xl mb-6"></i>

                <h3 class="text-3xl font-bold mb-4">
                    {{ $service[0] }}
                </h3>

                <p class="text-slate-500 group-hover:text-white">
                    Enjoy premium hotel facilities and world-class service.
                </p>

            </div>

            @endforeach

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

            @php
            $gallery = [
            ['Luxury Pool','https://images.unsplash.com/photo-1578683010236-d716f9a3f461'],
            ['Modern Room','https://images.unsplash.com/photo-1566073771259-6a8506099945'],
            ['Beach View','https://images.unsplash.com/photo-1542314831-068cd1dbfeeb'],
            ['Premium Stay','https://images.unsplash.com/photo-1582719478250-c89cae4dc85b']
            ];
            @endphp

            @foreach($gallery as $image)

            <div
                data-aos="fade-up"
                class="relative overflow-hidden rounded-[2rem] group">

                <img src="{{ $image[1] }}?auto=format&fit=crop&w=800&q=80"
                     class="h-80 w-full object-cover group-hover:scale-110 transition duration-700">

                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">

                    <h3 class="text-white text-2xl font-extrabold">
                        {{ $image[0] }}
                    </h3>

                </div>

            </div>

            @endforeach

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
                Get In Touch
            </h2>

            <div class="space-y-6 text-slate-300">

                <p><i class="fa-solid fa-location-dot text-amber-400 mr-3"></i>Malabe, Sri Lanka</p>

                <p><i class="fa-solid fa-phone text-amber-400 mr-3"></i>+94 77 651 4545</p>

                <p><i class="fa-solid fa-envelope text-amber-400 mr-3"></i>info@royalstay.com</p>

            </div>

            <div class="mt-10 bg-white/10 p-6 rounded-3xl">
                <h4 class="text-white font-bold mb-3">Opening Hours</h4>
                <p class="text-slate-300">Mon - Sun : 24 Hours</p>
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

<footer class="bg-slate-900 border-t border-slate-800">

    <div class="max-w-7xl mx-auto px-6 py-16 grid md:grid-cols-4 gap-10">

        <div>
            <h3 class="text-3xl font-extrabold text-white mb-4">
                RoyalStay<span class="text-amber-400">.</span>
            </h3>

            <p class="text-slate-400">
                Luxury hotel experience with premium facilities and secure online booking.
            </p>
        </div>

        <div>
            <h4 class="text-white font-bold mb-4">Quick Links</h4>

            <div class="space-y-2 text-slate-400">
                <a href="#about" class="block">About</a>
                <a href="#rooms" class="block">Rooms</a>
                <a href="#services" class="block">Services</a>
                <a href="#contact" class="block">Contact</a>
            </div>
        </div>

        <div>
            <h4 class="text-white font-bold mb-4">Contact</h4>

            <div class="space-y-2 text-slate-400">
                <p>Malabe, Sri Lanka</p>
                <p>+94 77 651 4545</p>
                <p>info@royalstay.com</p>
            </div>
        </div>

        <div>
            <h4 class="text-white font-bold mb-4">Follow Us</h4>

            <div class="flex gap-4 text-2xl text-amber-400">
                <i class="fab fa-facebook"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-youtube"></i>
            </div>
        </div>

    </div>

    <div class="border-t border-slate-800 py-6 text-center text-slate-400">
        © {{ date('Y') }} RoyalStay Hotel Management System. All Rights Reserved.
    </div>

</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
AOS.init({
    duration: 1000,
    once: true
});

const btn = document.getElementById('mobileMenuBtn');
const menu = document.getElementById('mobileMenu');

btn?.addEventListener('click', () => {
    menu?.classList.toggle('hidden');
});
</script>

</body>
</html>