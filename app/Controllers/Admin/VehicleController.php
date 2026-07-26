<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\FileUploader;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index(Request $request): void
    {
        $this->view('admin/vehicles/index', [
            'vehicles'   => Vehicle::all(),
            'activePage' => 'vehicles',
            'pageTitle'  => 'Zenith | Arac Yonetimi',
        ], 'layouts/admin');
    }

    public function store(Request $request): void
    {
        $data = $request->body;
        try {
            if (!empty($_FILES['photo_file']['name'])) {
                $data['photo_url'] = FileUploader::uploadImage($_FILES['photo_file'], 'vehicles');
            }
        } catch (\RuntimeException $e) {
            flash('error', 'Fotograf yuklenemedi: ' . $e->getMessage());
            $this->redirect('/admin/vehicles');
        }

        Vehicle::create($data);
        flash('success', 'Arac eklendi.');
        $this->redirect('/admin/vehicles');
    }

    public function update(Request $request, string $id): void
    {
        $vid = (int) $id;
        $data = $request->body;
        $existing = Vehicle::find($vid);

        try {
            if (!empty($_FILES['photo_file']['name'])) {
                $data['photo_url'] = FileUploader::uploadImage($_FILES['photo_file'], 'vehicles');
                if ($existing && !empty($existing['photo_url'])) {
                    FileUploader::delete($existing['photo_url']);
                }
            } else {
                $data['photo_url'] = $existing['photo_url'] ?? null;
            }
        } catch (\RuntimeException $e) {
            flash('error', 'Fotograf yuklenemedi: ' . $e->getMessage());
            $this->redirect('/admin/vehicles');
        }

        if (!empty($request->body['remove_photo'])) {
            if ($existing && !empty($existing['photo_url'])) {
                FileUploader::delete($existing['photo_url']);
            }
            $data['photo_url'] = null;
        }

        Vehicle::update($vid, $data);
        flash('success', 'Arac guncellendi.');
        $this->redirect('/admin/vehicles');
    }

    public function destroy(Request $request, string $id): void
    {
        $existing = Vehicle::find((int) $id);
        if ($existing && !empty($existing['photo_url'])) {
            FileUploader::delete($existing['photo_url']);
        }
        Vehicle::delete((int) $id);
        flash('success', 'Arac silindi.');
        $this->redirect('/admin/vehicles');
    }
}
