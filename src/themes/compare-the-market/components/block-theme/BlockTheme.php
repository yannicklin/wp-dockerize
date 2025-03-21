<?php

namespace Atlas\Components;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

class BlockTheme extends Component
{
    public array $theme;
    public string $name;
    public ?string $classes_paddings;
    public ?string $classes_margins;

    public function __construct(array $acf, string $name)
    {
        $this->theme = $acf;
        $this->name = $name;
        $this->classes_paddings = !empty($this->theme) ? $this->generateBlockSpacingClasses('padding') : '';
        $this->classes_margins = !empty($this->theme) ? $this->generateBlockSpacingClasses('margin') : '';
    }

    public function generateCustomCSS()
    {

        if ($this->theme['block_theme']['scss'] ?? false) {
            $scss = "section.{$this->getBlockId()} { {$this->theme['block_theme']['scss']} }";

            try {
                return $this->getScssCompiler()->compileString($scss)->getCss();
            } catch (Exception $ex) {
                echo '<!---- CSS Compilation Exception ' . $ex->getMessage() . ' ------>';
                error_log($ex->getMessage());
                return false;
            }
        }

        return false;
    }

    public function getBlockId()
    {
        return $this->theme['block_theme']['id'] ?? 'block-theme';
    }

    private function getScssCompiler()
    {
        $compiler = new Compiler();

        $compiler->setOutputStyle(OutputStyle::COMPRESSED);

        return $compiler;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('Components::block-theme.block-theme');
    }

    /**
     * Get the Spacing(Padding/Margin) Classes for the component.
     *
     * @return string
     */
    private function generateBlockSpacingClasses(string $spacing = 'padding')
    {
        $classes = [];
        $class_prefix = ('margin' == $spacing) ? 'm' : 'p';

        if ('side-navigation' === $this->name) {
            if ('padding' === $spacing) {
                $classes[] = self::decideEachSpacingClass($class_prefix . 'y', 'side-navigation');
                $classes[] = self::decideEachSpacingClass($class_prefix . 'x', 'none');
            }
        } else if ('side-navigation' === ($this->theme[('block_parent')] ?? '')) {
            if ('padding' === $spacing) {
                $classes[] = self::decideEachSpacingClass($class_prefix . 'y', 'side-navigation-blocks');
                $classes[] = self::decideEachSpacingClass($class_prefix . 'x', 'none');
            }
        } else if ($fields = $this->theme[('block_' . $spacing . 's')] ?? false) {
            foreach ($fields as $field_name => $field_value) {
                switch ($field_name) {
                    case ('block_' . $spacing . '_top'):
                        $classes[] = self::decideEachSpacingClass($class_prefix . 't', $field_value);
                        break;
                    case ('block_' . $spacing . '_right'):
                        $classes[] = self::decideEachSpacingClass($class_prefix . 'e', $field_value);
                        break;
                    case ('block_' . $spacing . '_bottom'):
                        $classes[] = self::decideEachSpacingClass($class_prefix . 'b', $field_value);
                        break;
                    case ('block_' . $spacing . '_left'):
                        $classes[] = self::decideEachSpacingClass($class_prefix . 's', $field_value);
                        break;
                }
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Static Function for Each Spacing Class with Numeric
     *
     * @return string
     */
    private static function decideEachSpacingClass(string $prefix = 'pt', string $input = 'none')
    {
        $class_spacing = '';
        switch ($input) {
            case 'none':
                $class_spacing = $prefix . '-0';
                break;
            case 'small':
                $class_spacing = $prefix . '-32';
                break;
            case 'medium':
                $class_spacing = $prefix . '-32 ' . $prefix . '-lg-40';
                break;
            case 'large':
                $class_spacing = $prefix . '-40 ' . $prefix . '-lg-80';
                break;
            case 'x-large':
                $class_spacing = $prefix . '-40 ' . $prefix . '-lg-120';
                break;
            case 'side-navigation':
                $class_spacing = $prefix . '-16 ' . $prefix . '-lg-32';
                break;
            case 'side-navigation-blocks':
                $class_spacing = $prefix . '-48';
                break;
        }
        return $class_spacing;
    }
}
