<x-card>
    <x-header title="Edit Barang Masuk" class="px-3 pt-3" size="text-2xl" separator>
        <x-slot:actions>
            <x-button label="Kembali" icon-left="o-arrow-left" wire:click="goBack" class="btn-outline" />
        </x-slot:actions>
    </x-header>

    <form wire:submit.prevent="updateItem" class="p-4 space-y-4">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <x-input label="Nama Barang" wire:model="item.name" placeholder="Masukkan nama barang" />
            <x-input label="Jumlah" wire:model="item.quantity" type="number" min="1" placeholder="Masukkan jumlah" />
            <x-input label="Harga Satuan" wire:model="item.price" type="number" min="0" placeholder="Masukkan harga satuan" />
            <x-select label="Kategori" wire:model="item.category_id" placeholder="Pilih kategori">
                <!-- Isi dengan opsi kategori yang tersedia -->
            </x-select>
        </div>

        <x-textarea label="Deskripsi" wire:model="item.description" placeholder="Masukkan deskripsi barang" />

        <x-file label="Foto Barang" wire:model="newImage" accept="image/*" />

        @if($item->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $item->image) }}" alt="Foto Barang" class="object-cover w-32 h-32 rounded">
            </div>
        @endif

        <div class="flex justify-end space-x-2">
            <x-button label="Batal" wire:click="cancel" class="btn-ghost" />
            <x-button type="submit" label="Simpan Perubahan" icon-right="o-paper-airplane" class="btn-primary" />
        </div>
    </form>
</x-card>
