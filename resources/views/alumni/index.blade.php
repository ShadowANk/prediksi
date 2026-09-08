@extends('layouts.app')

@section('title','Data Alumni')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold">
            Data Alumni
        </h2>
    </div>


</div>



<div class="card shadow-sm mb-4">

<div class="card-body">


<form method="GET"
      action="{{ route('alumni.index') }}">


<div class="row g-3">


<div class="col-md-4">

<input type="text"
       name="search"
       value="{{ request('search') }}"
       class="form-control"
       placeholder="Cari NIM atau Nama">

</div>



<div class="col-md-3">

<select name="program_studi"
        class="form-select">


<option value="">
Semua Program Studi
</option>


@foreach($programStudis as $prodi)

<option value="{{ $prodi }}"
@if(request('program_studi')==$prodi)
selected
@endif
>
{{ $prodi }}
</option>

@endforeach


</select>

</div>



<div class="col-md-3">

<select name="tahun_lulus"
        class="form-select">


<option value="">
Semua Tahun
</option>


@foreach($tahunLulus as $tahun)

<option value="{{ $tahun }}"
@if(request('tahun_lulus')==$tahun)
selected
@endif
>

{{ $tahun }}

</option>

@endforeach


</select>

</div>



<div class="col-md-2">

<button class="btn btn-primary w-100">
Cari
</button>

</div>


</div>


</form>


</div>

</div>





<div class="card shadow-sm">

<div class="card-header fw-bold">

Daftar Alumni

</div>


<div class="card-body">


<div class="table-responsive">


<table class="table table-hover">


<thead>

<tr>

<th>No</th>
<th>NIM</th>
<th>Nama</th>
<th>Email</th>
<th>Program Studi</th>
<th>Tahun Lulus</th>

</tr>

</thead>


<tbody>


@forelse($alumnis as $index=>$alumni)


<tr>

<td>
{{ $alumnis->firstItem()+$index }}
</td>


<td>
{{ $alumni->nim }}
</td>


<td class="fw-semibold">
{{ $alumni->nama_lengkap }}
</td>


<td>
{{ $alumni->email_address ?? '-' }}
</td>


<td>
{{ $alumni->program_studi }}
</td>


<td>
{{ $alumni->tahun_lulus }}
</td>


</tr>


@empty

<tr>

<td colspan="6"
class="text-center">

Belum ada data alumni

</td>

</tr>

@endforelse


</tbody>


</table>


</div>


{{ $alumnis->links() }}


</div>

</div>


@endsection