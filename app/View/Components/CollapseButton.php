<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CollapseButton extends Component
{
    public $collapseId, $buttonClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($collapseId, $buttonClass = "")
    {
        $this->collapseId = $collapseId;
        $this->buttonClass = $buttonClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.collapse-button');
    }
}
