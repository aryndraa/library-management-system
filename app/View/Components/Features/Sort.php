<?php

namespace App\View\Components\Features;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sort extends Component
{
    /**
     * Create a new component instance.
     */
    public array $sortItems = [];

    public function __construct(array $sortItems = [])
    {
        $this->sortItems = $sortItems;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.features.sort');
    }
}
