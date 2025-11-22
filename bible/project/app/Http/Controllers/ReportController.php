<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IssuanceBook;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function generate(Request $request)
    {
        $period = $request->input('period', []);
        $from = Carbon::parse($period['from'] ?? now()->startOfMonth());
        $to = Carbon::parse($period['to'] ?? now()->endOfMonth());

        $issuances = IssuanceBook::with('informationResource')
            ->whereBetween('created_at', [$from, $to])
            ->get()
            ->groupBy(fn($item) => Carbon::parse($item->created_at)->format('Y-m-d'));

        // Ключи = то, что хранится в БД
        $categories = [
            'political' => 'Политическая литература (1, 2, 3к, 3)',
            'natural_science' => 'Естествознание',
            'mathematics' => 'Математика',
            'medicine' => 'Медицина (5, 5а, 61)',
            'technical' => 'Техника (6)',
            'art_and_sport' => 'Искусство и спорт (7)',
            'fiction' => 'Художественная литература',
            'magazines' => 'Журналы',
            'other' => 'Прочие (0,4,8,91)',
            'videocassettes' => 'Видеокассеты',
            'audiorecords' => 'Звукозаписи',
        ];

        $header = array_merge(
            ['Дата', 'Всего выдано'],
            array_values($categories),
            ['Студентам', 'Прочим']
        );

        $filePath = storage_path('app/public/issuance_report_' . now()->format('Y_m_d_H_i_s') . '.xlsx');
        $writer = SimpleExcelWriter::create($filePath)->addHeader($header);

        $totals = array_fill_keys(array_merge(['all'], array_keys($categories), ['students', 'others']), 0);

        foreach ($issuances as $date => $items) {
            $dayStats = array_fill_keys(array_merge(['all'], array_keys($categories), ['students', 'others']), 0);
            $dayStats['all'] = $items->count();

            foreach ($items as $item) {
                $bookType = optional($item->informationResource)->type ?? 'other';

                if (!array_key_exists($bookType, $categories)) {
                    $bookType = 'other';
                }

                $dayStats[$bookType]++;

                $consumer = mb_strtolower($item->consumer);
                if (str_contains($consumer, 'студ') || $consumer === 'student' || $consumer === 'студентам') {
                    $dayStats['students']++;
                } else {
                    $dayStats['others']++;
                }
            }

            $row = [
                Carbon::parse($date)->format('d.m.Y'),
                $dayStats['all'],
            ];

            foreach (array_keys($categories) as $key) {
                $row[] = $dayStats[$key];
            }

            $row[] = $dayStats['students'];
            $row[] = $dayStats['others'];

            $writer->addRow($row);

            foreach ($totals as $key => $_) {
                $totals[$key] += $dayStats[$key];
            }
        }

        // Итоговая строка
        $totalRow = ['Итого', $totals['all']];
        foreach (array_keys($categories) as $key) {
            $totalRow[] = $totals[$key];
        }
        $totalRow[] = $totals['students'];
        $totalRow[] = $totals['others'];

        $writer->addRow($totalRow);
        $writer->close();

        return response()->download($filePath)->deleteFileAfterSend();
    }
}
