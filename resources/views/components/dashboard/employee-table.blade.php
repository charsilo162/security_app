<div
    x-data="{
        search: '',
        perPage: 5,
        page: 1,
        selected: [],
        employees: [
            {id:'EMP001', name:'John Smith', email:'john@example.com', role:'Engineer'},
            {id:'EMP002', name:'Sarah Johnson', email:'sarah@example.com', role:'Manager'},
            {id:'EMP003', name:'Michael Brown', email:'mike@example.com', role:'Designer'},
            {id:'EMP004', name:'Emily Davis', email:'emily@example.com', role:'HR'},
            {id:'EMP005', name:'David Miller', email:'david@example.com', role:'DevOps'},
            {id:'EMP006', name:'Lisa Wong', email:'lisa@example.com', role:'Marketing'},
        ],

        get filtered() {
            return this.employees.filter(e =>
                e.name.toLowerCase().includes(this.search.toLowerCase())
            )
        },

        get paginated() {
            let start = (this.page - 1) * this.perPage
            return this.filtered.slice(start, start + this.perPage)
        },

        toggleAll(e) {
            this.selected = e.target.checked
                ? this.paginated.map(e => e.id)
                : []
        }
    }"
    class="bg-white dark:bg-zinc-900 rounded-xl border dark:border-zinc-700"
>

    <!-- HEADER -->
    <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <h2 class="font-semibold text-lg">
            Employees <span class="text-sm text-zinc-400">(250)</span>
        </h2>

        <input
            x-model="search"
            placeholder="Search employee..."
            class="border rounded-lg px-4 py-2 text-sm
                   dark:bg-zinc-800 dark:border-zinc-600"
        />
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-zinc-100 dark:bg-zinc-800">
                <tr>
                    <th class="p-3">
                        <input type="checkbox" @change="toggleAll">
                    </th>
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Role</th>
                </tr>
            </thead>

            <tbody>
                <template x-for="emp in paginated" :key="emp.id">
                    <tr class="border-t dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <td class="p-3">
                            <input type="checkbox" :value="emp.id" x-model="selected">
                        </td>
                        <td class="p-3" x-text="emp.id"></td>
                        <td class="p-3" x-text="emp.name"></td>
                        <td class="p-3" x-text="emp.email"></td>
                        <td class="p-3" x-text="emp.role"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="p-4 flex justify-between items-center text-sm">
        <span>
            Showing
            <span x-text="(page - 1) * perPage + 1"></span>
            -
            <span x-text="Math.min(page * perPage, filtered.length)"></span>
        </span>

        <div class="flex gap-2">
            <button @click="page--" :disabled="page === 1">Prev</button>
            <button @click="page++" :disabled="page * perPage >= filtered.length">Next</button>
        </div>
    </div>

</div>
