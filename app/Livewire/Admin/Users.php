<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    use WithPagination;

    public $userId;
    public $username, $firstname, $lastname, $email, $password, $address, $city, $country, $postal, $about, $institution, $occupation, $lattes_link, $role, $active;
    public $isEditMode = false;
    public $showModal = false;

    protected $rules = [
        'username' => 'required|string|max:255',
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'nullable|min:6',
        'role' => 'required|string',
        'active' => 'boolean',
    ];

    public function openModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    private function resetInputFields()
    {
        $this->reset(['userId', 'username', 'firstname', 'lastname', 'email', 'password', 'address', 'city', 'country', 'postal', 'about', 'institution', 'occupation', 'lattes_link', 'role', 'active']);
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate();

        User::create([
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'postal' => $this->postal,
            'about' => $this->about,
            'institution' => $this->institution,
            'occupation' => $this->occupation,
            'lattes_link' => $this->lattes_link,
            'role' => $this->role,
            'active' => $this->active,
        ]);

        session()->flash('message', 'Usuário criado com sucesso!');
        $this->closeModal();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->username = $user->username;
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->email = $user->email;
        $this->address = $user->address;
        $this->city = $user->city;
        $this->country = $user->country;
        $this->postal = $user->postal;
        $this->about = $user->about;
        $this->institution = $user->institution;
        $this->occupation = $user->occupation;
        $this->lattes_link = $user->lattes_link;
        $this->role = $user->role;
        $this->active = $user->active;

        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'username' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => 'nullable|min:6',
            'role' => 'required|string',
            'active' => 'boolean',
        ]);

        $user = User::find($this->userId);
        $user->update([
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => $this->password ? Hash::make($this->password) : $user->password,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'postal' => $this->postal,
            'about' => $this->about,
            'institution' => $this->institution,
            'occupation' => $this->occupation,
            'lattes_link' => $this->lattes_link,
            'role' => $this->role,
            'active' => $this->active,
        ]);

        session()->flash('message', 'Usuário atualizado com sucesso!');
        $this->closeModal();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'Usuário deletado com sucesso!');
    }

    public function render()
    {
        $users = User::paginate(10);
        return view('livewire.admin.users', compact('users'));
    }
}
