<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DatePicker extends Component
{
    public $value;

    public function __construct ($value = null)
    {
        $this->value = $value;
    }

    public function render ()
    {
        return view('components.date-picker');
    }
}
