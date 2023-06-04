@extends('template/home')
@section('content')

    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session()->get('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($reminder)
        <div class="alert alert-primary alert-dismissible fade show" role="alert" >
            <div class="d-flex flex-row">
                <div class="mx-1"><h1>H-{{ $reminder->selisih }} </h1></div>
                <div class="mt-3"><p>Menuju {{ $reminder->title }}</p></div>
            </div>
            <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>  -->
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="container">
                        <div id='calendar' class="mb-3"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="container">
                        <h5>Buat Rencana Penanaman</h5>
                        <hr>
                        @if ($schedule == null)
                            <form id="form_schedule" action="{{ route('schedule.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                            <div class="form-group">
                                <label for="luas_lahan">Masukkan Luas lahan</label>
                                <input type="number" name="luas_lahan" id="luas_lahan" class="form-control">
                                @error('luas_lahan')
                                    <span class="text-danger">*{{$message}}</span>   
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="bibit_jagung">Pilih Bibit Jagung</label>
                                <select name="bibit_jagung" id="bibit_jagung" class="form-control">
                                    <option value="">Pilih Bibit</option>
                                    <option value="1">Jagung hibrida</option>
                                    <option value="2">Jagung manis</option>
                                </select>
                                @error('bibit_jagung')
                                    <span class="text-danger">*{{$message}}</span>   
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pupuk">Pilih Pupuk 1 (Urea)</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <select name="pupuk" id="pupuk" class="form-control">
                                            <option value="">Pilih Pupuk</option>
                                            <option value="1">Pupuk Nitrea</option>
                                            <option value="2">Pupuk Mahkota</option>
                                            <option value="3">Pupuk Daun Buah</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pupukSatuModal"><i class="fas fa-info"></i></button>
                                    </div>
                                </div>
                                @error('pupuk')
                                    <span class="text-danger">*{{$message}}</span>   
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pupuk_sec">Pilih Pupuk (NPK)</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <select name="pupuk_sec" id="pupuk_sec" class="form-control">
                                            <option value="">Pilih Pupuk</option>
                                            <option value="1">Pupuk Yaramilla Palmae</option>
                                            <option value="2">Pupuk Phonska</option>
                                            <option value="3">Pupuk NPK</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pupukDuaModal"><i class="fas fa-info"></i></button>
                                        </div>
                                    </div>
                                @error('pupuk_sec')
                                    <span class="text-danger">*{{$message}}</span>   
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tgl_mulai">Pilih Tanggal Mulai</label>
                                <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control">
                                @error('tgl_mulai')
                                    <span class="text-danger">*{{$message}}</span>   
                                @enderror
                            </div>
                            <div class="form-group float-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        @else
                            <form>
                                <div class="form-group">
                                    <label for="luas_lahan">Masukkan Luas lahan</label>
                                    <input type="number" name="luas_lahan" id="luas_lahan" class="form-control" value="{{ $schedule->luas_lahan }}" disabled>
                                    @error('luas_lahan')
                                        <span class="text-danger">*{{$message}}</span>   
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="bibit_jagung">Pilih Bibit Jagung</label>
                                    <select name="bibit_jagung" id="bibit_jagung" class="form-control" disabled>
                                        <option value="">Pilih Bibit</option>
                                        <option value="1" {{ $schedule->id_jagung == 1 ? 'selected' : '' }}>Jagung hibrida</option>
                                        <option value="2" {{ $schedule->id_jagung == 2 ? 'selected' : '' }}>Jagung manis</option>
                                    </select>
                                    @error('bibit_jagung')
                                        <span class="text-danger">*{{$message}}</span>   
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="pupuk">Pilih Pupuk 1</label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <select name="pupuk" id="pupuk" class="form-control" disabled>
                                                <option value="">Pilih Pupuk</option>
                                                <option value="1" {{ $schedule->id_pupuk == 1 ? 'selected' : '' }}>Pupuk Nitrea</option>
                                                <option value="2" {{ $schedule->id_pupuk == 2 ? 'selected' : '' }}>Pupuk Mahkota</option>
                                                <option value="3" {{ $schedule->id_jagung == 3 ? 'selected' : '' }}>Pupuk Daun Buah</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#pupukSatuModal"><i class="fas fa-info"></i></button>
                                        </div>
                                    </div>
                                    @error('pupuk')
                                        <span class="text-danger">*{{$message}}</span>   
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="pupuk_sec">Pilih Pupuk 2</label>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <select name="pupuk_sec" id="pupuk_sec" class="form-control" disabled>
                                                <option value="">Pilih Pupuk</option>
                                                <option value="1" {{ $schedule->id_pupuk_sec == 1 ? 'selected' : '' }}>Pupuk Yaramilla Palmae</option>
                                                <option value="2" {{ $schedule->id_pupuk_sec== 2 ? 'selected' : '' }}>Pupuk Phonska</option>
                                                <option value="3" {{ $schedule->id_pupuk_sec == 3 ? 'selected' : '' }}>Pupuk NPK</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#pupukDuaModal"><i class="fas fa-info"></i></button>
                                        </div>
                                    </div>
                                            @error('pupuk_sec')
                                                <span class="text-danger">*{{$message}}</span>   
                                            @enderror
                                    </div>
                                <div class="form-group">
                                    <label for="tgl_mulai">Pilih Tanggal Mulai</label>
                                    <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" value="{{$schedule->tgl_mulai}}" disabled>
                                    @error('tgl_mulai')
                                        <span class="text-danger">*{{$message}}</span>   
                                    @enderror
                                </div>
                                <div class="form-group float-right">
                                    <button type="submit" id="submit" class="btn btn-primary" disabled>Submit</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-3">
        <div class="card-header">
            <i class="fa-sharp fa-solid fa-notes"></i> Notes
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @if ($event != null)
                    @foreach ($event as $e)
                        <li class="list-group-item {{ $e->start_event == date('Y-m-d') ? 'bg-primary text-light' : '' }}">{{ $e->start_event }} : {{ $e->title }}</li>                        
                    @endforeach   
                @else
                    Belum Ada Jadwal
                @endif
            </ul>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="pupukSatuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pupuk Urea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            Manfaat pupuk urea adalah memasok unsur nitrogen yang sangat dibutuhkan tanaman terutama dalam pembentukan hijau daun, mempercepat proses pertumbuhan, dan menambahkan nutrisi protein untuk tanaman. <br>
                <br> <strong>Nitrea : </strong> 
                <br> Spesifikasi:
                <br> - Kadar Biuret maksimal 1%
                <br> - Kadar Nitrogen minimal 46%
                <br> - Bentuk butiran prill uncoated
                <br> - 100% larut dalam air
                <br> - Warna pink untuk urea bersubsidi
                <br> Kandungan:
                <br> - Nitrogen 46%
                <br> <em>Harga : Rp675.000/50kg</em> <br> 

                <br> <strong>Mahkota :</strong> 
                <br> Urea Mahkota berbentuk prill, sehingga lebih memudahkan petani karena unsur N lebih cepat terserap. Pupuk ini juga mengandung Biuret yang merupakan ikatan peptida sehingga pelepasan unsur hara dapat diatur sedemikian rupa dan kehilangan akibat penguapan akan sangat kecil.
                <br> <em>Harga : Rp680.000/50kg</em> <br> 
                <br> <strong> Daun buah : </strong>
                <br> Kandungan : Nitrogen 46%
                <br> Bentuk : Prill, warna putih
                <br> Diproduksi oleh : PT Pupuk Kalimantan Timur
                <br> Urea Prill Daun Buah adalah merek yang digunakan untuk pupuk Urea Prill Non Subsidi produksi Pupuk Kaltim, berwarna putih dengan ukuran butiran 1 - 3,35 mm
                <br> <em>Harga : Rp615.000/50kg</em> 

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="pupukDuaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pupuk NPK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            Pupuk NPK adalah pupuk yang memiliki kandungan tiga unsur hara makro, yaitu Nitrogen (N) Fosfor (P) dan Kalium (K). Selain unsur hara makro, beberapa produsen pupuk juga menambahkan unsur hara mikro seperti  klorida, boron, besi, mangan, kalsium, magnesium, sulfur, tembaga, seng, dll untuk meramu sebuah formulasi yang disesuaikan dengan peruntukannya.                
                <br> Manfaat pupuk NPK secara umum adalah membantu pertumbuhan tanaman agar berkembang secara maksimal. Setiap unsur hara dalam pupuk NPK memiliki peran yang berbeda dalam membantu pertumbuhan tanaman. Ketiganya merupakan unsur hara makro primer karena paling banyak dibutuhkan oleh tanaman. <br>
                <br> <strong>Yaramila Palmae : </strong> 
                <br> Kandungan nutrisi :
                <br> - Nitrogen 13%
                <br> - Fosfat 11%
                <br> - Kalium 21%
                <br> - Magnesium 2%
                <br> - Boron 0,2%
                <br> YaraMila Palmae merupakan pupuk NPK prill berkualitas tinggi yang mengandung Magnesium (Mg) dan Boron (B).
                <br> <em>Harga : Rp850.000/50kg </em>  <br> 
                <br> <strong>Phonska : </strong>
                <br> Kandungan : 
                <br> - N (Nitrogen) : 15%
                <br> - P2O5 (Fosfat) : 10%
                <br> - K (Kalium) : 12%
                <br> - S (Sulfur) : 10% 
                <br> Spesifikasi : 
                <br> - Bentuk granul
                <br> - Larut dalam air
                <br> - Warna pink/merah muda
                <br> - Kemasan 50kg
                <br> <em>Harga : Rp360.000/50kg</em> <br>   

                <br> <strong> NPK 16 16 16 Super Aktif : </strong>
                <br> Kandungan : 
                <br> - N (Nitrogen) : 16%
                <br> - P2O5 (Fosfat) : 16%
                <br> - K2O (Kalium) : 16%
                <br> - CaF2 (Kalsium Florida) : 2,9 %
                <br> Spesifikasi : 
                <br> - Kelembaban : 3%maks
                <br> - Ukuran butiran :  1-4 mm 90% min. 1mm 3% maks
                <br> - Bentuk : butiran 
                <br> - Warna : merah muda
                <br> <em>Harga : Rp1.175.000/50kg</em> <br>               </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <script>

        $('#form_schedule').on('submit', function(e){
            var form = $('#form_schedule');
            e.preventDefault();
            // get is_member from auth
            var is_member = {{ Auth::user()->is_member }};
            if(is_member===1){
                swal({
                    title: "Apakah Anda Yakin?",
                    text: "Data penanaman akan disimpan.",
                    icon: "warning",
                    type: "warning",
                    buttons: ["Batal","Submit!"],
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Saya Yakin!'
                }).then((result) => {
                    if (result) {
                        form.submit();
                    }
                });
            }else{
                // alert('Anda belum menjadi member, silahkan daftar terlebih dahulu');
                swal({
                    title: "Anda belum menjadi member, silahkan daftar terlebih dahulu",
                    text: "Klik Ya untuk mendaftar",
                    icon: "warning",
                    buttons: ["Batal","Ya"],
                    confirmButtonColor: '#3085d6',
                    dangerMode: false,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = "{{ url('user/dashboard') }}";
                    }
                });
            }
        })

        var calendar = $('#calendar').fullCalendar({
            // editable:true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay'
            },
            @if($event != null)
            events: [
                @foreach($event as $e)
                {
                    title : '{{ $e->title }}',
                    start : '{{ $e->start_event }}',
                    end : '{{ $e->end_event }}',
                    @if($e->tipe == 1)
                        color: '#FFA500',
                        textColor: 'black'
                    @endif
                },
                @endforeach
            ],
            @endif
            selectable: true,
            selectHelper:true,
            select:function(start, end, allDay)
            {
                var title = prompt("Enter Event Title");
                if(title)
                {
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                    
                }
            },
            eventTextColor: 'white',
        })
    </script>
@endsection