<div class="relative my-4 mx-7 px-5 py-3 bg-white shadow-md">
    <form wire:submit="update" method="get">
        @csrf
        <x-input-label for="name">Nama</x-input-label>
        <x-text-input id="name" wire:model="name" placehorder="Nama Penuh" />
        @error('name')
            <div class="text-red-600">{{ $message }}</div>
        @enderror
        <x-input-label for="email">Email</x-input-label>
        <x-text-input wire:model="email" placehorder="Email" />
        @error('email')
            <div class="text-red-600">{{ $message }}</div>
        @enderror
        <x-input-label for="password">Password</x-input-label>
        <x-text-input type="password" wire:model="password" placehorder="password" />
        @error('password')
            <div class="text-red-600">{{ $message }}</div>
        @enderror
        <x-primary-button>Tambah</x-primary-button>
    </form>
    <form class="absolute pt-3 top-0 right-4" wire:submit='delete' wire:confirm='Are you sure to delete?' method="get">
        <x-secondary-button class=" text-red-600" type="submit">Delete</x-secondary-button>
    </form>
</div>
