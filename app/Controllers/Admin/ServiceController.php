<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Service;
use App\Models\Institution;
use App\Models\Vehicle;

class ServiceController extends Controller
{
    public function index(Request $request): void
    {
        $this->view('admin/services/index', [
            'services'         => Service::allWithRelations(),
            'institutionsList' => Institution::options(),
            'vehiclesList'     => Vehicle::options(),
            'activePage'       => 'services',
            'pageTitle'        => 'Zenith | Servis Yonetimi',
        ], 'layouts/admin');
    }

    public function store(Request $request): void
    {
        Service::create($request->body);
        flash('success', 'Servis eklendi.');
        $this->redirect('/admin/services');
    }

    public function update(Request $request, string $id): void
    {
        Service::update((int) $id, $request->body);
        flash('success', 'Servis guncellendi.');
        $this->redirect('/admin/services');
    }

    public function destroy(Request $request, string $id): void
    {
        Service::delete((int) $id);
        flash('success', 'Servis silindi.');
        $this->redirect('/admin/services');
    }
}
