<?php

namespace App\View\Components\Features;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TotalItems extends Component
{
    public $item;
    public $total;

    /**
     * Create a new component instance.
     */
    public function __construct($item, $total)
    {
        $this->item = $item;
        $this->total = $total;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.features.total-items');
    }
}
