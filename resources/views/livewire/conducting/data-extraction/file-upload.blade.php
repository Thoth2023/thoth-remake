<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="file">
        Selecione o arquivo (.bib ou .csv)
    </label>
    <input type="file" wire:model="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" accept=".bib,.csv,text/plain,application/csv" required>
    @error('file') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
</div> 