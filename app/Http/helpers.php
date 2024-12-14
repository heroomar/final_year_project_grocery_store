<?php

function __route($name, $parameters = [], $absolute = true){
    try {
        return route($name, $parameters, $absolute) ;
    } catch (\Throwable $th) {
        return url($name);
    }
}

function theme_name(){
    return "dark";
}

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
            $html .= '<a href="' . (!empty($item['route']) ? __route($item['route']) : '#!') . '" class="dash-link">';

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

function module_is_active($name){
    return true;
}

if (!function_exists('bulkDeleteCloneCheckboxColumn')) {
    function bulkDeleteCloneCheckboxColumn() {
        // Initialize an array to hold the columns
        $columns = [];

        // Check if the BulkDelete module is active
        if (module_is_active('BulkDelete')) {
            // Add the checkbox column if the module is active
            $columns[] = \Yajra\DataTables\Html\Column::computed('checkbox')
                ->title('<input type="checkbox" id="select-all">')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->width(20)
                ->addClass('text-center')
                ->render('function() {
                    return \'<input type="checkbox" class="select-row" value="\' + this.id + \'">\';
                }');
        }

        return $columns; // Return the array of columns
    }
}

if (!function_exists('bulkDeleteForm')) {
    function bulkDeleteForm($type,$dataTableId) {
        return [
            'text' => '<i class="ti ti-trash"></i> ' . __('Delete'),
            'className' => 'btn btn-light-danger bulk-delete me-1',
            'action' => "function(e, dt, button, config) {
                bulkDelete('{$type}','{$dataTableId}');
            }"
        ];
    }
}


if (!function_exists('APP_THEME')) {
    function APP_THEME($user_id = null)
    {
        
        return 'grocery';
        
    }
}

function getCurrentStore(){
    return 1;
}


function get_file($path, $theme_id = '')
    {
        return $path;
    }


function currency_format_with_sym($a,$b,$c){
    return $a;
}

function get_currency(){
    return 'Rs. ';
}

function SetNumberFormat($num){
    return number_format($num,2);
}

function SetNumber($num){
    return number_format($num,2);
}