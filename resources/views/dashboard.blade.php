<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->name }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 gap-6">
            <!-- Resim Yükleme Formu Kartı -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Gülümseme Tespiti için Resim Yükle</h2>
                <form action="{{ route('smile.detect') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700">Resim Yükle</label>
                        <input type="file" id="image" name="image" accept="image/*" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-600">Gülümseme Tespit Et</button>
                    </div>
                </form>
            </div>

            <!-- Son Yüklenen Gülümseme Tespiti Kartı -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Son Yüklenen Gülümseme Tespiti</h2>

                @if($lastUpload && count($lastUpload) > 0)
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold mb-4">Son Yüklenen Resim</h3>
                        <img src="{{ asset('storage/' . $lastUpload->image_path) }}" alt="Uploaded Image" class="rounded-lg mb-4 w-64 h-64 object-cover">

                        <h3 class="text-xl font-semibold">Gülümseme Tespiti</h3>
                        @if($lastUpload->smile_detected)
                            <p class="text-green-500 font-bold">Gülümseme tespit edildi! 😊</p>
                        @else
                            <p class="text-red-500 font-bold">Gülümseme tespit edilmedi.</p>
                        @endif
                    </div>
                @else
                    <p class="text-gray-600">Henüz bir resim Yüklenmedi.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
