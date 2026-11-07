
<script>
window.codeAnswers = window.codeAnswers || {};
window.taskStates = window.taskStates || {};

function normalizeCode(value) {
    return String(value ?? '').trim().replace(/\s+/g, ' ');
}

function selectCodeBlock(taskIndex, button) {
    const answers = window.codeAnswers[taskIndex] || [];
    const slots = document.getElementById('answer-slots-' + taskIndex);
    const maxSlots = Number(slots.dataset.slotCount);
    const optionId = button.dataset.optionId;

    if (answers.length >= maxSlots) return;
    if (answers.some(item => item.id === optionId)) return;

    answers.push({
        id: optionId,
        code: button.dataset.code
    });

    window.codeAnswers[taskIndex] = answers;
    window.taskStates[taskIndex] = {
        ...window.taskStates[taskIndex],
        checked: false
    };

    renderCodeAnswer(taskIndex);
    hideExerciseFeedback(taskIndex);
}

function removeCodeBlock(taskIndex, position) {
    const answers = window.codeAnswers[taskIndex] || [];
    answers.splice(position, 1);

    window.taskStates[taskIndex] = {
        ...window.taskStates[taskIndex],
        checked: false
    };

    renderCodeAnswer(taskIndex);
    hideExerciseFeedback(taskIndex);
}

function renderCodeAnswer(taskIndex) {
    const container = document.getElementById('answer-slots-' + taskIndex);
    const optionsContainer = document.getElementById('code-options-' + taskIndex);
    const answers = window.codeAnswers[taskIndex] || [];
    const totalSlots = Number(container.dataset.slotCount);

    container.replaceChildren();

    for (let i = 0; i < totalSlots; i++) {
        const answer = answers[i];

        if (answer) {
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = answer.code;
            button.className =
                'max-w-full rounded-lg border-2 border-yellow-400 ' +
                'bg-[#292929] px-4 py-3 font-mono text-sm ' +
                'text-blue-400 whitespace-pre-wrap break-all';

            button.addEventListener('click', function () {
                removeCodeBlock(taskIndex, i);
            });

            container.appendChild(button);
        } else {
            const slot = document.createElement('div');
            slot.className =
                'flex h-12 min-w-14 items-center justify-center ' +
                'rounded-lg border-2 border-dashed border-gray-600 ' +
                'text-xs text-gray-500';
            slot.textContent = i + 1;
            container.appendChild(slot);
        }
    }

    document.getElementById('answer-count-' + taskIndex)
        .textContent = answers.length;

    optionsContainer.querySelectorAll('.code-choice').forEach(button => {
        button.disabled = answers.some(
            item => item.id === button.dataset.optionId
        );
    });
}

function checkCodeOrder(taskIndex) {
    const answers = window.codeAnswers[taskIndex] || [];
    const slots = document.getElementById('answer-slots-' + taskIndex);
    const totalSlots = Number(slots.dataset.slotCount);

    let correctOrder;

    try {
        const answerElement = document.getElementById(
            'exercise-answer-' + taskIndex
        );

        correctOrder = JSON.parse(answerElement.textContent);
    } catch (error) {
        showExerciseFeedback(
            taskIndex,
            'Konfigurasi tidak valid',
            'Kunci jawaban tidak dapat dibaca.',
            false
        );
        return;
    }

    if (!Array.isArray(correctOrder) || correctOrder.length === 0) {
        showExerciseFeedback(
            taskIndex,
            'Latihan belum siap',
            'Guru belum mengatur kunci jawaban.',
            false
        );
        return;
    }

    if (answers.length !== totalSlots) {
        showExerciseFeedback(
            taskIndex,
            'Jawaban belum lengkap',
            'Lengkapi semua kotak jawaban terlebih dahulu.',
            false
        );
        return;
    }

    const isCorrect = answers.every((answer, i) =>
        normalizeCode(answer.code) === normalizeCode(correctOrder[i])
    );

    window.taskStates[taskIndex] = {
        ...window.taskStates[taskIndex],
        checked: isCorrect
    };

    if (isCorrect) {
        showExerciseFeedback(
            taskIndex,
            '🎉 Jawaban benar!',
            'Hebat! Kamu berhasil menyusun kode dengan benar.',
            true
        );
    } else {
        showExerciseFeedback(
            taskIndex,
            'Jawaban belum tepat',
            'Periksa kembali urutan kode dan coba lagi.',
            false
        );
    }
}

function showExerciseFeedback(taskIndex, title, message, success) {
    const box = document.getElementById(
        'exercise-feedback-' + taskIndex
    );

    box.className = success
        ? 'rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-300'
        : 'rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300';

    const heading = document.createElement('h3');
    heading.className = 'font-extrabold';
    heading.textContent = title;

    const paragraph = document.createElement('p');
    paragraph.className = 'mt-2';
    paragraph.textContent = message;

    box.replaceChildren(heading, paragraph);
}

function hideExerciseFeedback(taskIndex) {
    const box = document.getElementById(
        'exercise-feedback-' + taskIndex
    );

    if (box) {
        box.classList.add('hidden');
        box.replaceChildren();
    }
}
</script>
