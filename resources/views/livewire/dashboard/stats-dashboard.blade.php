<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Gráfico de Estado de Proyectos -->
    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-800">Estado de Proyectos</h3>
        </x-slot>
        
        @if (!empty($projectStatusData['series']) && max($projectStatusData['series']) > 0)
            <div class="h-64">
                <livewire:livewire-pie-chart
                    key="{{ $projectStatusData['pieChartModel']->reactiveKey() }}"
                    :pie-chart-model="$projectStatusData['pieChartModel']"
                />
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                No hay datos de proyectos para mostrar.
            </div>
        @endif
    </x-card>

    <!-- Gráfico de Estado de Tareas -->
    <x-card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-800">Estado de Tareas</h3>
        </x-slot>
        
        @if (!empty($taskStatusData['series']) && max($taskStatusData['series']) > 0)
            <div class="h-64">
                <livewire:livewire-pie-chart
                    key="{{ $taskStatusData['pieChartModel']->reactiveKey() }}"
                    :pie-chart-model="$taskStatusData['pieChartModel']"
                />
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                No hay datos de tareas para mostrar.
            </div>
        @endif
    </x-card>

    <!-- Gráfico de Proyectos Completados -->
    <div class="lg:col-span-2">
        <x-card>
            <x-slot name="header">
                <h3 class="text-lg font-semibold text-gray-800">Proyectos Completados por Mes</h3>
            </x-slot>
            
            @if (!empty($progressData['series']))
                <div class="h-72">
                    <livewire:livewire-line-chart
                        key="{{ $progressData['lineChartModel']->reactiveKey() }}"
                        :line-chart-model="$progressData['lineChartModel']"
                    />
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    No hay datos de progreso para mostrar.
                </div>
            @endif
        </x-card>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</div>