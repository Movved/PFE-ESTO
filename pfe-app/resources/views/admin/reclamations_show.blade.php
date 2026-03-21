<!DOCTYPE html>
<html lang="fr">
<head>
    <script>
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Réclamation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', ['title' => 'Réclamation', 'search' => false])

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <div>
                    <div class="page-title">Réclamation #{{ $reclamation->id_reclamation }}</div>
                    <div class="page-sub">{{ $reclamation->prenom }} {{ $reclamation->nom }} — {{ $reclamation->nom_module }}</div>
                </div>
                <a href="{{ route('admin.reclamations') }}" class="btn btn-secondary">← Retour</a>
            </div>

            <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;align-items:start;">

                {{-- LEFT: detail --}}
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Student info --}}
                    <div class="card">
                        <div class="card-header"><div class="card-title">Étudiant</div></div>
                        <div class="info-row"><span class="info-label">Nom complet</span><span class="info-value">{{ $reclamation->prenom }} {{ $reclamation->nom }}</span></div>
                        <div class="info-row"><span class="info-label">CNE</span><span class="info-value" style="font-family:monospace;">{{ $reclamation->cne }}</span></div>
                    </div>

                    {{-- Note info --}}
                    <div class="card">
                        <div class="card-header"><div class="card-title">Note concernée</div></div>
                        <div class="info-row"><span class="info-label">Module</span><span class="info-value">{{ $reclamation->nom_module }} ({{ $reclamation->code_module }})</span></div>
                        <div class="info-row">
                            <span class="info-label">Note</span>
                            <span class="info-value" style="color:{{ $reclamation->note >= 10 ? 'var(--green)' : 'var(--red)' }};">
                                {{ $reclamation->note !== null ? number_format($reclamation->note, 2).'/20' : '—' }}
                            </span>
                        </div>
                        @if($reclamation->rattrapage !== null)
                        <div class="info-row">
                            <span class="info-label">Rattrapage</span>
                            <span class="info-value" style="color:{{ $reclamation->rattrapage >= 10 ? 'var(--green)' : 'var(--red)' }};">
                                {{ number_format($reclamation->rattrapage, 2) }}/20
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Message --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Message</div>
                            <span class="cell-secondary" style="font-size:12px;">
                                {{ $reclamation->date_reclamation ? \Carbon\Carbon::parse($reclamation->date_reclamation)->format('d/m/Y à H:i') : '—' }}
                            </span>
                        </div>
                        <div class="message-box">{{ $reclamation->message }}</div>
                    </div>

                </div>

                {{-- RIGHT: statut + actions --}}
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Current statut --}}
                    <div class="card">
                        <div class="card-header"><div class="card-title">Statut actuel</div></div>
                        <div style="padding:16px 20px;">
                            @php
                                $statutClass = match($reclamation->statut) {
                                    'traitee'   => 'badge-open',
                                    'rejetee'   => 'badge-closed',
                                    default     => 'badge-pending',
                                };
                                $statutLabel = match($reclamation->statut) {
                                    'traitee'   => 'Traitée',
                                    'rejetee'   => 'Rejetée',
                                    default     => 'En attente',
                                };
                            @endphp
                            <span class="badge {{ $statutClass }}" style="font-size:13px;padding:6px 14px;">
                                <span class="badge-dot"></span>{{ $statutLabel }}
                            </span>
                        </div>
                    </div>

                    {{-- Change statut --}}
                    <div class="card">
                        <div class="card-header"><div class="card-title">Changer le statut</div></div>
                        <form method="POST" action="{{ route('admin.reclamations.statut', $reclamation->id_reclamation) }}" style="padding:16px 20px;display:flex;flex-direction:column;gap:12px;">
                            @csrf @method('PUT')
                            <div class="form-group" style="padding:0;">
                                <label>Nouveau statut</label>
                                <select name="statut" required>
                                    <option value="en_attente" {{ $reclamation->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="traitee"    {{ $reclamation->statut === 'traitee'   ? 'selected' : '' }}>Traitée</option>
                                    <option value="rejetee"    {{ $reclamation->statut === 'rejetee'   ? 'selected' : '' }}>Rejetée</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>

                    {{-- Quick link to edit note --}}
                    <div class="card">
                        <div class="card-header"><div class="card-title">Actions</div></div>
                        <div style="padding:16px 20px;display:flex;flex-direction:column;gap:10px;">
                            <a href="{{ route('admin.notes.edit', $reclamation->id_note) }}" class="btn btn-secondary" style="justify-content:center;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:14px;height:14px;"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Modifier la note
                            </a>
                            <form method="POST" action="{{ route('admin.reclamations.destroy', $reclamation->id_reclamation) }}" onsubmit="return confirm('Supprimer cette réclamation ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;">Supprimer</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</body>
</html>
