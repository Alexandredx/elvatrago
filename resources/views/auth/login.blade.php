<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Elvatrago</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body style="background: #070a12; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1.5rem;">

    <div style="width: 100%; max-width: 440px;">
        <!-- Brand Header -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="{{ route('login') }}" class="logo-brand" style="display: inline-flex; justify-content: center; font-size: 2rem; margin-bottom: 0.5rem;">
                <i data-feather="shopping-bag" style="width: 32px; height: 32px; color: #6366f1;"></i>
                <span>ELVATRAGO</span>
            </a>
            <p style="color: #94a3b8; font-size: 0.95rem;">Ingresa a tu cuenta para explorar el catálogo</p>
        </div>

        <!-- Glassmorphism Card -->
        <div style="background: rgba(30, 41, 59, 0.6); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 1.5rem; padding: 2rem; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);">
            
            <!-- Flash Alert -->
            @if(session('success'))
                <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399; padding: 0.75rem 1rem; border-radius: 0.75rem; font-size: 0.875rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="check-circle" style="width: 16px; height: 16px;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; padding: 0.75rem 1rem; border-radius: 0.75rem; font-size: 0.875rem; margin-bottom: 1.5rem;">
                    <ul style="margin: 0; padding-left: 1.25rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Correo Electrónico</label>
                    <div style="position: relative;">
                        <i data-feather="mail" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #64748b; width: 18px; height: 18px;"></i>
                        <input type="email" name="email" required value="{{ old('email') }}" placeholder="tu@correo.com" style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem; background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none; transition: all 0.2s ease;">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Contraseña</label>
                    <div style="position: relative;">
                        <i data-feather="lock" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #64748b; width: 18px; height: 18px;"></i>
                        <input type="password" name="password" required placeholder="••••••••" style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem; background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none; transition: all 0.2s ease;">
                    </div>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.75rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; color: #94a3b8; font-size: 0.85rem; cursor: pointer;">
                        <input type="checkbox" name="remember" style="accent-color: #6366f1; width: 16px; height: 16px;">
                        Recordarme
                    </label>
                </div>

                <button type="submit" style="width: 100%; padding: 0.85rem; background: var(--accent-gradient); border: none; border-radius: 0.75rem; color: #ffffff; font-weight: 800; font-size: 1rem; cursor: pointer; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4); transition: all 0.3s ease;">
                    Iniciar Sesión
                </button>
            </form>

            <!-- Footer Switch -->
            <div style="margin-top: 1.5rem; text-align: center;">
                <p style="font-size: 0.875rem; color: #94a3b8; margin-bottom: 0.75rem;">¿No tienes una cuenta aún?</p>
                <a href="{{ route('register') }}" style="display: block; width: 100%; padding: 0.75rem; background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.4); color: #a5b4fc; border-radius: 0.75rem; font-weight: 700; font-size: 0.95rem; text-decoration: none; transition: all 0.2s ease;">
                    ✨ Registrarse Gratis
                </a>
            </div>

            <!-- Demo Account Info Box -->
            <div style="margin-top: 1.5rem; background: rgba(15, 23, 42, 0.6); border: 1px dashed rgba(255, 255, 255, 0.15); padding: 0.85rem 1rem; border-radius: 0.75rem; font-size: 0.8rem; color: #94a3b8;">
                <div style="font-weight: 700; color: #cbd5e1; margin-bottom: 0.35rem; display: flex; align-items: center; gap: 0.35rem;">
                    <i data-feather="key" style="width: 13px; height: 13px;"></i> Cuentas Demo Rápidas:
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.75rem;">
                    <span>🛡️ Admin: admin@elvatrago.com</span>
                    <span>🛍️ Cliente: cliente@elvatrago.com</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
