<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AccountModal extends Component
{
    public string $modalId;
    public string $action;
    public ?int $parentId;
    public ?int $method;

    public function __construct($modalId, $action, $parentId = null, $method = null)
    {
        $this->modalId = $modalId;
        $this->action = $action;
        $this->parentId = $parentId;
        $this->method = $method;
    }

    public function render()
    {
        return view('components.account-modal');
    }
}
