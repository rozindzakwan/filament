<?php

namespace App\Components;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use ReflectionClass;
use Str;

class TextInput implements Htmlable
{
    protected static array $configurations = [];
    protected string|Closure $label;
    protected int|Closure|null $maxLength = null;
    protected Component $livewire;


    public function __construct(
        protected string $name
    )
    {
    }

    /**
     * @param string $name
     * @return self
     * Initialize input
     */
    public static function make(string $name): self
    {
        $input = new self($name);

        foreach (self::$configurations as $configuration) {
            $configuration($input);
        }
        return $input;
    }

    /**
     * @param Closure $configure
     * @return void
     * Globally configuration
     */
    public static function configureUsing(Closure $configure): void
    {
        self::$configurations[] = $configure;
    }

    public function label(string|Closure $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function maxLength(int|null|Closure $maxLength): self
    {
        $this->maxLength = $maxLength;

        return $this;
    }


    /**
     * @return string
     * Make output html able
     */
    public function toHtml(): string
    {
        return $this->render()->render();
    }

    public function render(): View
    {
        return view('components.text-input', $this->extractPublicMethods());
    }


    /**
     * @return array
     * Output become function
     */
    public function extractPublicMethods(): array
    {
        $reflection = new ReflectionClass($this);
        $methods = array();

        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $methods[$method->getName()] = Closure::fromCallable([$this, $method->getName()]);
        }

        return $methods;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->evaluate($this->label ?? null) ?? str($this->name)
            ->title();
    }


    /**
     * @param $value
     * @return mixed
     * Check if is closure if closure will return function
     */
    public function evaluate($value)
    {
        if ($value instanceof Closure) {
            return app()->call($value, [
                'random' => Str::random(),
                'state' => $this->livewire->{$this->getName()}
            ]);
        }

        return $value;
    }


    public function getMaxLength(): ?int
    {
        return $this->evaluate($this->maxLength);
    }

    /**
     * @param Component $livewire
     * @return $this
     * include livewire
     */
    public function livewire(Component $livewire): self
    {
        $this->livewire = $livewire;

        return $this;
    }
}
