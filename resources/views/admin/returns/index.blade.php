@extends('layouts.admin')

@section('title', 'Solicitudes de Devolución - Admin')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff; display: flex; align-items: center; gap: 0.75rem;">
            <i data-feather="rotate-ccw" style="color: #fb923c;"></i>
            Solicitudes de Devolución
        </h1>
        <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 0.25rem;">
            Gestiona, aprueba o rechaza los pedidos de devolución y reembolsos de los clientes.
        </p>
    </div>
</div>

<!-- Filtros de Estado & Búsqueda -->
<div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
    <!-- Pills de filtro -->
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <a href="{{ route('admin.returns.index', ['status' => 'all', 'search' => $search]) }}" 
           style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.825rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
                  background: {{ $status === 'all' ? 'rgba(249, 115, 22, 0.25)' : 'rgba(30, 41, 59, 0.6)' }};
                  border: 1px solid {{ $status === 'all' ? 'rgba(249, 115, 22, 0.5)' : 'rgba(255, 255, 255, 0.08)' }};
                  color: {{ $status === 'all' ? '#ffffff' : '#94a3b8' }};">
            Todos ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.returns.index', ['status' => 'pending', 'search' => $search]) }}" 
           style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.825rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
                  background: {{ $status === 'pending' ? 'rgba(245, 158, 11, 0.25)' : 'rgba(30, 41, 59, 0.6)' }};
                  border: 1px solid {{ $status === 'pending' ? 'rgba(245, 158, 11, 0.5)' : 'rgba(255, 255, 255, 0.08)' }};
                  color: {{ $status === 'pending' ? '#fbbf24' : '#94a3b8' }};">
            Pendientes ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.returns.index', ['status' => 'approved', 'search' => $search]) }}" 
           style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.825rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
                  background: {{ $status === 'approved' ? 'rgba(59, 130, 246, 0.25)' : 'rgba(30, 41, 59, 0.6)' }};
                  border: 1px solid {{ $status === 'approved' ? 'rgba(59, 130, 246, 0.5)' : 'rgba(255, 255, 255, 0.08)' }};
                  color: {{ $status === 'approved' ? '#60a5fa' : '#94a3b8' }};">
            Aprobadas ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('admin.returns.index', ['status' => 'completed', 'search' => $search]) }}" 
           style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.825rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
                  background: {{ $status === 'completed' ? 'rgba(16, 185, 129, 0.25)' : 'rgba(30, 41, 59, 0.6)' }};
                  border: 1px solid {{ $status === 'completed' ? 'rgba(16, 185, 129, 0.5)' : 'rgba(255, 255, 255, 0.08)' }};
                  color: {{ $status === 'completed' ? '#34d399' : '#94a3b8' }};">
            Completadas ({{ $counts['completed'] }})
        </a>
        <a href="{{ route('admin.returns.index', ['status' => 'rejected', 'search' => $search]) }}" 
           style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.825rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
                  background: {{ $status === 'rejected' ? 'rgba(239, 68, 68, 0.25)' : 'rgba(30, 41, 59, 0.6)' }};
                  border: 1px solid {{ $status === 'rejected' ? 'rgba(239, 68, 68, 0.5)' : 'rgba(255, 255, 255, 0.08)' }};
                  color: {{ $status === 'rejected' ? '#f87171' : '#94a3b8' }};">
            Rechazadas ({{ $counts['rejected'] }})
        </a>
    </div>

    <!-- Buscador -->
    <form action="{{ route('admin.returns.index') }}" method="GET" style="display: flex; gap: 0.5rem;">
        <input type="hidden" name="status" value="{{ $status }}">
        <div style="position: relative;">
            <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por cliente, devolución u orden..." 
                   style="background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.12); color: #ffffff; padding: 0.55rem 1rem 0.55rem 2.25rem; border-radius: 0.75rem; font-size: 0.85rem; width: 280px;">
            <i data-feather="search" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #64748b;"></i>
        </div>
        <button type="submit" style="background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.4); color: #fdba74; padding: 0.55rem 0.9rem; border-radius: 0.75rem; font-size: 0.85rem; font-weight: 600; cursor: pointer;">
            Filtrar
        </button>
        @if($search)
            <a href="{{ route('admin.returns.index', ['status' => $status]) }}" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #94a3b8; padding: 0.55rem 0.75rem; border-radius: 0.75rem; font-size: 0.85rem; display: flex; align-items: center;">
                Limpiar
            </a>
        @endif
    </form>
