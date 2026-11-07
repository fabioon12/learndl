
<script>
window.taskStates = window.taskStates || {};
window.quizAnswers = window.quizAnswers || {};

/*
|--------------------------------------------------------------------------
| PILIH JAWABAN
|--------------------------------------------------------------------------
*/
function selectQuizOption(taskIndex, optionIndex) {
    const state = window.taskStates[taskIndex] || {};

    // Jawaban yang sudah benar dikunci.
    if (state.checked) return;

    window.quizAnswers[taskIndex] = optionIndex;

    const container = document.getElementById(
        'quiz-options-' + taskIndex
    );

    container.querySelectorAll('.quiz-option').forEach(
        function (button) {
            const selected = Number(
                button.dataset.optionIndex
            ) === optionIndex;

            button.classList.toggle(
                'border-indigo-400', selected
            );

            button.classList.toggle(
                'bg-indigo-500/10', selected
            );

            button.classList.toggle(
                'border-gray-700', !selected
            );

            button.setAttribute(
                'aria-pressed', selected ? 'true' : 'false'
            );

            const indicator = button.querySelector(
                '.quiz-indicator'
            );

            if (indicator) {
                indicator.textContent = selected ? '●' : '○';
                indicator.classList.toggle(
                    'text-indigo-400', selected
                );
            }
        }
    );

    const status = document.getElementById(
        'quiz-selection-status-' + taskIndex
    );

    if (status) {
        status.textContent = 'Jawaban telah dipilih';
    }

    const feedback = document.getElementById(
        'quiz-feedback-' + taskIndex
    );

    if (feedback) {
        feedback.classList.add('hidden');
    }
}

/*
|--------------------------------------------------------------------------
| PERIKSA JAWABAN
|--------------------------------------------------------------------------
*/

function checkQuizAnswer(taskIndex) {

    // Inisialisasi state
    window.quizAnswers = window.quizAnswers || {};
    window.taskStates = window.taskStates || {};

    const state = window.taskStates[taskIndex] || {};

    // Jangan periksa ulang soal yang sudah benar
    if (state.checked === true) {
        return;
    }

    // 1. Pastikan siswa sudah memilih jawaban
    const selected = window.quizAnswers[taskIndex];

    if (selected === undefined || selected === null) {
        showQuizFeedback(
            taskIndex,
            '⚠️ Pilih jawaban terlebih dahulu!',
            'Pilih salah satu jawaban sebelum menekan CHECK JAWABAN.',
            false
        );
        return;
    }

    // 2. Periksa jumlah nyawa
    if (
        typeof window.getHearts === 'function' &&
        window.getHearts() <= 0
    ) {
        showQuizFeedback(
            taskIndex,
            '💔 Nyawa Habis!',
            'Klik tombol Ulangi Tantangan untuk mendapatkan 3 HP kembali.',
            false
        );

        window.updateCharacter?.('gameover');
        return;
    }

    // 3. Ambil data jawaban benar
    const dataElement = document.getElementById(
        'quiz-data-' + taskIndex
    );

    if (!dataElement) {
        showQuizFeedback(
            taskIndex,
            '❌ Konfigurasi kuis bermasalah',
            'Data jawaban kuis tidak ditemukan.',
            false
        );
        return;
    }

    let quizData;

    try {
        quizData = JSON.parse(dataElement.textContent);
    } catch (error) {
        console.error('Quiz JSON error:', error);

        showQuizFeedback(
            taskIndex,
            '❌ Konfigurasi kuis bermasalah',
            'Data jawaban tidak dapat dibaca.',
            false
        );
        return;
    }

    const correct = Number(quizData.correctIndex);
    const isCorrect = Number(selected) === correct;

    if (!Number.isInteger(correct)) {
        showQuizFeedback(
            taskIndex,
            '❌ Konfigurasi jawaban bermasalah',
            'Indeks jawaban benar tidak valid.',
            false
        );
        return;
    }

    // 4. JAWABAN BENAR
    if (isCorrect) {

        window.taskStates[taskIndex] = {
            ...state,
            checked: true
        };

        showQuizFeedback(
            taskIndex,
            '🎉 Jawaban benar!',
            quizData.explanation ||
                'Hebat! Kamu berhasil menjawab dengan tepat.',
            true
        );

        // Karakter merayakan keberhasilan
        window.updateCharacter?.('success');

        // Update progress pembelajaran
        window.updateProgress?.();

        // Kunci semua opsi setelah benar
        const container = document.getElementById(
            'quiz-options-' + taskIndex
        );

        if (container) {
            container.querySelectorAll('.quiz-option')
                .forEach(function (button) {

                    button.disabled = true;

                    const optionIndex = Number(
                        button.dataset.optionIndex
                    );

                    if (optionIndex === correct) {
                        button.classList.remove(
                            'border-indigo-400'
                        );

                        button.classList.add(
                            'border-emerald-400',
                            'bg-emerald-500/10'
                        );

                        const indicator = button.querySelector(
                            '.quiz-indicator'
                        );

                        if (indicator) {
                            indicator.textContent = '✓';
                            indicator.classList.add(
                                'text-emerald-400'
                            );
                        }
                    }
                });
        }

        // Ubah tombol check menjadi berhasil
        const checkButton = document.getElementById(
            'quiz-check-button-' + taskIndex
        );

        if (checkButton) {
            checkButton.disabled = true;
            checkButton.textContent = '✓ JAWABAN BENAR';
            checkButton.classList.add('opacity-70');
        }

        return;
    }

    // 5. JAWABAN SALAH

    // Kurangi tepat satu nyawa
    window.decreaseHeart?.();

    const remainingHearts =
        typeof window.getHearts === 'function'
            ? window.getHearts()
            : null;

    if (remainingHearts === 0) {

        showQuizFeedback(
            taskIndex,
            '💔 Nyawa Habis!',
            'Jawaban belum tepat. Klik Ulangi Tantangan untuk memulihkan nyawa.',
            false
        );

        window.updateCharacter?.('gameover');

    } else {

        showQuizFeedback(
            taskIndex,
            '❌ Jawaban belum tepat!',
            remainingHearts === null
                ? 'Coba perhatikan kembali pertanyaannya.'
                : 'Coba lagi! Sisa nyawa: ' +
                    remainingHearts + ' HP.',
            false
        );

        // Reaksi karakter sudah diatur oleh decreaseHeart()
    }
}


/*
|--------------------------------------------------------------------------
| FEEDBACK KUIS
|--------------------------------------------------------------------------
*/
function showQuizFeedback(taskIndex, title, message, success) {
    const box = document.getElementById(
        'quiz-feedback-' + taskIndex
    );

    if (!box) return;

    box.className = success
        ? 'rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-5 text-emerald-300'
        : 'rounded-xl border border-red-500/30 bg-red-500/10 p-5 text-red-300';

    const heading = document.createElement('h3');
    heading.className = 'font-extrabold';
    heading.textContent = title;

    const paragraph = document.createElement('p');
    paragraph.className = 'mt-2 text-sm leading-6';
    paragraph.textContent = message;

    box.replaceChildren(heading, paragraph);
}
</script>
