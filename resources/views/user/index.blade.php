@extends('template/home')
@section('content')

@if (session()->has('message'))
    <div class="alert alert-success">{{session()->get('message')}}</div>
@endif
{{-- if with success --}}
@if (session()->has('success'))
    <div class="alert alert-success">{{session()->get('success')}}</div>
@endif


{{-- form with name, email, password, no_telp --}}
<form action="{{ route('user.update', Auth::user()->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        {{-- input group with delete button --}}
        <div class="input-group mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama" name="name" value="{{ Auth::user()->name }}">
            <button class="btn btn-danger" type="button" id="button-addon2" onclick="delValue('name')">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        {{-- input group with delete button --}}
        <div class="input-group mb-3">
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" name="email" value="{{ Auth::user()->email }}" required>
            <button class="btn btn-danger" type="button" id="button-addon2" onclick="delValue('email')">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password" value="{{ Auth::user()->password }}">
    </div>
    <div class="mb-3">
        <label for="no_telp" class="form-label">No Telepon</label>
        {{-- input group with delete button --}}
        <div class="input-group mb-3">
            <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" placeholder="No Telepon" name="no_telp" value="{{ Auth::user()->no_telp }}">
            <button class="btn btn-danger" type="button" id="button-addon2" onclick="delValue('no_telp')">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    <br>
    <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button" class="btn btn-primary">Simpan</button>
    
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Perubahan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakan Anda yakin ingin menyimpan perubahan?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
            </div>
        </div>
    </div>
</form>
<script>
    function delValue(id){
        document.getElementById(id).value = "";
    }
</script>
@endsection