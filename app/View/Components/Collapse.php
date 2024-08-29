<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Collapse extends Component
{
    public $collapseId, $buttonClass, $bodyClass, $groupClass;

    public function __construct($collapseId, $buttonClass = "", $bodyClass = "", $groupClass = "")
    {
        $this->collapseId = $collapseId;
        $this->buttonClass = $buttonClass;
        $this->bodyClass = $bodyClass;
        $this->groupClass = $groupClass;
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
