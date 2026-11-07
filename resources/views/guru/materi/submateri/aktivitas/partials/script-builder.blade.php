
<script>
// =====================================================
// TRIX IMAGE UPLOAD LISTENER
// =====================================================

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
            const errorMsg = data.message ||
                (data.errors ? Object.values(data.errors).flat().join(', ') : 'Gagal upload gambar');

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


// =====================================================
// AKTIVITAS BUILDER
// =====================================================

function aktivitasBuilder(allowedTypes = [], existingBlocks = []) {
    return {
        allowedTypes: Array.isArray(allowedTypes) ? allowedTypes : [],
        blocks: [],

        init() {
            console.log('Allowed Types:', this.allowedTypes);
            console.log('Existing Blocks:', existingBlocks);

            if (Array.isArray(existingBlocks) && existingBlocks.length > 0) {
                existingBlocks.forEach(block => {
                    this.addBlock(block.tipe, block);
                });
            } else if (this.allowedTypes.length > 0) {
                this.addBlock(this.allowedTypes[0]);
            }
        },

        getLabel(tipe) {
            const labels = {
                teks: 'Teks / Bacaan',
                video: 'Video Pembelajaran',
                interaktif: 'Simulasi Interaktif',
                praktik: 'Praktik Kode',
                latihan: 'Latihan Soal',
                coding_project: 'Coding Project HTML/CSS/JS'
            };

            return labels[tipe] || tipe;
        },

        addBlock(tipe, data = null) {
            const id = 'editor-' + Date.now() + '-' +
                Math.floor(Math.random() * 1000);

            const defaultProject = {
                nama: '',
                deskripsi: '',
                bahasa: 'html',
                starter_code: `<!DOCTYPE html>
<html>
<head>
    <title>Proyek Saya</title>
</head>
<body>

</body>
</html>`,
                missions: []
            };

            const project = data && data.project
                ? {
                    ...defaultProject,
                    ...data.project,
                    missions: Array.isArray(data.project.missions)
                        ? data.project.missions.map(mission => ({
                            id: mission.id || (
                                'mission-' + Date.now() + '-' +
                                Math.floor(Math.random() * 1000)
                            ),
                            ...mission,
                            criteria: Array.isArray(mission.criteria)
                                ? mission.criteria.map(criterion => ({
                                    type: 'tag_exists',
                                    tag: '',
                                    text: '',
                                    attribute: '',
                                    ...criterion
                                }))
                                : []
                        }))
                        : []
                }
                : { ...defaultProject };

            this.blocks.push({
                id,
                tipe,
                previewOpen: false,

                isi: data ? (data.isi || '') : '',
                tips: data ? (data.tips || '') : '',
                arahan: data ? (data.arahan || '') : '',
                clue: data ? (data.clue || '') : '',

                project
            });
        },

        addMission(blockIndex) {
            const project = this.blocks[blockIndex].project;

            project.missions.push({
                id: 'mission-' + Date.now() + '-' +
                    Math.floor(Math.random() * 1000),
                judul: '',
                instruksi: '',
                petunjuk: '',
                criteria: [
                    {
                        type: 'tag_exists',
                        tag: 'p',
                        text: '',
                        attribute: ''
                    }
                ]
            });
        },

        removeMission(blockIndex, missionIndex) {
            this.blocks[blockIndex].project.missions.splice(
                missionIndex, 1
            );
        },

        addCriterion(blockIndex, missionIndex) {
            this.blocks[blockIndex].project.missions[missionIndex].criteria.push({
                type: 'tag_exists',
                tag: '',
                text: '',
                attribute: ''
            });
        },

        removeCriterion(blockIndex, missionIndex, criterionIndex) {
            this.blocks[blockIndex].project.missions[missionIndex].criteria.splice(
                criterionIndex, 1
            );
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
    };
}
</script>
