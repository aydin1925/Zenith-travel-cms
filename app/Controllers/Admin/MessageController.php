<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Message;

class MessageController extends Controller
{
    /** GET /admin/messages */
    public function index(Request $request): void
    {
        $filter = $request->query['filter'] ?? 'all';
        $source = null; $onlyUnread = null;

        if ($filter === 'unread')  $onlyUnread = true;
        if ($filter === 'contact') $source = 'contact';
        if ($filter === 'quote')   $source = 'quote';

        $this->view('admin/messages/index', [
            'messages'   => Message::all($source, $onlyUnread),
            'counts'     => Message::counts(),
            'filter'     => $filter,
            'activePage' => 'messages',
            'pageTitle'  => 'Zenith | Gelen Mesajlar',
        ], 'layouts/admin');
    }

    /** GET /admin/messages/{id} */
    public function show(Request $request, string $id): void
    {
        $msg = Message::find((int) $id);
        if (!$msg) {
            flash('error', 'Mesaj bulunamadı.');
            $this->redirect('/admin/messages');
        }

        // Ilk goruntulendiginde okundu isaretle
        if ((int) $msg['is_read'] === 0) {
            Message::markRead((int) $id, true);
            $msg['is_read'] = 1;
        }

        // form_data JSON ise decode
        $formData = null;
        if (!empty($msg['form_data'])) {
            $decoded = json_decode($msg['form_data'], true);
            if (is_array($decoded)) $formData = $decoded;
        }

        $this->view('admin/messages/show', [
            'msg'        => $msg,
            'formData'   => $formData,
            'activePage' => 'messages',
            'pageTitle'  => 'Zenith | Mesaj Detayı',
        ], 'layouts/admin');
    }

    /** GET /admin/messages/{id}/toggle-read */
    public function toggleRead(Request $request, string $id): void
    {
        $msg = Message::find((int) $id);
        if ($msg) {
            Message::markRead((int) $id, !(int) $msg['is_read']);
            flash('success', ((int) $msg['is_read'] === 0) ? 'Okundu olarak işaretlendi.' : 'Okunmadı olarak işaretlendi.');
        }
        $this->redirect('/admin/messages');
    }

    /** GET /admin/messages/{id}/delete */
    public function destroy(Request $request, string $id): void
    {
        Message::delete((int) $id);
        flash('success', 'Mesaj silindi.');
        $this->redirect('/admin/messages');
    }
}
