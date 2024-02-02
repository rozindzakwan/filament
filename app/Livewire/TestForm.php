<?php

namespace App\Livewire;

use App\Components\TextInput;
use Illuminate\Support\Str;
use Livewire\Component;

class TestForm extends Component
{
    public $email;

    public function render()
    {
        TextInput::configureUsing(function ($input) {
            $input->maxLength(3);
        });

        TextInput::test();

        $input = TextInput::make('name')
            ->livewire($this);
        $inputEmail = TextInput::make('email')
            ->livewire($this);

        return view('livewire.test-form', [
            'input' => $input,
            'inputEmail' => $inputEmail,
        ]);
    }
}
