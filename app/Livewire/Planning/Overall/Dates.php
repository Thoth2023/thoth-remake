<?php

namespace App\Livewire\Planning\Overall;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Utils\ActivityLogHelper as Log;

class Dates extends Component
{
    private $translationPath = 'project/planning.overall.dates.livewire';
    public $currentProject;

    /**
     * Fields to be filled by the form.
     */
    public $startDate;
    public $endDate;

    /**
     * Validation rules.
     */
    protected $rules = [
        'currentProject' => 'required',
        'startDate' => 'required|date',
        'endDate' => 'required|date|after:startDate',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'startDate.required' => __($this->translationPath . '.start_date.required'),
            'startDate.invalid' => __($this->translationPath . '.start_date.invalid'),
            'endDate.required' => __($this->translationPath . '.end_date.required'),
            'endDate.after' => __($this->translationPath . '.end_date.after'),
        ];
    }

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->startDate = $this->currentProject->start_date;
        $this->endDate = $this->currentProject->end_date;
    }

    /**
     * Submit the form. It also validates the input fields.
     */
    public function submit()
    {
        $this->validate();

        $dates = ProjectModel::first(['start_date', 'end_date'])
            ->where('id_project', $this->currentProject->id);

        $this->currentProject->addDate(
            startDate: $this->startDate,
            endDate: $this->endDate
        );

        Log::logActivity(
            action: $dates === null ? 'Added project dates: ' : 'Updated project dates: ',
            description: $this->startDate . ' - ' . $this->endDate,
            projectId: $this->currentProject->id_project,
        );
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.overall.dates',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}