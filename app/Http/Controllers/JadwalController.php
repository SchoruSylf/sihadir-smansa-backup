<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        // Fetch schedules from the database and join necessary tables
        $schedules = DB::table('jadwals')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->select(
                'jadwals.hari',
                'jadwals.jam_mulai',
                'jadwals.jam_selesai',
                'mata_pelajarans.kode_mapel AS mapel_kode',
                'kelas.kelas AS kelas_nama',
                'kelas.jenis_kelas'
            )
            ->orderBy('jadwals.hari')
            ->orderBy('jadwals.jam_mulai')
            ->orderBy('kelas.jenis_kelas')
            ->get()
            ->map(function ($schedule) {
                $schedule->jam_mulai = Carbon::parse($schedule->jam_mulai)->format('H:i');
                $schedule->jam_selesai = Carbon::parse($schedule->jam_selesai)->format('H:i');
                return $schedule;
            });

        // Define breaks for each day
        $breaks = [
            'Senin' => [
                ['start' => '10:00', 'end' => '10:15'],
                ['start' => '11:45', 'end' => '12:15']
            ],
            'Selasa' => [
                ['start' => '10:00', 'end' => '10:15'],
                ['start' => '11:45', 'end' => '12:15']
            ],
            'Rabu' => [
                ['start' => '10:00', 'end' => '10:15'],
                ['start' => '11:45', 'end' => '12:15']
            ],
            'Kamis' => [
                ['start' => '10:00', 'end' => '10:15'],
                ['start' => '11:45', 'end' => '12:15']
            ],
            'Jumat' => [
                ['start' => '09:15', 'end' => '09:30']
            ]
        ];

        // Process intervals and handle breaks
        $processedSchedules = $schedules->groupBy('hari')->map(function ($daySchedules, $hari) use ($breaks) {
            $intervals = [];
            foreach ($daySchedules as $schedule) {
                $start = Carbon::parse($schedule->jam_mulai);
                $end = Carbon::parse($schedule->jam_selesai);

                // Add breaks into the schedule
                foreach ($breaks[$hari] as $break) {
                    $breakStart = Carbon::parse($break['start']);
                    $breakEnd = Carbon::parse($break['end']);

                    // Add intervals before and after breaks
                    while ($start < $end) {
                        if ($start < $breakStart && $start->copy()->addMinutes(45) > $breakStart) {
                            $intervalEnd = $breakStart;
                        } else if ($start >= $breakEnd) {
                            $intervalEnd = $start->copy()->addMinutes(45);
                            if ($intervalEnd > $end) {
                                $intervalEnd = $end;
                            }
                        } else {
                            $intervalEnd = $start->copy()->addMinutes(45);
                            if ($intervalEnd > $end) {
                                $intervalEnd = $end;
                            }
                        }

                        $intervals[] = (object) [
                            'hari' => $schedule->hari,
                            'jam_mulai' => $start->format('H:i'),
                            'jam_selesai' => $intervalEnd->format('H:i'),
                            'mapel_kode' => $schedule->mapel_kode,
                            'kelas_nama' => $schedule->kelas_nama,
                            'jenis_kelas' => $schedule->jenis_kelas,
                        ];
                        $start = $intervalEnd;

                        // Handle break interval
                        if ($start == $breakStart) {
                            $intervals[] = (object) [
                                'hari' => $hari,
                                'jam_mulai' => $break['start'],
                                'jam_selesai' => $break['end'],
                                'mapel_kode' => 'ISTIRAHAT',
                                'kelas_nama' => '',
                                'jenis_kelas' => '',
                                'is_break' => true,
                            ];
                            $start = $breakEnd;
                        }
                    }
                }

                // Add last interval if it's not already added
                if ($start->format('H:i') != $end->format('H:i')) {
                    $intervals[] = (object) [
                        'hari' => $schedule->hari,
                        'jam_mulai' => $start->format('H:i'),
                        'jam_selesai' => $end->format('H:i'),
                        'mapel_kode' => $schedule->mapel_kode,
                        'kelas_nama' => $schedule->kelas_nama,
                        'jenis_kelas' => $schedule->jenis_kelas,
                    ];
                }
            }

            // Add remaining breaks if not already included
            foreach ($breaks[$hari] as $break) {
                $breakIncluded = collect($intervals)->first(function ($interval) use ($break) {
                    return $interval->jam_mulai == $break['start'] && $interval->jam_selesai == $break['end'];
                });

                if (!$breakIncluded) {
                    $intervals[] = (object) [
                        'hari' => $hari,
                        'jam_mulai' => $break['start'],
                        'jam_selesai' => $break['end'],
                        'mapel_kode' => 'ISTIRAHAT',
                        'kelas_nama' => '',
                        'jenis_kelas' => '',
                        'is_break' => true,
                    ];
                }
            }

            return collect($intervals)->sortBy('jam_mulai')->values();
        });

        // Group and sort schedules by time range
        $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $groupedSchedules = $processedSchedules->sortKeysUsing(function ($a, $b) use ($daysOfWeek) {
            return array_search($a, $daysOfWeek) - array_search($b, $daysOfWeek);
        })->map(function ($schedules) {
            return $schedules->groupBy(function ($schedule) {
                return $schedule->jam_mulai . '-' . $schedule->jam_selesai;
            })->map(function ($timeSchedules) {
                $slots = [];
                foreach (range(10, 12) as $kelas) {
                    foreach (range('A', 'L') as $column) {
                        $schedule = $timeSchedules->first(function ($schedule) use ($kelas, $column) {
                            return $schedule->kelas_nama == $kelas && $schedule->jenis_kelas == $column;
                        });
                        $slots[$kelas][$column] = $schedule ? $schedule->mapel_kode : ' ';
                    }
                }
                return [
                    'time_range' => $timeSchedules->first()->jam_mulai . ' - ' . $timeSchedules->first()->jam_selesai,
                    'slots' => $slots,
                    'is_break' => $timeSchedules->first()->is_break ?? false,
                ];
            })->values();
        });

        return view('jadwal', [
            'groupedSchedules' => $groupedSchedules // Pass grouped schedules to the view
        ]);
    }
}
