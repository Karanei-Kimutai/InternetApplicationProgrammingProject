<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Verification</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/tp-logo.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="robots" content="noindex">
</head>
<body class="min-h-screen bg-slate-900 text-white">
    <div class="max-w-5xl mx-auto py-10 px-4 space-y-6">
        <header class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-start gap-3">
                <img src="{{ asset('images/tp-logo.svg') }}" alt="Temporary Pass logo" class="h-12 w-auto hidden sm:block">
                <div>
                    <p class="text-xs uppercase tracking-[0.4em] text-blue-300">Security Portal</p>
                    <h1 class="text-3xl font-semibold">Scan or enter a QR token</h1>
                    <p class="text-sm text-slate-300 mt-2">Paste the token shown in the QR payload. We’ll display the pass status instantly.</p>
                </div>
            </div>
            <form action="{{ route('security.logout') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/40">
                    Log out
                </button>
            </form>
        </header>

        <section class="bg-white/10 rounded-3xl p-6 shadow-2xl space-y-4">
            <label for="token" class="text-sm font-medium text-slate-200">QR token</label>
            <div class="flex flex-col gap-3 sm:flex-row">
                <input type="text" id="token" name="token" placeholder="Paste or scan token..." class="flex-1 rounded-2xl border border-white/20 bg-transparent px-4 py-3 text-white focus:border-blue-400 focus:ring-2 focus:ring-blue-500" />
                <button id="lookupBtn" class="rounded-2xl bg-blue-500 px-5 py-3 font-semibold text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">Lookup</button>
                <button id="scanToggle" class="rounded-2xl border border-blue-400 px-5 py-3 font-semibold text-blue-200 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-blue-200">Scan QR</button>
            </div>
            <div id="scannerContainer" class="hidden rounded-2xl border border-white/20 p-4 space-y-3">
                <video id="qrVideo" class="w-full rounded-xl bg-black/50" playsinline></video>
                <p class="text-xs text-slate-300">Point the camera at the QR. Once detected, lookup runs automatically.</p>
                <button id="stopScan" class="inline-flex items-center rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20 focus:ring-2 focus:ring-white/30">Stop scanning</button>
            </div>
            <p class="text-xs text-slate-400">Tip: Most scanners show the raw token after decoding the QR. Long-press to copy then paste above.</p>
        </section>

        <section id="resultCard" class="hidden rounded-3xl bg-white/5 p-6 shadow-lg">
            <div id="resultHeader" class="flex items-center gap-3">
                <div id="statusDot" class="h-3 w-3 rounded-full bg-slate-400"></div>
                <p id="statusText" class="text-lg font-semibold">Awaiting lookup…</p>
            </div>
            <dl class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 text-sm text-slate-200">
                <div class="sm:col-span-2 lg:col-span-1">
                    <dt class="text-slate-400 uppercase tracking-wide text-xs">Profile photo</dt>
                    <dd class="mt-1">
                        <div class="mt-2 flex items-center">
                            <div class="relative h-28 w-28 overflow-hidden rounded-2xl border border-white/20 bg-white/10">
                                <img id="holderPhoto" class="hidden h-full w-full object-cover" alt="Pass holder photo">
                                <div id="holderPhotoFallback" class="flex h-full w-full items-center justify-center text-[0.65rem] font-semibold uppercase tracking-wide text-slate-400">No photo</div>
                            </div>
                        </div>
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-400 uppercase tracking-wide text-xs">Holder</dt>
                    <dd class="mt-1 font-medium" id="holderName">—</dd>
                </div>
                <div>
                    <dt class="text-slate-400 uppercase tracking-wide text-xs">Email</dt>
                    <dd class="mt-1 font-medium" id="holderEmail">—</dd>
                </div>
                <div>
                    <dt class="text-slate-400 uppercase tracking-wide text-xs">Pass reference</dt>
                    <dd class="mt-1 font-medium" id="passReference">—</dd>
                </div>
                <div>
                    <dt class="text-slate-400 uppercase tracking-wide text-xs">Reason</dt>
                    <dd class="mt-1 font-medium" id="passReason">—</dd>
                </div>
                <div>
                    <dt class="text-slate-400 uppercase tracking-wide text-xs">Valid from</dt>
                    <dd class="mt-1 font-medium" id="validFrom">—</dd>
                </div>
                <div>
                    <dt class="text-slate-400 uppercase tracking-wide text-xs">Valid until</dt>
                    <dd class="mt-1 font-medium" id="validUntil">—</dd>
                </div>
            </dl>
        </section>

        <section class="rounded-3xl bg-white/5 p-6 text-sm text-slate-300">
            <p class="font-semibold text-white">Security checklist</p>
            <ul class="mt-3 list-disc list-inside space-y-1">
                <li>Verify the QR token matches the applicant’s ID or email.</li>
                <li>Ensure the status shows <span class="text-emerald-300 font-semibold">APPROVED</span> and the current time is within the valid window.</li>
                <li>If the pass is expired or rejected, direct the visitor to the security desk.</li>
            </ul>
        </section>
    </div>

    <script>
        const lookupBtn = document.getElementById('lookupBtn');
        const scanToggle = document.getElementById('scanToggle');
        const tokenInput = document.getElementById('token');
        const resultCard = document.getElementById('resultCard');
        const statusText = document.getElementById('statusText');
        const statusDot = document.getElementById('statusDot');
        const holderName = document.getElementById('holderName');
        const holderEmail = document.getElementById('holderEmail');
        const passReference = document.getElementById('passReference');
        const passReason = document.getElementById('passReason');
        const validFrom = document.getElementById('validFrom');
        const validUntil = document.getElementById('validUntil');
        const holderPhoto = document.getElementById('holderPhoto');
        const holderPhotoFallback = document.getElementById('holderPhotoFallback');
        const scannerContainer = document.getElementById('scannerContainer');
        const qrVideo = document.getElementById('qrVideo');
        const stopScan = document.getElementById('stopScan');
        let scanStream = null;
        let scanInterval = null;

        const extractToken = (raw) => {
            const trimmed = (raw ?? '').trim();
            if (!trimmed) {
                return '';
            }

            if (trimmed.includes('://')) {
                try {
                    const url = new URL(trimmed);
                    const segments = url.pathname.split('/').filter(Boolean);
                    if (segments.length) {
                        return segments.pop();
                    }
                } catch (error) {
                    // Ignore parse failures and fall back to regex
                }
            }

            const match = trimmed.match(/([A-Za-z0-9-]{10,})$/);
            return match ? match[1] : trimmed;
        };

        const setStatus = (ok, text) => {
            statusText.textContent = text;
            statusDot.className = `h-3 w-3 rounded-full ${ok ? 'bg-emerald-400' : 'bg-red-400'}`;
            resultCard.classList.remove('hidden');
        };

        const resetHolderPhoto = () => {
            holderPhoto.classList.add('hidden');
            holderPhoto.removeAttribute('src');
            holderPhotoFallback.classList.remove('hidden');
        };

        const runLookup = async (token) => {
            if (!token) {
                setStatus(false, 'Enter a token first.');
                return;
            }

            setStatus(true, 'Checking...');
            holderName.textContent = holderEmail.textContent = passReference.textContent = passReason.textContent = validFrom.textContent = validUntil.textContent = '—';
            resetHolderPhoto();

            try {
                const response = await fetch('{{ route('security.lookup') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ token }),
                });

                const data = await response.json();

                if (!response.ok || !data.found) {
                    setStatus(false, data.message ?? 'Pass not found.');
                    return;
                }

                setStatus(data.status === 'approved', `Status: ${data.status.toUpperCase()}`);
                holderName.textContent = data.holder_name ?? 'Unknown';
                holderEmail.textContent = data.holder_email ?? 'Unknown';
                passReference.textContent = data.pass_reference ?? '—';
                passReason.textContent = data.reason ?? '—';
                validFrom.textContent = data.valid_from ? new Date(data.valid_from).toLocaleString() : '—';
                validUntil.textContent = data.valid_until ? new Date(data.valid_until).toLocaleString() : '—';
                if (data.holder_photo_url) {
                    holderPhoto.src = data.holder_photo_url;
                    holderPhoto.alt = `${data.holder_name ?? 'Pass holder'} photo`;
                    holderPhoto.classList.remove('hidden');
                    holderPhotoFallback.classList.add('hidden');
                }
            } catch (error) {
                console.error(error);
                setStatus(false, 'Unable to contact server.');
            }
        };

        lookupBtn.addEventListener('click', () => runLookup(extractToken(tokenInput.value)));
        tokenInput.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') runLookup(extractToken(tokenInput.value));
        });

        const stopCamera = () => {
            if (scanInterval) {
                clearInterval(scanInterval);
                scanInterval = null;
            }
            if (scanStream) {
                scanStream.getTracks().forEach(track => track.stop());
                scanStream = null;
            }
            scannerContainer.classList.add('hidden');
        };

        scanToggle.addEventListener('click', async () => {
            if (scanStream) {
                stopCamera();
                return;
            }

            try {
                scanStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
                qrVideo.srcObject = scanStream;
                await qrVideo.play();
                scannerContainer.classList.remove('hidden');

                const track = scanStream.getVideoTracks()[0];
                const imageCapture = new ImageCapture(track);

                scanInterval = setInterval(async () => {
                    try {
                        const bitmap = await imageCapture.grabFrame();
                        const canvas = document.createElement('canvas');
                        canvas.width = bitmap.width;
                        canvas.height = bitmap.height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(bitmap, 0, 0);
                        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                        const code = jsQR(imageData.data, imageData.width, imageData.height);
                        if (code?.data) {
                            tokenInput.value = extractToken(code.data);
                            stopCamera();
                            runLookup(tokenInput.value);
                        }
                    } catch (error) {
                        console.error('scan error', error);
                    }
                }, 500);
            } catch (error) {
                console.error(error);
                setStatus(false, 'Camera access denied.');
            }
        });

        stopScan.addEventListener('click', stopCamera);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
</body>
</html>
