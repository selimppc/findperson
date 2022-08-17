@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                    <form action="{{ route('persons') }}" method="GET" >
                        <input type="hidden" name="rowLimit" value="{!!  $limit !!}" />
                        <div class="input-group">
                            <div class="form-outline" style="margin-right: 5px">
                                <input type="number" id="birthYear" name="birthYear" value="{!! $birthYear !!}" placeholder="search by birth year" class="form-control" />
                                <div id="birthYearCheck" style="color: red; display: none;">
                                    <small> * Year must be greater than zero. </small>
                                </div>
                            </div>
                            <div class="form-outline" style="margin-right: 5px">
                                <input type="number" id="birthMonth" name="birthMonth" value="{!! $birthMonth !!}" placeholder="search by birth month" class="form-control" maxlength="12"  />
                                <div id="birthMonthCheck" style="color: red; display: none;">
                                    <small> * Month must be between 01 to 12. </small>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Filter
                            </button>
                        </div>
                        <small><i>execution time : {{$difference}} ms</i></small>
                    </form>


                    <div class="card-body container mt-5">
                        <table class="table table-striped table-bordered mb-5">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">Name</th>
                                <th scope="col">Birthday</th>
                                <th scope="col">Phone</th>
                                <th scope="col">IP</th>
                                <th scope="col">Country</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($persons as $person)
                                <tr>
                                    <td scope="row">{{ $person->id }}</td>
                                    <td>{{ $person->email }}</td>
                                    <td>{{ $person->name }}</td>
                                    <td>{{ $person->birth_date }}</td>
                                    <td>{{ $person->phone }}</td>
                                    <td>{{ $person->ip }}</td>
                                    <td>{{ $person->country }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {!! $persons->render() !!}
                        </div>

                    </div>

            </div>
        </div>

        <p>&nbsp;</p>
        <div class="card col-md-4">
            <div class="card-header">How many people?</div>
            <div class="card-body">
                <h5 class="card-title"> </h5>
                <p class="card-text">Enter a number of how many people you may want to add to the list.</p>

                <div class="input-group">
                    <div class="form-outline" style="width: 100%">
                        <input type="text" name="limitValue"  class="form-control" value={{$limit}} />
                    </div>
                </div>
            </div>
            <div class="card-footer" style="text-align: right">
                <button type="reset" class="btn" id="cancelLimit">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" id="limitStart">
                    Start
                </button>
            </div>
        </div>

    </div>




@endsection
@section('script')
    <script type="text/javascript">
       jQuery(function ($) {
           $("#birthYearCheck").hide();
           $("#birthMonthCheck").hide();

            {{-- custom pagination value set on start event --}}
            $('[id^=limitStart]').on('click', function (e) {
                e.preventDefault();
                const limit = $('input[name="limitValue"]').val();
                $('input[name="rowLimit"]').val(limit);
            });

            {{-- default value set on cancel event --}}
            $('[id^=cancelLimit]').on('click', function (e) {
                const defaultLimit = '<?php echo($limit); ?>';
                e.preventDefault();
                $('input[name="limitValue"]').val(defaultLimit);
                $('input[name="rowLimit"]').val(defaultLimit);
            });

           $("#birthYear").keyup(function () {
               let year = $("#birthYear").val();
               if (year < 1 ){
                   $("#birthYearCheck").show();
                   $("#birthYear").val('');
                   return false;
               }else{
                   $("#birthYearCheck").hide();
                   return true;
               }
           });
           $("#birthMonth").keyup(function () {
               let month = $("#birthMonth").val();
               if ( (month > 12) || (month < 1)){
                   $("#birthMonthCheck").show();
                   $("#birthMonth").val('');
                   return false;
               }else {
                   $("#birthMonthCheck").hide();
                   return true;
               }
           });
        });

    </script>
@endsection
