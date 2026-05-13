@extends('layouts.d_layout')

@section('title', 'Offline License Generator')
@section('page_title', 'Offline License Generator')

@section('content')
<style>
    /* ── Page wrapper ── */
    .lic-grid {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 1.75rem;
        align-items: start;
        max-width: 1300px;
    }

    /* ── Cards ── */
    .lic-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,.08);
        padding: 1.75rem;
    }
    .lic-card h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 1.25rem;
        color: #111827;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    /* ── Form labels ── */
    .lic-label {
        display: block;
        font-size: .8125rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: .4rem;
    }
    .lic-input {
        width: 100%;
        padding: .55rem .75rem;
        border: 1.5px solid #d1d5db;
        border-radius: 8px;
        font-size: .9rem;
        box-sizing: border-box;
        transition: border-color .2s;
        outline: none;
    }
    .lic-input:focus { border-color: #6366f1; }

    /* ── Day preset buttons ── */
    .day-presets {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
        margin-bottom: 1.25rem;
    }
    .day-btn {
        padding: .4rem .85rem;
        border-radius: 20px;
        border: 1.5px solid #d1d5db;
        background: #f9fafb;
        font-size: .8125rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .18s;
        color: #374151;
    }
    .day-btn:hover { border-color: #6366f1; color: #6366f1; background: #eef2ff; }
    .day-btn.selected {
        background: #6366f1;
        border-color: #6366f1;
        color: #fff;
        box-shadow: 0 2px 8px rgba(99,102,241,.35);
    }

    /* ── Generate button ── */
    .btn-generate {
        width: 100%;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        padding: .75rem;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: .95rem;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
        letter-spacing: .02em;
    }
    .btn-generate:hover { opacity: .9; transform: translateY(-1px); }
    .btn-generate:disabled { opacity: .6; cursor: not-allowed; transform: none; }

    /* ── Result box ── */
    .result-box {
        margin-top: 1.5rem;
        padding: 1.25rem;
        background: #f0fdf4;
        border: 1.5px solid #86efac;
        border-radius: 10px;
    }
    .result-box h4 { margin: 0 0 .5rem; color: #15803d; font-size: .95rem; font-weight: 700; }
    .result-box p  { margin: 0 0 .75rem; font-size: .8125rem; color: #4b5563; }
    .key-textarea {
        width: 100%;
        padding: .65rem;
        border: 1.5px solid #d1d5db;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-size: .78rem;
        background: #f9fafb;
        resize: none;
        box-sizing: border-box;
        color: #111827;
    }
    .btn-copy {
        margin-top: .5rem;
        width: 100%;
        padding: .5rem;
        background: #fff;
        border: 1.5px solid #d1d5db;
        border-radius: 8px;
        font-weight: 600;
        font-size: .8125rem;
        cursor: pointer;
        transition: background .2s;
        color: #374151;
    }
    .btn-copy:hover { background: #f3f4f6; }

    /* ── Alerts ── */
    .alert-err {
        background: #fee2e2;
        border: 1px solid #ef4444;
        color: #b91c1c;
        padding: .85rem 1rem;
        border-radius: 8px;
        font-size: .85rem;
        margin-bottom: 1rem;
    }
    .alert-ok {
        background: #eff6ff;
        border: 1px solid #93c5fd;
        color: #1d4ed8;
        padding: .85rem 1rem;
        border-radius: 8px;
        font-size: .85rem;
        margin-bottom: 1rem;
    }

    /* ── Table ── */
    .lic-table { width: 100%; border-collapse: collapse; font-size: .84rem; }
    .lic-table thead tr { background: #f8fafc; border-bottom: 2px solid #e5e7eb; }
    .lic-table th {
        padding: .7rem 1rem;
        text-align: left;
        font-size: .72rem;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .06em;
        white-space: nowrap;
    }
    .lic-table td { padding: .65rem 1rem; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
    .lic-table tbody tr:last-child td { border-bottom: none; }
    .lic-table tbody tr:hover td { background: #fafafa; }

    /* Key cell */
    .key-cell {
        font-family: 'Courier New', monospace;
        font-size: .7rem;
        color: #374151;
        max-width: 220px;
        word-break: break-all;
        cursor: pointer;
    }
    .key-cell-short { color: #6b7280; }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .25rem .6rem;
        border-radius: 20px;
        font-size: .72rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .badge-days    { background: #e0e7ff; color: #3730a3; }
    .badge-active  { background: #dcfce7; color: #15803d; }
    .badge-suspended { background: #fee2e2; color: #b91c1c; }
    .badge-expired { background: #f3f4f6; color: #6b7280; }

    /* Action buttons */
    .btn-action {
        padding: .3rem .65rem;
        border-radius: 6px;
        border: none;
        font-size: .75rem;
        font-weight: 600;
        cursor: pointer;
        transition: opacity .2s;
    }
    .btn-action:hover { opacity: .8; }
    .btn-suspend    { background: #fef3c7; color: #92400e; }
    .btn-reactivate { background: #d1fae5; color: #065f46; }

    /* Tooltip for key expand */
    .key-full {
        display: none;
        position: absolute;
        background: #1f2937;
        color: #f9fafb;
        padding: .5rem .75rem;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-size: .72rem;
        z-index: 100;
        width: 320px;
        word-break: break-all;
        box-shadow: 0 4px 16px rgba(0,0,0,.2);
        top: 100%;
        left: 0;
        margin-top: 4px;
    }
    .key-wrapper { position: relative; }
    .key-wrapper:hover .key-full { display: block; }

    @media (max-width: 900px) {
        .lic-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="lic-grid">

    {{-- ── LEFT: Generator Form ── --}}
    <div class="lic-card">
        <h3>🔑 Create New License</h3>

        @if ($errors->any())
            <div class="alert-err">
                <ul style="margin:0;padding-left:1.25rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert-ok">✅ {{ session('success') }}</div>
        @endif

        <form action="{{ route('licenses.generate') }}" method="POST" id="licForm">
            @csrf
            <input type="hidden" name="days" id="selectedDays" value="">

            {{-- Client name --}}
            <div style="margin-bottom:1rem;">
                <label for="client_name" class="lic-label">Client Name</label>
                <input type="text" name="client_name" id="client_name" required
                       class="lic-input" placeholder="e.g. Acme Corp"
                       value="{{ old('client_name') }}">
            </div>

            {{-- Day preset buttons --}}
            <div style="margin-bottom:.4rem;">
                <label class="lic-label">Duration (Days)</label>
            </div>
            <div class="day-presets">
                @foreach([7, 15, 30, 45, 90, 180, 365] as $d)
                    <button type="button" class="day-btn" data-days="{{ $d }}"
                            onclick="selectDays(this)">
                        {{ $d == 365 ? '1 Year' : $d . 'd' }}
                    </button>
                @endforeach
            </div>

            {{-- Display selected expiry --}}
            <div style="margin-bottom:1.25rem;font-size:.8125rem;color:#6b7280;" id="expiryPreview">
                👆 Select a duration above to continue
            </div>

            <button type="submit" class="btn-generate" id="genBtn" disabled>
                ⚡ Generate License Key
            </button>
        </form>

        {{-- Generated key result --}}
        @if(session('generated_key'))
            <div class="result-box">
                <h4>✅ License Generated Successfully!</h4>
                <p>
                    Client: <strong>{{ session('client_name') }}</strong> &nbsp;|&nbsp;
                    Duration: <strong>{{ session('days') }} days</strong> &nbsp;|&nbsp;
                    Expires: <strong>{{ \Carbon\Carbon::parse(session('expiry_date'))->format('d M Y') }}</strong>
                </p>
                <textarea id="generated_key_box" readonly rows="4" class="key-textarea">{{ session('generated_key') }}</textarea>
                <button type="button" onclick="copyToClipboard()" class="btn-copy">
                    📋 Copy Key to Clipboard
                </button>
            </div>
        @endif
    </div>

    {{-- ── RIGHT: Recently Generated Keys Table ── --}}
    <div class="lic-card" style="overflow-x:auto;">
        <h3>📋 Recently Generated Keys</h3>

        @if($licenses->isEmpty())
            <p style="color:#9ca3af;font-size:.875rem;">No keys generated yet. Create your first license above.</p>
        @else
            <table class="lic-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Duration</th>
                        <th>Expiry</th>
                        <th>License Key</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($licenses as $license)
                        @php
                            $isExpired = \Carbon\Carbon::parse($license->expiry_date)->isPast();
                            $statusBadge = $license->status === 'suspended'
                                ? ['class' => 'badge-suspended', 'icon' => '⏸️', 'label' => 'Suspended']
                                : ($isExpired
                                    ? ['class' => 'badge-expired', 'icon' => '⌛', 'label' => 'Expired']
                                    : ['class' => 'badge-active',  'icon' => '✅', 'label' => 'Active']);
                        @endphp
                        <tr>
                            <td style="color:#9ca3af;font-size:.75rem;">{{ $license->id }}</td>

                            <td style="font-weight:600;color:#111827;">{{ $license->client_name }}</td>

                            <td>
                                <span class="badge badge-days">{{ $license->days }}d</span>
                            </td>

                            <td style="white-space:nowrap;color:#374151;">
                                {{ \Carbon\Carbon::parse($license->expiry_date)->format('d M Y') }}
                            </td>

                            {{-- License Key cell with hover to reveal full key --}}
                            <td>
                                <div class="key-wrapper">
                                    <span class="key-cell key-cell-short"
                                          title="Hover to see full key">
                                        {{ substr($license->license_key, 0, 20) }}…
                                    </span>
                                    <div class="key-full">
                                        {{ $license->license_key }}
                                        <br><br>
                                        <span style="color:#9ca3af;font-size:.65rem;">Click copy button below</span>
                                    </div>
                                </div>
                                <button type="button"
                                        onclick="copyKey('{{ addslashes($license->license_key) }}')"
                                        style="margin-top:.3rem;font-size:.7rem;padding:.2rem .5rem;background:#f3f4f6;border:1px solid #e5e7eb;border-radius:5px;cursor:pointer;">
                                    📋 Copy
                                </button>
                            </td>

                            <td>
                                <span class="badge {{ $statusBadge['class'] }}">
                                    {{ $statusBadge['icon'] }} {{ $statusBadge['label'] }}
                                </span>
                            </td>

                            <td style="color:#9ca3af;font-size:.75rem;white-space:nowrap;">
                                {{ $license->created_at->diffForHumans() }}
                            </td>

                            <td>
                                @if($license->status === 'active' && !$isExpired)
                                    <form method="POST"
                                          action="{{ route('licenses.suspend', $license) }}"
                                          style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-action btn-suspend"
                                                onclick="return confirm('Suspend this license?')">
                                            ⏸ Suspend
                                        </button>
                                    </form>
                                @elseif($license->status === 'suspended')
                                    <form method="POST"
                                          action="{{ route('licenses.reactivate', $license) }}"
                                          style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-action btn-reactivate"
                                                onclick="return confirm('Reactivate this license?')">
                                            ▶ Reactivate
                                        </button>
                                    </form>
                                @else
                                    <span style="font-size:.75rem;color:#9ca3af;">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<script>
    // ── Day preset selection ──────────────────────────────────
    function selectDays(btn) {
        const days = parseInt(btn.dataset.days, 10);

        // Deselect all
        document.querySelectorAll('.day-btn').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');

        // Store in hidden input
        document.getElementById('selectedDays').value = days;

        // Calculate expiry preview
        const expiry = new Date();
        expiry.setDate(expiry.getDate() + days);
        const formatted = expiry.toLocaleDateString('en-GB', {
            day: '2-digit', month: 'short', year: 'numeric'
        });
        document.getElementById('expiryPreview').innerHTML =
            `📅 Expires on <strong>${formatted}</strong> (${days} days from today)`;

        // Enable generate button
        document.getElementById('genBtn').disabled = false;
    }

    // Prevent form submission without selecting days
    document.getElementById('licForm').addEventListener('submit', function(e) {
        if (!document.getElementById('selectedDays').value) {
            e.preventDefault();
            alert('Please select a duration for the license.');
        }
    });

    // ── Copy generated key to clipboard ──────────────────────
    function copyToClipboard() {
        var el = document.getElementById('generated_key_box');
        el.select();
        el.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(el.value).then(() => {
            showCopyToast('✅ License key copied!');
        }).catch(() => {
            document.execCommand('copy');
            showCopyToast('✅ Copied!');
        });
    }

    function copyKey(key) {
        navigator.clipboard.writeText(key).then(() => {
            showCopyToast('✅ Key copied to clipboard!');
        }).catch(() => {
            showCopyToast('❌ Copy failed — try manually selecting the key.');
        });
    }

    function showCopyToast(msg) {
        let toast = document.getElementById('copyToast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'copyToast';
            toast.style.cssText = `
                position:fixed;bottom:1.5rem;right:1.5rem;
                background:#1f2937;color:#fff;
                padding:.75rem 1.25rem;border-radius:10px;
                font-size:.875rem;font-weight:600;
                z-index:9999;opacity:0;
                transition:opacity .3s;
                box-shadow:0 4px 16px rgba(0,0,0,.3);
            `;
            document.body.appendChild(toast);
        }
        toast.textContent = msg;
        toast.style.opacity = '1';
        setTimeout(() => { toast.style.opacity = '0'; }, 2500);
    }
</script>
@endsection