</div>

<!-- Tabla de Solicitudes -->
<div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; overflow: hidden;">
    @if($returns->count() > 0)
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.75rem; text-transform: uppercase; color: #94a3b8;">
                    <th style="padding: 1rem 1.25rem;">Nº Solicitud</th>
                    <th style="padding: 1rem 1.25rem;">Orden Asociada</th>
                    <th style="padding: 1rem 1.25rem;">Cliente</th>
                    <th style="padding: 1rem 1.25rem;">Motivo</th>
                    <th style="padding: 1rem 1.25rem;">Monto</th>
                    <th style="padding: 1rem 1.25rem;">Estado</th>
                    <th style="padding: 1rem 1.25rem;">Fecha</th>
                    <th style="padding: 1rem 1.25rem; text-align: center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($returns as $ret)
                    <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05); transition: background 0.2s;">
                        <td style="padding: 1rem 1.25rem; font-weight: 800; color: #fb923c;">
                            {{ $ret->return_number }}
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            @if($ret->order)
                                <a href="{{ route('admin.orders.show', $ret->order->id) }}" style="color: #38bdf8; font-weight: 700; text-decoration: none;">
                                    {{ $ret->order->order_number }}
                                </a>
                            @else
                                <span style="color: #64748b; font-size: 0.8rem;">Sin orden directa</span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            <div style="font-weight: 700; color: #ffffff;">{{ $ret->customer_name }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $ret->customer_email }}</div>
                        </td>
                        <td style="padding: 1rem 1.25rem; color: #cbd5e1; max-width: 220px;">
                            <div style="font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $ret->reason }}
                            </div>
                        </td>
                        <td style="padding: 1rem 1.25rem; font-weight: 800; color: #34d399;">
                            @if($ret->refund_amount)
                                ${{ number_format($ret->refund_amount, 2) }}
                            @else
                                <span style="color: #64748b; font-size: 0.8rem;">-</span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            @if($ret->status === 'pending')
                                <span style="background: rgba(245, 158, 11, 0.18); border: 1px solid rgba(245, 158, 11, 0.4); color: #fbbf24; padding: 0.25rem 0.6rem; border-radius: 9999px; font-size: 0.725rem; font-weight: 700; text-transform: uppercase;">
                                    Pendiente
                                </span>
                            @elseif($ret->status === 'approved')
                                <span style="background: rgba(59, 130, 246, 0.18); border: 1px solid rgba(59, 130, 246, 0.4); color: #60a5fa; padding: 0.25rem 0.6rem; border-radius: 9999px; font-size: 0.725rem; font-weight: 700; text-transform: uppercase;">
                                    Aprobada
                                </span>
                            @elseif($ret->status === 'completed')
                                <span style="background: rgba(16, 185, 129, 0.18); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399; padding: 0.25rem 0.6rem; border-radius: 9999px; font-size: 0.725rem; font-weight: 700; text-transform: uppercase;">
                                    Completada
                                </span>
                            @elseif($ret->status === 'rejected')
                                <span style="background: rgba(239, 68, 68, 0.18); border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171; padding: 0.25rem 0.6rem; border-radius: 9999px; font-size: 0.725rem; font-weight: 700; text-transform: uppercase;">
                                    Rechazada
                                </span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.25rem; color: #94a3b8; font-size: 0.825rem;">
                            {{ $ret->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td style="padding: 1rem 1.25rem; text-align: center;">
                            <a href="{{ route('admin.returns.show', $ret->id) }}" 
                               style="background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.4); color: #fdba74; padding: 0.4rem 0.85rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <i data-feather="edit-2" style="width: 13px; height: 13px;"></i> Gestionar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="padding: 1rem 1.25rem;">
            {{ $returns->links() }}
        </div>
    @else
        <div style="padding: 4rem 2rem; text-align: center; color: #94a3b8;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(249, 115, 22, 0.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; color: #fb923c;">
                <i data-feather="rotate-ccw" style="width: 32px; height: 32px;"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">No hay solicitudes de devolución</h3>
            <p style="font-size: 0.9rem; max-width: 420px; margin: 0 auto;">
                Cuando un cliente solicite una devolución o reembolso por un producto, aparecerá listada en este apartado para su revisión.
            </p>
        </div>
    @endif
</div>
@endsection
