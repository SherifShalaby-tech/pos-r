<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Collapse extends Component
{
    public $collapseId, $color;

    public function __construct($collapseId, $color = "primary")
    {
        $this->collapseId = $collapseId;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.collapse');
    }
}
