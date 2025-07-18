<x-layout>
    <x-slot name="title">Kontak Kami - KakiKita</x-slot>
<div class="container py-5">
    <h2 class="text-center mb-5" style="color: #0d47a1;">Hubungi Kami</h2>
    <div class="row">
        <!-- Form Kontak dengan border -->
        <div class="col-md-6">
            <div class="p-4 border rounded shadow-sm h-100">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('kirim.pesan') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="pesan" class="form-label">Pesan</label>
                        <textarea name="pesan" class="form-control @error('pesan') is-invalid @enderror" rows="5">{{ old('pesan') }}</textarea>
                        @error('pesan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn text-white w-100" style="background-color: #0d47a1;">Kirim Pesan</button>
                </form>
            </div>
        </div>

        <!-- Informasi Toko -->
        <div class="col-md-6 mt-4 mt-md-0">
            <div class="p-4 border rounded shadow-sm h-100">
                <h5 class="fw-bold" style="color: #0d47a1;">Informasi Toko</h5>
                <p><strong>Alamat:</strong><br> Tegal, Jawa Tengah, Indonesia</p>
                <p><strong>Email:</strong><br> kakikita@gmail.com</p>
                <p><strong>Telepon:</strong><br> +62 888 6666 999</p>
                <p>Kami akan merespon pesan Anda secepat mungkin. Terima kasih telah menghubungi kami.</p>
            </div>
        </div>
    </div>
</div>
</x-layout>
