<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuccessAlert extends Component
{
    /**
     * Taken here rather than with @props: Blade escapes bound attributes once on
     * the way in, so the view's {{ $value }} showed quotes as &quot;
     */
    public function __construct(public string $value)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.success-alert');
    }
}
