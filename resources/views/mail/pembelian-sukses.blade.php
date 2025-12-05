<x-mail::message>
# Pembelian Paket Ujian Berhasil!

Halo **{{ $user->name }}**,

Selamat! Pembelian paket ujian Anda telah berhasil diproses.

## Detail Pembelian
- **Paket Ujian**: {{ $paket->nama }}
- **Harga**: Rp {{ number_format($pembelian->harga, 0, ',', '.') }}
- **Status**: {{ $pembelian->status }}
- **Tanggal Pembelian**: {{ $pembelian->created_at->format('d M Y H:i') }}

@if($paket->whatsapp_group_link)
Anda dapat bergabung ke grup WhatsApp untuk informasi lebih lanjut:
<x-mail::button :url="$paket->whatsapp_group_link" color="success">
    Gabung Grup WhatsApp
</x-mail::button>
@endif

Terima kasih telah menggunakan layanan kami!

Salam,<br>
{{ config('app.name') }}
</x-mail::message>