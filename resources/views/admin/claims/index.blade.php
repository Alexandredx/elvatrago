@extends('layouts.admin')

@section('title', 'Libro de Reclamaciones - Panel Admin')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">Libro de Reclamaciones Virtual</h1>
        <p style="color: #94a3b8; font-size: 0.9rem;">Gestión y respuesta legal a los Reclamos y Quejas registrados por los clientes.</p>
    </div>
</div>

<!-- KPI Cards -->
<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-label">Total Registrados</div>
        <div class="stat-value" style="color: #ffffff;">{{ $counts['all'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pendientes</div>
        <div class="stat-value" style="color: #f59e0b;">{{ $counts['pending'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">En Proceso</div>
        <div class="stat-value" style="color: #3b82f6;">{{ $counts['in_process'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Resueltos</div>
        <div class="stat-value" style="color: #10b981;">{{ $counts['resolved'] }}</div>
    </div>
</div>

<!-- Filtros y Búsqueda -->
<div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1rem; padding: 1.25rem; margin-bottom: 1.75rem; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <a href="{{ route('admin.claims.index', ['status' => 'all', 'search' => $search]) }}" style="padding: 0.4rem 0.85rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; text-decoration: none; background: {{ $status === 'all' ? '#f97316' : 'rgba(255,255,255,0.06)' }}; color: #ffffff;">
            Todos ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.claims.index', ['status' => 'pending', 'search' => $search]) }}" style="padding: 0.4rem 0.85rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; text-decoration: none; background: {{ $status === 'pending' ? '#f59e0b' : 'rgba(255,255,255,0.06)' }}; color: #ffffff;">
            Pendientes ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.claims.index', ['status' => 'in_process', 'search' => $search]) }}" style="padding: 0.4rem 0.85rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; text-decoration: none; background: {{ $status === 'in_process' ? '#3b82f6' : 'rgba(255,255,255,0.06)' }}; color: #ffffff;">
            En Proceso ({{ $counts['in_process'] }})
        </a>
        <a href="{{ route('admin.claims.index', ['status' => 'resolved', 'search' => $search]) }}" style="padding: 0.4rem 0.85rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; text-decoration: none; background: {{ $status === 'resolved' ? '#10b981' : 'rgba(255,255,255,0.06)' }}; color: #ffffff;">
            Resueltos ({{ $counts['resolved'] }})
        </a>
    </div>

    <form action="{{ route('admin.claims.index') }}" method="GET" style="display: flex; gap: 0.5rem; align-items: center;">
        <input type="hidden" name="status" value="{{ $status }}">
        <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por código, cliente o DNI..." style="padding: 0.5rem 0.85rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 0.5rem; color: #ffffff; font-size: 0.85rem; width: 260px;">
        <button type="submit" style="background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.4); color: #fdba74; padding: 0.5rem 0.85rem; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 700; cursor: pointer;">
            Buscar
        </button>
    </form>
</div>

<!-- Tabla de Reclamaciones -->
@if($claims->count() > 0)
    <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1rem; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255,255,255,0.08); color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">
                    <th style="padding: 1rem 1.25rem;">N° Hoja</th>
                    <th style="padding: 1rem 1.25rem;">Tipo</th>
                    <th style="padding: 1rem 1.25rem;">Consumidor</th>
                    <th style="padding: 1rem 1.25rem;">Bien / Orden</th>
                    <th style="padding: 1rem 1.25rem;">Estado</th>
                    <th style="padding: 1rem 1.25rem;">Fecha</th>
                    <th style="padding: 1rem 1.25rem; text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($claims as $claim)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); color: #cbd5e1;">
                        <td style="padding: 1rem 1.25rem; font-weight: 700; color: #f97316;">
                            {{ $claim->claim_number }}
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            <span style="background: {{ $claim->type === 'reclamo' ? 'rgba(249, 115, 22, 0.2)' : 'rgba(59, 130, 246, 0.2)' }}; color: {{ $claim->type === 'reclamo' ? '#fdba74' : '#93c5fd' }}; padding: 0.2rem 0.55rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                                {{ $claim->type }}
                            </span>
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            <div style="font-weight: 600; color: #ffffff;">{{ $claim->customer_name }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $claim->document_type }}: {{ $claim->document_number }} | {{ $claim->customer_phone }}</div>
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            <div style="text-transform: capitalize;">{{ $claim->contracted_good }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $claim->order_number ?? 'S/N' }}</div>
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            <span style="color: {{ $claim->status_color }}; font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $claim->status_color }};"></span>
                                {{ $claim->status_label }}
                            </span>
                        </td>
                        <td style="padding: 1rem 1.25rem; font-size: 0.8rem; color: #94a3b8;">
                            {{ $claim->created_at->format('d/m/Y') }}
                        </td>
                        <td style="padding: 1rem 1.25rem; text-align: right;">
                            <a href="{{ route('admin.claims.show', $claim->id) }}" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); color: #ffffff; padding: 0.4rem 0.85rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <span>Ver / Responder</span> &rarr;
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $claims->links() }}
    </div>
@else
    <div style="text-align: center; padding: 4rem 2rem; background: rgba(30, 41, 59, 0.3); border-radius: 1rem; border: 1px dashed rgba(255,255,255,0.1);">
        <i data-feather="check-circle" style="width: 48px; height: 48px; color: #10b981; margin-bottom: 1rem;"></i>
        <h3 style="font-size: 1.25rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">No hay reclamaciones registradas</h3>
        <p style="color: #94a3b8; font-size: 0.9rem;">Cuando los clientes registren un reclamo o queja en el Libro de Reclamaciones aparecerán en esta bandeja.</p>
    </div>
@endif
@endsection
