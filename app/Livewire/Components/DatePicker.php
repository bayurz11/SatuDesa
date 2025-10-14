<?php

namespace App\Livewire\Components;

use Livewire\Component;

class DatePicker extends Component
{
    public $model;
    public function render()
    {
        return view('livewire.components.date-picker');
    }
}
