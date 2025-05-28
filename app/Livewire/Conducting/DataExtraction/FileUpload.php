<?php

namespace App\Http\Livewire\Conducting\DataExtraction;

use App\Models\Project;
use App\Models\Member;
use App\Models\BibUpload;
use App\Jobs\ProcessBibUpload;
use App\Rules\ValidBibFile;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;

    public $file;
    public $project;
    public $member;

    public function rules()
    {
        return [
            'file' => ['required', 'file', 'max:10240', new ValidBibFile],
        ];
    }

    public function mount()
    {
        $this->project = Project::findOrFail(session('project_id'));
        $this->member = Member::where('user_id', auth()->id())
            ->where('project_id', $this->project->id)
            ->firstOrFail();
    }

    public function updatedFile()
    {
        $this->validateOnly('file');
    }

    public function save()
    {
        $this->validate();

        try {
            $file = $this->file;
            $mimeType = $file->getMimeType();
            $extension = $file->getClientOriginalExtension();
            
            if (!in_array($extension, ['bib', 'csv']) || 
                (!str_starts_with($mimeType, 'text/') && $mimeType !== 'application/csv')) {
                throw new \Exception('Apenas arquivos .bib e .csv são permitidos.');
            }

            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName, 'public');

            $bibUpload = BibUpload::create([
                'project_id' => $this->project->id,
                'member_id' => $this->member->id,
                'file_name' => $fileName,
                'file_path' => 'uploads/' . $fileName,
                'file_type' => $extension,
                'status' => 'pending'
            ]);

            ProcessBibUpload::dispatch($bibUpload);

            $this->emit('toast', 'success', 'Arquivo enviado com sucesso!');
            $this->reset('file');
        } catch (\Exception $e) {
            $this->emit('toast', 'error', $e->getMessage());
        }
    }
} 