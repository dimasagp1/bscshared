<?php

namespace App\Livewire;

use Livewire\Component;

class ComingSoon extends Component
{
    public $menuTitle = 'Fitur';
    public $menuDesc = '';
    public $frCode = '';

    public function mount($title = 'Fitur', $desc = '', $fr = '')
    {
        $this->menuTitle = $title;
        $this->menuDesc = $desc;
        $this->frCode = $fr;
    }

    public function render()
    {
        return view('livewire.coming-soon')->layout('layouts.app', ['title' => $this->menuTitle]);
    }
}
