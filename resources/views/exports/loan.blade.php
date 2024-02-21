<table>
    <tbody>
        <tr>
            <th>Tanggal Pengajuan</th>
            <th>Nama Kendaraan</th>
            <th>Jenis Kendaraan</th>
            <th>Asal Kendaraan</th>
            <th>Kepemilikan</th>
            <th>Nomer Polisi</th>
            <th>Jenis BBM</th>
            <th>Status</th>
            <th>Peminjam</th>
            <th>Admin yang menyetujui</th>
            <th>Petugas yang menyetujui</th>
            <th>Tanggal Pengembalian</th>
            <th>Petugas yang mengembalikan</th>
            <th>Cost penggunaan bahan bakar</th>
        </tr>
        @foreach ($loans as $loan)
            <tr>
                <td>{{ $loan->created_at }}</td>
                <td>{{ $loan->vehicle->name }}</td>
                <td>{{ $loan->vehicle->vehicleType->name }}</td>
                <td>{{ $loan->vehicle->vehicleOrigin->name }}</td>
                <td>{{ $loan->vehicle->ownership }}</td>
                <td>{{ $loan->vehicle->police_number }}</td>
                <td>{{ $loan->vehicle->fuel_type }}</td>
                <td>{{ $loan->message }}</td>
                <td>{{ $loan->pegawai?->name }}</td>
                <td>{{ $loan->admin?->name }}</td>
                <td>{{ $loan->petugas?->name }}</td>
                <td>{{ $loan->return_date }}</td>
                <td>{{ $loan->returnPetugas?->name }}</td>
                <td>{{ $loan->fuel_cost }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
