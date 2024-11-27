<div>
    <div class="flex my-2 justify-between">
        <div>
            <x-text-input type="text" wire:model.live.debounce.300ms="search" placeholder="Search for a user" />
        </div>
        <div class="my-2"><x-primary-button><a href="{{ route('create-worker') }}">Tambah
                    Pengguna</a></x-primary-button></div>
    </div>

    <table class="min-w-full border border-gray-700 bg-white overflow-hidden">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="p-4 border border-gray-700 text-left">Bil</th>
                <th class="p-4 border border-gray-700 text-left">Nama Penuh</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $item)
                <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                    <td class="p-4 border border-b border-gray-700">{{ $loop->iteration }}</td>
                    <td class="p-4 border border-b border-gray-700">
                        <div class=" flex justify-between">
                            <div><a href="{{ route('user-report', [$item->id]) }}">{{ $item->name }}</a></div>
                            <div>
                                <x-secondary-button>
                                    <a href="{{ route('user-info', [$item->id]) }}">Edit</a>
                                </x-secondary-button>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="p-4 text-center text-gray-500">Tiada dalam data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $users->links() }}

</div>
