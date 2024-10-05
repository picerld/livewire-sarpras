<?php

namespace App\Livewire\Utils;

use App\Models\IncomingItem;
use App\Models\OutgoingItem;
use App\Models\User;
use Livewire\Component;

class Charts extends Component
{
    public $chart;
    public $class;
    public $type;

    public function mount($type) {
        $this->type = $type;

        // Retrieve data for incoming and outgoing items grouped by month
        $incomingItems = IncomingItem::selectRaw('MONTH(created_at) as month, SUM(total_items) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $outgoingItems = OutgoingItem::selectRaw('MONTH(created_at) as month, SUM(total_items) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare data for the chart
        $labels = collect(range(1, 12))->map(function($month) {
            return \Carbon\Carbon::create()->month($month)->format('M'); // Convert month number to name
        })->toArray();

        $incomingData = $this->mapDataByMonth($incomingItems);
        $outgoingData = $this->mapDataByMonth($outgoingItems);

        // Define chart configuration
        $this->chart = [
            'type' => $type,
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Incoming Items',
                        'data' => $incomingData,
                        'backgroundColor' => '#111111', // Black bars
                        'borderRadius' => 5,
                        'barThickness' => 'flex', // Flexible bar width
                    ],
                    [
                        'label' => 'Outgoing Items',
                        'data' => $outgoingData,
                        'backgroundColor' => '#333333', // Dark gray bars
                        'borderRadius' => 5,
                        'barThickness' => 'flex', // Flexible bar width
                    ],
                ]
            ],
            'options' => [
                'scales' => [
                    'x' => [
                        'grid' => [
                            'display' => true, // Hide x-axis grid lines
                        ],
                        'ticks' => [
                            'color' => '#999999', // Light gray for labels
                        ],
                        'barPercentage' => 0.6, // Width of bars relative to category
                        'categoryPercentage' => 0.8, // Width of category (leaves space between bars)
                    ],
                    'y' => [
                        'grid' => [
                            'display' => false,
                            'color' => 'rgba(0, 0, 0, 0.1)', // Light gray for grid lines
                        ],
                        'ticks' => [
                            'color' => '#999999', // Light gray for labels
                            'stepSize' => 1500, // Adjust step size if needed
                        ]
                    ]
                ],
                'plugins' => [
                    'legend' => [
                        'display' => false, // Hide the legend for simplicity
                    ]
                ],
                'layout' => [
                    'padding' => 0,
                ],
                'responsive' => true,
                'maintainAspectRatio' => false,
            ]
        ];
    }

    private function mapDataByMonth($items)
    {
        $data = array_fill(0, 12, 0); // Initialize array with 12 months, set to 0

        foreach ($items as $item) {
            $data[$item->month - 1] = $item->total;
        }

        return $data;
    }

    public function render()
    {
        return view('livewire.utils.charts');
    }
}
