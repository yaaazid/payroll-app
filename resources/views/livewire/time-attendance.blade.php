<div>
<div class="p-6 max-w-6xl mx-auto text-gray-200 bg-gray-900 min-h-screen">
    <h2 class="text-3xl font-bold mb-6 text-indigo-400 flex items-center gap-2">
        🕒 <span>Time & Attendance</span>
    </h2>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-800 text-green-200 rounded-md shadow-sm border border-green-600">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="saveOvertime" class="mb-10 bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
        <h3 class="text-xl font-semibold text-indigo-300 mb-4">Add Overtime</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">Employee ID</label>
                <input type="text" wire:model="employee_id"
                    class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('employee_id') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">Date</label>
                <input type="date" wire:model="overtime_date"
                    class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('overtime_date') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">Start Time</label>
                <input type="time" wire:model="start_time"
                    class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('start_time') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">End Time</label>
                <input type="time" wire:model="end_time"
                    class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('end_time') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">Duration (hours)</label>
                <input type="text" wire:model="duration_hours" readonly
                    class="w-full bg-gray-700 text-gray-400 border border-gray-600 rounded px-3 py-2 cursor-not-allowed">
                @error('duration_hours') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">Reason</label>
                <textarea wire:model="reason" rows="3"
                    class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                @error('reason') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded font-semibold transition">
                Save Overtime
            </button>
        </div>
    </form>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-gray-800 p-4 rounded-lg shadow-md border border-gray-700">
            <h4 class="text-lg font-semibold text-indigo-300 mb-3">Recent Attendances</h4>
            <ul class="space-y-2 text-sm">
                @foreach ($attendances as $att)
                    <li class="flex justify-between border-b border-gray-700 pb-1">
                        <span>{{ $att->employee_id }} - {{ $att->attendance_date }}</span>
                        <span>{{ $att->status }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="bg-gray-800 p-4 rounded-lg shadow-md border border-gray-700">
            <h4 class="text-lg font-semibold text-indigo-300 mb-3">Recent Overtimes</h4>
            <ul class="space-y-2 text-sm">
                @foreach ($overtimes as $ot)
                    <li class="flex justify-between border-b border-gray-700 pb-1">
                        <span>{{ $ot->employee_id }} - {{ $ot->overtime_date }}</span>
                        <span>{{ $ot->duration_hours }} hrs</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

</div>
