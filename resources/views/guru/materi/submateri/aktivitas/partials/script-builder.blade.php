<script>
// Singleton Listener Upload Gambar Trix
if (!window.trixUploadListenerInitialized) {
    document.addEventListener("trix-attachment-add", function(event) {
        if (event.attachment.file) {
            uploadTrixImage(event.attachment);
        }
    });
    window.trixUploadListenerInitialized = true;
}

function uploadTrixImage(attachment) {
    const formData = new FormData();
    formData.append("upload", attachment.file);

    fetch("{{ route('guru.materi.submateri.aktivitas.image') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        },
        body: formData
    })
    .then(async response => {
        const data = await response.json();
        if (!response.ok) {
            // Tangkap pesan error dari laravel jika ada
            const errorMsg = data.message || (data.errors ? Object.values(data.errors).flat().join(', ') : 'Gagal upload gambar');
            throw new Error(errorMsg);
        }
        return data;
    })
    .then(data => {
        if (data.url) {
            attachment.setAttributes({
                url: data.url,
                href: data.url
            });
        }
    })
    .catch(error => {
        console.error("Error uploading image:", error);
        attachment.remove();
        alert("Gagal mengunggah gambar: " + error.message);
    });
}


function aktivitasBuilder(allowedTypes, existingBlocks = []) {
    return {
        allowedTypes: allowedTypes || [],
        blocks: [],

        init() {
            if (existingBlocks && existingBlocks.length > 0) {
                existingBlocks.forEach(block => {
                    this.addBlock(block.tipe, block);
                });
            } else if (this.allowedTypes && this.allowedTypes.length > 0) {
                this.addBlock(this.allowedTypes[0]);
            }
        },

        getLabel(tipe) {
            const labels = {
                'teks': 'Teks / Bacaan',
                'video': 'Video Pembelajaran',
                'interaktif': 'Simulasi Interaktif',
                'praktik': 'Praktik Kode',
                'latihan': 'Latihan Soal'
            };
            return labels[tipe] || tipe;
        },

        addBlock(tipe, data = null) {
            const id = 'editor-' + Date.now() + '-' + Math.floor(Math.random() * 1000);
            
            // WAJIB: Pastikan semua key properti terdefinisi string kosong '', bukan undefined/null
            this.blocks.push({
                id: id,
                tipe: tipe,
                isi: data ? (data.isi || '') : '',
                tips: data ? (data.tips || '') : '',
                arahan: data ? (data.arahan || '') : '',
                clue: data ? (data.clue || '') : ''
            });
        },

        removeBlock(index) {
            this.blocks.splice(index, 1);
        },

        moveUp(index) {
            if (index > 0) {
                const temp = this.blocks[index];
                this.blocks[index] = this.blocks[index - 1];
                this.blocks[index - 1] = temp;
            }
        },

        moveDown(index) {
            if (index < this.blocks.length - 1) {
                const temp = this.blocks[index];
                this.blocks[index] = this.blocks[index + 1];
                this.blocks[index + 1] = temp;
            }
        }
    }
}
</script>