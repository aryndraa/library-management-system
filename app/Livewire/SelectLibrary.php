<?php

namespace App\Livewire;

use App\Models\Library;
use App\Models\MemberVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SelectLibrary extends Component
{
    public $search = '';

    public $show = true;

    public function setLibrarySession($id)
    {
        session(['library_id_session' => $id]);

        $this->show = false;

        $memberId = Auth::id();
        $today = Carbon::today();

        $existingVisit = MemberVisit::where('member_id', $memberId)
            ->where('library_id', $id)
            ->whereDate('visit_date', $today)
            ->exists();

        if (!$existingVisit) {
            MemberVisit::create([
                'member_id' => $memberId,
                'library_id' => $id,
                'visit_date' => $today,
            ]);
        }

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
