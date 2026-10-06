{{-- Floating Toast Notifications System (Top-Centered & Auto-dismissing) --}}
<div id="toast-container" class="fixed top-20 sm:top-24 left-1/2 -translate-x-1/2 z-[99999] flex flex-col items-center gap-3 max-w-sm sm:max-w-md md:max-w-lg w-[calc(100%-2rem)] pointer-events-none" aria-live="polite">
    @if(session('success'))
        <div class="toast-item pointer-events-auto flex items-start gap-3.5 p-4 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl shadow-slate-900/15 border border-emerald-200/90 w-full relative overflow-hidden group transition-all duration-300 ease-out transform translate-y-0 opacity-100"
             role="alert"
             data-type="success"
             data-duration="4500">
            <!-- Icon Badge -->
            <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-emerald-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <!-- Message Body -->
            <div class="flex-1 min-w-0 pr-1">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-emerald-700 block mb-0.5">Berhasil</span>
                <p class="text-sm font-medium text-slate-800 leading-snug break-words">{{ session('success') }}</p>
            </div>
            <!-- Dismiss Button -->
            <button type="button" onclick="dismissToast(this.closest('.toast-item'))" class="shrink-0 p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" aria-label="Tutup notifikasi">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <!-- Progress Countdown Bar -->
            <div class="toast-progress absolute bottom-0 left-0 h-1 bg-emerald-500/80 rounded-full" style="animation: toastCountdown 4.5s linear forwards;"></div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast-item pointer-events-auto flex items-start gap-3.5 p-4 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl shadow-slate-900/15 border border-rose-200/90 w-full relative overflow-hidden group transition-all duration-300 ease-out transform translate-y-0 opacity-100"
             role="alert"
             data-type="error"
             data-duration="5500">
            <!-- Icon Badge -->
            <div class="w-9 h-9 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-rose-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <!-- Message Body -->
            <div class="flex-1 min-w-0 pr-1">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-rose-700 block mb-0.5">Perhatian</span>
                <p class="text-sm font-medium text-slate-800 leading-snug break-words">{{ session('error') }}</p>
            </div>
            <!-- Dismiss Button -->
            <button type="button" onclick="dismissToast(this.closest('.toast-item'))" class="shrink-0 p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" aria-label="Tutup notifikasi">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <!-- Progress Countdown Bar -->
            <div class="toast-progress absolute bottom-0 left-0 h-1 bg-rose-500/80 rounded-full" style="animation: toastCountdown 5.5s linear forwards;"></div>
        </div>
    @endif

    @if(session('warning'))
        <div class="toast-item pointer-events-auto flex items-start gap-3.5 p-4 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl shadow-slate-900/15 border border-amber-200/90 w-full relative overflow-hidden group transition-all duration-300 ease-out transform translate-y-0 opacity-100"
             role="alert"
             data-type="warning"
             data-duration="5000">
            <!-- Icon Badge -->
            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-amber-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <!-- Message Body -->
            <div class="flex-1 min-w-0 pr-1">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-amber-700 block mb-0.5">Peringatan</span>
                <p class="text-sm font-medium text-slate-800 leading-snug break-words">{{ session('warning') }}</p>
            </div>
            <!-- Dismiss Button -->
            <button type="button" onclick="dismissToast(this.closest('.toast-item'))" class="shrink-0 p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" aria-label="Tutup notifikasi">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <!-- Progress Countdown Bar -->
            <div class="toast-progress absolute bottom-0 left-0 h-1 bg-amber-500/80 rounded-full" style="animation: toastCountdown 5s linear forwards;"></div>
        </div>
    @endif

    @if(session('info') || session('status'))
        <div class="toast-item pointer-events-auto flex items-start gap-3.5 p-4 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl shadow-slate-900/15 border border-sky-200/90 w-full relative overflow-hidden group transition-all duration-300 ease-out transform translate-y-0 opacity-100"
             role="alert"
             data-type="info"
             data-duration="4500">
            <!-- Icon Badge -->
            <div class="w-9 h-9 rounded-xl bg-sky-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-sky-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <!-- Message Body -->
            <div class="flex-1 min-w-0 pr-1">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-sky-700 block mb-0.5">Informasi</span>
                <p class="text-sm font-medium text-slate-800 leading-snug break-words">{{ session('info') ?? session('status') }}</p>
            </div>
            <!-- Dismiss Button -->
            <button type="button" onclick="dismissToast(this.closest('.toast-item'))" class="shrink-0 p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" aria-label="Tutup notifikasi">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <!-- Progress Countdown Bar -->
            <div class="toast-progress absolute bottom-0 left-0 h-1 bg-sky-500/80 rounded-full" style="animation: toastCountdown 4.5s linear forwards;"></div>
        </div>
    @endif

    @if(isset($errors) && $errors->any() && !session('error'))
        <div class="toast-item pointer-events-auto flex items-start gap-3.5 p-4 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl shadow-slate-900/15 border border-rose-200/90 w-full relative overflow-hidden group transition-all duration-300 ease-out transform translate-y-0 opacity-100"
             role="alert"
             data-type="error"
             data-duration="6500">
            <!-- Icon Badge -->
            <div class="w-9 h-9 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-rose-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <!-- Message Body -->
            <div class="flex-1 min-w-0 pr-1">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-rose-700 block mb-0.5">Kesalahan Pengisian</span>
                <p class="text-sm font-medium text-slate-800 leading-snug break-words">{{ $errors->first() }}</p>
                @if($errors->count() > 1)
                    <span class="text-[11px] text-slate-500 mt-0.5 block font-normal">+ {{ $errors->count() - 1 }} kesalahan lainnya</span>
                @endif
            </div>
            <!-- Dismiss Button -->
            <button type="button" onclick="dismissToast(this.closest('.toast-item'))" class="shrink-0 p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" aria-label="Tutup notifikasi">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <!-- Progress Countdown Bar -->
            <div class="toast-progress absolute bottom-0 left-0 h-1 bg-rose-500/80 rounded-full" style="animation: toastCountdown 6.5s linear forwards;"></div>
        </div>
    @endif
