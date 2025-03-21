<?php

namespace Atlas\Core\Extensions\Blade;

use Illuminate\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Str;
use InvalidArgumentException;

class ComponentTagCompiler extends \Illuminate\View\Compilers\ComponentTagCompiler
{
    /**
     * Get the component class for a given component alias.
     *
     * @param  string  $component
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function componentClass(string $component)
    {

        $viewFactory = Container::getInstance()->make(Factory::class);

        if (isset($this->aliases[$component])) {
            if (class_exists($alias = $this->aliases[$component])) {
                return $alias;
            }

            if ($viewFactory->exists($alias)) {
                return $alias;
            }

            throw new InvalidArgumentException(
                "Unable to locate class or view [{$alias}] for component [{$component}]."
            );
        }

        if ($class = $this->findClassByComponent($component)) {
            return $class;
        }

        if (class_exists($class = $this->guessClassName($component))) {
            return $class;
        }

        if (class_exists($class = $this->guessAtlasClassName($component))) {
            return $class;
        }

        if ($viewFactory->exists($view = $this->guessViewName($component))) {
            return $view;
        }

        if ($viewFactory->exists($view = $this->guessViewName($component) . '.index')) {
            return $view;
        }

        throw new InvalidArgumentException(
            "Unable to locate a class or view for component [{$component}]."
        );
    }

    /**
     * Guess the class name for the given component.
     *
     * @param  string  $component
     * @return string
     */
    protected function guessAtlasClassName(string $component)
    {
        $componentPieces = array_map(function ($componentPiece) {
            return ucfirst(Str::camel($componentPiece));
        }, explode('.', $component));


        if (!class_exists('Atlas\\Components\\' . implode('\\', $componentPieces))) {
            dump('Class Atlas\\Components\\' . implode('\\', $componentPieces) . ' not found');
        }

        return 'Atlas\\Components\\' . implode('\\', $componentPieces);
    }
}
