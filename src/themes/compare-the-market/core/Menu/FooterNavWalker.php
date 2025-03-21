<?php
// phpcs:ignoreFile

namespace Atlas\Core\Menu;

use Walker_Nav_Menu;

class FooterNavWalker extends Walker_Nav_Menu
{
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        parent::start_lvl($output);
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        parent::end_lvl($output);
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $item->classes = [];

        $item->classes[] = 'depth-' . $depth . ' col';

        $args = $this->fixArgsOutput($args);

        parent::start_el($output, $item, $depth, $args, $id);
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $args = $this->fixArgsOutput($args);

        parent::end_el($output, $item, $depth, $args);
    }

    private function fixArgsOutput($args)
    {
        return (object)$args;
    }
}
