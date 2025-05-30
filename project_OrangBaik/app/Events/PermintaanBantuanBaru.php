<?php

namespace App\Events;

use App\Models\RequestBantuan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;

class PermintaanBantuanBaru implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $request;

    public function __construct(RequestBantuan $request)
    {
        $this->request = $request;
    }

    public function broadcastOn()
    {
        return new Channel('admin-notifikasi');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->request->id,
            'nama_korban' => $this->request->user->name ?? 'Tidak diketahui',
            'jenis_kebutuhan' => $this->request->jenis_kebutuhan,
            'deskripsi' => $this->request->deskripsi,
            'status' => $this->request->status,
            'tanggal' => $this->request->created_at->format('d M Y H:i')
        ];
    }

    public function broadcastAs()
    {
        return 'permintaan.baru';
    }
}
