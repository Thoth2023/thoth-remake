<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\BibUpload;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Search extends Component
{

    
    /**
     * Render the component.
     * 
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view(
            'livewire.conducting.study-selection.search');
    }
}
