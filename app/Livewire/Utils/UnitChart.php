<?php

namespace App\Livewire\Utils;

use App\Models\IncomingItem;
use App\Models\OutgoingItem;
use Carbon\Carbon;
use Livewire\Component;

class UnitChart extends Component
{
    public $chart;
    public $currentTime;

    public function mount()
    {
        $this->currentTime = Carbon::now();

        $outgoingItem = OutgoingItem::whereMonth('created_at', $this->currentTime->month)
            ->whereYear('created_at', $this->currentTime->year)
            ->sum('total_items');
        $incomingItem = IncomingItem::whereMonth('created_at', $this->currentTime->month)
            ->whereYear('created_at', $this->currentTime->year)
            ->sum('total_items');

        $this->chart = [
            'type' => 'bar',
            'data' => [
                'labels' => ['Total Transaction'],
                'datasets' => [
                    [
                        'label' => 'Barang Masuk',
                        'data' => [$incomingItem],
                        'backgroundColor' => '#1E201E',
                        'borderRadius' => 5,
                        'barThickness' => 75,
                    ],
                    [
                        'label' => 'Barang Keluar',
                        'data' => [$outgoingItem],
                        'backgroundColor' => '#5E5E5E',
                        'borderRadius' => 5,
                        'barThickness' => 75
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
                            'color' => '#000000',
                        ],
                        'barPercentage' => 0.6,
                        'categoryPercentage' => 0.25,
                    ],
                    'y' => [
                        'grid' => [
                            'display' => true,
                            'color' => 'rgba(0, 0, 0, 0.1)',
                        ],
                        'ticks' => [
                            'color' => '#999999',
                            'stepSize' => 100,
                        ],
                    ]
                ],
                'plugins' => [
                    'legend' => [
                        'display' => false,
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

    public function render()
    {
        return view('livewire.utils.unit-chart');
    }
}
