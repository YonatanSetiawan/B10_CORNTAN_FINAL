@extends('template/home')
@section('content')
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Bukti Pembayaran</th>
            <th>Berlangganan Dari</th>
            <th>Berlangganan Hingga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($member as $key => $datamember)
            @if ($datamember->status == 'pending' && $datamember->upload_bukti != null)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $datamember->nama }}</td>
                    <td>{{ $datamember->email }}</td>
                    <td><a type="button" class="btn btn-primary text-light" onclick="showImage('{{ $datamember->upload_bukti }}')">Lihat Bukti</a></td>
                    <td>{{ date('d-m-Y', strtotime($datamember->created_at))}}</td>
                    <td>{{ $datamember->expired_at }}</td>
                    <td class="d-flex text-light">
                        <form action="{{ route('admin.reject', $datamember->id_user) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger mr-2">Batal</button>
                        </form>
                        <form action="{{ route('admin.approve', $datamember->id_user) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Konfirmasi</button>
                        </form>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
<br>
<br>
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <h5 class="font-weight-bold">Daftar Pengguna</h5>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Nomor Telepon</th>
            <th>Status Pembayaran</th>
            <th>Masa Mulai Berlangganan</th>
            <th>Masa Akhir Langganan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user as $key => $user)
            @if ($user->user_roles !==1)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->no_telp }}</td>
                    @if ($user->is_member!==1)
                        <td class="text-warning">Menunggu</td>
                        <td></td>
                    @else
                    <td class="text-success">Valid</td>
                    {{-- show from array $member above --}}
                    {{-- check if $member is array or object --}}
                    @foreach ($member as $key => $datamember)
                        @if ($datamember->id_user == $user->id)
                            <td>{{ date('d-m-Y', strtotime($datamember->created_at)) }}</td>
                            <td>{{ $datamember->expired_at }}</td>
                        @endif
                    @endforeach
                    @endif
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Bukti Pembayaran</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="" alt="bukti-pembayaran" width="300px">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kembali</button>
      </div>
    </div>
  </div>
</div>
<script>
    function showImage(image){
        document.querySelector('.modal-body img').src = "{{ asset('images/bukti/') }}"+"/"+image;
        $('#exampleModal').modal('show');
    }
</script>
@endsection