{{-- Uses the main authenticated user layout --}}
<x-app-layout>

    {{-- Header section shown at the top of the page --}}
    <x-slot name="header">

        {{-- Dashboard page title --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>

    </x-slot>

    {{-- Main page content area --}}
    <div class="py-12">

        {{-- Centers content and limits maximum width --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- White card container --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Card content --}}
                <div class="p-6 text-gray-900">

                    {{-- Display login success message --}}
                    {{ __("You're logged in!") }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>