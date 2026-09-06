<x-filament::page>
    <div class="space-y-6 max-w-xl mx-auto">

        {{-- BAGIAN 1: FORM UNTUK INPUT MANUAL & SCANNER FISIK --}}
        <div id="manual-scanner-section">
            <p class="text-center text-gray-400 mb-2">Gunakan scanner fisik atau ketik manual di bawah</p>
            <form wire:submit.prevent="submit" id="form-absensi">
                <x-filament::input.wrapper>
                    <x-filament::input
                        type="text"
                        wire:model="kodeAbsen"
                        id="kodeAbsen"
                        placeholder="Scan atau masukkan kode absen..."
                        autofocus />
                </x-filament::input.wrapper>
            </form>
        </div>

        {{-- WADAH SCANNER KAMERA --}}
        <div id="qr-reader"
            class="w-full border-2 border-dashed border-gray-300 rounded-lg overflow-hidden mb-4"
            style="display: none; height: 300px; position: relative;">
            <div id="qr-overlay"></div>
        </div>

        <div class="flex items-center text-center">
            <div class="flex-grow border-t border-gray-600"></div>
            <span class="flex-shrink mx-4 text-gray-400">ATAU</span>
            <div class="flex-grow border-t border-gray-600"></div>
        </div>

        {{-- BAGIAN 2: TOMBOL UNTUK SCANNER KAMERA HP --}}
        <div class="text-center">
            <x-filament::button
                id="cameraButton"
                icon="heroicon-o-qr-code"
                size="lg"
                color="info">
                Scan Menggunakan Kamera
            </x-filament::button>
        </div>

    </div>

    @push('scripts')
    <style>
        #qr-reader video {
            width: 100% !important;
            height: auto !important;
        }

    </style>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputKodeAbsen = document.getElementById('kodeAbsen');

            inputKodeAbsen.addEventListener('change', function() {
                if (inputKodeAbsen.value.trim() !== '') {
                    @this.submit();
                }
            });

            window.addEventListener('scan-berhasil', event => {
                setTimeout(() => {
                    inputKodeAbsen.value = '';
                    inputKodeAbsen.focus();
                }, 50);
            });

            if (typeof Html5Qrcode === 'undefined') return;

            const qrReader = document.getElementById('qr-reader');
            const cameraButton = document.getElementById('cameraButton');
            let isCameraRunning = false;
            const html5QrCode = new Html5Qrcode("qr-reader");

            const onScanSuccess = (decodedText) => {
                @this.set('kodeAbsen', decodedText);
                @this.submit();
                stopCamera();
            };

            const startCamera = () => {
                const config = {
                    fps: 60,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                };
                html5QrCode.start({
                        facingMode: "environment"
                    }, config, onScanSuccess, () => {})
                    .then(() => {
                        qrReader.style.display = 'block';
                        cameraButton.innerText = 'Hentikan Kamera';
                        isCameraRunning = true;
                    })
                    .catch(err => alert(`ERROR: Tidak dapat memulai kamera. (${err})`));
            };

            const stopCamera = () => {
                if (isCameraRunning) {
                    html5QrCode.stop()
                        .then(() => {
                            qrReader.style.display = 'none';
                            cameraButton.innerText = 'Scan Menggunakan Kamera';
                            isCameraRunning = false;
                        })
                        .catch(err => console.error("Gagal menghentikan scanner.", err));
                }
            };

            cameraButton.addEventListener('click', () => {
                if (isCameraRunning) stopCamera();
                else startCamera();
            });
        });
    </script>
    @endpush
</x-filament::page>