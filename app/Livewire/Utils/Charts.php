<?php

namespace App\Livewire\Utils;

use App\Models\User;
use Livewire\Component;

class Charts extends Component
{
    public $chart;
    public $class;
    public $type;

    public function mount($type) {
        $this->type = $type;

        $users = User::all();
        $roles = $users->groupBy('role')->map->count();

        $labels = $roles->keys()->toArray();
        $data = $roles->values()->toArray();

        $this->chart = [
            'type' => $type,
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Presentase',
                        'data' => $data,
                        'fill' => false,
                        'backgroundColor' => [
                            '#e23670',
                            '#2662d9',
                            '#2eb88a',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(201, 203, 207, 0.2)',
                        ],
                        // 'borderColor' => [
                        //     '#e23670',
                        //     'rgba(153, 102, 255, 1)',
                        //     'rgba(255, 205, 86, 1)',
                        //     'rgba(54, 162, 235, 1)',
                        //     'rgba(255, 159, 64, 1)',
                        //     'rgba(75, 192, 192, 1)',
                        //     'rgba(201, 203, 207, 1)'
                        // ],
                        // 'borderWidth' => 4,
                        'borderRadius' => 4,
                    ]
                ]
            ],
            'options' => [
                'plugins' => [
                    'legend' => [
                        'labels' => [
                            'font' => [
                                'size' => 13,
                            ]
                        ],
                    ]
                ],
                'animations' => [
                    'tension' => [
                        'duration' => 1000,
                        'easing' => 'easeInOutBounce'
                    ]
                ],
            ]
        ];
        
    }

    public function render()
    {
        return view('livewire.utils.charts');
    }
}
