<div class="d-flex input-group justify-self-end" style="width: 18rem;">
    <x-search.input class="form-control" target="search-papers" placeholder="Search..." aria-label="Search" />
</div>
@script
<script>
    $wire.on('search', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript
