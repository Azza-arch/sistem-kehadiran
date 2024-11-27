<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Report extends Component
{
    public $totalDuration = [];
    public $dailyDuration = [];
    public $totalWorkPoint = [];
    public $user;
    public $year;
    public $month;

    public function mount($userId, $year = null, $month = null)
    {
        $this->year = $year ?? Carbon::now()->format('Y');
        $this->month = $month ?? Carbon::now()->format('m');

        $this->user = User::with('attend')->findOrFail($userId);

        $attendancesByMonth = $this->user->attend
            ->whereBetween('check_in', [
                Carbon::create($this->year)->startOfYear(),
                Carbon::create($this->year)->endOfYear(),
            ])
            ->groupBy(fn($attendance) => Carbon::parse($attendance->check_in)->format('m'));

        foreach (range(1, 12) as $month) {
            $month = sprintf('%02d', $month);

            $this->totalDuration[$month] = 0;
            $this->totalWorkPoint[$month] = 0;
            $daysInMonth = Carbon::create($this->year, $month)->daysInMonth;

            foreach (range(1, $daysInMonth) as $day) {
                $dayKey = sprintf('%04d-%02d-%02d', $this->year, $month, $day);
                $this->dailyDuration[$dayKey] = 0;
            }
        }

        foreach ($attendancesByMonth as $month => $attendances) {
            $uniqueDaysInMonth = [];

            foreach ($attendances as $attendance) {
                $checkInTime = Carbon::parse($attendance->check_in);
                $checkOutTime = Carbon::parse($attendance->check_out);
                $dayKey = $checkInTime->format('Y-m-d');

                $attendance->day = $checkInTime->format('d');
                $attendance->formatted_in_time = $checkInTime->format('h:i A');
                $attendance->formatted_out_time = $checkOutTime->format('h:i A');

                $durationInMin = $checkInTime->diffInMinutes($checkOutTime);
                $durationInHours = $durationInMin / 60;
                $attendance->duration = sprintf('%02d:%02d', intdiv($durationInMin, 60), $durationInMin % 60);

                $this->dailyDuration[$dayKey] += $durationInHours;

                $this->totalDuration[$month] += $durationInHours;

                $uniqueDaysInMonth[$dayKey] = true;

                if ($this->dailyDuration[$dayKey] < 3) {
                    $attendance->point = 0;
                } elseif ($this->dailyDuration[$dayKey] >= 3 && $this->dailyDuration[$dayKey] < 5) {
                    $attendance->point = 0.5;
                } else {
                    $attendance->point = 1;
                }

                $this->totalWorkPoint[$month] += $attendance->point;
            }
        }
    }

    public function render()
    {
        return view('livewire.report', [
            'monthlyAttendance' => $this->user->attend
                ->whereBetween('check_in', [
                    Carbon::create($this->year)->startOfYear(),
                    Carbon::create($this->year)->endOfYear(),
                ])
                ->groupBy(fn($attendance) => Carbon::parse($attendance->check_in)->format('m')),
            'year' => $this->year,
            'totalDuration' => $this->totalDuration,
            'totalWorkPoint' => $this->totalWorkPoint,
            'dailyDuration' => $this->dailyDuration,
        ]);
    }
}
