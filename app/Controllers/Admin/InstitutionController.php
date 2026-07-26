<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\FileUploader;
use App\Models\Institution;

class InstitutionController extends Controller
{
    public function index(Request $request): void
    {
        $this->view('admin/institutions/index', [
            'institutions' => Institution::all(),
            'activePage'   => 'institutions',
            'pageTitle'    => 'Zenith | Kurum Yonetimi',
        ], 'layouts/admin');
    }

    public function store(Request $request): void
    {
        $data = $request->body;

        // Logo upload (varsa)
        try {
            if (!empty($_FILES['logo_file']['name'])) {
                $data['logo_url'] = FileUploader::uploadImage($_FILES['logo_file'], 'institutions');
            }
        } catch (\RuntimeException $e) {
            flash('error', 'Logo yuklenemedi: ' . $e->getMessage());
            $this->redirect('/admin/institutions');
        }

        Institution::create($data);
        flash('success', 'Kurum basariyla eklendi.');
        $this->redirect('/admin/institutions');
    }

    public function update(Request $request, string $id): void
    {
        $iid = (int) $id;
        $data = $request->body;

        // Mevcut kurumu al (eski logo path'ini bilmek icin)
        $existing = Institution::find($iid);

        // Logo upload (varsa yenisi)
        try {
            if (!empty($_FILES['logo_file']['name'])) {
                $data['logo_url'] = FileUploader::uploadImage($_FILES['logo_file'], 'institutions');
                // Eski logo dosyasini temizle
                if ($existing && !empty($existing['logo_url'])) {
                    FileUploader::delete($existing['logo_url']);
                }
            } else {
                // Yeni yuklenmedi — eski logo path'ini koru
                $data['logo_url'] = $existing['logo_url'] ?? null;
            }
        } catch (\RuntimeException $e) {
            flash('error', 'Logo yuklenemedi: ' . $e->getMessage());
            $this->redirect('/admin/institutions');
        }

        // Logo silme kutucugu isaretliyse
        if (!empty($request->body['remove_logo'])) {
            if ($existing && !empty($existing['logo_url'])) {
                FileUploader::delete($existing['logo_url']);
            }
            $data['logo_url'] = null;
        }

        Institution::update($iid, $data);
        flash('success', 'Kurum guncellendi.');
        $this->redirect('/admin/institutions');
    }

    public function destroy(Request $request, string $id): void
    {
        // Silmeden once logo dosyasini temizle
        $existing = Institution::find((int) $id);
        if ($existing && !empty($existing['logo_url'])) {
            FileUploader::delete($existing['logo_url']);
        }

        Institution::delete((int) $id);
        flash('success', 'Kurum silindi.');
        $this->redirect('/admin/institutions');
    }
}
