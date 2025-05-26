<div>
    <form wire:submit.prevent="save">
        <div>
            <label for="titulo">Título do Projeto</label>
            <input type="text" id="titulo" wire:model="titulo">
            @error('titulo') <span style="color: red">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>
                <input type="checkbox" wire:model="avaliacao_pares">
                Avaliação por Pares
            </label>
        </div>

        <div>
            <label>
                <input type="checkbox" wire:model="revisor">
                Revisor
            </label>
        </div>

        <div>
            <label>
                <input type="checkbox" wire:model="publico">
                Projeto Público
            </label>
        </div>

        <div wire:ignore>
            <label>Descrição do Projeto</label>
            <div id="quill-editor" style="height: 200px;"></div>
        </div>
        <input type="hidden" id="descricao" wire:model="descricao">

        <button type="submit">Salvar Projeto</button>
    </form>

    @if (session()->has('message'))
        <p style="color: green">{{ session('message') }}</p>
    @endif
</div>

<!-- QuillJS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    document.addEventListener('livewire:load', function () {
        const quill = new Quill('#quill-editor', { theme: 'snow' });

        quill.on('text-change', function () {
            const html = quill.root.innerHTML;
            document.getElementById('descricao').value = html;
            @this.set('descricao', html);
        });

        // Atualiza o editor com o conteúdo carregado
        Livewire.hook('message.processed', () => {
            const conteudo = @this.get('descricao');
            if (conteudo && quill.root.innerHTML !== conteudo) {
                quill.root.innerHTML = conteudo;
            }
        });
    });
</script>
