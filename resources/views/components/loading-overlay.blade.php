{{-- ============================================================ --}}
{{-- Loading Overlay Component                                  --}}
{{-- Full-page spinner shown during AJAX operations.           --}}
{{-- Toggle with window.showLoading() / window.hideLoading()   --}}
{{-- ============================================================ --}}

<!-- Begin: Loading Overlay -->
<div id="loadingOverlay"
    class="fixed inset-0 bg-white/70 backdrop-blur-sm z-[9999] items-center justify-center hidden">
    <div class="flex flex-col items-center gap-3">
        {{-- Spinner ring --}}
        <div class="w-12 h-12 rounded-full border-4 border-blue-100 border-t-blue-600 animate-spin"></div>
        <p class="text-sm font-medium text-gray-500">Loading...</p>
    </div>
</div>
<!-- End: Loading Overlay -->

<script>
    // Show full-page loading overlay
    window.showLoading = () => {
        const el = document.getElementById('loadingOverlay');
        if (el) el.classList.replace('hidden', 'flex');
    };

    // Hide full-page loading overlay
    window.hideLoading = () => {
        const el = document.getElementById('loadingOverlay');
        if (el) el.classList.replace('flex', 'hidden');
    };
</script>
