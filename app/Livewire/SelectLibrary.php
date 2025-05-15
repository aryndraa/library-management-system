<?php

namespace App\Livewire;

use App\Models\Library;
use Livewire\Component;

class SelectLibrary extends Component
{
    public $search = '';

    public $show = true;

    public function setLibrarySession($id)
    {
        session(['library_id_session' => $id]);

        $this->show = false;

        return redirect()->route('member.home');

    }

    public function render()
    {
        $libraries = Library::query()
            ->when($this->search, function ($query) {
               $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('address', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.select-library', ['libraries' => $libraries]);
    }
}
