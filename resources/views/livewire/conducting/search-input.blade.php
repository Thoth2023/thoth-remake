<div>
   <!-- resources/views/components/search-input.blade.php -->
<div class="form-group my-3">
    <input type="text" class="form-control" id="searchInput" placeholder="Search studies">
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const title = row.children[1].textContent.toLowerCase();
            if (title.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

</div>
