<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LegalController extends Controller
{
    /**
     * Centro General de Políticas y Legal
     */
    public function index()
    {
        return view('legal.index');
    }

    /**
     * Términos y Condiciones de Uso y Contratación
     */
    public function terms()
    {
        return view('legal.terms');
    }

    /**
     * Política de Privacidad y Tratamiento de Datos Personales
     */
    public function privacy()
    {
        return view('legal.privacy');
    }

    /**
     * Política de Envíos, Garantías y Devoluciones
     */
    public function returns()
    {
        return view('legal.returns');
    }

    /**
     * Política de Cookies y Privacidad Web
     */
    public function cookies()
    {
        return view('legal.cookies');
    }

    /**
     * Libro de Reclamaciones Virtual (Formulario)
     */
    public function claims()
    {
        return view('legal.claims');
    }

    /**
     * Registro de Hoja de Reclamación Virtual
     */
    public function storeClaim(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:reclamo,queja',
            'customer_name' => 'required|string|max:255',
            'document_type' => 'required|in:DNI,CE,Pasaporte,RUC',
            'document_number' => 'required|string|max:30',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:30',
            'customer_address' => 'required|string|max:255',
            'is_minor' => 'nullable|boolean',
            'parent_name' => 'nullable|required_if:is_minor,1|string|max:255',
            'contracted_good' => 'required|in:producto,servicio',
            'amount_claimed' => 'nullable|numeric|min:0',
            'order_number' => 'nullable|string|max:50',
            'good_description' => 'nullable|string|max:500',
            'details' => 'required|string|min:15|max:3000',
            'consumer_request' => 'required|string|min:10|max:2000',
            'accept_policy' => 'required|accepted',
        ], [
            'type.required' => 'Debes seleccionar si es un Reclamo o una Queja.',
            'customer_name.required' => 'Ingresa tu nombre completo.',
            'document_number.required' => 'Ingresa tu número de documento de identidad.',
            'customer_email.required' => 'Ingresa un correo electrónico para notificarte formalmente.',
            'customer_phone.required' => 'Ingresa un teléfono o celular de contacto.',
            'customer_address.required' => 'Ingresa tu dirección o domicilio.',
            'parent_name.required_if' => 'Si eres menor de edad, debes indicar el nombre de tu padre, madre o apoderado.',
            'details.required' => 'Describe detalladamente los hechos de tu reclamo o queja.',
            'consumer_request.required' => 'Especifica qué solución o pedido concreto solicitas.',
            'accept_policy.accepted' => 'Debes aceptar la declaración jurada y el tratamiento de datos para registrar el reclamo.',
        ]);

        // Generar correlativo legal: LR-YYYY-XXXX
        $year = date('Y');
        $countThisYear = Claim::whereYear('created_at', $year)->count() + 1;
        $claimNumber = sprintf('LR-%s-%04d', $year, $countThisYear);

        $claim = Claim::create([
            'claim_number' => $claimNumber,
            'type' => $validated['type'],
            'customer_name' => $validated['customer_name'],
            'document_type' => $validated['document_type'],
            'document_number' => $validated['document_number'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'is_minor' => $request->boolean('is_minor'),
            'parent_name' => $request->input('parent_name'),
            'contracted_good' => $validated['contracted_good'],
            'amount_claimed' => $validated['amount_claimed'] ?? null,
            'order_number' => $validated['order_number'] ?? null,
            'good_description' => $validated['good_description'] ?? null,
            'details' => $validated['details'],
            'consumer_request' => $validated['consumer_request'],
            'status' => 'pending',
        ]);

        return redirect()->route('legal.claims.success', $claim->claim_number)
            ->with('success', 'Tu reclamación ha sido registrada formalmente. Hemos generado tu Hoja de Reclamación oficial.');
    }

    /**
     * Constancia de Hoja de Reclamación registrada
     */
    public function claimSuccess($claimNumber)
    {
        $claim = Claim::where('claim_number', $claimNumber)->firstOrFail();
        return view('legal.claim_success', compact('claim'));
    }

    /**
     * Módulo Admin: Listado de Reclamaciones
     */
    public function adminIndex(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search');

        $query = Claim::latest();

        if ($status !== 'all' && in_array($status, ['pending', 'in_process', 'resolved', 'rejected'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('claim_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('order_number', 'like', "%{$search}%");
            });
        }

        $claims = $query->paginate(15)->withQueryString();

        $counts = [
            'all' => Claim::count(),
            'pending' => Claim::where('status', 'pending')->count(),
            'in_process' => Claim::where('status', 'in_process')->count(),
            'resolved' => Claim::where('status', 'resolved')->count(),
            'rejected' => Claim::where('status', 'rejected')->count(),
        ];

        return view('admin.claims.index', compact('claims', 'counts', 'status', 'search'));
    }

    /**
     * Módulo Admin: Ver Detalle de Reclamación
     */
    public function adminShow(Claim $claim)
    {
        return view('admin.claims.show', compact('claim'));
    }

    /**
     * Módulo Admin: Responder o cambiar estado
     */
    public function adminUpdate(Request $request, Claim $claim)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_process,resolved,rejected',
            'admin_response' => 'nullable|string|max:5000',
        ]);

        $claim->status = $validated['status'];
        $claim->admin_response = $validated['admin_response'];

        if (in_array($validated['status'], ['resolved', 'rejected']) && empty($claim->responded_at)) {
            $claim->responded_at = now();
        }

        $claim->save();

        return back()->with('success', 'El estado y respuesta de la reclamación se actualizaron correctamente.');
    }
}
