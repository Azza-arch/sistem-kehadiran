<div>
    <form wire:submit.prevent="in_out">
        @if ($attendance)
            <x-primary-button type="submit">Check Out</x-primary-button>
        @else
        <input type="text" class="rounded-md" wire:model="catatan" placeholder="Tulis nota sekira lambat">
            <x-primary-button type="submit">Check In</x-primary-button>
        @endif
    </form>
    {{-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}
</div>
