<x-app-layout>
    {{-- ?CRUD Maklumat Pekerja --}}
    <div class="justify-center items-center">
        <h1 class="my-4 mx-7">Edit Pengguna {{ $user->name }}</h1>
      <div class="my-3">  <livewire:worker-info :userId='$user->id' /></div>
    </div>
</x-app-layout>
