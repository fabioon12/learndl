
<script src="https://cdn.jsdelivr.net/pyodide/v0.25.0/full/pyodide.js"></script>

<script>
window.taskStates = window.taskStates || {};

let pyodideInstance = null;
let pyodidePromise = null;

/*
|--------------------------------------------------------------------------
| PYTHON ENGINE
|--------------------------------------------------------------------------
*/
async function loadPythonEngine() {
    if (pyodideInstance) {
        return pyodideInstance;
    }

    if (!pyodidePromise) {
        pyodidePromise = (async function () {
            if (typeof loadPyodide !== 'function') {
                throw new Error(
                    'Library Python belum berhasil dimuat.'
                );
            }

            return await loadPyodide();
        })();
    }

    try {
        pyodideInstance = await pyodidePromise;
        return pyodideInstance;
    } catch (error) {
        pyodidePromise = null;
        throw error;
    }
}

/*
|--------------------------------------------------------------------------
| FEEDBACK PRAKTIK
|--------------------------------------------------------------------------
*/
function showPracticeFeedback(index, message, success) {
    const box = document.getElementById(
        'practice-feedback-' + index
    );

    if (!box) return;

    box.className = success
        ? 'rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-300'
        : 'rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300';

    box.textContent = message;
}

/*
|--------------------------------------------------------------------------
| MENJALANKAN PROGRAM
|--------------------------------------------------------------------------
*/
async function runPlayground(index) {
    const editor = document.getElementById(
        'code-editor-' + index
    );

    if (!editor) return;

    const language = editor.dataset.language;
    const mode = editor.dataset.mode;
    const code = editor.value;

    const status = document.getElementById(
        'run-status-' + index
    );

    const button = document.getElementById(
        'run-button-' + index
    );

    if (button.disabled) return;

    button.disabled = true;
    button.textContent = 'MENJALANKAN...';

    status.textContent = 'Menjalankan program...';
    status.className = 'text-[11px] text-yellow-400';

    window.taskStates[index] = {
        ...window.taskStates[index],
        ran: false
    };

    try {
        if (language === 'html') {
            const iframe = document.getElementById(
                'preview-' + index
            );

            iframe.srcdoc = code;
        }

        else if (language === 'css') {
            const iframe = document.getElementById(
                'preview-' + index
            );

            /*
             * Membuat halaman preview CSS tanpa
             * menyisipkan kode ke dalam script JS.
             */
            const doc = [
                '<!DOCTYPE html>',
                '<html>',
                '<head>',
                '<meta charset="UTF-8">',
                '<style>',
                'body { font-family: Arial; padding: 24px; }',
                code.replace(/<\/style/gi, '<\\/style'),
                '</style>',
                '</head>',
                '<body>',
                '<h1 class="demo-title">Hello World!</h1>',
                '<p class="demo-text">Area preview CSS.</p>',
                '<button class="demo-button">Klik Saya</button>',
                '</body>',
                '</html>'
            ].join('\n');

            iframe.srcdoc = doc;
        }

        else if (language === 'python') {
            const output = document.getElementById(
                'python-output-' + index
            );

            output.textContent = 'Memuat Python Engine...';

            const pyodide = await loadPythonEngine();

            output.textContent = 'Menjalankan program...';

            pyodide.globals.set('student_code', code);

            const pythonRunner = [
                'import sys',
                'import io',
                'import traceback',
                '',
                '_stdout = io.StringIO()',
                '_stderr = io.StringIO()',
                '_old_stdout = sys.stdout',
                '_old_stderr = sys.stderr',
                'sys.stdout = _stdout',
                'sys.stderr = _stderr',
                '',
                'try:',
                '    exec(student_code, {})',
                'except Exception:',
                '    traceback.print_exc(file=_stderr)',
                'finally:',
                '    sys.stdout = _old_stdout',
                '    sys.stderr = _old_stderr',
                '',
                '_result = _stdout.getvalue()',
                'if _stderr.getvalue():',
                '    _result += _stderr.getvalue()',
                '_result if _result else "(Program selesai tanpa output)"'
            ].join('\n');

            const result = await pyodide.runPythonAsync(
                pythonRunner
            );

            output.textContent = String(result);

            if (String(result).includes('Traceback (most recent call last)')) {
                throw new Error(
                    'Program Python mengalami kesalahan. Periksa output.'
                );
            }
        }

        else {
            throw new Error(
                'Bahasa pemrograman tidak didukung.'
            );
        }

        /*
         * Playground: berhasil dijalankan.
         * Debugging: baru berhasil dieksekusi,
         * belum berarti solusi sudah benar.
         */
        window.taskStates[index] = {
            ...window.taskStates[index],
            ran: true
        };

        status.textContent = '✓ Program dijalankan';
        status.className = 'text-[11px] text-emerald-400';

        showPracticeFeedback(
            index,
            mode === 'debugging'
                ? 'Program telah dijalankan. Periksa apakah hasilnya sudah sesuai dengan instruksi guru.'
                : 'Program berhasil dijalankan! Kamu dapat melanjutkan aktivitas.',
            true
        );

    } catch (error) {
        status.textContent = 'Gagal menjalankan program';
        status.className = 'text-[11px] text-red-400';

        showPracticeFeedback(
            index,
            error.message || 'Terjadi kesalahan.',
            false
        );

    } finally {
        button.disabled = false;
        button.textContent = '▶ RUN CODE';
    }
}

/*
|--------------------------------------------------------------------------
| RESET EDITOR
|--------------------------------------------------------------------------
*/
function resetPlayground(index) {
    const editor = document.getElementById(
        'code-editor-' + index
    );

    if (!editor) return;

    /*
     * Simpan starter code dari isi textarea awal.
     */
    if (!editor.hasAttribute('data-initialized')) {
        editor.dataset.initialCode = editor.value;
        editor.dataset.initialized = 'true';
    }

    editor.value = editor.dataset.initialCode;

    window.taskStates[index] = {
        ...window.taskStates[index],
        ran: false
    };

    const status = document.getElementById(
        'run-status-' + index
    );

    status.textContent = 'Belum dijalankan';
    status.className = 'text-[11px] text-gray-400';

    const iframe = document.getElementById(
        'preview-' + index
    );

    if (iframe) {
        iframe.srcdoc = '';
    }

    const output = document.getElementById(
        'python-output-' + index
    );

    if (output) {
        output.textContent =
            'Klik Run Code untuk menjalankan program Python.';
    }

    const feedback = document.getElementById(
        'practice-feedback-' + index
    );

    if (feedback) {
        feedback.classList.add('hidden');
    }
}

/*
|--------------------------------------------------------------------------
| INITIAL STATE
|--------------------------------------------------------------------------
*/
document.querySelectorAll('[id^="code-editor-"]').forEach(
    function (editor) {
        editor.dataset.initialCode = editor.value;
        editor.dataset.initialized = 'true';

        /*
         * Jika siswa mengubah kode setelah Run,
         * status perlu diperbarui.
         */
        editor.addEventListener('input', function () {
            const index = Number(
                editor.id.replace('code-editor-', '')
            );

            window.taskStates[index] = {
                ...window.taskStates[index],
                ran: false
            };

            const status = document.getElementById(
                'run-status-' + index
            );

            if (status) {
                status.textContent = 'Kode telah diubah';
                status.className = 'text-[11px] text-yellow-400';
            }
        });
    }
);
</script>
