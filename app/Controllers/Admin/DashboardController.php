<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Institution;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\Message;

class DashboardController extends Controller
{
    /** GET /admin/dashboard */
    public function index(Request $request): void
    {
        $msgCounts = Message::counts();

        $this->view('admin/dashboard', [
            'insCount'      => Institution::count(),
            'vehicleCount'  => Vehicle::count(),
            'srvsCount'     => Service::count(),
            'unreadMsgs'    => $msgCounts['unread'],
            'totalMsgs'     => $msgCounts['total'],
            'recentMsgs'    => array_slice(Message::all(null, true), 0, 5),
            'activePage'    => 'dashboard',
            'pageTitle'     => 'Zenith Yonetim Paneli',
        ], 'layouts/admin');
    }
}
