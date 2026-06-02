<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Luxury Hotel Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS Animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    <style>
        html {
            scroll-behavior: smooth;
        }

        .hero-bg {
            background:
                linear-gradient(rgba(2, 6, 23, 0.75), rgba(2, 6, 23, 0.75)),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

<!-- Navbar -->
<header class="fixed top-0 left-0 w-full z-50 bg-slate-950/90 backdrop-blur border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <a href="{{ route('home') }}" class="text-2xl font-bold text-white">
            RoyalStay<span class="text-amber-400">.</span>
        </a>

        <nav class="hidden md:flex items-center gap-7 text-sm font-medium text-slate-200">
            <a href="#home" class="hover:text-amber-400">Home</a>
            <a href="#about" class="hover:text-amber-400">About</a>
            <a href="#rooms" class="hover:text-amber-400">Rooms</a>
            <a href="#services" class="hover:text-amber-400">Services</a>
            <a href="#gallery" class="hover:text-amber-400">Gallery</a>
            <a href="#contact" class="hover:text-amber-400">Contact</a>
        </nav>

        <div class="hidden md:flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-white hover:text-amber-400">
                Login
            </a>
            <a href="{{ route('register') }}" class="bg-amber-400 text-slate-950 px-5 py-2 rounded-full font-semibold hover:bg-amber-300">
                Register
            </a>
        </div>

    </div>
</header>

<!-- Hero -->
<section id="home" class="hero-bg min-h-screen flex items-center">
    <div class="max-w-7xl mx-auto px-6 pt-24">
        <div class="max-w-3xl" data-aos="fade-up">
            <p class="text-amber-400 uppercase tracking-[0.3em] mb-4 font-semibold">
                Luxury Hotel Experience
            </p>

            <h1 class="text-5xl md:text-7xl font-extrabold text-white leading-tight mb-6">
                Enjoy Your Dream Stay With Modern Comfort
            </h1>

            <p class="text-slate-200 text-lg mb-8">
                Book beautiful rooms, enjoy premium services, and manage your stays through a modern hotel management system.
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="#rooms" class="bg-amber-400 text-slate-950 px-7 py-3 rounded-full font-bold hover:bg-amber-300">
                    Explore Rooms
                </a>

                <a href="{{ route('register') }}" class="border border-white text-white px-7 py-3 rounded-full font-bold hover:bg-white hover:text-slate-950">
                    Book Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- About -->
<section id="about" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

        <div data-aos="fade-right">
            <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1000&q=80"
                 class="rounded-3xl shadow-xl"
                 alt="Hotel Lobby">
        </div>

        <div data-aos="fade-left">
            <p class="text-amber-500 font-bold uppercase tracking-widest mb-3">About Us</p>

            <h2 class="text-4xl font-extrabold text-slate-900 mb-5">
                A Modern Hotel Designed For Comfort
            </h2>

            <p class="text-slate-600 leading-8 mb-6">
                RoyalStay is a modern hotel platform designed to provide customers with easy room booking,
                comfortable stays, secure payments, and excellent services.
            </p>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-100 p-5 rounded-2xl">
                    <h3 class="font-bold text-slate-900 mb-2">Mission</h3>
                    <p class="text-sm text-slate-600">Provide excellent hotel service with easy digital access.</p>
                </div>

                <div class="bg-slate-100 p-5 rounded-2xl">
                    <h3 class="font-bold text-slate-900 mb-2">Vision</h3>
                    <p class="text-sm text-slate-600">Become a trusted modern hotel booking platform.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Rooms -->
<section id="rooms" class="py-24 bg-slate-100">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14" data-aos="fade-up">
            <p class="text-amber-500 font-bold uppercase tracking-widest mb-3">Our Rooms</p>
            <h2 class="text-4xl font-extrabold text-slate-900">Featured Rooms</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse($rooms as $room)
                <div class="bg-white rounded-3xl overflow-hidden shadow hover:shadow-2xl transition" data-aos="zoom-in">

                    <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
                         class="h-60 w-full object-cover"
                         alt="Room Image">

                    <div class="p-6">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-xl font-bold text-slate-900">
                                {{ $room->room_type }}
                            </h3>

                            <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                {{ ucfirst($room->status) }}
                            </span>
                        </div>

                        <p class="text-slate-600 text-sm mb-4">
                            {{ $room->description }}
                        </p>

                        <div class="flex flex-wrap gap-2 mb-5">
                            @if(is_array($room->facilities))
                                @foreach($room->facilities as $facility)
                                    <span class="text-xs bg-slate-100 px-3 py-1 rounded-full">
                                        {{ $facility }}
                                    </span>
                                @endforeach
                            @endif
                        </div>

                        <div class="flex justify-between items-center">
                            <p class="text-amber-500 font-extrabold text-xl">
                                Rs. {{ number_format($room->price_per_night, 2) }}
                                <span class="text-sm text-slate-500 font-normal">/ night</span>
                            </p>

                            <a href="{{ route('login') }}" class="bg-slate-950 text-white px-4 py-2 rounded-full text-sm hover:bg-amber-500 hover:text-slate-950">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center col-span-3 text-slate-500">No rooms available yet.</p>
            @endforelse
        </div>

    </div>
</section>

<!-- Services -->
<section id="services" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14" data-aos="fade-up">
            <p class="text-amber-500 font-bold uppercase tracking-widest mb-3">Services</p>
            <h2 class="text-4xl font-extrabold text-slate-900">Hotel Facilities</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">

            @php
                $services = [
                    ['icon' => 'fa-utensils', 'title' => 'Restaurant', 'desc' => 'Enjoy delicious meals prepared by professional chefs.'],
                    ['icon' => 'fa-person-swimming', 'title' => 'Swimming Pool', 'desc' => 'Relax and refresh yourself in our luxury pool.'],
                    ['icon' => 'fa-dumbbell', 'title' => 'Gym', 'desc' => 'Stay fit during your vacation with modern equipment.'],
                    ['icon' => 'fa-spa', 'title' => 'Spa', 'desc' => 'Experience relaxing spa treatments and wellness care.'],
                    ['icon' => 'fa-building', 'title' => 'Conference Hall', 'desc' => 'Perfect spaces for business meetings and events.'],
                    ['icon' => 'fa-bell-concierge', 'title' => 'Room Service', 'desc' => 'Fast and friendly service directly to your room.'],
                ];
            @endphp

            @foreach($services as $service)
                <div class="bg-slate-100 p-8 rounded-3xl hover:bg-slate-950 hover:text-white transition" data-aos="fade-up">
                    <i class="fa-solid {{ $service['icon'] }} text-4xl text-amber-500 mb-5"></i>
                    <h3 class="text-xl font-bold mb-3">{{ $service['title'] }}</h3>
                    <p class="text-sm opacity-80">{{ $service['desc'] }}</p>
                </div>
            @endforeach

        </div>
    </div>
</section>

<!-- Gallery -->
<section id="gallery" class="py-24 bg-slate-100">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14" data-aos="fade-up">
            <p class="text-amber-500 font-bold uppercase tracking-widest mb-3">Gallery</p>
            <h2 class="text-4xl font-extrabold text-slate-900">Hotel Moments</h2>
        </div>

        <div class="grid md:grid-cols-4 gap-5">
            @foreach([
                'photo-1564501049412-61c2a3083791',
                'photo-1542314831-068cd1dbfeeb',
                'photo-1578683010236-d716f9a3f461',
                'photo-1582719508461-905c673771fd'
            ] as $photo)
                <img src="https://images.unsplash.com/{{ $photo }}?auto=format&fit=crop&w=600&q=80"
                     class="h-64 w-full object-cover rounded-3xl shadow hover:scale-105 transition"
                     alt="Hotel Gallery"
                     data-aos="zoom-in">
            @endforeach
        </div>

    </div>
</section>

<!-- Contact -->
<section id="contact" class="py-24 bg-slate-950 text-white">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12">

        <div data-aos="fade-right">
            <p class="text-amber-400 font-bold uppercase tracking-widest mb-3">Contact</p>
            <h2 class="text-4xl font-extrabold mb-6">Get In Touch</h2>

            <div class="space-y-4 text-slate-300">
                <p><i class="fa-solid fa-location-dot text-amber-400 mr-3"></i> Maharagama, Sri Lanka</p>
                <p><i class="fa-solid fa-phone text-amber-400 mr-3"></i> +94 77 123 4567</p>
                <p><i class="fa-solid fa-envelope text-amber-400 mr-3"></i> info@royalstay.com</p>
            </div>
        </div>

        <form class="bg-white/10 backdrop-blur p-8 rounded-3xl" data-aos="fade-left">
            <input type="text" placeholder="Your Name" class="w-full mb-4 px-4 py-3 rounded-xl text-slate-900">
            <input type="email" placeholder="Your Email" class="w-full mb-4 px-4 py-3 rounded-xl text-slate-900">
            <textarea placeholder="Message" rows="4" class="w-full mb-4 px-4 py-3 rounded-xl text-slate-900"></textarea>

            <button type="button" class="bg-amber-400 text-slate-950 px-6 py-3 rounded-full font-bold hover:bg-amber-300">
                Send Message
            </button>
        </form>

    </div>
</section>

<!-- Footer -->
<footer class="bg-slate-900 text-slate-400 py-6 text-center">
    <p>© {{ date('Y') }} RoyalStay Hotel Management System. All Rights Reserved.</p>
</footer>

<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 900,
        once: true
    });
</script>

</body>
</html>