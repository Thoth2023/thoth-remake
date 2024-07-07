<?php

namespace App\Livewire\Conducting;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\File;
use App\Models\Project as ProjectModel;


class FileUpload extends Component
{
  use WithFileUploads;

  public $currentProject;
  public $databases = [];
  public $selectedDatabase = '';

  public $file;

  public function mount()
  {
      $projectId = request()->segment(2);
      $this->currentProject = ProjectModel::findOrFail($projectId);
      $this->databases = $this->currentProject->databases;
   }

    /**
     * Reset the fields to the default values.
     */
   public function resetFields()
   {
       $this->selectedDatabase = '';
       $this->file = null;
   }

   public function save()
   {
       $this->validate([
           'selectedDatabase' => 'required|exists:project_databases,id_database',
           'file' => 'required|file|mimes:bib,csv|max:10240',
       ]);

       $name = md5($this->file . microtime()) . '.' . $this->file->extension();

       $this->file->storeAs('files', $name);

       File::create([
           'file_name' => $name,
           'database_id' => $this->selectedDatabase,
       ]);

       session()->flash('message', 'The file is successfully uploaded!');
   }


   public function render()
   {
     return view('livewire.conducting.file-upload', [
       'files' => File::all(),
     ]);
   }
 }
