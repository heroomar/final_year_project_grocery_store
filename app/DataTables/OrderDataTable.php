<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dataTable = (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function (Order $order) {
                if (auth()->user()->role == 3){
                    return '<a href="javascript:void(0)"
                            data-url="'. route('order.order_view', ($order->id)) .'" data-size="lg"
                            data-ajax-popup="true" data-title="'. __('Order') .'    #'. $order->product_order_id .'"
                            class="x-3 btn btn-sm align-items-center btn btn-sm btn-warning" data-bs-toggle="tooltip"
                            data-original-title="'. __('Show') .'" data-bs-toggle="tooltip"
                            title="'. __('Show') .'">
                            <i class="ti ti-eye"></i>
                        </a>'; 
                }
                return view('order.action', compact('order'));
            })
            ->editColumn('product_order_id', function ($item) {
                $btnClass = 'bg-info';
                if($item->delivered_status == 2 || $item->delivered_status == 3) {
                    $btnClass = 'bg-danger';
                } elseif($item->delivered_status == 1) {
                    $btnClass = 'bg-success';
                }elseif($item->delivered_status == 4) {
                    $btnClass = ' btn-warning';
                } elseif($item->delivered_status == 5) {
                    $btnClass = 'btn-secondary';
                } elseif($item->delivered_status == 6) {
                    $btnClass = 'btn-dark';
                }
                return '<div class="d-flex align-items-center">
                            <a 
                                href="javascript:void(0)"
                                data-url="'. route('order.order_view', ($item->id)) .'" data-size="lg"
                                data-ajax-popup="true" data-title="Order    #'. $item->product_order_id .'"
                               data-bs-toggle="tooltip"
                                data-original-title="Show" data-bs-toggle="tooltip"
                            class="btn ' . $btnClass . ' btn-sm text-sm" data-toggle="tooltip" title="' . __('Invoice ID') . '">
                                <span class="btn-inner--icon"></span>
                                <span class="btn-inner--text">#'. $item->product_order_id . '</span>
                            </a>
                        </div>';
            })
            ->editColumn('order_date', function ($item) {
                
                return \App\Models\Utility::dateFormat($item->order_date);
            })
            ->editColumn('customer_id', function ($item) {
                if ($item->customer_id != 0) {
                    return (!empty($item->CustomerData->name) ? $item->CustomerData->name : '') . '<br>' .
                           (!empty($item->CustomerData->mobile) ? $item->CustomerData->mobile : '');
                } else {
                    return __('Walk-in-customer');
                }
            })
            ->editColumn('final_price', function ($item) {
                return currency_format_with_sym(($item->final_price ?? 0), getCurrentStore(), APP_THEME()) ?? SetNumberFormat($item->final_price);
            })
            ->editColumn('payment_type', function ($item) {
                $paymentTypes = [
                    'cod' => __('Cash On Delivery'),
                    
                    'POS' => __('POS'),
                    
                ];

                return $paymentTypes[$item->payment_type] ?? '';
            })
            ->editColumn('delivered_status', function ($item) {
                $statusButtons = [
                    0 => '<button type="button" class="btn btn-sm btn-soft-info btn-icon rounded-pill badge-same">
                            <span class="btn-inner--icon"><i class="fas fa-check soft-info"></i></span>
                            <span class="btn-inner--text"> ' . __('Pending') . ' : ' . \App\Models\Utility::dateFormat($item->order_date) . ' </span>
                        </button>',
                    1 => '<button type="button" class="btn btn-sm btn-soft-success btn-icon bg-success rounded-pill badge-same">
                            <span class="btn-inner--text"> ' . __('Delivered') . ' : ' . \App\Models\Utility::dateFormat($item->delivery_date) . ' </span>
                        </button>',
                    2 => '<button type="button" class="btn btn-sm btn-soft-danger btn-icon bg-danger rounded-pill badge-same">
                            <span class="btn-inner--text"> ' . __('Cancel') . ' : ' . \App\Models\Utility::dateFormat($item->cancel_date) . ' </span>
                        </button>',
                    3 => '<button type="button" class="btn btn-sm btn-soft-danger btn-icon bg-danger rounded-pill badge-same">
                            <span class="btn-inner--text"> ' . __('Return') . ' : ' . \App\Models\Utility::dateFormat($item->return_date) . ' </span>
                        </button>',
                    4 => '<button type="button" class="btn btn-sm btn-soft-warning btn-icon bg-warning rounded-pill badge-same">
                            <span class="btn-inner--text"> ' . __('Confirmed') . ' : ' . \App\Models\Utility::dateFormat($item->confirmed_date) . ' </span>
                        </button>',
                    5 => '<button type="button" class="btn btn-sm btn-soft-secondary btn-icon rounded-pill badge-same">
                            <span class="btn-inner--icon"><i class="fas fa-check soft-secondary"></i></span>
                            <span class="btn-inner--text"> ' . __('Picked Up') . ' : ' . \App\Models\Utility::dateFormat($item->picked_date) . ' </span>
                        </button>',
                    6 => '<button type="button" class="btn btn-sm btn-soft-dark btn-icon bg-dark rounded-pill badge-same">
                            <span class="btn-inner--text"> ' . __('Shipped') . ' : ' . \App\Models\Utility::dateFormat($item->shipped_date) . ' </span>
                        </button>',
                    7 => '<button type="button" class="btn btn-sm btn-soft-dark btn-icon bg-dark rounded-pill badge-same">
                            <span class="btn-inner--text"> ' . __('Partially Paid') . ' : ' . \App\Models\Utility::dateFormat($item->order_date) . ' </span>
                        </button>',
                ];

                return $statusButtons[$item->delivered_status] ?? '';
            })
            ->rawColumns(['action', 'product_order_id', 'order_date','customer_id', 'final_price', 'payment_type', 'delivered_status']);
        return $dataTable;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        if (auth()->user()->role == 3){
            return $model->where('user_id' , auth()->id());
        }
        return $model->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $dataTable = $this->builder()
            ->setTableId('order-table')
            ->columns(array_merge(bulkDeleteCloneCheckboxColumn(), $this->getColumns()))
            ->minifiedAjax()
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

                        var searchInput = $(\'#\'+table.api().table().container().id+\' label input[type="search"]\');
                        searchInput.removeClass(\'form-control form-control-sm\');
                        searchInput.addClass(\'dataTable-input\');
                        var select = $(table.api().table().container()).find(".dataTables_length select").removeClass(\'custom-select custom-select-sm form-control form-control-sm\').addClass(\'dataTable-selector\');
                    }');
        $exportButtonConfig = [
        ];

        $bulkdeleteButtonConfig = [];
        if (module_is_active('BulkDelete')) {
            $bulkdeleteButtonConfig = bulkDeleteForm('order','order-table');
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
                'print' => __('Print'),
                'reset' => __('Reset'),
                'reload' => __('Reload'),
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
            Column::make('id')->searchable(false)->visible(false)->printable(false),
            Column::make('product_order_id')->title(__('Order Id')),
            Column::make('order_date')->title(__('Date')),
            Column::make('customer_id')->title(__('Customer Info')),
            Column::make('final_price')->title(__('Price')),
            Column::make('payment_type')->title(__('Payment Type')),
            Column::make('delivered_status')->title(__('Order Status')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Order_' . date('YmdHis');
    }
}
