<?php

return [

    'modal' => [
        'title' => 'Understanding access permissions',
        'content' => '
<p>The system has different permission levels for project members. Each level determines what actions the user can perform.</p>

<style>
.permission-table {
    font-size: 0.85rem;
}
.permission-table th,
.permission-table td {
    white-space: nowrap;
    padding: 6px 10px;
}
.permission-wrapper {
    max-width: 100%;
    overflow-x: auto;
}
</style>

<div class="permission-wrapper mt-3">
<table class="table table-bordered permission-table">
<thead>
    <tr>
        <th>Level</th>
        <th>Status</th>
        <th>Protocol</th>
        <th>View</th>
        <th>Manage</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td><strong>Administrator</strong></td>
        <td>Any</td>
        <td>✅</td>
        <td>✅</td>
        <td>✅</td>
    </tr>
    <tr>
        <td><strong>Researcher/Reviewer</strong></td>
        <td>Accepted</td>
        <td>✅</td>
        <td>✅</td>
        <td>❌</td>
    </tr>
    <tr>
        <td><strong>Researcher/Reviewer</strong></td>
        <td>Pending</td>
        <td>✅</td>
        <td>❌</td>
        <td>❌</td>
    </tr>
    <tr>
        <td><strong>Viewer</strong></td>
        <td>Accepted/Pending</td>
        <td>✅</td>
        <td>❌</td>
        <td>❌</td>
    </tr>
    <tr>
        <td><strong>External User</strong></td>
        <td>Public project</td>
        <td>✅</td>
        <td>❌</td>
        <td>❌</td>
    </tr>
    <tr>
        <td><strong>External User</strong></td>
        <td>Private project</td>
        <td>❌</td>
        <td>❌</td>
        <td>❌</td>
    </tr>
</tbody>
</table>
</div>
        ',
        'close' => 'Close',
    ],

];
