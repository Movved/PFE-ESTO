<!DOCTYPE html>
<html lang="fr">

<head>
    @include('partials.theme-init')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Modifier Enseignant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/sidebar.css', 'resources/js/sidebar.js'])
    <style>
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px
        }

        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-primary)
        }

        .page-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            max-width: 640px
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border)
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary)
        }

        .card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px
        }

        label {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary)
        }

        input[type=text],
        input[type=email],
        select {
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            background: var(--background);
            color: var(--text-primary);
            outline: none;
            width: 100%;
            box-sizing: border-box
        }

        input:focus,
        select:focus {
            border-color: var(--primary)
        }

        .form-error {
            font-size: 11px;
            color: var(--danger);
            margin-top: 2px
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-primary);
            cursor: pointer
        }

        .card-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: opacity 0.15s
        }

        .btn:hover {
            opacity: 0.85
        }

        .btn-primary {
            background: var(--primary);
            color: white
        }

        .btn-ghost {
            background: var(--background);
            color: var(--text-primary);
            border: 1px solid var(--border)
        }
    </style>
</head>

<body>
    {{-- SIDEBAR --}}
    @include('layouts.sidebar-admin')
    <div class="main">
        <header class="topbar"><span class="topbar-title">Modifier un enseignant</span></header>
        <main class="content">
            <div class="page-header">
                <div>
                    <div class="page-title">{{ $enseignant->prenom }} {{ $enseignant->nom }}</div>
                    <div class="page-sub">{{ $enseignant->nom_departement }}</div>
                </div>
                <a href="{{ route('admin.enseignants') }}" class="btn btn-ghost">← Retour</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Modifier les informations</div>
                </div>
                <form method="POST" action="{{ route('admin.enseignants.update', $enseignant->id_enseignant) }}">
                    @csrf @method('PUT')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group"><label>Prénom</label><input type="text" name="prenom"
                                    value="{{ old('prenom', $enseignant->prenom) }}">@error('prenom')<div
                                    class="form-error">{{ $message }}</div>@enderror</div>
                            <div class="form-group"><label>Nom</label><input type="text" name="nom"
                                    value="{{ old('nom', $enseignant->nom) }}">@error('nom')<div class="form-error">
                                    {{ $message }}</div>@enderror</div>
                        </div>
                        <div class="form-group"><label>Email</label><input type="email" name="email"
                                value="{{ old('email', $enseignant->email) }}">@error('email')<div class="form-error">
                                {{ $message }}</div>@enderror</div>
                        <div class="form-group"><label>Spécialité</label><input type="text" name="specialite"
                                value="{{ old('specialite', $enseignant->specialite) }}">@error('specialite')<div
                                class="form-error">{{ $message }}</div>@enderror</div>
                        <div class="form-group">
                            <label>Département</label>
                            <select name="id_departement">
                                @foreach($departements as $d)
                                    <option value="{{ $d->id_departement }}" {{ (old('id_departement', $enseignant->id_departement) == $d->id_departement) ? 'selected' : '' }}>
                                        {{ $d->nom_departement }}</option>
                                @endforeach
                            </select>
                            @error('id_departement')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <label class="checkbox-row"><input type="checkbox" name="is_chef" {{ $enseignant->is_chef ? 'checked' : '' }}> Chef de département</label>
                        <label class="checkbox-row"><input type="checkbox" name="actif" {{ $enseignant->actif ? 'checked' : '' }}> Compte actif</label>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <a href="{{ route('admin.enseignants') }}" class="btn btn-ghost">Annuler</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>