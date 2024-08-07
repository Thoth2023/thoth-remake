<div>
   <!-- resources/views/components/export-buttons.blade.php -->
<div class="btn-group my-3">
    <a class="btn py-1 px-3 btn-outline-dark" onclick="exportTo('csv')">
        <i class="fa-solid fa-file-csv"></i>
        Export to CSV
    </a>
    <button class="btn btn-outline-primary" onclick="exportTo('xml')">Export to XML</button>
    <button class="btn btn-outline-primary" onclick="exportTo('pdf')">Export to PDF</button>
    <button class="btn btn-outline-primary" onclick="printTable()">Print</button>
</div>

</div>
