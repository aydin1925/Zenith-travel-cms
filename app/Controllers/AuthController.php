<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\User;

/**
 * Login / auth / logout akisi.
 * Guest middleware sadece login sayfasina takilir: giris yapmis kullaniciyi
 * dogrudan dashboard'a atar.
 */
class AuthController extends Controller
{
    /** GET /login */
    public function showLogin(Request $request): void
    {
        $this->view('auth/login', [
            'error' => $request->query['error'] ?? null,
        ]);
    }

    /** POST /login */
    public function login(Request $request): void
    {
        $username = trim((string) $request->input('username', ''));
        $password = (string) $request->input('password', '');

        if ($username === '' || $password === '') {
            $this->redirect('/login?error=bos_alan');
        }

        $user = User::findByUsername($username);
        if (!$user || !password_verify($password, $user['password'])) {
            $this->redirect('/login?error=kullanici_bulunamadi');
        }

        // Session fixation korumasi
        session_regenerate_id(true);

        $_SESSION['user_id']  = (int) $user['id'];
        $_SESSION['username'] = $user['username'] ?? '';
        $_SESSION['role']     = $user['role'] ?? null;

        $this->redirect('/admin/dashboard');
    }

    /** GET /logout */
    public function logout(Request $request): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        $this->redirect('/login');
    }
}
