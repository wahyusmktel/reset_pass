<form action="{{ $action }}" method="POST" class="card p-4 shadow-sm bg-white">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="siswa_id" class="form-label">Siswa</label>
        <select name="siswa_id" id="siswa_id" class="form-select" required>
            <option value="">-- Pilih Siswa --</option>
            @foreach ($siswas as $siswa)
                <option value="{{ $siswa->id }}"
                    {{ old('siswa_id', $data->siswa_id ?? '') == $siswa->id ? 'selected' : '' }}>
                    {{ $siswa->nama }} ({{ $siswa->nis }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Keterangan</label>
        <input type="text" name="keterangan" class="form-control"
            value="{{ old('keterangan', $data->keterangan ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Status Pengajuan</label>
        <select name="status_pengajuan" class="form-select" required>
            <option value="1"
                {{ old('status_pengajuan', $data->status_pengajuan ?? '') == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0"
                {{ old('status_pengajuan', $data->status_pengajuan ?? '') == 0 ? 'selected' : '' }}>Tidak Aktif
            </option>
        </select>
    </div>

    <button class="btn btn-primary">{{ $button }}</button>
</form>
