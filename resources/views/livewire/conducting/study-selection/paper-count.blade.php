<strong>({{ $this->paperCount }} papers)</strong>
@script
<script>
    $wire.on('paper-count', ([{ message, type }]) => {
        toasty({ message, type });
    });
</script>
@endscript


