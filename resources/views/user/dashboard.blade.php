@extends('template/home')
@section('content')

@if (session()->has('message'))
    <div class="alert alert-success">{{session()->get('message')}}</div>
@endif
{{-- if with success --}}
@if (session()->has('success'))
    <div class="alert alert-success">{{session()->get('success')}}</div>
@endif

{{-- membership status --}}
@if (Auth::user()->is_member == 0)
    <div class="alert alert-danger">Anda belum menjadi member, silahkan upgrade ke member untuk dapat menggunakan fitur kalender</div>
    {{-- button upgrade --}}
    <a type="button" class="btn btn-primary text-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-primary">Pilih metode pembayaran</a>
@endif
@if(Auth::user()->is_member == 1)
    <div class="alert alert-success">Anda sudah menjadi member</div>
@endif
@if (Auth::user()->is_member == 9)
    <div class="alert alert-primary">Proses upgrade anda sedang diproses, silahkan upload bukti pembayaran</div>
    {{-- button upgrade --}}
    <a type="button" class="btn btn-primary text-light" data-bs-toggle="modal" data-bs-target="#staticBukti" class="btn btn-primary">Upload bukti pembayaran</a>
@endif
@if (Auth::user()->is_member == 8)
    <div class="alert alert-primary">Silahkan tunggu email konfirmasi</div>
    {{-- button lihat bukti pembayaran --}}
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Cek Bukti Pembayaran
    </button>
@endif
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('user.upgrade', Auth::user()->id) }}" method="POST">
        @csrf
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Berlangganan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {{-- payment method --}}
            <div class="mb-3">
                <label for="payment_method" class="form-label">Metode Pembayaran</label>
                <select class="form-select" aria-label="Default select example" id="payment_method" name="payment_method">
                    <option selected>Pilih metode pembayaran</option>
                    <option value="1">Transfer Bank</option>
                    <option value="2">Go Pay</option>
                    <option value="3">Dana</option>
                </select>
                {{-- bank and number --}}
                <div class="mt-3 d-none text-center" id="payment-details">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Proses</button>
        </div>
        </div>
    </form>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBukti" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBuktiLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('user.payment', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBuktiLabel">Upload Bukti Pembayaran</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {{-- payment method --}}
            <div class="mb-3">
                <label for="file_upload" class="form-label">Pilih File</label>
                <input class="form-control" type="file" id="file_upload" name="file_upload">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Unggah</button>
        </div>
        </div>
    </form>
  </div>
</div>
<!-- Modal -->
@if($member!=null && $member->upload_bukti != null)
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Bukti Pembayaran</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="{{ asset('images/bukti/'.$member->upload_bukti) }}" alt="bukti-pembayaran" width="300px">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
      </div>
    </div>
  </div>
</div>
@endif
<script>
    function delValue(id){
        document.getElementById(id).value = "";
    }
    // if select option is 1 show bank BCA and number 0123621321
    var select = document.getElementById('payment_method');
    select.addEventListener('change', function(){
        var paymentDetails = document.getElementById('payment-details');
        var selectedOption = this.options[select.selectedIndex];
        var value = selectedOption.value;
        var bank = document.createElement('div');
        var number = document.createElement('div');
        var nominal = document.createElement('div');
        var tujuan = document.createElement('div');
        if (value == 1) {
            bank.innerHTML = "Bank : BCA";
            number.innerHTML = "Virtual Account : 0123621321";
            nominal.innerHTML = "Rp89.000";
            tujuan.innerHTML = "a/n CornTan";
        } else if (value == 2) {
            // add image qr to bank
            bank.innerHTML = "Go Pay 0891247127482";
            number.innerHTML = "<img src='{{ asset('images/qrcode.jpg') }}' alt='qr-code' width='300px'>";
            nominal.innerHTML = "Rp89.000";
            tujuan.innerHTML = "a/n CornTan";
        } else if (value == 3) {
            bank.innerHTML = "Dana";
            number.innerHTML = "Nomor : 08123456789";
            nominal.innerHTML = "Rp89.000";
            tujuan.innerHTML = "a/n CornTan";
        } else {
            bank.innerHTML = "";
            number.innerHTML = "";
        }
        paymentDetails.innerHTML = "";
        // add br
        bank.insertAdjacentHTML("beforeend", "<br>");
        paymentDetails.appendChild(bank);
        paymentDetails.appendChild(number);
        paymentDetails.appendChild(nominal);
        paymentDetails.appendChild(tujuan);
        paymentDetails.classList.remove('d-none');
    });
</script>
@endsection