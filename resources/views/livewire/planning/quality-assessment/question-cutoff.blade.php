<div>
    <hr class="mt-0" />
    <div class="card-header py-0">
        <x-helpers.modal
            target="question-quality"
            modalTitle="Minimal Score to Approve"
            modalContent="hahaha"
        />
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
            <x-input
                id="question-quality-id"
                label="Soma dos Pesos"
                placeholder="0"
                pattern="[A-Za-z]{3}"
                disabled
            />
            <x-input
                id="weight"
                label="Cutoff"
                type="number"
                maxlength="3"
                min="0"
                placeholder="2"
            />
        </div>
    </div>
</div>

<script>
    function limit(element, maxLength = 10) {
        const value = element.value.toString();

        if (value.length > maxLength) {
            element.value = value.slice(0, maxLength);
        }
    }

    document
        .querySelector('input[id="weight"]')
        .addEventListener('input', function () {
            limit(this, 10);
        });
</script>
