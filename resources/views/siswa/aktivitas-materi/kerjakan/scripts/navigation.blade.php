
<script>
(function () {
    'use strict';

    window.taskStates = window.taskStates || {};
    window.codeAnswers = window.codeAnswers || {};
    window.quizAnswers = window.quizAnswers || {};

    let currentTask = 0;
    let isSubmitting = false;

    const taskBlocks = Array.from(
        document.querySelectorAll('.task-block')
    );

    const totalTasks = taskBlocks.length;

    const nextButton = document.getElementById('next-button');
    const previousButton = document.getElementById('previous-button');
    const completeForm = document.getElementById('complete-form');

    const stepLabel = document.getElementById('step-label');
    const headerStepLabel = document.getElementById('header-step-label');
    const mobileStepLabel = document.getElementById('mobile-step-label');

    const stepPercentage = document.getElementById('step-percentage');
    const bottomProgress = document.getElementById('bottom-progress');

    const feedbackBox = document.getElementById('feedback-box');
    const feedbackTitle = document.getElementById('feedback-title');
    const feedbackMessage = document.getElementById('feedback-message');

    const segments = Array.from(
        document.querySelectorAll(
            '#progress-container .progress-segment'
        )
    );

    const mobileSegments = Array.from(
        document.querySelectorAll(
            '#mobile-progress-container .mobile-progress-segment'
        )
    );


    /*
    |--------------------------------------------------------------------------
    | NORMALISASI TIPE AKTIVITAS
    |--------------------------------------------------------------------------
    */
    function normalizeTaskType(type) {
        const value = String(type || '').toLowerCase().trim();

        const aliases = {
            text: 'teks',
            youtube: 'video',
            code: 'praktik',
            arahan: 'latihan',
            interaktif: 'pilihan_ganda'
        };

        return aliases[value] || value;
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS PENYELESAIAN AKTIVITAS
    |--------------------------------------------------------------------------
    */
    function isTaskCompleted(index) {
        const task = taskBlocks[index];

        if (!task) return false;

        const type = normalizeTaskType(task.dataset.type);
        const state = window.taskStates[index] || {};

        switch (type) {
            case 'teks':
            case 'video':
                return state.visited === true;

            case 'praktik':
                return state.ran === true;

            case 'latihan':
            case 'pilihan_ganda':
                return state.checked === true;

            case 'coding_project':
                return state.completed === true;

            default:
                return false;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE SEGMENT PROGRESS
    |--------------------------------------------------------------------------
    */
    function paintSegments(segmentList) {
        segmentList.forEach(function (segment, index) {
            segment.classList.remove(
                'bg-yellow-400',
                'bg-emerald-400',
                'bg-gray-600',
                'bg-gray-700'
            );

            if (isTaskCompleted(index)) {
                segment.classList.add('bg-emerald-400');
            } else if (index === currentTask) {
                segment.classList.add('bg-yellow-400');
            } else {
                segment.classList.add('bg-gray-700');
            }
        });
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PROGRESS
    |--------------------------------------------------------------------------
    */
    function updateProgress() {
        const currentNumber = totalTasks
            ? currentTask + 1
            : 0;

        const completedCount = taskBlocks.reduce(
            function (count, task, index) {
                return count + (
                    isTaskCompleted(index) ? 1 : 0
                );
            },
            0
        );

        const percentage = totalTasks
            ? Math.round((completedCount / totalTasks) * 100)
            : 0;

        if (stepLabel) {
            stepLabel.textContent =
                'Tahap ' + currentNumber + ' dari ' + totalTasks;
        }

        if (headerStepLabel) {
            headerStepLabel.textContent =
                currentNumber + ' / ' + totalTasks;
        }

        if (mobileStepLabel) {
            mobileStepLabel.textContent =
                currentNumber + '/' + totalTasks;
        }

        if (stepPercentage) {
            stepPercentage.textContent = percentage + '%';
        }

        if (bottomProgress) {
            bottomProgress.style.width = percentage + '%';
        }

        paintSegments(segments);
        paintSegments(mobileSegments);
    }


    /*
    |--------------------------------------------------------------------------
    | FEEDBACK
    |--------------------------------------------------------------------------
    */
    function hideFeedback() {
        if (feedbackBox) {
            feedbackBox.classList.add('hidden');
        }
    }

    function showFeedback(title, message, success = false) {
        if (!feedbackBox) {
            window.alert(title + '\n' + message);
            return;
        }

        feedbackBox.classList.remove('hidden');

        feedbackBox.classList.toggle(
            'border-emerald-400',
            success === true
        );

        feedbackBox.classList.toggle(
            'border-red-400',
            success !== true
        );

        feedbackBox.classList.toggle(
            'bg-emerald-500/10',
            success === true
        );

        feedbackBox.classList.toggle(
            'bg-red-500/10',
            success !== true
        );

        if (feedbackTitle) {
            feedbackTitle.textContent = title;
        }

        if (feedbackMessage) {
            feedbackMessage.textContent = message;
        }

        feedbackBox.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE TAMPILAN AKTIVITAS
    |--------------------------------------------------------------------------
    */
    function updateTask() {
        if (!totalTasks) {
            if (stepLabel) {
                stepLabel.textContent = 'Belum ada aktivitas';
            }

            if (headerStepLabel) {
                headerStepLabel.textContent = '0 / 0';
            }

            if (mobileStepLabel) {
                mobileStepLabel.textContent = '0/0';
            }

            if (nextButton) {
                nextButton.classList.add('hidden');
            }

            if (previousButton) {
                previousButton.classList.add('hidden');
            }

            updateProgress();
            return;
        }

        currentTask = Math.max(
            0,
            Math.min(currentTask, totalTasks - 1)
        );

        taskBlocks.forEach(function (task, index) {
            const active = index === currentTask;

            task.classList.toggle('hidden', !active);

            task.setAttribute(
                'aria-hidden',
                active ? 'false' : 'true'
            );
        });

        if (previousButton) {
            previousButton.disabled =
                isSubmitting || currentTask === 0;

            previousButton.classList.toggle(
                'opacity-40',
                currentTask === 0
            );
        }

        if (nextButton) {
            nextButton.classList.remove('hidden');
            nextButton.disabled = isSubmitting;

            nextButton.textContent =
                currentTask === totalTasks - 1
                    ? 'SELESAIKAN MISI ✓'
                    : 'LANJUT →';
        }

        // Sinkronisasi karakter MOOSE.
        const activeTask = taskBlocks[currentTask];

        if (
            activeTask &&
            typeof window.updateCharacter === 'function'
        ) {
            window.updateCharacter(
                normalizeTaskType(activeTask.dataset.type)
            );
        }

        hideFeedback();
        updateProgress();
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDASI AKTIVITAS
    |--------------------------------------------------------------------------
    */
    function validateCurrentTask() {
        const task = taskBlocks[currentTask];

        if (!task) return false;

        const type = normalizeTaskType(task.dataset.type);

        // Teks dan video selesai ketika siswa menekan lanjut.
        if (type === 'teks' || type === 'video') {
            window.taskStates[currentTask] =
                window.taskStates[currentTask] || {};

            window.taskStates[currentTask].visited = true;

            updateProgress();
            return true;
        }

        // Aktivitas sudah selesai.
        if (isTaskCompleted(currentTask)) {
            return true;
        }

        const messages = {
            praktik: [
                'Praktik belum selesai!',
                'Jalankan kode dengan tombol RUN CODE terlebih dahulu.'
            ],

            latihan: [
                'Latihan belum selesai!',
                'Susun kode dengan benar lalu tekan CHECK JAWABAN.'
            ],

            pilihan_ganda: [
                'Kuis belum selesai!',
                'Pilih jawaban yang benar lalu tekan CHECK JAWABAN.'
            ],

            coding_project: [
                'Coding Project belum selesai!',
                'Selesaikan seluruh misi Coding Project terlebih dahulu sebelum melanjutkan.'
            ]
        };

        const message = messages[type] || [
            'Aktivitas belum selesai!',
            'Aktivitas ini belum dinyatakan selesai.'
        ];

        showFeedback(
            message[0],
            message[1],
            false
        );

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | SCROLL KE ATAS AREA PEMBELAJARAN
    |--------------------------------------------------------------------------
    */
    function scrollToTop() {
        const scrollContainer = document.querySelector(
            '#learning-game .overflow-y-auto'
        );

        if (scrollContainer) {
            scrollContainer.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    }


    /*
    |--------------------------------------------------------------------------
    | NEXT TASK
    |--------------------------------------------------------------------------
    */
    function nextTask() {
        if (isSubmitting || !totalTasks) return;

        if (!validateCurrentTask()) {
            return;
        }

        if (currentTask < totalTasks - 1) {
            currentTask++;

            updateTask();
            scrollToTop();

            return;
        }

        completeLearning();
    }


    /*
    |--------------------------------------------------------------------------
    | PREVIOUS TASK
    |--------------------------------------------------------------------------
    */
    function previousTask() {
        if (isSubmitting || currentTask === 0) return;

        currentTask--;

        updateTask();
        scrollToTop();
    }


    /*
    |--------------------------------------------------------------------------
    | COMPLETE LEARNING
    |--------------------------------------------------------------------------
    */
    function completeLearning() {
        if (isSubmitting || !totalTasks) return;

        const firstIncomplete = taskBlocks.findIndex(
            function (task, index) {
                return !isTaskCompleted(index);
            }
        );

        // Masih ada aktivitas yang belum selesai.
        if (firstIncomplete !== -1) {
            currentTask = firstIncomplete;

            updateTask();
            validateCurrentTask();

            return;
        }

        if (!completeForm) {
            showFeedback(
                'Form tidak ditemukan!',
                'Periksa ID complete-form pada navigasi.',
                false
            );

            return;
        }

        isSubmitting = true;

        if (nextButton) {
            nextButton.disabled = true;
            nextButton.textContent = 'MENYIMPAN PROGRES...';
        }

        if (previousButton) {
            previousButton.disabled = true;
        }

        // Kirim form ke Laravel.
        HTMLFormElement.prototype.submit.call(completeForm);
    }


    /*
    |--------------------------------------------------------------------------
    | MENANDAI CODING PROJECT SELESAI
    |--------------------------------------------------------------------------
    |
    | Fungsi ini dipanggil oleh script Coding Project ketika
    | seluruh misi berhasil diselesaikan.
    |
    */
    function completeCodingProject(index) {
        const task = taskBlocks[index];

        if (!task) return;

        const type = normalizeTaskType(task.dataset.type);

        // Pastikan block benar-benar Coding Project.
        if (type !== 'coding_project') {
            console.warn(
                'Block ini bukan Coding Project:',
                index
            );

            return;
        }

        window.taskStates[index] =
            window.taskStates[index] || {};

        window.taskStates[index].completed = true;

        // Simpan kode terakhir jika tersedia.
        const projectEditor = document.getElementById(
            `coding-editor-${index}`
        );

        if (projectEditor) {
            window.codeAnswers[index] = projectEditor.value;
        }

        updateProgress();

        // Feedback bahwa aktivitas berhasil diselesaikan.
        showFeedback(
            'Coding Project berhasil diselesaikan! 🎉',
            'Seluruh misi telah berhasil dikerjakan. Kamu bisa melanjutkan ke aktivitas berikutnya.',
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GLOBAL FUNCTIONS
    |--------------------------------------------------------------------------
    */
    window.nextTask = nextTask;
    window.previousTask = previousTask;
    window.updateTask = updateTask;
    window.updateProgress = updateProgress;
    window.showFeedback = showFeedback;
    window.hideFeedback = hideFeedback;

    // Fungsi untuk dipanggil oleh script Coding Project.
    window.completeCodingProject = completeCodingProject;


    /*
    |--------------------------------------------------------------------------
    | COMPLETE FORM
    |--------------------------------------------------------------------------
    */
    if (completeForm) {
        completeForm.addEventListener(
            'submit',
            function (event) {
                event.preventDefault();

                completeLearning();
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | INISIALISASI
    |--------------------------------------------------------------------------
    */
    updateTask();

})();
</script>
