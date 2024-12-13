<?php

namespace App\DataTables;

use App\Models\Customer;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class CustomerDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('first_name', function (Customer $customer)  {
                $customer_info = null;
                if ($customer) { // Check if $customer is not null
                    
                       $customer_info = '<p class="text-capitalize text-success">' . $customer->first_name . ' ' . $customer->last_name . ' </p> <br>' . $customer->mobile;
                    
                }
                return $customer_info;
            })
            ->editColumn('last_active', function (Customer $customer) {
                if ($customer && $customer->last_active) { // Ensure $customer is not null
                    $active = \Carbon\Carbon::parse($customer->last_active);
                    return $active->format('F d, Y');
                }
                return null;
            })
            ->editColumn('regiester_date', function (Customer $customer) {
                if ($customer && $customer->regiester_date) { // Ensure $customer is not null
                    $carbonDate = \Carbon\Carbon::parse($customer->regiester_date);
                    return $carbonDate->format('F d, Y');
                }
                return null;
            })
            ->editColumn('orders', function (Customer $customer) {
                if ($customer) { // Ensure $customer is not null
                    return '<a href="'.route('customer.show', $customer->id).'">'.$customer->Ordercount().'</a>';
                }
                return null;
            })
            
            ->addColumn('action', function (Customer $customer)  {
                
                    return view('customer.action', compact('customer'));
                
            })
            
            ->filterColumn('first_name', function ($query, $keyword) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$keyword}%"])->orWhere('mobile', 'Like', "%{$keyword}%");
            })
            ->rawColumns(['first_name', 'email', 'last_active', 'regiester_date', 'orders', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Customer $model, Request $request): QueryBuilder
    {
        $query = $model->newQuery()->where('theme_id', APP_THEME())->where('store_id', getCurrentStore());

        $requestData = $request->all();

        if (isset($requestData['field_name']) && ($requestData['field_name'] == 'Name' || $requestData['field_name'] == 'Email')) {
            if (!empty($requestData['selected_name']) && !empty($requestData['text_field'])) {
                // check for name and email filtering
                if ($requestData['selected_name'] === 'Includes') {
                    $query->where(function ($subQuery) use ($requestData) {
                        $subQuery->where('first_name', 'like', '%' . $requestData['text_field'] . '%')
                            ->orWhere('email', 'like', '%' . $requestData['text_field'] . '%');
                    });
                } elseif ($requestData['selected_name'] === 'Excludes') {
                    $query->where(function ($subQuery) use ($requestData) {
                        $subQuery->where(function ($sQuery) use ($requestData) {
                            $sQuery->where('first_name', 'not like', '%' . $requestData['text_field'] . '%')
                                ->orWhere('email', 'not like', '%' . $requestData['text_field'] . '%');
                        });
                    });
                }
            }
        }

        // Check for last active filtering
        if (isset($requestData['field_name']) && $requestData['field_name'] == 'Last Active') {
            if (!empty($requestData['selected_name']) && !empty($requestData['text_field'])) {
                $dateValue = $requestData['text_field'];
                if ($requestData['selected_name'] === 'Before') {
                    $query->whereDate('last_active', '<', $dateValue);
                } elseif ($requestData['selected_name'] === 'After') {
                    $query->whereDate('last_active', '>', $dateValue);
                } else {
                    $query->whereDate('last_active', $dateValue);
                }
            }
        }

        
        // check for number of orders filtering
        if (isset($requestData['field_name']) && $requestData['field_name'] == 'No. of Orders') {
            if (!empty($requestData['selected_name']) && !empty($requestData['text_field'])) {
                $filteredCustomers = [];

                $orderCountValue = (int) $requestData['text_field'];
                foreach ($query->get() as $key => $value) {
                    $counter = $value->Ordercount();

                    if ($requestData['selected_name'] === 'Less Than' && $counter < $orderCountValue) {
                        $filteredCustomers[] = $value->id;
                    } else if ($requestData['selected_name'] === 'Less Than' && $counter > $orderCountValue) {
                        $filteredCustomers[] = $value->id;
                    } else if ($requestData['selected_name'] === 'Equal' && $counter == $orderCountValue) {
                        $filteredCustomers[] = $value->id;
                    }
                }
                $query->whereIn('id', $filteredCustomers);
            }
        }

        

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('customer-table')
            ->columns(( $this->getColumns()))
            ->ajax([
                'data' => 'function(d) {
                    d.field_name = $("select[name=field_name]").val();

                    d.selected_name = $("select[name=selected_name]").val();
                    d.text_field = $("input[name=text_field]").val();
                    
                }',
            ])
            ->orderBy(0)
            ->language([
                "paginate" => [
                    "next" => '<i class="ti ti-chevron-right"></i>',
                    "previous" => '<i class="ti ti-chevron-left"></i>'
                ],
                'lengthMenu' => "_MENU_" . __('Entries Per Page'),
                "searchPlaceholder" => __('Search...'),
                "search" => "",
                "info" => __("Showing")." _START_ ".__("to"). " _END_ ".__("of")." _TOTAL_ ".__("entries")
            ])
            ->initComplete('function() {
                var table = this;
                $("body").on("click", "#applyfilter", function() {

                    if (!$("select[name=field_name]").val() && !$("select[name=selected_name]").val() && !$("input[name=text_field]").val()) {
                        toastrs("Error!", "Please select Atleast One Filter ", "error");
                        return;
                    }

                    $("#customer-table").DataTable().draw();
                });

                $("body").on("click", "#clearfilter", function() {
                    $("select[name=field_name]").val("")
                    $("select[name=selected_name]").val("")
                    $("input[name=text_field]").val("")
                    $("#customer-table").DataTable().draw();
                });

                var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
                searchInput.removeClass(\'form-control form-control-sm\');
                searchInput.addClass(\'dataTable-input\');
                var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'dataTable-selector\');
            }');

        $exportButtonConfig = [];
        // $exportButtonConfig = [
        //     'extend' => 'collection',
        //     'className' => 'btn btn-light-secondary me-1 dropdown-toggle',
        //     'text' => '<i class="ti ti-download"></i> ' . __('Export'),
        //     'buttons' => [
        //         [
        //             'extend' => 'print',
        //             'text' => '<i class="fas fa-print"></i> ' . __('Print'),
        //             'className' => 'btn btn-light text-primary dropdown-item',
        //             'exportOptions' => ['columns' => [0, 1, 3]],
        //         ],
        //         [
        //             'extend' => 'csv',
        //             'text' => '<i class="fas fa-file-csv"></i> ' . __('CSV'),
        //             'className' => 'btn btn-light text-primary dropdown-item',
        //             'exportOptions' => ['columns' => [0, 1, 3]],
        //         ],
        //         [
        //             'extend' => 'excel',
        //             'text' => '<i class="fas fa-file-excel"></i> ' . __('Excel'),
        //             'className' => 'btn btn-light text-primary dropdown-item',
        //             'exportOptions' => ['columns' => [0, 1, 3]],
        //         ],
        //     ],
        // ];

        $bulkdeleteButtonConfig = [];
        if (module_is_active('BulkDelete')) {
            $bulkdeleteButtonConfig = bulkDeleteForm('customer','customer-table');
        }

        $buttonsConfig = array_merge([
            // $bulkdeleteButtonConfig,
            // $exportButtonConfig,
            [
                'extend' => 'reset',
                'className' => 'btn btn-light-danger me-1',
            ],
            [
                'extend' => 'reload',
                'className' => 'btn btn-light-warning',
            ],
        ]);

        $dataTable->parameters([
            "dom" =>  "
        <'dataTable-top'<'dataTable-dropdown page-dropdown'l><'dataTable-botton table-btn dataTable-search tb-search  d-flex justify-content-end gap-2'Bf>>
        <'dataTable-container'<'col-sm-12'tr>>
        <'dataTable-bottom row'<'col-5'i><'col-7'p>>",
            'buttons' => $buttonsConfig,
            "drawCallback" => 'function( settings ) {
                var tooltipTriggerList = [].slice.call(
                    document.querySelectorAll("[data-bs-toggle=tooltip]")
                  );
                  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                  });
                  var popoverTriggerList = [].slice.call(
                    document.querySelectorAll("[data-bs-toggle=popover]")
                  );
                  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl);
                  });
                  var toastElList = [].slice.call(document.querySelectorAll(".toast"));
                  var toastList = toastElList.map(function (toastEl) {
                    return new bootstrap.Toast(toastEl);
                  });
            }'
        ]);

        $dataTable->language([
            'buttons' => [
                'create' => __('Create'),
                'export' => __('Export'),
                'print' => __('Print'),
                'reset' => __('Reset'),
                'reload' => __('Reload'),
                'excel' => __('Excel'),
                'csv' => __('CSV'),
            ]
        ]);

        return $dataTable;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->searchable(false)->visible(false)->exportable(false)->printable(false),
            Column::make('first_name')->title(__('Customer Info')),
            Column::make('email')->title(__('Email')),
            Column::make('regiester_date')->title(__('Date Registered')),
            Column::make('orders')->title(__('Orders'))->searchable(false)->orderable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('Action ignore'),
            
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Customer_' . date('YmdHis');
    }
}
