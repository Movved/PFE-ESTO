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
    <title>Admin — Réclamations</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="main" id="main-content">
        @include('layouts.topbar', [
            'title'             => 'Réclamations',
            'search'            => false,
        ])

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Réclamations</div>
                        <div class="card-sub">
                            {{ $reclamations->count() }} réclamation(s) —
                            <span style="color:var(--gold);">{{ $reclamations->where('statut','en_attente')->count() }} en attente</span>
                        </div>
                    </div>
                </div>
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Étudiant</th>
                                <th>Module</th>
                                <th>Note</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th class="center">Statut</th>
                                <th class="center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reclamations as $r)
                            <tr>
                                <td>
                                    <div class="etu-cell">
                                        <div class="user-avatar-small">{{ strtoupper(substr($r->prenom,0,1)) }}{{ strtoupper(substr($r->nom,0,1)) }}</div>
                                        <div>
                                            <div class="etu-name">{{ $r->prenom }} {{ $r->nom }}</div>
                                            <div class="cell-secondary">{{ $r->cne }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="etu-name" style="font-size:13px;">{{ $r->nom_module }}</div>
                                    <div class="cell-secondary">{{ $r->code_module }}</div>
                                </td>
                                <td>
                                    <span style="font-weight:600;color:{{ ($r->note ?? 0) >= 10 ? 'var(--green)' : 'var(--red)' }};">
                                        {{ $r->note !== null ? number_format($r->note,2) : '—' }}
                                    </span>
                                    @if($r->rattrapage !== null)
                                        <div class="cell-secondary">Ratt: {{ number_format($r->rattrapage,2) }}</div>
                                    @endif
                                </td>
                                <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" class="cell-secondary">
                                    {{ Str::limit($r->message, 60) }}
                                </td>
                                <td class="cell-secondary" style="white-space:nowrap;">
                                    {{ $r->date_reclamation ? \Carbon\Carbon::parse($r->date_reclamation)->format('d/m/Y') : '—' }}
                                </td>
                                <td class="center">
    @php
        $sc = match($r->statut) {
            'traitee' => 'badge-open',
            'rejetee' => 'badge-closed',
            default   => 'badge-pending',
        };
        $sl = match($r->statut) {
            'traitee' => 'Traitée',
            'rejetee' => 'Rejetée',
            default   => 'En attente',
        };
    @endphp
    <span class="badge {{ $sc }}"><span class="badge-dot"></span>{{ $sl }}</span>
    </td>
                                <td class="center">
                                    <div class="action-group action-group--center">
                                        <a href="{{ route('admin.reclamations.show', $r->id_reclamation) }}" class="btn btn-secondary btn-sm">Détail</a>
                                        <form method="POST" action="{{ route('admin.reclamations.destroy', $r->id_reclamation) }}" onsubmit="return confirm('Supprimer cette réclamation ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7"><div class="empty-state">Aucune réclamation.</div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>