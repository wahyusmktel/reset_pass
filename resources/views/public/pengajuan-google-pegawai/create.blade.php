<form method="POST" action="{{ route('public.pegawai.store') }}">
    @csrf
    <div class="mb-3">
        <label for="nip" class="form-label">NIP</label>
        <select name="nip" id="nip" class="form-select" onchange="showPegawaiData(this.value)" required>
            <option value="">-- Pilih NIP --</option>
            @foreach (\App\Models\Pegawai::all() as $pegawai)
                <option value="{{ $pegawai->nip }}">{{ $pegawai->nip }}</option>
            @endforeach
        </select>
    </div>

    <div id="detailPegawai" style="display:none">
        <p><strong>Nama:</strong> <span id="nama_guru"></span></p>
        <p><strong>Email:</strong> <span id="email_guru"></span></p>
        <p><strong>Jabatan:</strong> <span id="jabatan"></span></p>
        <button type="submit" class="btn btn-primary">Ajukan Reset</button>
    </div>
</form>

<script>
    const pegawaiData = @json(\App\Models\Pegawai::all()->keyBy('nip'));

    function showPegawaiData(nip) {
        if (nip && pegawaiData[nip]) {
            const data = pegawaiData[nip];
            document.getElementById('nama_guru').textContent = data.nama_guru;
            document.getElementById('email_guru').textContent = maskEmail(data.email_guru);
            document.getElementById('jabatan').textContent = data.jabatan;
            document.getElementById('detailPegawai').style.display = 'block';
        } else {
            document.getElementById('detailPegawai').style.display = 'none';
        }
    }

    function maskEmail(email) {
        const [name, domain] = email.split('@');
        const maskedName = name.length <= 2 ? name[0] + '*' : name[0] + '*'.repeat(name.length - 2) + name[name.length -
            1];
        return maskedName + '@' + domain;
    }
</script>
