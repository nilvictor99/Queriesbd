<?php

namespace App\Filament\Widgets;

use App\Models\ReniecData;
use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget as BaseWidget;
use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $monthlyData = ReniecData::select(DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->pluck('count')
            ->toArray();

        $genderCount = ReniecData::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender')
            ->toArray();

        $totalRecords = ReniecData::count();
        $todayRecords = ReniecData::whereDate('created_at', today())->count();
        $progressPercentage = $totalRecords > 0 ? ($todayRecords / $totalRecords) * 100 : 0;

        return [
            Stat::make('Total Registros RENIEC', number_format($totalRecords))
                ->icon('heroicon-o-users')
                ->progress($progressPercentage)
                ->progressBarColor('success')
                ->iconBackgroundColor('primary')
                ->chartColor('primary')
                ->iconPosition('start')
                ->description('Total de registros en el sistema')
                ->descriptionIcon('heroicon-o-document-text', 'before')
                ->descriptionColor('primary')
                ->iconColor('primary')
                ->chart($monthlyData),

            Stat::make('Registros por Género', ($genderCount['M'] ?? 0).' / '.($genderCount['F'] ?? 0))
                ->icon('heroicon-o-user-group')
                ->iconBackgroundColor('warning')
                ->description('Masculino / Femenino')
                ->descriptionIcon('heroicon-o-chart-pie', 'before')
                ->descriptionColor('warning')
                ->iconColor('warning'),

            Stat::make('Registros de Hoy', number_format($todayRecords))
                ->icon('heroicon-o-clock')
                ->backgroundColor('secondary')
                ->iconBackgroundColor('success')
                ->description('Registros en las últimas 24 horas')
                ->descriptionIcon($todayRecords > 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down', 'before')
                ->descriptionColor($todayRecords > 0 ? 'success' : 'danger')
                ->iconColor('success'),
        ];
    }
}