</div>

<style>
@keyframes toastCountdown {
    0% { width: 100%; }
    100% { width: 0%; }
}
.toast-item {
    animation: toastSlideDown 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes toastSlideDown {
    0% {
        opacity: 0;
        transform: translateY(-24px) scale(0.95);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
</style>

<script>
(function() {
    window.dismissToast = function(el) {
        if (!el || el.dataset.dismissing === 'true') return;
        el.dataset.dismissing = 'true';
        el.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        el.style.opacity = '0';
        el.style.transform = 'translateY(-24px) scale(0.95)';
        setTimeout(() => {
            el.remove();
            const container = document.getElementById('toast-container');
            if (container && container.querySelectorAll('.toast-item').length === 0) {
                container.style.display = 'none';
            }
        }, 320);
    };

    function setupToasts() {
        const toasts = document.querySelectorAll('.toast-item');
        toasts.forEach(toast => {
            if (toast.dataset.initialized === 'true') return;
            toast.dataset.initialized = 'true';

            const duration = parseInt(toast.dataset.duration || '4500', 10);
            let timer = null;

            const startTimer = () => {
                timer = setTimeout(() => {
                    window.dismissToast(toast);
                }, duration);
            };

            const progressBar = toast.querySelector('.toast-progress');

            toast.addEventListener('mouseenter', () => {
                clearTimeout(timer);
                if (progressBar) progressBar.style.animationPlayState = 'paused';
            });

            toast.addEventListener('mouseleave', () => {
                if (progressBar) progressBar.style.animationPlayState = 'running';
                timer = setTimeout(() => {
                    window.dismissToast(toast);
                }, 1500);
            });

            startTimer();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupToasts);
    } else {
        setupToasts();
    }
})();
</script>
