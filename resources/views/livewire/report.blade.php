<div>
    @foreach (range(1, 12) as $month)
        @php
            $formattedMonth = sprintf('%02d', $month);
            $monthName = Carbon\Carbon::create()->month($month)->format('F');
            $daysInMonth = Carbon\Carbon::create($year, $month)->daysInMonth;
            $attendances = $monthlyAttendance->get($formattedMonth, collect());
            $previousDay = null;
        @endphp

        <div class="flex gap-9">
            <div class="ml-52 py-4 text-center justify-start">
                <div>
                    <h1 class="font-bold uppercase text-xl">Rekod Kehadiran Kakitangan</h1>
                </div>
                <div>
                    <h1 class="uppercase">{{ $user->name }}</h1>
                </div>
            </div>
            <div class="flex mt-24 gap-28">
                <h2>Tahun: {{ $year }}</h2>
                <h3>Bulan: {{ $month }}</h3>
            </div>
        </div>

        <table class="mx-auto my-4 table-auto w-2/3 border border-gray-700 bg-white overflow-hidden">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-2 border border-gray-700 text-left">HB</th>
                    <th class="px-2 border w-80 border-gray-700 text-left">Keterangan</th>
                    <th class="px-2 border border-gray-700 text-left">Masuk</th>
                    <th class="px-2 border border-gray-700 text-left">Keluar</th>
                    <th class="px-2 border border-gray-700 text-left">Tempoh</th>
                    <th class="px-2 border border-gray-700 text-left">Jumlah</th>
                    <th class="px-2 border border-gray-700 text-left">Point</th>
                </tr>
            </thead>
            <tbody>
                @foreach (range(1, $daysInMonth) as $day)
                    @php
                        $attendancesForDay = $attendances->filter(function ($attend) use ($day) {
                            return Carbon\Carbon::parse($attend->check_in)->format('d') == sprintf('%02d', $day);
                        });
                        $dayKey = sprintf('%04d-%02d-%02d', $year, $month, $day);
                    @endphp

                    @if ($attendancesForDay->isNotEmpty())
                        @foreach ($attendancesForDay as $index => $attend)
                            <tr class="{{ $day % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">

                                <td class="text-center px-2 border border-b border-gray-700">
                                    @if ($day !== $previousDay)
                                        {{ $day }}
                                        @php $previousDay = $day; @endphp
                                    @else
                                        <div class="invisible">{{ $day }}</div>
                                    @endif
                                </td>

                                <td class="border px-2 border-b border-gray-700">{{ $attend->catatan }}</td>
                                <td class="text-right border px-2 border-b border-gray-700">
                                    {{ $attend->formatted_in_time }}</td>
                                <td class="text-right border px-2 border-b border-gray-700">
                                    {{ $attend->formatted_out_time }}</td>
                                <td class="text-right border px-2 border-b border-gray-700">{{ $attend->duration }}</td>

                                <td class="text-right border px-2 border-b border-gray-700">
                                    @if ($index == 0)
                                        @php
                                            $totalHoursDecimal = $dailyDuration[$dayKey];
                                            $hours = floor($totalHoursDecimal);
                                            $minutes = round(($totalHoursDecimal - $hours) * 60);
                                        @endphp
                                        {{ sprintf('%02d:%02d', $hours, $minutes) }}
                                    @else
                                        <div class="invisible"></div>
                                    @endif
                                </td>

                                <td class="text-right border px-2 border-b border-gray-700">{{ $attend->point }}</td>
                            </tr>
                        @endforeach

                        @if ($attendancesForDay->count() === 1)
                            <tr class="{{ $day % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="text-center px-2 border border-b border-gray-700">
                                    <div class="invisible">{{ $day }}</div>
                                </td>
                                <td class="border px-2 border-b border-gray-700"></td> 
                                <td class="text-right border px-2 border-b border-gray-700"></td> 
                                <td class="text-right border px-2 border-b border-gray-700"></td> 
                                <td class="text-right border px-2 border-b border-gray-700"></td> 
                                <td class="text-right border px-2 border-b border-gray-700"></td> 
                                <td class="text-right border px-2 border-b border-gray-700"></td> 
                            </tr>
                        @endif
                    @else

                        @for ($i = 0; $i < 2; $i++)
                            <tr class="{{ $day % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="text-center px-2 border border-b border-gray-700">
                                    @if ($i === 0)
                                        {{ $day }}
                                    @else
                                        <div class="invisible">{{ $day }}</div>
                                    @endif
                                </td>
                                <td class="border px-2 border-b border-gray-700"></td>
                                <td class="text-right border px-2 border-b border-gray-700"></td>
                                <td class="text-right border px-2 border-b border-gray-700"></td>
                                <td class="text-right border px-2 border-b border-gray-700"></td>
                                <td class="text-right border px-2 border-b border-gray-700"></td>
                                <td class="text-right border px-2 border-b border-gray-700"></td>
                            </tr>
                        @endfor
                    @endif
                @endforeach
            </tbody>
            <tfoot class="bg-gray-200 text-gray-700">
                <tr>
                    <td colspan="4" class="text-right border border-gray-700 font-bold">Total for
                        {{ $monthName }}:</td>
                    <td class="border border-gray-700">
                        @php
                            $totalHoursDecimal = $totalDuration[$formattedMonth];
                            $hours = floor($totalHoursDecimal);
                            $minutes = round(($totalHoursDecimal - $hours) * 60);
                        @endphp
                        {{ sprintf('%02d:%02d', $hours, $minutes) }}
                    </td>
                    <td class="border border-gray-700"></td>
                    <td class="border border-gray-700">{{ $totalWorkPoint[$formattedMonth] }}</td>
                </tr>
            </tfoot>
        </table>
    @endforeach
</div>
