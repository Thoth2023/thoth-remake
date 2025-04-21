<div class="d-flex gap-1 mb-3">
    <b>{{ __('project/conducting.data-extraction.modal.status-extraction' )}}: </b>
    <b class="{{ 'text-' . strtolower($status_description) }}">
        {{ __("project/conducting.data-extraction.status." . strtolower($status_description)) }}
    </b>
</div>
@script
<script>
    $wire.on('paper-status', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>

<h2 class="text-xl font-semibold mt-10 mb-4">📝 Minhas Anotações</h2>
@livewire('notes')

@endscript
