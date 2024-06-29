<div class="pt-6">
    <div class="container">
        <div class="w-full px-5 py-5 text-gray-500 bg-white rounded-lg shadow dark:bg-dark" x-data="{ chartData: chartData() }"
            x-init="chartData.fetch()">
            <div class="flex flex-wrap items-end">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold leading-tight">
                        Grafik
                    </h3>
                </div>
                <div class="relative" @click.away="chartData.showDropdown=false">
                    <button class="h-6 text-xs hover:text-gray-300 focus:outline-none"
                        @click="chartData.showDropdown=!chartData.showDropdown">
                        <span x-text="chartData.options[chartData.selectedOption].label"></span><i
                            class="ml-1 mdi mdi-chevron-down"></i>
                    </button>
                    <div class="absolute right-0 top-auto z-30 w-32 min-w-full mt-1 -mr-3 text-sm bg-gray-700 rounded shadow-lg"
                        x-show="chartData.showDropdown" style="display: none"
                        x-transition:enter="transition ease duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease duration-300 transform"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4">
                        <span class="absolute top-0 right-0 w-3 h-3 mr-3 -mt-1 transform rotate-45 bg-gray-500"></span>
                        <div class="relative z-10 w-full py-1 rounded dark:bg-gray-700 bg-base-100">
                            <ul class="text-xs list-reset">
                                <template x-for="(item,index) in chartData.options">
                                    <li class="px-4 py-2 transition-colors duration-100 cursor-pointer hover:bg-gray-600 hover:text-white"
                                        :class="{ 'dark:text-white': this.index == chartData.selectedOption }"
                                        @click="chartData.selectOption(this.index);chartData.showDropdown=false">
                                        <span x-text="item.label"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap items-end mb-5">
                <h4 class="inline-block mr-2 text-2xl font-semibold leading-tight text-gray-500 lg:text-3xl">
                    Data Barang
                </h4>
            </div>
            <div>
                <canvas id="chart" class="w-full"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    Number.prototype.comma_formatter = function() {
        return this.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    let chartData = function() {
        return {
            date: 'today',
            options: [{
                    label: 'Hari ini',
                    value: 'today',
                },
                {
                    label: 'Minggu terakhir',
                    value: '7days',
                },
                {
                    label: 'Bulan terakhir',
                    value: '30days',
                },
                {
                    label: 'Semester terakhir',
                    value: '6months',
                },
                {
                    label: 'This Year',
                    value: 'year',
                },
            ],
            showDropdown: false,
            selectedOption: 0,
            selectOption: function(index) {
                this.selectedOption = index;
                this.date = this.options[index].value;
                this.renderChart();
            },
            data: null,
            fetch: function() {
                fetch('https://cdn.jsdelivr.net/gh/swindon/fake-api@master/tailwindAlpineJsChartJsEx1.json')
                    .then(res => res.json())
                    .then(res => {
                        this.data = res.dates;
                        this.renderChart();
                    })
            },
            renderChart: function() {
                let c = false;

                Chart.helpers.each(Chart.instances, function(instance) {
                    if (instance.chart.canvas.id == 'chart') {
                        c = instance;
                    }
                });

                if (c) {
                    c.destroy();
                }

                let ctx = document.getElementById('chart').getContext('2d');

                let chart = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: this.data[this.date].data.labels,
                        datasets: [{
                                label: "Barang Masuk",
                                backgroundColor: "rgba(102, 126, 234, 0.25)",
                                borderColor: "rgba(102, 126, 234, 1)",
                                pointBackgroundColor: "rgba(102, 126, 234, 1)",
                                data: this.data[this.date].data.income,
                            },
                            {
                                label: "Barang Keluar",
                                backgroundColor: "rgba(237, 100, 166, 0.25)",
                                borderColor: "rgba(237, 100, 166, 1)",
                                pointBackgroundColor: "rgba(237, 100, 166, 1)",
                                data: this.data[this.date].data.expenses,
                            },
                        ],
                    },
                    layout: {
                        padding: {
                            right: 10
                        }
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    callback: function(value, index, array) {
                                        return value > 1000 ? ((value < 1000000) ? value /
                                            1000 + 'K' : value / 1000000 + 'M') : value;
                                    }
                                }
                            }]
                        }
                    }
                });
            }
        }
    }
</script>