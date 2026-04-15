@extends('layouts.admin')

@section('sidebar-users')
bg-red-50 text-red-600 hover:bg-red-50 hover:text-red-600
@endsection

@section('page-style')
@endsection

@section('content')
<div class="grid grid-cols-[1fr_4fr] gap-4 items-start mb-4">
    <h1 class="text-start">Data Pengguna</h1>
    <div class="flex flex-wrap gap-3 ms-auto">
        <input id="search" type="text" placeholder="Cari nama/email..." class="bg-white rounded-md py-2 px-3 outline-none w-50"
        >
        <select id="role" class="bg-white rounded-md py-2 px-3 outline-none w-50">
            <option value="">Semua Peran</option>
            <option value="admin">Admin</option>
            <option value="editor">Editor</option>
            <option value="viewer">Viewer</option>
        </select>

        <button onclick="applyFilter()" class="bg-red-500 hover:bg-red-500 text-white px-6 py-2 rounded-md outline-none border-none cursor-pointer">
            Filter
        </button>
    </div>
</div>
<div class="overflow-x-auto bg-white rounded-md">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b border-gray-100">
                <td class="py-2 px-3 font-[500] w-[50px]">#ID</td>
                <td class="py-2 px-3 font-[500]">Nama Pengguna</td>
                <td class="py-2 px-3 font-[500]">Email</td>
                <td class="py-2 px-3 font-[500]">Peran</td>
                <td class="py-2 px-3 font-[500]">Status</td>
            </tr>
        </thead>
        <tbody id="userTable">
            <tr>
                <td colspan="5" class="py-2 px-3 text-center text-gray-500">
                    No data found
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="flex justify-between items-center mt-4">
    <button id="prevBtn"
        onclick="changePage(-1)"
        class="px-4 py-2 rounded-md hover:bg-gray-600 bg-gray-200 hover:text-white disabled:opacity-25 disabled:hover:bg-gray-200 disabled:hover:text-black" disabled>
        Sebelumnya
    </button>
    <span id="pageInfo" class="text-sm text-gray-600"></span>
    <button id="nextBtn"
        onclick="changePage(1)"
        class="px-4 py-2 rounded-md hover:bg-gray-600 bg-gray-200 hover:text-white disabled:opacity-25 disabled:hover:bg-gray-200 disabled:hover:text-black" disabled>
        Selanjutnya
    </button>
</div>
@endsection

@section('page-scripts')
<script>
    // Dummy Data
    const api_url   = '{{ route('api.users.index') }}'
    let page        = 1;

    loadUsers();
    async function loadUsers() {
        const search = document.getElementById('search')?.value || '';
        const role = document.getElementById('role')?.value || '';

        const url = `${api_url}?page=${page}&search=${search}&role=${role}`;

        try {
            const res = await fetch(url);
            const json = await res.json();

            const result = json.data;
            const users = result.data || [];

            document.getElementById('userTable').innerHTML =
                users.length
                    ? users.map(user => `
                        <tr>
                            <td class="py-2 px-3">${user.id}</td>
                            <td class="py-2 px-3">${user.name}</td>
                            <td class="py-2 px-3 opacity-50">${user.email}</td>
                            <td class="py-2 px-3 opacity-50 capitalize">${user.role ?? '-'}</td>
                            <td class="py-2 px-3 opacity-50 capitalize">${user.status ?? '-'}</td>
                        </tr>
                    `).join('')
                    : `<tr><td colspan="5" class="p-3 text-center text-gray-500">No data</td></tr>`;

            document.getElementById('pageInfo').innerText =
                `Page ${result.current_page} / ${result.last_page}`;

            document.getElementById('prevBtn').disabled = result.current_page <= 1;
            document.getElementById('nextBtn').disabled = result.current_page >= result.last_page;

        } catch (err) {
            console.error(err);
        }
    }

    function changePage(step) {
        page += step;
        loadUsers();
    }

    function applyFilter() {
        page = 1;
        loadUsers();
    }
</script>
@endsection
