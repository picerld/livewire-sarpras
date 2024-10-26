<?php

namespace App\Livewire\Utils;

use App\Models\IncomingItem;
use App\Models\OutgoingItem;
use Livewire\Component;

class TransactionChart extends Component
{
    public $chart;
    public $class;

    public function mount() {
        $incomingItems = IncomingItem::selectRaw('MONTH(created_at) as month, SUM(total_items) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $outgoingItems = OutgoingItem::selectRaw('MONTH(created_at) as month, SUM(total_items) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = collect(range(1, 12))->map(function($month) {
            return \Carbon\Carbon::create()->month($month)->format('M');
        })->toArray();

        $incomingData = $this->mapDataByMonth($incomingItems);
        $outgoingData = $this->mapDataByMonth($outgoingItems);

        $this->chart = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Incoming Items',
                        'data' => $incomingData,
                        'backgroundColor' => '#1E201E',
                        'borderRadius' => 5,
                        'barThickness' => 23,
                    ],
                    [
                        'label' => 'Outgoing Items',
                        'data' => $outgoingData,
                        'backgroundColor' => '#5E5E5E',
                        'borderRadius' => 5,
                        'barThickness' => 23,
                    ],
                ]
            ],
            'options' => [
                'scales' => [
                    'x' => [
                        'grid' => [
                            'display' => true,
                        ],
                        'ticks' => [
                            'color' => '#999999',
                        ],
                        'barPercentage' => 0.5,
                        'categoryPercentage' => 0.5,
                    ],
                    'y' => [
                        'grid' => [
                            'display' => false,
                            'color' => 'rgba(0, 0, 0, 0.1)',
                        ],
                        'ticks' => [
                            'color' => '#999999',
                            'stepSize' => 50,
                        ],
                    ]
                ],
                'plugins' => [
                    'legend' => [
                        'display' => true,
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
        $data = array_fill(0, 12, 0);

        foreach ($items as $item) {
            $data[$item->month - 1] = $item->total;
        }

        return $data;
    }

    public function render()
    {
        return view('livewire.utils.transaction-chart');
    }
}
