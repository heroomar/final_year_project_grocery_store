<?php
if (!function_exists('generateMenu')) {
    function generateMenu($menuItems, $parent = null)
    {
        $html = '';

        $filteredItems = array_filter($menuItems, function ($item) use ($parent) {
            return $item['parent'] == $parent;
        });
        usort($filteredItems, function ($a, $b) {
            return $a['order'] - $b['order'];
        });

        foreach ($filteredItems as $item) {
            if ($item['name'] == 'mobilescreensetting' && env('IS_MOBILE') != 'yes') {
                continue;
            }
            $hasChildren = hasChildren($menuItems, $item['name']);
            if ($item['parent'] == null) {
                $html .= '<li class="dash-item dash-hasmenu">';
            } else {
                $html .= '<li class="dash-item">';
            }
            $html .= '<a href="' . (!empty($item['route']) ? url($item['route']) : '#!') . '" class="dash-link">';

            if ($item['parent'] == null) {
                $html .= ' <span class="dash-micon"><i class="ti ti-' . $item['icon'] . '"></i></span>
                <span class="dash-mtext">';
            }
            $html .= __($item['title']) . '</span>';
            if ($hasChildren) {
                $html .= '<span class="dash-arrow"> <i data-feather="chevron-right"></i> </span> </a>';
                $html .= '<ul class="dash-submenu">';
                $html .= generateMenu($menuItems, $item['name']);
                $html .= '</ul>';
            } else {
                $html .= '</a>';
            }
            $html .= '</li>';

        }
        return $html;
    }
}

if (!function_exists('hasChildren')) {
    function hasChildren($menuItems, $name)
    {
        foreach ($menuItems as $item) {
            if ($item['parent'] === $name) {
                return true;
            }
        }
        return false;
    }
}
