
<div class="space-y-6">

    <!-- HEADER CODING PROJECT -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-700 via-violet-700 to-purple-800 p-6 text-white">
        <div class="relative z-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15 text-2xl">
                    <i class="fa-solid fa-code"></i>
                </div>

                <div>
                    <h3 class="text-lg font-black">Coding Project HTML</h3>
                    <p class="text-sm text-indigo-100">
                        Rancang proyek coding berbasis misi untuk siswa.
                    </p>
                </div>
            </div>

            <button type="button"
                @click="block.previewOpen = true"
                class="rounded-xl bg-white px-4 py-3 text-sm font-bold text-indigo-700 shadow-lg transition hover:bg-indigo-50">
                <i class="fa-solid fa-eye mr-2"></i>
                Preview Tampilan Siswa
            </button>
        </div>

        <i class="fa-solid fa-laptop-code absolute -bottom-8 -right-4 text-9xl text-white/10"></i>
    </div>


    <!-- INFORMASI PROYEK -->
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">

        <!-- IDENTITAS PROYEK -->
        <div class="space-y-4 rounded-2xl border border-gray-200 bg-white p-5">

            <div>
                <h4 class="font-bold text-gray-800">Informasi Proyek</h4>
                <p class="text-xs text-gray-500">
                    Tentukan identitas proyek yang akan dikerjakan siswa.
                </p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Nama Proyek
                </label>

                <input type="text"
                    x-model="block.project.nama"
                    :name="`sections[${index}][project][nama]`"
                    class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Contoh: Membuat Halaman Profil">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Deskripsi Proyek
                </label>

                <textarea
                    x-model="block.project.deskripsi"
                    :name="`sections[${index}][project][deskripsi]`"
                    rows="5"
                    class="w-full rounded-xl border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Jelaskan tujuan dan gambaran proyek..."></textarea>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-gray-700">
                    Bahasa Pemrograman
                </label>

                <div class="flex items-center gap-3 rounded-xl border border-orange-200 bg-orange-50 p-3">
                    <i class="fa-brands fa-html5 text-2xl text-orange-600"></i>

                    <div>
                        <p class="text-sm font-bold text-gray-800">HTML</p>
                        <p class="text-xs text-gray-500">Automatic Validation</p>
                    </div>

                    <span class="ml-auto rounded-lg bg-orange-100 px-3 py-1 text-xs font-bold text-orange-700">
                        HTML5
                    </span>
                </div>

                <input type="hidden"
                    :name="`sections[${index}][project][bahasa]`"
                    value="html">
            </div>
        </div>


        <!-- STARTER CODE -->
        <div class="space-y-4 rounded-2xl border border-gray-200 bg-white p-5">

            <div>
                <h4 class="font-bold text-gray-800">Starter Code</h4>
                <p class="text-xs text-gray-500">
                    Kode awal yang akan diterima siswa ketika memulai proyek.
                </p>
            </div>

            <div class="overflow-hidden rounded-xl bg-gray-950">

                <div class="flex items-center justify-between border-b border-white/10 bg-gray-900 px-4 py-3">
                    <span class="text-xs font-bold text-gray-200">
                        <i class="fa-solid fa-code mr-2 text-indigo-400"></i>
                        index.html
                    </span>

                    <span class="text-xs text-green-400">HTML</span>
                </div>

                <textarea
                    x-model="block.project.starter_code"
                    :name="`sections[${index}][project][starter_code]`"
                    rows="12"
                    spellcheck="false"
                    class="w-full resize-y border-0 bg-gray-950 p-4 font-mono text-xs leading-6 text-green-300 focus:ring-0"></textarea>
            </div>

            <div class="rounded-xl bg-indigo-50 p-3 text-xs text-indigo-800">
                <i class="fa-solid fa-lightbulb mr-1"></i>
                Kode ini menjadi dasar pengerjaan siswa dan digunakan pada setiap misi.
            </div>
        </div>
    </div>


    <!-- MISI CODING -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">

        <div class="flex flex-col gap-3 border-b border-gray-200 bg-gray-50 p-5 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-flag text-indigo-600"></i>
                    <h4 class="font-bold text-gray-800">Misi Coding</h4>
                </div>

                <p class="mt-1 text-xs text-gray-500">
                    Pecah proyek menjadi beberapa tahapan pengerjaan.
                </p>
            </div>

            <button type="button"
                @click="addMission(index)"
                class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow transition hover:bg-indigo-700">
                <i class="fa-solid fa-plus mr-1"></i>
                Tambah Misi
            </button>
        </div>


        <div class="space-y-4 p-5">

            <template x-for="(mission, mIndex) in block.project.missions" :key="mission.id">

                <div class="overflow-hidden rounded-2xl border border-gray-200">

                    <!-- HEADER MISI -->
                    <div class="flex items-center justify-between bg-indigo-50 px-4 py-3">

                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-sm font-black text-white"
                                x-text="mIndex + 1"></span>

                            <div>
                                <p class="text-sm font-bold text-gray-800"
                                    x-text="mission.judul || 'Misi Baru'"></p>

                                <p class="text-xs text-indigo-600">
                                    Tahapan pengerjaan proyek
                                </p>
                            </div>
                        </div>

                        <button type="button"
                            @click="removeMission(index, mIndex)"
                            class="rounded-lg p-2 text-red-500 hover:bg-red-50">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>


                    <!-- ISI MISI -->
                    <div class="space-y-4 p-4">

                        <input type="hidden"
                            :name="`sections[${index}][project][missions][${mIndex}][id]`"
                            x-model="mission.id">


                        <!-- JUDUL -->
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Judul Misi
                            </label>

                            <input type="text"
                                x-model="mission.judul"
                                :name="`sections[${index}][project][missions][${mIndex}][judul]`"
                                class="w-full rounded-xl border-gray-300 text-sm"
                                placeholder="Contoh: Membuat struktur HTML">
                        </div>


                        <!-- INSTRUKSI -->
                        <!-- INSTRUKSI MISI -->
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Instruksi Misi
                            </label>

                            <!-- Input tersembunyi untuk dikirim ke Laravel -->
                            <input
                                type="hidden"
                                x-model="mission.instruksi"
                                :name="`sections[${index}][project][missions][${mIndex}][instruksi]`"
                                :id="`mission-instruksi-${index}-${mIndex}`">

                            <!-- Trix Editor -->
                            <trix-editor
                                :input="`mission-instruksi-${index}-${mIndex}`"
                                x-init="$nextTick(() => {
                                    if ($el.editor) {
                                        $el.editor.loadHTML(mission.instruksi || '');
                                    }
                                })"
                                x-on:trix-change="mission.instruksi = $el.innerHTML"
                                class="trix-content min-h-[160px] rounded-xl border border-gray-300 bg-white text-sm focus-within:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-100">
                            </trix-editor>

                            <p class="mt-2 text-xs text-gray-400">
                                Gunakan toolbar untuk membuat instruksi lebih terstruktur.
                            </p>
                        </div>

                        <!-- PETUNJUK MISI -->
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Petunjuk Misi
                            </label>

                            <!-- Input tersembunyi untuk dikirim ke Laravel -->
                            <input
                                type="hidden"
                                x-model="mission.petunjuk"
                                :name="`sections[${index}][project][missions][${mIndex}][petunjuk]`"
                                :id="`mission-petunjuk-${index}-${mIndex}`">

                            <!-- Trix Editor -->
                            <trix-editor
                                :input="`mission-petunjuk-${index}-${mIndex}`"
                                x-init="$nextTick(() => {
                                    if ($el.editor) {
                                        $el.editor.loadHTML(mission.petunjuk || '');
                                    }
                                })"
                                x-on:trix-change="mission.petunjuk = $el.innerHTML"
                                class="trix-content min-h-[120px] rounded-xl border border-gray-300 bg-white text-sm focus-within:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-100">
                            </trix-editor>

                            <p class="mt-2 text-xs text-gray-400">
                                Berikan petunjuk tambahan untuk membantu siswa menyelesaikan misi.
                            </p>
                        </div>

                        <!-- KRITERIA VALIDASI -->
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                            <div class="mb-4">
                                <h5 class="text-sm font-bold text-gray-800">
                                    <i class="fa-solid fa-shield-halved mr-1 text-indigo-600"></i>
                                    Kriteria Validasi Otomatis
                                </h5>

                                <p class="text-xs text-gray-500">
                                    Tentukan syarat yang harus dipenuhi kode siswa.
                                </p>
                            </div>


                            <template x-for="(criterion, cIndex) in mission.criteria" :key="cIndex">

                                <div class="mb-3 grid grid-cols-1 items-center gap-2 rounded-lg bg-white p-3 md:grid-cols-2">

                                    <!-- JENIS KRITERIA -->
                                    <select
                                        x-model="criterion.type"
                                        :name="`sections[${index}][project][missions][${mIndex}][criteria][${cIndex}][type]`"
                                        class="rounded-lg border-gray-300 text-sm">

                                        <option value="tag_exists">
                                            Elemen HTML tersedia
                                        </option>

                                        <option value="text_contains">
                                            Teks tertentu tersedia
                                        </option>

                                        <option value="attribute_exists">
                                            Atribut tersedia
                                        </option>
                                    </select>


                                    <!-- TAG EXISTS -->
                                    <input
                                        type="text"
                                        x-show="criterion.type === 'tag_exists'"
                                        :disabled="criterion.type !== 'tag_exists'"
                                        x-model="criterion.tag"
                                        :name="`sections[${index}][project][missions][${mIndex}][criteria][${cIndex}][tag]`"
                                        class="rounded-lg border-gray-300 text-sm"
                                        placeholder="Contoh: h1, p, img">


                                    <!-- TEXT CONTAINS -->
                                    <input
                                        type="text"
                                        x-show="criterion.type === 'text_contains'"
                                        :disabled="criterion.type !== 'text_contains'"
                                        x-model="criterion.text"
                                        :name="`sections[${index}][project][missions][${mIndex}][criteria][${cIndex}][text]`"
                                        class="rounded-lg border-gray-300 text-sm"
                                        placeholder="Teks yang harus tersedia">


                                    <!-- ATTRIBUTE EXISTS -->
                                    <div
                                        x-show="criterion.type === 'attribute_exists'"
                                        class="flex gap-2">

                                        <input
                                            type="text"
                                            x-model="criterion.tag"
                                            :disabled="criterion.type !== 'attribute_exists'"
                                            :name="`sections[${index}][project][missions][${mIndex}][criteria][${cIndex}][tag]`"
                                            class="w-1/2 rounded-lg border-gray-300 text-sm"
                                            placeholder="Tag: img">

                                        <input
                                            type="text"
                                            x-model="criterion.attribute"
                                            :disabled="criterion.type !== 'attribute_exists'"
                                            :name="`sections[${index}][project][missions][${mIndex}][criteria][${cIndex}][attribute]`"
                                            class="w-1/2 rounded-lg border-gray-300 text-sm"
                                            placeholder="Atribut: src">
                                    </div>


                                    <!-- HAPUS KRITERIA -->
                                    <button type="button"
                                        @click="removeCriterion(index, mIndex, cIndex)"
                                        class="text-left text-xs font-semibold text-red-500">
                                        <i class="fa-solid fa-trash mr-1"></i>
                                        Hapus kriteria
                                    </button>

                                </div>
                            </template>


                            <!-- TAMBAH KRITERIA -->
                            <button type="button"
                                @click="addCriterion(index, mIndex)"
                                class="text-sm font-bold text-indigo-600 hover:text-indigo-800">
                                <i class="fa-solid fa-plus mr-1"></i>
                                Tambah Kriteria
                            </button>

                        </div>
                    </div>
                </div>
            </template>


            <!-- KOSONG -->
            <div x-show="block.project.missions.length === 0"
                class="rounded-xl border-2 border-dashed border-gray-200 p-8 text-center">

                <i class="fa-solid fa-flag text-3xl text-gray-300"></i>

                <p class="mt-3 text-sm font-bold text-gray-600">
                    Belum ada misi
                </p>

                <p class="mt-1 text-xs text-gray-400">
                    Tambahkan misi pertama untuk memulai proyek.
                </p>
            </div>

        </div>
    </div>


    <!-- PREVIEW TAMPILAN SISWA -->
    <div
        x-show="block.previewOpen"
        x-cloak
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-gray-950/70 p-3 sm:p-6"
        @keydown.escape.window="block.previewOpen = false">

        <div
            class="flex max-h-[95vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl bg-gray-100 shadow-2xl"
            @click.outside="block.previewOpen = false">


            <!-- HEADER MODAL -->
            <div class="flex items-center justify-between bg-gray-900 px-5 py-4 text-white">

                <div>
                    <h3 class="font-bold">Preview Tampilan Siswa</h3>

                    <p class="text-xs text-gray-400">
                        Simulasi tampilan Coding Project pada akun siswa.
                    </p>
                </div>

                <button type="button"
                    @click="block.previewOpen = false"
                    class="rounded-lg p-2 text-gray-300 hover:bg-white/10">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>


            <!-- ISI PREVIEW -->
            <div class="overflow-y-auto p-4 sm:p-6">

                <div class="overflow-hidden rounded-2xl bg-white shadow-sm">

                    <!-- HEADER PROYEK SISWA -->
                    <div class="bg-gradient-to-r from-indigo-700 to-violet-700 p-6 text-white">

                        <div class="mb-3 flex items-center gap-2 text-xs font-bold text-indigo-200">
                            <i class="fa-solid fa-code"></i>
                            CODING PROJECT / HTML
                        </div>

                        <h2 class="text-2xl font-black"
                            x-text="block.project.nama || 'Nama Proyek Belum Diisi'"></h2>

                        <p class="mt-2 max-w-2xl text-sm text-indigo-100"
                            x-text="block.project.deskripsi || 'Deskripsi proyek akan muncul di sini.'"></p>

                        <div class="mt-5 flex flex-wrap gap-2">

                            <span class="rounded-lg bg-white/15 px-3 py-2 text-xs font-bold">
                                <i class="fa-solid fa-list-check mr-1"></i>
                                <span x-text="block.project.missions.length"></span>
                                Misi
                            </span>

                            <span class="rounded-lg bg-white/15 px-3 py-2 text-xs font-bold">
                                <i class="fa-solid fa-code mr-1"></i>
                                HTML5
                            </span>

                        </div>
                    </div>


                    <!-- KONTEN PREVIEW -->
                    <div class="grid grid-cols-1 gap-5 p-5 lg:grid-cols-3">


                        <!-- DAFTAR MISI -->
                        <div class="space-y-3 lg:col-span-1">

                            <h4 class="font-bold text-gray-800">
                                Daftar Misi
                            </h4>

                            <template x-for="(mission, mIndex) in block.project.missions" :key="mission.id">

                                <div class="rounded-xl border border-indigo-100 bg-indigo-50 p-3">

                                    <div class="flex items-center gap-2">

                                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-xs font-bold text-white"
                                            x-text="mIndex + 1"></span>

                                        <span class="text-xs font-bold text-gray-800"
                                            x-text="mission.judul || 'Misi ' + (mIndex + 1)"></span>

                                    </div>
                                </div>
                            </template>


                            <div
                                x-show="block.project.missions.length === 0"
                                class="rounded-xl border border-dashed p-4 text-center text-xs text-gray-400">

                                Misi belum tersedia.
                            </div>
                        </div>


                        <!-- DETAIL MISI -->
                        <div class="space-y-4 lg:col-span-2">

                            <div class="rounded-xl border border-gray-200 bg-white p-4">

                                <div class="mb-3 flex items-center justify-between">

                                    <h4 class="font-bold text-gray-800">
                                        Petunjuk Pengerjaan
                                    </h4>

                                    <span class="rounded-lg bg-green-100 px-2 py-1 text-xs font-bold text-green-700">
                                        Contoh Tampilan
                                    </span>
                                </div>


                                <template x-if="block.project.missions.length > 0">

                                    <div>

                                        <h5 class="font-bold text-indigo-700"
                                            x-text="block.project.missions[0].judul || 'Misi Pertama'"></h5>

                                        <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-gray-600"
                                            x-text="block.project.missions[0].instruksi || 'Instruksi misi akan ditampilkan di sini.'"></p>


                                        <div class="mt-4 rounded-xl bg-amber-50 p-3">

                                            <p class="text-xs font-bold text-amber-700">
                                                <i class="fa-solid fa-lightbulb mr-1"></i>
                                                Petunjuk
                                            </p>

                                            <p class="mt-1 whitespace-pre-line text-xs text-amber-800"
                                                x-text="block.project.missions[0].petunjuk || 'Petunjuk tambahan akan muncul di sini.'"></p>

                                        </div>
                                    </div>
                                </template>


                                <div
                                    x-show="block.project.missions.length === 0"
                                    class="text-sm text-gray-400">

                                    Tambahkan misi untuk melihat instruksi siswa.
                                </div>

                            </div>


                            <!-- STARTER CODE PREVIEW -->
                            <div class="overflow-hidden rounded-xl border border-gray-800 bg-gray-950">

                                <div class="flex items-center justify-between border-b border-white/10 px-4 py-3">

                                    <span class="text-xs font-bold text-white">
                                        <i class="fa-solid fa-code mr-2 text-green-400"></i>
                                        Editor HTML - index.html
                                    </span>

                                    <span class="text-xs text-green-400">
                                        Starter Code
                                    </span>
                                </div>

                                <pre class="max-h-64 overflow-auto p-4 text-xs leading-6 text-green-300"><code x-text="block.project.starter_code || '<!-- Kode awal HTML -->'"></code></pre>

                            </div>

                        </div>
                    </div>
                </div>


                <p class="mt-4 text-center text-xs text-gray-500">
                    Preview ini merupakan simulasi tampilan siswa, bukan halaman pengerjaan yang sebenarnya.
                </p>

            </div>


            <!-- FOOTER MODAL -->
            <div class="flex justify-end border-t bg-white p-4">

                <button type="button"
                    @click="block.previewOpen = false"
                    class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-indigo-700">
                    Tutup Preview
                </button>

            </div>
        </div>
    </div>

</div>
@push('styles')
<style>
trix-editor {
    min-height: 120px;
    max-height: 400px;
    overflow-y: auto;
    padding: 12px 14px;
    line-height: 1.7;
    color: #374151;
}

trix-toolbar {
    background: #f9fafb;
    border: 1px solid #d1d5db;
    border-bottom: none;
    border-radius: 12px 12px 0 0;
    padding: 8px;
}

trix-toolbar .trix-button-group {
    border-color: #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
}

trix-toolbar .trix-button {
    border-bottom: none;
}

trix-toolbar .trix-button:not(:disabled):hover {
    background: #eef2ff;
}

trix-editor {
    border-radius: 0 0 12px 12px;
    border-color: #d1d5db;
}

trix-editor:focus {
    border-color: #6366f1;
    outline: none;
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.12);
}

trix-editor h1 {
    font-size: 1.25rem;
    font-weight: 800;
    margin-bottom: 10px;
}

trix-editor ul {
    list-style: disc;
    padding-left: 24px;
}

trix-editor ol {
    list-style: decimal;
    padding-left: 24px;
}

trix-editor a {
    color: #4f46e5;
    text-decoration: underline;
}
</style>
@endpush