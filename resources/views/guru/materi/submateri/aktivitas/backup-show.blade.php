@extends('guru.layouts.app')

@section('title', 'Show Halaman Submateri')

@push('scripts')
<!-- Pyodide WebAssembly Compiler Python -->
<script src="https://cdn.jsdelivr.net/pyodide/v0.25.0/full/pyodide.js"></script>

<!-- Script Logic Playground (Dipisah dari HTML agar tidak bentrok) -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('codePlayground', (index, rawCode, language) => ({
            showEditor: false,
            userCode: rawCode,
            language: language,
            pyodide: null,
            isRunning: false,
            pythonOutput: '',

            toggleEditor() {
                this.showEditor = !this.showEditor;
                if (this.showEditor) {
                    this.$nextTick(() => {
                        this.runCode();
                        if (this.language === 'python') {
                            this.initPyodideEngine();
                        }
                    });
                }
            },

            async initPyodideEngine() {
                if (this.language === 'python' && !this.pyodide) {
                    this.pythonOutput = 'Memuat engine Python...';
                    try {
                        this.pyodide = await loadPyodide();
                        this.pythonOutput = 'Engine Python siap! Klik Run Code untuk menjalankan.';
                    } catch (err) {
                        this.pythonOutput = 'Gagal memuat Pyodide: ' + err.message;
                    }
                }
            },

            async runCode() {
                if (this.language === 'html' || this.language === 'css') {
                    let iframe = this.$refs.previewFrame;
                    if (iframe) {
                        let doc = iframe.contentDocument || iframe.contentWindow.document;
                        doc.open();
                        doc.write(this.userCode);
                        doc.close();
                    }
                } else if (this.language === 'python') {
                    this.isRunning = true;
                    this.pythonOutput = 'Running script...\n';
                    
                    try {
                        await this.initPyodideEngine();
                        
                        // Gunakan runner aman untuk Python
                        const wrapperScript = `
import sys
import io

sys.stdout = io.StringIO()

try:
    exec(${JSON.stringify(this.userCode)})
    output = sys.stdout.getvalue()
except Exception as e:
    output = f"Error: {e}"

output
`;

                        let result = await this.pyodide.runPythonAsync(wrapperScript);
                        this.pythonOutput = result || '(Program selesai tanpa output)';
                    } catch (err) {
                        this.pythonOutput = 'Execution Error:\n' + err.message;
                    } finally {
                        this.isRunning = false;
                    }
                }
            }
        }));
    });
</script>
@endpush

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 space-y-6">

@foreach($submateri->konten_builder ?? [] as $index => $block)
    @if(($block['tipe'] ?? '') === 'praktik')
        @php
            $judul = $block['arahan'] ?? 'Example';
            $bahasa = $block['tips'] ?? 'html';
            $kodeAwal = $block['isi'] ?? '';
        @endphp

        <!-- Card Example Style W3Schools -->
        <div class="my-6 bg-[#282c34] rounded-2xl p-6 shadow-xl text-white space-y-4 font-sans"
             x-data="codePlayground({{ $index }}, {{ json_encode($kodeAwal) }}, '{{ $bahasa }}')">

            <!-- Title / Header -->
            <h3 class="text-lg font-bold text-gray-100">{{ $judul }}</h3>

            <!-- Code Preview Box (Dark Theme) -->
            <div class="p-4 bg-[#1e1e1e] rounded-xl border border-gray-700/60 font-mono text-xs text-gray-200 overflow-x-auto leading-relaxed">
                <pre><code>{{ $kodeAwal }}</code></pre>
            </div>

            <!-- Button Try it Yourself -->
            <div class="pt-2">
                <button type="button" 
                        @click="toggleEditor()" 
                        class="px-5 py-2.5 bg-[#04aa6d] hover:bg-[#059862] text-white font-bold text-xs rounded-xl shadow-md transition active:scale-95 inline-flex items-center justify-center gap-2 cursor-pointer min-w-[140px]">
                    <span x-show="!showEditor">Try it Yourself »</span>
                    <span x-show="showEditor" x-cloak>Tutup Editor «</span>
                </button>
            </div>

            <!-- Integrated Code Playground -->
            <div x-show="showEditor" x-cloak x-transition class="pt-4 border-t border-gray-700 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 h-[380px]">
                    
                    <!-- Source Code Editor -->
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold text-gray-400">
                            <span class="flex items-center gap-1.5 uppercase">
                                <i class="fa-solid fa-code"></i> Editor (<span x-text="language"></span>)
                            </span>
                            <button type="button" 
                                    @click="runCode()" 
                                    :disabled="isRunning"
                                    class="px-3 py-1 bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 text-white rounded-lg text-xs font-bold transition flex items-center gap-1 cursor-pointer">
                                <i class="fa-solid fa-play text-[10px]"></i> 
                                <span x-text="isRunning ? 'Running...' : 'Run Code'"></span>
                            </button>
                        </div>
                        <textarea x-model="userCode" 
                                  @input.debounce.800ms="if(language !== 'python') runCode()"
                                  class="w-full flex-1 p-3 bg-[#1e1e1e] text-emerald-400 font-mono text-xs rounded-xl border border-gray-700 focus:outline-none resize-none leading-relaxed"></textarea>
                    </div>

                    <!-- Result Output Area -->
                    <div class="flex flex-col space-y-2">
                        <span class="text-xs font-bold text-gray-400 uppercase">
                            <i class="fa-solid fa-terminal mr-1"></i> Result Output
                        </span>
                        
                        <!-- Output HTML / CSS (Frame) -->
                        <template x-if="language === 'html' || language === 'css'">
                            <div class="w-full flex-1 bg-white rounded-xl border border-gray-700 overflow-hidden">
                                <iframe x-ref="previewFrame" class="w-full h-full border-0"></iframe>
                            </div>
                        </template>

                        <!-- Output Python Console (Terminal Style) -->
                        <template x-if="language === 'python'">
                            <div class="w-full flex-1 p-3 bg-black/90 text-green-400 font-mono text-xs rounded-xl border border-gray-700 overflow-y-auto whitespace-pre-wrap leading-relaxed shadow-inner">
                                <span x-text="pythonOutput"></span>
                            </div>
                        </template>
                    </div>

                </div>
            </div>

        </div>
    @endif
@endforeach

</div>
@endsection