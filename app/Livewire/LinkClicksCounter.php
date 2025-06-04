<?php

namespace App\Livewire;

use App\Models\Link;
use Livewire\Component;

class LinkClicksCounter extends Component
{

    public Link $link;

    protected $listeners = ['linkClicked' => '$refresh'];
    
    public function render()
    {
        return view('livewire.link-clicks-counter', [
            'count' => $this->link->clicks()->count(),
        ]);
    }
}
