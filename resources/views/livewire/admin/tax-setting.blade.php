<div x-data="{ open: false }">
    <div class="p-6 max-w-5xl mx-auto text-gray-200 bg-gray-900 min-h-screen">
        <h2 class="text-3xl font-bold mb-6 text-indigo-400 flex items-center gap-2">
            📋 <span>Tax Settings</span>
        </h2>

        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-800 text-green-200 rounded-md shadow-sm border border-green-600">
                {{ session('success') }}
            </div>
        @endif

        {{-- Trigger --}}
        <button
            @click="open = true"
            class="mb-6 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded transition">
            + Add New Tax
        </button>

        {{-- Modal --}}
        <div
            x-show="open"
            x-transition
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50"
        >
            <div class="bg-gray-800 w-full max-w-2xl p-6 rounded-lg shadow-xl relative border border-gray-700">
                <h3 class="text-xl font-semibold text-indigo-400 mb-4">
                    {{ $taxId ? 'Edit Tax' : 'Add New Tax' }}
                </h3>

                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm mb-1">Name</label>
                            <input type="text" wire:model.defer="name"
                                class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm mb-1">Rate (%)</label>
                            <input type="number" wire:model.defer="rate" step="0.01"
                                class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('rate') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm mb-1">Threshold</label>
                            <input type="number" wire:model.defer="threshold" step="0.01"
                                class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('threshold') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm mb-1">Description</label>
                            <textarea wire:model.defer="description" rows="3"
                                class="w-full bg-gray-700 text-gray-200 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                            @error('description') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-3">
                        <button type="button"
                            @click="open = false"
                            class="px-4 py-2 text-sm text-gray-300 hover:text-white hover:underline">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded transition">
                            {{ $taxId ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow border border-gray-700 mt-6">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-700 text-gray-300">
                    <tr>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Description</th>
                        <th class="p-3 text-left">Rate (%)</th>
                        <th class="p-3 text-left">Threshold</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($taxes as $tax)
                        <tr class="border-t border-gray-700 hover:bg-gray-700/50 transition">
                            <td class="p-3 text-gray-200">{{ $tax->name }}</td>
                            <td class="p-3 text-gray-300">{{ $tax->description }}</td>
                            <td class="p-3 text-gray-300">{{ $tax->rate }}</td>
                            <td class="p-3 text-gray-300">{{ $tax->threshold }}</td>
                            <td class="p-3 text-center space-x-2">
                                <button wire:click="edit({{ $tax->id }})"
                                    @click="open = true"
                                    class="text-indigo-400 hover:underline font-medium">Edit</button>
                                <button wire:click="delete({{ $tax->id }})"
                                    class="text-red-400 hover:underline font-medium"
                                    onclick="confirm('Are you sure you want to delete this tax?') || event.stopImmediatePropagation()">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-400">No tax records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
