{{-- ============================================================ --}}
{{-- DataTable Actions Partial – Users                          --}}
{{-- Renders a kebab menu (3-dot) with Edit and Delete options. --}}
{{-- ============================================================ --}}

<!-- Begin: Table Row Actions -->
<div style="display:flex;align-items:center;justify-content:flex-start;gap:6px;padding-right:4px">

    {{-- Edit button --}}
    <a href="{{ $editUrl }}"
       style="width:30px;height:30px;border-radius:8px;border:1.5px solid #bfdbfe;background:#eff6ff;color:#2563eb;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all .15s"
       onmouseover="this.style.background='#2563eb';this.style.color='#fff'"
       onmouseout="this.style.background='#eff6ff';this.style.color='#2563eb'"
       title="Edit user">
        <svg style="width:13px;height:13px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
    </a>

    {{-- Delete button --}}
    <button type="button"
            style="width:30px;height:30px;border-radius:8px;border:1.5px solid #fecaca;background:#fff1f2;color:#ef4444;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .15s"
            onmouseover="this.style.background='#ef4444';this.style.color='#fff'"
            onmouseout="this.style.background='#fff1f2';this.style.color='#ef4444'"
            class="btn-delete-user"
            data-id="{{ $row->id }}"
            data-name="{{ $row->name }}"
            data-url="{{ $deleteUrl }}"
            title="Delete user">
        <svg style="width:13px;height:13px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
    </button>

</div>
<!-- End: Table Row Actions -->
