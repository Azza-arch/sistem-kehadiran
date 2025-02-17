<div class="sm:fixed sm:top-0 sm:right-0 p-6 text-end z-10">

    @auth
        @if (Auth::user()->email !== 'syed@gmail.com')
            <a href="{{ url('/dashboard') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                wire:navigate>Dashboard</a>
        @else
            <a href="{{ url('/home') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                wire:navigate>Dashboard</a>
        @endif
    @else
        <a href="{{ route('login') }}"
            class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
            wire:navigate>Log in</a>
    @endauth
</div>
