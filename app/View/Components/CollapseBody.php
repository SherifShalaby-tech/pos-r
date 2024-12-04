<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CollapseBody extends Component
{
    public $collapseId, $bodyClass;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($collapseId, $bodyClass = "")
    {
        $this->collapseId = $collapseId;
        $this->bodyClass = $bodyClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.collapse-body');
    }
}
