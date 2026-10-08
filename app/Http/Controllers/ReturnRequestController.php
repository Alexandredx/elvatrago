<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;

class ReturnRequestController extends Controller
{
    /**
     * Muestra la lista de solicitudes de devolución para el administrador.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search');

        $query = ReturnRequest::with('order')->latest();

        if ($status !== 'all' && in_array($status, ['pending', 'approved', 'rejected', 'completed'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('return_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhereHas('order', function ($oq) use ($search) {
                      $oq->where('order_number', 'like', "%{$search}%");
                  });
            });
        }

        $returns = $query->paginate(15)->withQueryString();

        // Contadores para métricas rápidas
        $counts = [
            'all' => ReturnRequest::count(),
            'pending' => ReturnRequest::where('status', 'pending')->count(),
            'approved' => ReturnRequest::where('status', 'approved')->count(),
            'rejected' => ReturnRequest::where('status', 'rejected')->count(),
            'completed' => ReturnRequest::where('status', 'completed')->count(),
        ];

        return view('admin.returns.index', compact('returns', 'counts', 'status', 'search'));
    }

    /**
     * Muestra el detalle de una solicitud de devolución específica.
     */
    public function show(ReturnRequest $return)
    {
        $return->load(['order.items']);
        return view('admin.returns.show', compact('return'));
    }

    /**
     * Actualiza el estado, monto de reembolso y notas de la solicitud.
     */
    public function updateStatus(Request $request, ReturnRequest $return)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'refund_amount' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $return->update($validated);

        return back()->with('success', "Estado de la solicitud {$return->return_number} actualizado correctamente.");
    }

    /**
     * Permite eliminar una solicitud (opcional para el admin).
     */
    public function destroy(ReturnRequest $return)
    {
        $returnNumber = $return->return_number;
        $return->delete();

        return redirect()->route('admin.returns.index')->with('success', "Solicitud {$returnNumber} eliminada correctamente.");
    }

    /**
     * Vista pública para que el cliente ingrese su solicitud de devolución.
     */
    public function showPublicForm()
    {
        return view('returns.create_public');
    }

    /**
     * Formulario o proceso público para que un cliente registre una devolución.
     */
    public function storePublic(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string|exists:orders,order_number',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'reason' => 'required|string|max:255',
            'details' => 'required|string|max:1500',
        ]);

        $order = Order::where('order_number', $validated['order_number'])->first();

        // Generar número correlativo de devolución único DEV-AÑO-RANDOM
        $returnNumber = 'DEV-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6));

        $returnRequest = ReturnRequest::create([
            'return_number' => $returnNumber,
            'order_id' => $order?->id,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'reason' => $validated['reason'],
            'details' => $validated['details'],
            'status' => 'pending',
            'refund_amount' => $order?->total_amount ?? null,
        ]);

        return back()->with('success', "¡Tu solicitud de devolución ({$returnNumber}) ha sido enviada con éxito! Nuestro equipo la revisará pronto.");
    }
}
