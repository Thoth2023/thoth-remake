<?php

namespace App\Livewire\Conducting;

use App\Utils\ToastHelper;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\File;
use App\Models\Project as ProjectModel;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Component
{
  use WithFileUploads;

  public $currentProject;
  public $databases = [];
  public $selectedDatabase = [];

  public $file;

  protected $messages = [
    'selectedDatabase.required' => 'The database field is required.',
    'file.required' => 'The file field is required.',
    'file.mimes' => 'The file must be a type of: bib, csv.',
    'file.max' => 'The file size must not exceed 10MB.',
  ];

  protected $rules = [
    'selectedDatabase' => 'required|exists:project_databases,id_database',
    'file' => 'required|file|max:10240',
    'file.mimes' => 'The file must be a type of: bib, csv.',
    'file.max' => 'The file size must not exceed 10MB.',
  ];

  public function toast(string $message, string $type)
  {
    $this->dispatch('file-upload', ToastHelper::dispatch($type, $message));
  }

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
    $this->selectedDatabase['value'] = null;
    $this->file = null;
  }

  public function save()
  {
    $this->validate();

    $name = md5($this->file . microtime()) . '.' . $this->file->extension();

    $this->file->storeAs('files', $name);

    File::create([
      'file_name' => $name,
      'id_database' => $this->selectedDatabase['value'],
    ]);

    $this->toast(
      message: 'File uploaded successfully.',
      type: 'success'
    );

    $this->resetFields();
  }

  public function deleteFile($id)
  {
    $file = File::findOrFail($id);

    try {
      Storage::delete('files/' . $file->file_name);
      $file->delete();

      $this->toast(
        message: 'File deleted successfully.',
        type: 'success'
      );
    } catch (\Exception $e) {
      $this->toast(
        message: 'An error occurred while deleting the file.',
        type: 'error'
      );
    }
  }

  public function render()
  {
    return view('livewire.conducting.file-upload', [
      'files' => File::all(),
    ]);
  }
}
