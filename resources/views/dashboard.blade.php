<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <p class="text-gray-600 mb-6">
                        Manage your attendance by checking in and checking out.
                        Use the button below to perform the action based on your current status.
                    </p>
                    <livewire:worker-dashboard />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
