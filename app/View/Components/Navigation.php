<?php

namespace App\View\Components;


use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;




class Navigation extends Component
{
    public $user;
    public $page;
    public $timestamp;



    public function __construct($user, $page, $timestamp = null)
    {
        $this->user = $user;
        $this->page = $page;
        $this->timestamp = $timestamp ?? Carbon::now();
    }

    public function render(): View|Closure|string
    {
        return view('components.navigation', );
    }
}
