<?php

namespace App\View\Components;

use Illuminate\Foundation\Application;
use Illuminate\View\Component;

class DatePicker extends Component
{
    public $value;

    public function __construct ($value = null)
    {
        $this->value = $value;
    }

    public function render (): Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Support\Htmlable|\Closure|string
    {
        return view('components.date-picker');
    }
}
