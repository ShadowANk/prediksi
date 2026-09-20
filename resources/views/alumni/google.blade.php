@extends('layouts.app')


@section('content')

<div class="p-6">

    <h1 class="text-2xl font-bold mb-5">
        Data Alumni Google Sheet
    </h1>


    <div class="overflow-x-auto">

        @if(count($data) > 0)

        <table class="border w-full">

            <thead>

                <tr>

                    @foreach(array_keys($data[0]) as $header)

                    <th class="border p-2 bg-gray-100">
                        {{ $header }}
                    </th>

                    @endforeach

                </tr>

            </thead>


            <tbody>


                @foreach($data as $row)

                <tr>

                    @foreach($row as $value)

                    <td class="border p-2">
                        {{ $value }}
                    </td>

                    @endforeach

                </tr>

                @endforeach


            </tbody>


        </table>


        @else


        <div class="p-5 border">
            Data Google Sheet kosong
        </div>


        @endif


    </div>


</div>


@endsection