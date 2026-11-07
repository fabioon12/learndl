
<script>
(function () {
    'use strict';

    const MAX_HEARTS = 3;
    let hearts = MAX_HEARTS;

    const messages = {
        teks: [
            '🫎',
            'Yuk, pahami materinya terlebih dahulu!',
            'Baca dengan teliti sebelum melanjutkan.'
        ],
        video: [
            '🫎',
            'Perhatikan video pembelajaran ini!',
            'Catat informasi yang penting.'
        ],
        praktik: [
            '💻',
            'Saatnya menguji kemampuan coding-mu!',
            'Jalankan kode untuk menyelesaikan misi.'
        ],
        latihan: [
            '🧩',
            'Ayo susun kode dengan urutan yang benar!',
            'Gunakan logika dan pemahamanmu.'
        ],
        pilihan_ganda: [
            '🫎',
            'Pilih jawaban yang paling tepat!',
            'Setiap jawaban salah mengurangi 1 HP.'
        ],
        success: [
            '🎉',
            'Hebat! Jawabanmu benar!',
            'Pertahankan semangatmu!'
        ],
        wrong: [
            '😵',
            'Belum tepat! Satu nyawamu berkurang.',
            'Coba pikirkan kembali jawabannya.'
        ],
        danger: [
            '😰',
            'Hati-hati! Tinggal satu nyawa!',
            'Periksa jawabanmu dengan lebih teliti.'
        ],
        gameover: [
            '💔',
            'Nyawamu habis!',
            'Ulangi tantangan untuk mencoba kembali.'
        ],
        finish: [
            '🏆',
            'Selamat! Semua tantangan selesai!',
            'Kamu berhasil menyelesaikan misi.'
        ]
    };

    function updateCharacter(type) {
        const aliases = {
            text: 'teks',
            youtube: 'video',
            code: 'praktik',
            arahan: 'latihan',
            interaktif: 'pilihan_ganda'
        };

        const normalized = aliases[type] || type;
        const config = messages[normalized] || messages.teks;

        const emoji = document.getElementById(
            'character-emoji'
        );
        const message = document.getElementById(
            'character-message'
        );
        const submessage = document.getElementById(
            'character-submessage'
        );

        if (emoji) emoji.textContent = config[0];
        if (message) message.textContent = config[1];
        if (submessage) submessage.textContent = config[2];
    }


    function renderHearts() {
        const container = document.getElementById('character-hearts');
        const label = document.getElementById('character-hp-label');
        const resetButton = document.getElementById('reset-hearts-button');

        if (!container) return;

        // Perbarui ikon hati
        container.querySelectorAll('.character-heart')
            .forEach(function (heart, index) {
                heart.textContent = index < hearts ? '❤️' : '🖤';
            });

        // Perbarui angka HP
        if (label) {
            label.textContent = hearts + ' / ' + MAX_HEARTS + ' HP';

            label.classList.toggle('text-red-400', hearts === 0);
            label.classList.toggle('text-gray-300', hearts > 0);
        }

        // Tampilkan tombol reset jika HP habis
        if (resetButton) {
            resetButton.classList.toggle('hidden', hearts > 0);
        }

        container.setAttribute(
            'aria-label',
            hearts + ' dari ' + MAX_HEARTS + ' nyawa'
        );
    }


    function decreaseHeart() {
        if (hearts <= 0) return false;

        hearts--;

        // Update indikator dan tombol reset
        renderHearts();

        if (hearts === 0) {
            updateCharacter('gameover');
        } else if (hearts === 1) {
            updateCharacter('danger');
        } else {
            updateCharacter('wrong');
        }

        return true;
    }

    function restoreHearts() {
        hearts = MAX_HEARTS;

        // Menyembunyikan tombol reset kembali
        renderHearts();

        updateCharacter('pilihan_ganda');
    }

    window.restoreHearts = restoreHearts;

    function getHearts() {
        return hearts;
    }

    window.updateCharacter = updateCharacter;
    window.decreaseHeart = decreaseHeart;
    window.restoreHearts = restoreHearts;
    window.getHearts = getHearts;

    renderHearts();
})();
</script>
