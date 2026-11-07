
<script>
(function () {
    const projects = {};

    /**
     * =========================================================
     * 1. MENGAMBIL DATA CODING PROJECT
     * =========================================================
     */
    function getProject(index) {
        if (projects[index]) {
            return projects[index];
        }

        const dataElement = document.getElementById(
            `coding-project-data-${index}`
        );

        const editor = document.getElementById(
            `coding-editor-${index}`
        );

        const preview = document.getElementById(
            `coding-preview-${index}`
        );

        if (!dataElement || !editor || !preview) {
            return null;
        }

        let config = {};

        try {
            config = JSON.parse(dataElement.textContent);
        } catch (error) {
            console.error(
                'Data Coding Project tidak valid:',
                error
            );
            return null;
        }

        projects[index] = {
            config: config,
            editor: editor,
            preview: preview,

            // Misi yang sedang aktif.
            currentMission: 0,

            // Menyimpan indeks misi yang sudah selesai.
            completedMissions: new Set(),

            // Satu kode untuk keseluruhan proyek.
            code: config.starter_code || '',

            // Kode awal untuk fungsi reset.
            starterCode: config.starter_code || ''
        };

        // Isi editor dengan kode awal.
        editor.value = projects[index].code;

        return projects[index];
    }


    /**
     * =========================================================
     * 2. LIVE PREVIEW
     * =========================================================
     */
    function updatePreview(index) {
        const project = getProject(index);

        if (!project) return;

        // Pastikan kode terbaru tersimpan.
        project.code = project.editor.value;

        // Preview menampilkan keseluruhan proyek.
        project.preview.srcdoc = project.code;
    }


    /**
     * =========================================================
     * 3. UPDATE PROGRESS MISI
     * =========================================================
     */
    function updateProgress(index) {
        const project = getProject(index);

        if (!project) return;

        const total = project.config.missions.length;
        const completed = project.completedMissions.size;

        const percentage = total > 0
            ? (completed / total) * 100
            : 0;

        const text = document.getElementById(
            `coding-progress-text-${index}`
        );

        const bar = document.getElementById(
            `coding-progress-bar-${index}`
        );

        if (text) {
            text.textContent = `${completed}/${total} selesai`;
        }

        if (bar) {
            bar.style.width = `${percentage}%`;
        }

        const buttons = document.querySelectorAll(
            `#coding-project-${index} .coding-mission-button`
        );

        buttons.forEach((button, missionIndex) => {
            const number = button.querySelector(
                '.coding-mission-number'
            );

            const status = button.querySelector(
                '.coding-mission-status'
            );

            const icon = button.querySelector(
                '.coding-mission-icon'
            );

            const isCompleted =
                project.completedMissions.has(missionIndex);

            const isActive =
                project.currentMission === missionIndex;

            // Reset tampilan status tombol.
            button.classList.toggle(
                'border-indigo-400',
                isActive && !isCompleted
            );

            button.classList.toggle(
                'bg-indigo-500/10',
                isActive && !isCompleted
            );

            button.classList.toggle(
                'border-green-500/40',
                isCompleted
            );

            if (isCompleted) {
                if (status) {
                    status.textContent = 'Misi selesai';
                    status.className =
                        'coding-mission-status mt-1 block text-xs text-green-400';
                }

                if (number) {
                    number.textContent = '✓';

                    number.classList.add(
                        'bg-green-500/20',
                        'text-green-400'
                    );
                }

                if (icon) {
                    icon.textContent = '✓';

                    icon.className =
                        'coding-mission-icon text-lg text-green-400';
                }
            } else {
                if (status) {
                    status.textContent = isActive
                        ? 'Sedang dikerjakan'
                        : 'Belum dikerjakan';

                    status.className =
                        'coding-mission-status mt-1 block text-xs text-gray-400';
                }

                if (number) {
                    number.textContent = missionIndex + 1;

                    number.classList.remove(
                        'bg-green-500/20',
                        'text-green-400'
                    );
                }

                if (icon) {
                    icon.textContent = isActive ? '●' : '○';

                    icon.className =
                        'coding-mission-icon text-lg text-gray-400';
                }
            }
        });
    }


    /**
     * =========================================================
     * 4. MEMILIH MISI
     * =========================================================
     *
     * Penting:
     * Berpindah misi hanya mengubah instruksi.
     * Kode HTML tidak pernah diganti atau di-reset.
     */

    function selectMission(index, missionIndex) {
        const project = getProject(index);

        if (!project) return;

        const mission = project.config.missions[missionIndex];

        if (!mission) return;

        // Simpan kode terbaru sebelum berpindah misi.
        project.code = project.editor.value;

        // Ubah misi aktif.
        project.currentMission = missionIndex;

        const title = document.getElementById(
            `coding-current-title-${index}`
        );

        const instruction = document.getElementById(
            `coding-current-instruction-${index}`
        );

        const hintWrapper = document.getElementById(
            `coding-hint-wrapper-${index}`
        );

        const hint = document.getElementById(
            `coding-current-hint-${index}`
        );

        const feedback = document.getElementById(
            `coding-feedback-${index}`
        );

        // Update judul misi.
        if (title) {
            title.textContent = mission.judul || 'Misi';
        }

        // Update instruksi misi (HTML dari Trix Editor).
        if (instruction) {
            const instructionHTML =
                mission.instruksi || '<p>Tidak ada instruksi.</p>';

            instruction.innerHTML = window.DOMPurify
                ? DOMPurify.sanitize(instructionHTML)
                : instructionHTML;
        }

        // Update petunjuk (HTML dari Trix Editor).
        if (hintWrapper && hint) {
            if (mission.petunjuk && mission.petunjuk.trim() !== '') {
                hint.innerHTML = window.DOMPurify
                    ? DOMPurify.sanitize(mission.petunjuk)
                    : mission.petunjuk;

                hintWrapper.classList.remove('hidden');
            } else {
                hint.innerHTML = '';
                hintWrapper.classList.add('hidden');
            }
        }

        // Pertahankan kode proyek yang sama di seluruh misi.
        project.editor.value = project.code;

        // Bersihkan feedback sebelumnya.
        if (feedback) {
            feedback.classList.add('hidden');
            feedback.innerHTML = '';
        }

        // Atur tombol pemeriksaan.
        const checkButton = document.getElementById(
            `coding-check-${index}`
        );

        if (checkButton) {
            const isCompleted =
                project.completedMissions.has(missionIndex);

            checkButton.disabled = isCompleted;

            if (isCompleted) {
                checkButton.textContent = '✓ MISI SUDAH SELESAI';
                checkButton.classList.add('opacity-60');
            } else {
                checkButton.textContent = '🔍 PERIKSA JAWABAN';
                checkButton.classList.remove('opacity-60');

                checkButton.onclick = function () {
                    checkMission(index);
                };
            }
        }

        // Update preview dan progress.
        updatePreview(index);
        updateProgress(index);
    }



    /**
     * =========================================================
     * 5. VALIDASI KRITERIA HTML
     * =========================================================
     */
    function validateCriteria(code, criteria) {
        const parser = new DOMParser();

        const documentHTML = parser.parseFromString(
            code,
            'text/html'
        );

        const results = [];

        (criteria || []).forEach((criterion) => {
            let passed = false;
            let description = '';

            switch (criterion.type) {

                /**
                 * Validasi elemen HTML.
                 * Contoh: h1, p, div, img.
                 */
                case 'tag_exists': {
                    const tag = (
                        criterion.tag || ''
                    ).trim();

                    description = `Memiliki elemen <${tag}>`;

                    if (
                        tag &&
                        /^[a-z][a-z0-9-]*$/i.test(tag)
                    ) {
                        passed =
                            documentHTML.getElementsByTagName(
                                tag
                            ).length > 0;
                    }

                    break;
                }


                /**
                 * Validasi teks dalam HTML.
                 */
                case 'text_contains': {
                    const expected = (
                        criterion.text || ''
                    ).trim();

                    description =
                        `Mengandung teks "${expected}"`;

                    passed =
                        expected !== '' &&
                        documentHTML.body.textContent
                            .toLowerCase()
                            .includes(expected.toLowerCase());

                    break;
                }


                /**
                 * Validasi atribut HTML.
                 * Contoh: src, href, alt, class.
                 */
                case 'attribute_exists': {
                    const attribute = (
                        criterion.attribute || ''
                    ).trim();

                    description =
                        `Memiliki atribut "${attribute}"`;

                    if (
                        /^[a-zA-Z_:][a-zA-Z0-9:._-]*$/.test(
                            attribute
                        )
                    ) {
                        passed = Array.from(
                            documentHTML.querySelectorAll('*')
                        ).some((element) => {
                            return element.hasAttribute(attribute);
                        });
                    }

                    break;
                }
            }

            results.push({
                passed: passed,
                description: description
            });
        });

        return results;
    }


    /**
     * =========================================================
     * 6. ESCAPE HTML
     * =========================================================
     */
    function escapeHTML(value) {
        return String(value).replace(
            /[&<>"']/g,
            (character) => {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                }[character];
            }
        );
    }


    /**
     * =========================================================
     * 7. MENAMPILKAN FEEDBACK
     * =========================================================
     */
    function showFeedback(index, passed, results) {
        const feedback = document.getElementById(
            `coding-feedback-${index}`
        );

        if (!feedback) return;

        const passedCount = results.filter(
            result => result.passed
        ).length;

        const total = results.length;

        feedback.className = passed
            ? 'rounded-xl border border-green-500/30 bg-green-500/10 p-4'
            : 'rounded-xl border border-red-500/30 bg-red-500/10 p-4';

        let html = `
            <div class="flex items-center gap-3">
                <span class="text-2xl">
                    ${passed ? '🎉' : '🔧'}
                </span>

                <div>
                    <h4 class="font-extrabold ${
                        passed ? 'text-green-400' : 'text-red-400'
                    }">
                        ${
                            passed
                                ? 'Misi berhasil diselesaikan!'
                                : 'Masih ada kriteria yang belum terpenuhi.'
                        }
                    </h4>

                    <p class="mt-1 text-xs text-gray-300">
                        ${passedCount} dari ${total} kriteria terpenuhi.
                    </p>
                </div>
            </div>

            <div class="mt-4 space-y-2">
        `;

        results.forEach((result) => {
            html += `
                <div class="flex items-start gap-2 text-xs">
                    <span class="${
                        result.passed
                            ? 'text-green-400'
                            : 'text-red-400'
                    }">
                        ${result.passed ? '✓' : '✕'}
                    </span>

                    <span class="text-gray-300">
                        ${escapeHTML(result.description)}
                    </span>
                </div>
            `;
        });

        html += '</div>';

        feedback.innerHTML = html;
        feedback.classList.remove('hidden');
    }


    /**
     * =========================================================
     * 8. MEMERIKSA MISI
     * =========================================================
     *
     * Setiap misi memeriksa keseluruhan kode proyek.
     */

    function checkMission(index) {
        const project = getProject(index);

        if (!project) return;

        const mission =
            project.config.missions[project.currentMission];

        if (!mission) return;

        // Ambil kode terbaru dari editor.
        project.code = project.editor.value;

        // Validasi seluruh proyek.
        const results = validateCriteria(
            project.code,
            mission.criteria || []
        );

        const passed =
            results.length > 0 &&
            results.every(result => result.passed);

        // Tampilkan hasil pemeriksaan.
        showFeedback(index, passed, results);

        // Jika belum lolos, berhenti.
        if (!passed) return;

        // Tandai misi sebagai selesai.
        project.completedMissions.add(
            project.currentMission
        );

        updateProgress(index);

        const nextMission = project.currentMission + 1;

        const button = document.getElementById(
            `coding-check-${index}`
        );

        // Masih ada misi berikutnya.
        if (nextMission < project.config.missions.length) {
            if (button) {
                button.textContent = 'LANJUT KE MISI BERIKUTNYA';
                button.disabled = false;
                button.classList.remove('opacity-60');

                button.onclick = function () {
                    selectMission(index, nextMission);
                };
            }

        } else {
            // ==========================================
            // SEMUA MISI BERHASIL DISELESAIKAN
            // ==========================================

            if (button) {
                button.textContent = '🎉 SEMUA MISI SELESAI';
                button.disabled = true;
                button.classList.add('opacity-60');
            }

            // Tandai Coding Project selesai pada navigasi.
            if (typeof window.completeCodingProject === 'function') {
                window.completeCodingProject(index);
            } else {
                console.error(
                    'Fungsi completeCodingProject tidak ditemukan!'
                );
            }
        }
    }
    /**
     * =========================================================
     * 9. RESET SELURUH PROYEK
     * =========================================================
     */

    function resetEditor(index) {
        const project = getProject(index);

        if (!project) return;

        const confirmation = confirm(
            'Apakah kamu yakin ingin mengulang seluruh kode proyek? ' +
            'Semua kode yang sudah dibuat dan status misi akan direset.'
        );

        if (!confirmation) return;

        // Kembalikan kode ke awal.
        project.code = project.starterCode;
        project.editor.value = project.code;

        // Hapus semua status misi selesai.
        project.completedMissions.clear();

        // Kembali ke misi pertama.
        project.currentMission = 0;

        // Reset status Coding Project pada navigasi.
        const projectElement = document.getElementById(
            `coding-project-${index}`
        );

        const taskElement = projectElement?.closest('.task-block');

        if (taskElement) {
            const taskBlocks = Array.from(
                document.querySelectorAll('.task-block')
            );

            const taskIndex = taskBlocks.indexOf(taskElement);

            if (taskIndex !== -1) {
                window.taskStates[taskIndex] =
                    window.taskStates[taskIndex] || {};

                window.taskStates[taskIndex].completed = false;

                if (typeof window.updateProgress === 'function') {
                    window.updateProgress();
                }
            }
        }

        // Perbarui tampilan misi pertama.
        selectMission(index, 0);

        // Perbarui preview dan progress.
        updatePreview(index);
        updateProgress(index);
    }



    /**
     * =========================================================
     * 10. EVENT LISTENER EDITOR
     * =========================================================
     */
    function initializeProject(element) {
        const id = element.id.replace(
            'coding-project-',
            ''
        );

        const index = Number(id);

        const project = getProject(index);

        if (!project) return;

        // Mencegah event listener dipasang berulang kali.
        if (project.initialized) return;

        project.initialized = true;

        // Setiap perubahan kode langsung disimpan.
        project.editor.addEventListener('input', function () {
            project.code = project.editor.value;

            updatePreview(index);
        });

        // Preview awal.
        updatePreview(index);

        // Pilih misi pertama.
        if (project.config.missions.length > 0) {
            selectMission(index, 0);
        }

        updateProgress(index);
    }


    /**
     * =========================================================
     * 11. FUNGSI GLOBAL UNTUK BLADE
     * =========================================================
     */
    window.selectCodingMission = selectMission;

    window.checkCodingMission = checkMission;

    window.resetCodingEditor = resetEditor;


    /**
     * =========================================================
     * 12. INISIALISASI SEMUA CODING PROJECT
     * =========================================================
     */
    function initializeAllProjects() {
        document.querySelectorAll(
            '[data-coding-project]'
        ).forEach((element) => {
            initializeProject(element);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initializeAllProjects
        );
    } else {
        initializeAllProjects();
    }

})();
</script>
