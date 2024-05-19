<div>
    <h1>Import Studies</h1>

    <!-- Seleção da database -->
    <div>
        <label for="database">Database:</label>
        <select id="database" wire:model="selectedDatabase">
            <option value="">Select Database</option>
            @foreach($databases as $database)
                <option value="{{ $database->id }}">{{ $database->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Upload de um arquivo -->
    <div>
        <label for="file">Choose file:</label>
        <input type="file" id="file" wire:model="file">
    </div>

    <!-- Botão de adicionar -->
    <div>
        <button wire:click="import">Adicionar</button>
    </div>

    <!-- Feedback para o usuário -->
    <div>
        @if (session()->has('message'))
            <p>{{ session('message') }}</p>
        @endif
        @error('file') <span class="error">{{ $message }}</span> @enderror
    </div>

    <!-- Lista de estudos importados -->
    <h2>Imported Studies</h2>
    <table>
        <thead>
            <tr>
                <th>Database</th>
                <th>Filename</th>
                <th>Imported Count</th>
                <th>Failed Imports</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($conducting as $study)
                <tr>
                    <td>{{ $study->database->name }}</td>
                    <td>{{ $study->file_name }}</td>
                    <td>{{ $study->imported_studies_count }}</td>
                    <td>{{ $study->failed_imports_count }}</td>
                    <td>
                        <button wire:click="delete({{ $study->id_importStudy }})">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>