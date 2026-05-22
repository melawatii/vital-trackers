{{-- ============================================================ --}}
{{-- DataTable Actions Partial                                  --}}
{{-- Renders edit and delete buttons for each table row.       --}}
{{-- ============================================================ --}}

<!-- Begin: Table Row Actions -->
<div class="flex items-center justify-end gap-2">
    {{-- Edit button --}}
    <a href="{{ $editUrl }}"
        class="w-8 h-8 rounded-lg border border-blue-200 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all duration-150"
        title="Edit category">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
    </a>

    {{-- Delete button --}}
    <button type="button"
        class="btn-delete w-8 h-8 rounded-lg border border-red-200 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all duration-150"
        data-id="{{ $row->id }}"
        data-url="{{ $deleteUrl }}"
        title="Delete category">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
    </button>
</div>
<!-- End: Table Row Actions -->
