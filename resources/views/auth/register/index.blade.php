@extends('auth.layouts.app')

@section('title', 'Daftar Akun Baru')

@section('content')
    <div class="w-full max-w-5xl bg-white dark:bg-[#120f22] sm:rounded-3xl shadow-2xl border-0 sm:border border-slate-100 dark:border-purple-500/10 overflow-hidden grid lg:grid-cols-12 min-h-screen sm:min-h-[700px]">
        <!-- Left Column (Form) -->
        <div class="lg:col-span-6 p-8 sm:p-12 flex flex-col justify-between relative order-last lg:order-first">
            
            <div class="flex items-center gap-2.5 mb-6">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-purple-600 flex items-center justify-center text-white shadow-md shadow-purple-500/20">
                    <i class="fa-solid fa-brain text-sm"></i>
                </div>
                <span class="font-extrabold text-base tracking-tight bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-300 bg-clip-text text-transparent">
                    Learn<span class="text-purple-500">DL</span>
                </span>
            </div>

            <div class="my-auto space-y-5">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                        Mulai Perjalanan Anda
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1.5 font-medium">
                        Buat akun baru untuk pengalaman belajar baru
                    </p>
                </div>

                <form id="register-form" class="space-y-4" action="{{ route('register.store') }}" method="POST">
                    @csrf
                    
                    <!-- 1. Peran / Role -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Daftar Sebagai</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative block cursor-pointer">
                                <input type="radio" name="role" value="siswa" {{ old('role', 'siswa') === 'siswa' ? 'checked' : '' }} class="sr-only role-radio">
                                <div class="role-card p-3.5 rounded-xl bg-slate-50 dark:bg-[#1a1632] border border-slate-200 dark:border-purple-500/20 text-center transition-all duration-200 hover:border-purple-500/40">
                                    <div class="role-icon text-slate-400 dark:text-slate-500 mb-1.5 transition duration-200">
                                        <i class="fa-solid fa-user-graduate text-base"></i>
                                    </div>
                                    <h3 class="text-xs font-bold text-slate-800 dark:text-slate-200">Siswa</h3>
                                    <p class="text-[10px] text-slate-400 mt-0.5 font-medium">Akses Sandbox & Materi</p>
                                </div>
                            </label>

                            <label class="relative block cursor-pointer">
                                <input type="radio" name="role" value="guru" {{ old('role') === 'guru' ? 'checked' : '' }} class="sr-only role-radio">
                                <div class="role-card p-3.5 rounded-xl bg-slate-50 dark:bg-[#1a1632] border border-slate-200 dark:border-purple-500/20 text-center transition-all duration-200 hover:border-purple-500/40">
                                    <div class="role-icon text-slate-400 dark:text-slate-500 mb-1.5 transition duration-200">
                                        <i class="fa-solid fa-chalkboard-user text-base"></i>
                                    </div>
                                    <h3 class="text-xs font-bold text-slate-800 dark:text-slate-200">Instruktur / Guru</h3>
                                    <p class="text-[10px] text-slate-400 mt-0.5 font-medium">Manajemen Kelas & Log</p>
                                </div>
                            </label>
                        </div>
                        @error('role')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2. Nama Lengkap -->
                    <div class="space-y-1.5">
                        <label for="fullname" class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 dark:text-slate-500 text-xs">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input type="text" id="fullname" name="fullname" value="{{ old('fullname') }}" required placeholder="Masukkan nama lengkap Anda" 
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-[#1a1632] border @error('fullname') border-red-500 @else border-slate-200 dark:border-purple-500/20 @enderror rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/10 text-slate-900 dark:text-white transition duration-200 placeholder:text-slate-400 dark:placeholder:text-slate-600">
                        </div>
                        @error('fullname')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 3. Alamat Email & WhatsApp -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1.5">
                            <label for="email" class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Alamat Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 dark:text-slate-500 text-xs">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" 
                                    class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-[#1a1632] border @error('email') border-red-500 @else border-slate-200 dark:border-purple-500/20 @enderror rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/10 text-slate-900 dark:text-white transition duration-200 placeholder:text-slate-400 dark:placeholder:text-slate-600">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="phone" class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Nomor WhatsApp</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 dark:text-slate-500 text-xs">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </span>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="081234567890" 
                                    class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-[#1a1632] border @error('phone') border-red-500 @else border-slate-200 dark:border-purple-500/20 @enderror rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/10 text-slate-900 dark:text-white transition duration-200 placeholder:text-slate-400 dark:placeholder:text-slate-600">
                            </div>
                            @error('phone')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- 4. Asal Sekolah, Tingkat/Kelas, & Mata Pelajaran -->
                    <div class="border-t border-slate-100 dark:border-purple-500/10 pt-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Asal Sekolah -->
                            <div class="space-y-1.5">
                                <label for="school_name" class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Asal Sekolah</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 dark:text-slate-500 text-xs">
                                        <i class="fa-solid fa-school"></i>
                                    </span>
                                    <select id="school_name" name="school_name" required
                                        class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-[#1a1632] border @error('school_name') border-red-500 @else border-slate-200 dark:border-purple-500/20 @enderror rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/10 text-slate-900 dark:text-white transition duration-200">
                                        <option value="">-- Pilih Sekolah --</option>
                                        <option value="SMKN 4 MALANG" {{ old('school_name') == 'SMKN 4 MALANG' ? 'selected' : '' }}>SMKN 4 MALANG</option>
                                        <option value="SMKN 5 MALANG" {{ old('school_name') == 'SMKN 5 MALANG' ? 'selected' : '' }}>SMKN 5 MALANG</option>
                                        <option value="SMKN 6 MALANG" {{ old('school_name') == 'SMKN 6 MALANG' ? 'selected' : '' }}>SMKN 6 MALANG</option>
                                        <option value="SMKN 8 MALANG" {{ old('school_name') == 'SMKN 8 MALANG' ? 'selected' : '' }}>SMKN 8 MALANG</option>
                                        <option value="SMKN 9 MALANG" {{ old('school_name') == 'SMKN 9 MALANG' ? 'selected' : '' }}>SMKN 9 MALANG</option>
                                        <option value="SMKN 11 MALANG" {{ old('school_name') == 'SMKN 11 MALANG' ? 'selected' : '' }}>SMKN 11 MALANG</option>
                                        <option value="SMKN 12 MALANG" {{ old('school_name') == 'SMKN 12 MALANG' ? 'selected' : '' }}>SMKN 12 MALANG</option>
                                    </select>
                                </div>
                                @error('school_name')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tingkat / Kelas (Khusus Siswa) -->
                            <div id="grade-field" class="space-y-1.5">
                                <label for="grade" class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Tingkat / Kelas</label>
                                <select id="grade" name="grade" 
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-[#1a1632] border @error('grade') border-red-500 @else border-slate-200 dark:border-purple-500/20 @enderror rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:border-purple-500 text-slate-900 dark:text-white transition duration-200">
                                    <option value="">Pilih Kelas</option>
                                    <option value="10" {{ old('grade') == '10' ? 'selected' : '' }}>Kelas 10</option>
                                    <option value="11" {{ old('grade') == '11' ? 'selected' : '' }}>Kelas 11</option>
                                    <option value="12" {{ old('grade') == '12' ? 'selected' : '' }}>Kelas 12</option>
                                </select>
                                @error('grade')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Mata Pelajaran (Khusus Guru - Sejajar dengan Asal Sekolah) -->
                            <div id="guru-fields" class="space-y-1.5 hidden">
                                <label for="subject" class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Mata Pelajaran</label>
                                <select id="subject" name="subject" 
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-[#1a1632] border @error('subject') border-red-500 @else border-slate-200 dark:border-purple-500/20 @enderror rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:border-purple-500 text-slate-900 dark:text-white transition duration-200">
                                    <option value="">Pilih Mata Pelajaran</option>
                                    <option value="Rekayasa Perangkat Lunak" {{ old('subject') == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                    <option value="Teknik Jaringan dan Telekomunikasi" {{ old('subject') == 'Teknik Jaringan dan Telekomunikasi' ? 'selected' : '' }}>Teknik Jaringan dan Telekomunikasi</option>
                                </select>
                                @error('subject')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 5. Field Khusus Siswa (Program Keahlian & Offering) -->
                    <div id="siswa-fields" class="space-y-3 border-t border-slate-100 dark:border-purple-500/10 pt-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Program Keahlian / Jurusan -->
                            <div class="space-y-1.5">
                                <label for="major" class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Program Keahlian</label>
                                <select id="major" name="major" 
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-[#1a1632] border @error('major') border-red-500 @else border-slate-200 dark:border-purple-500/20 @enderror rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:border-purple-500 text-slate-900 dark:text-white transition duration-200">
                                    <option value="">Pilih Program Keahlian</option>
                                    <option value="Rekayasa Perangkat Lunak" {{ old('major') == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                    <option value="Teknik Jaringan Komputer dan Telekomunikasi" {{ old('major') == 'Teknik Jaringan Komputer dan Telekomunikasi' ? 'selected' : '' }}>Teknik Jaringan Komputer dan Telekomunikasi</option>
                                </select>
                                @error('major')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Offering -->
                            <div class="space-y-1.5">
                                <label for="offering" class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Offering</label>
                                <select id="offering" name="offering" 
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-[#1a1632] border @error('offering') border-red-500 @else border-slate-200 dark:border-purple-500/20 @enderror rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:border-purple-500 text-slate-900 dark:text-white transition duration-200">
                                    <option value="">Pilih Offering</option>
                                    <option value="A" {{ old('offering') == 'A' ? 'selected' : '' }}>Offering A</option>
                                    <option value="B" {{ old('offering') == 'B' ? 'selected' : '' }}>Offering B</option>
                                    <option value="C" {{ old('offering') == 'C' ? 'selected' : '' }}>Offering C</option>
                                    <option value="D" {{ old('offering') == 'D' ? 'selected' : '' }}>Offering D</option>
                                </select>
                                @error('offering')
                                    <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 6. Password & Konfirmasi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 border-t border-slate-100 dark:border-purple-500/10 pt-3">
                        <div class="space-y-1.5">
                            <label for="password" class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Kata Sandi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 dark:text-slate-500 text-xs">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" id="password" name="password" required placeholder="Min. 8 karakter" 
                                    class="w-full pl-11 pr-10 py-3 bg-slate-50 dark:bg-[#1a1632] border @error('password') border-red-500 @else border-slate-200 dark:border-purple-500/20 @enderror rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/10 text-slate-900 dark:text-white transition duration-200 placeholder:text-slate-400">
                                <button type="button" onclick="togglePasswordVisibility('password', 'password-toggle-icon')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 text-xs">
                                    <i id="password-toggle-icon" class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label for="confirm-password" class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Konfirmasi Kata Sandi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 dark:text-slate-500 text-xs">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" id="confirm-password" name="password_confirmation" required placeholder="Ulangi kata sandi" 
                                    class="w-full pl-11 pr-10 py-3 bg-slate-50 dark:bg-[#1a1632] border border-slate-200 dark:border-purple-500/20 rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/10 text-slate-900 dark:text-white transition duration-200 placeholder:text-slate-400">
                                <button type="button" onclick="togglePasswordVisibility('confirm-password', 'confirm-toggle-icon')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 text-xs">
                                    <i id="confirm-toggle-icon" class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 7. Terms & Submit -->
                    <div class="flex items-start gap-2 pt-1">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" required class="rounded border-slate-300 dark:border-purple-500/30 text-purple-600 focus:ring-purple-500/20 bg-slate-50 dark:bg-[#1a1632] w-4 h-4 transition mt-0.5">
                            <span class="text-[11px] text-slate-600 dark:text-slate-400 font-medium leading-tight group-hover:text-slate-800 dark:group-hover:text-slate-200">
                                Saya menyetujui <a href="#" class="text-purple-500 underline">Ketentuan Layanan</a> & <a href="#" class="text-purple-500 underline">Kebijakan Privasi</a>.
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="w-full mt-2 bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-xs sm:text-sm font-bold py-3.5 rounded-xl shadow-lg shadow-purple-500/20 transform hover:-translate-y-0.5 active:translate-y-0 transition duration-200 flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-user-plus"></i> Buat Akun & Inisialisasi
                    </button>
                </form>
            </div>

            <p class="text-center text-xs text-slate-500 dark:text-slate-400 mt-6">
                Sudah memiliki akun? <a href="{{ route('login') }}" class="text-purple-600 dark:text-purple-400 font-bold hover:underline">Masuk Sekarang</a>
            </p>
        </div>

        <!-- Right Column (Info / Banner) -->
        <div class="lg:col-span-6 bg-gradient-to-tr from-[#120f22] via-[#1a153a] to-[#22122c] p-12 hidden lg:flex flex-col justify-between relative overflow-hidden border-l border-purple-500/10">
            <div class="absolute top-[-20%] right-[-20%] w-80 h-80 rounded-full bg-purple-500/10 blur-3xl animate-pulse"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-80 h-80 rounded-full bg-blue-500/20 blur-3xl animate-pulse" style="animation-delay: -2s"></div>
            
            <div class="absolute top-12 left-12 text-slate-500/20 text-xl animate-float"><i class="fa-solid fa-code"></i></div>
            <div class="absolute bottom-24 right-16 text-slate-500/20 text-2xl animate-float" style="animation-delay: -1.5s"><i class="fa-solid fa-database"></i></div>

            <div class="text-right">
                <span class="text-[10px] font-mono tracking-widest text-purple-400 uppercase bg-purple-500/10 px-3 py-1 rounded-full border border-purple-500/20">
                    Siklus Pembuatan Kelas Baru
                </span>
            </div>

            <div class="my-auto space-y-6 relative z-10 max-w-sm mx-auto w-full">
                <div class="bg-[#141126]/90 p-5 rounded-2xl border border-purple-500/20 font-mono text-xs shadow-2xl space-y-2 transform rotate-1 hover:rotate-0 transition duration-300">
                    <div class="flex items-center justify-between mb-3 border-b border-purple-500/10 pb-2">
                        <div class="flex gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500/70"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500/70"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500/70"></span>
                        </div>
                        <span class="text-[10px] text-slate-500">register_node.py</span>
                    </div>
                    <p class="text-slate-400"><span class="text-pink-400 font-bold">def</span> <span class="text-blue-400">buat_entitas</span>(nama, email):</p>
                    <p class="pl-4 text-slate-400">db.save(User(nama, email))</p>
                    <p class="pl-4 text-slate-400"><span class="text-pink-400 font-bold">return</span> {</p>
                    <p class="pl-8 text-emerald-400">"status": <span class="text-amber-400">"Aktif"</span>,</p>
                    <p class="pl-8 text-emerald-400">"materi_dasar": <span class="text-pink-400">True</span></p>
                    <p class="pl-4 text-slate-400">}</p>
                </div>

                <div class="bg-white/5 backdrop-blur-sm p-4 rounded-xl border border-white/10 flex items-start gap-3.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-400 text-sm shrink-0">
                        <i class="fa-solid fa-cubes"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white tracking-wide">Akses Sandbox Instan</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5 leading-relaxed">Begitu pendaftaran selesai, lingkungan kompilasi berbasis web langsung disiapkan tanpa setup manual.</p>
                    </div>
                </div>
            </div>

            <div class="text-xs text-slate-500 flex items-center justify-between">
                <span>© 2026 LearnDL Platform.</span>
                <span class="flex items-center gap-1"><i class="fa-solid fa-shield-halved text-purple-500/70 text-[10px]"></i> Cloud Security</span>
            </div>
        </div>

    </div>

    <!-- JavaScript Toggle Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleRadios = document.querySelectorAll('.role-radio');
            const siswaFields = document.getElementById('siswa-fields');
            const guruFields = document.getElementById('guru-fields');
            const gradeField = document.getElementById('grade-field');

            function toggleRoleFields(selectedRole) {
                if (selectedRole === 'siswa') {
                    siswaFields.classList.remove('hidden');
                    guruFields.classList.add('hidden');
                    if (gradeField) gradeField.classList.remove('hidden');
                } else {
                    siswaFields.classList.add('hidden');
                    guruFields.classList.remove('hidden');
                    if (gradeField) gradeField.classList.add('hidden');
                }
            }

            // Inisialisasi awal saat reload / validation error
            const checkedRole = document.querySelector('.role-radio:checked');
            if (checkedRole) {
                toggleRoleFields(checkedRole.value);
            }

            // Handle Role Selection (Siswa vs Guru)
            roleRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    toggleRoleFields(this.value);
                });
            });
        });

        // Toggle Password Visibility
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection