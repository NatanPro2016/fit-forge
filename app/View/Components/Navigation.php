<?php

namespace App\View\Components;


use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;




class Navigation extends Component
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function render(): View|Closure|string
    {
        return view('components.navigation', );
    }
}
