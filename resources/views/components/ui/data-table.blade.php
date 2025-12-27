@props([
    'title' => 'Table',
    'columns' => [],
    'rows' => [],
    'perPage' => 10,
])

<div
    x-data="{
        rows: {{ json_encode($rows) }},
        perPage: {{ $perPage }},
        page: 1,
        search: '',
        selected: [],

        get filtered() {
            if (!this.search) return this.rows

            return this.rows.filter(row =>
                Object.values(row)
                    .join(' ')
                    .toLowerCase()
                    .includes(this.search.toLowerCase())
            )
        },

        get from() {
            return (this.page - 1) * this.perPage
        },

        get to() {
            return Math.min(this.from + this.perPage, this.filtered.length)
        },

        get paginatedRows() {
            return this.filtered.slice(this.from, this.to)
        },

        next() {
            if (this.to < this.filtered.length) this.page++
        },

        prev() {
            if (this.page > 1) this.page--
        },

        toggleAll(e) {
            this.selected = e.target.checked
                ? this.paginatedRows.map(r => r.id)
                : []
        }
    }"
    class="bg-white dark:bg-zinc-900
           rounded-xl border border-zinc-200 dark:border-zinc-700
           overflow-hidden"
>

    <!-- HEADER -->
    <div class="p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h2 class="font-semibold text-lg text-zinc-900 dark:text-white">
            {{ $title }}
            <span class="text-sm text-zinc-400">
                (<span x-text="rows.length"></span>)
            </span>
        </h2>

        <input
            x-model="search"
            placeholder="Search..."
            class="w-full md:w-64 px-4 py-2 rounded-lg text-sm
                   bg-zinc-100 dark:bg-zinc-800
                   border border-zinc-300 dark:border-zinc-600
                   focus:outline-none focus:ring-2 focus:ring-red-600"
        />
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-zinc-100 dark:bg-zinc-800">
                <tr>
                    <th class="p-3 w-10">
                        <input type="checkbox" @change="toggleAll($event)">
                    </th>

                    @foreach ($columns as $column)
                        <th class="p-3 text-left font-medium text-zinc-700 dark:text-zinc-300">
                            {{ $column }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                <template x-for="row in paginatedRows" :key="row.id">
                    <tr
                        class="border-t border-zinc-200 dark:border-zinc-700
                               hover:bg-zinc-50 dark:hover:bg-zinc-800 transition"
                    >
                        <td class="p-3">
                            <input
                                type="checkbox"
                                :value="row.id"
                                x-model="selected"
                            >
                        </td>

                        <template x-for="value in Object.values(row).slice(1)">
                            <td
                                class="p-3 text-zinc-700 dark:text-zinc-300"
                                x-text="value"
                            ></td>
                        </template>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="p-4 flex items-center justify-between text-sm">
        <span class="text-zinc-500">
            Showing
            <span x-text="from + 1"></span>
            -
            <span x-text="to"></span>
            of
            <span x-text="filtered.length"></span>
        </span>

        <div class="flex gap-2">
            <button
                @click="prev"
                :disabled="page === 1"
                class="px-3 py-1 rounded border disabled:opacity-40"
            >
                Prev
            </button>

            <button
                @click="next"
                :disabled="to >= filtered.length"
                class="px-3 py-1 rounded border"
            >
                Next
            </button>
        </div>
    </div>

</div>
