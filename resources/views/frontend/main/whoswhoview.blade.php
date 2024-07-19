@extends('frontend.layouts.main_header')
@section('content')
    <div class="container px-5 mt-5 mb-4" data-aos="fade-up">
        <div class="one text-col ">
            <h1>Who's who</h1>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">

                        <section class="core-section" id="features">
                            <div class="container">


                                <div class="row" style="margin:5px;overflow-y:auto;">

                                    <br>

                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <!-- Grid row -->
                                            <div class="row">
                                                <!-- Grid column -->
                                                <div class="col-md-12">

                                                    <div class="searchnew">
                                                        <i class="fa fa-search"></i>
                                                        <input type="text" id="searchInput" class="form-control"
                                                            placeholder="Search...">
                                                    </div>
                                                </div>
                                                <!-- Grid column -->
                                            </div>
                                            <!-- Grid row -->
                                            <!--Table-->
                                            <div class="table-responsive">
                                                <table id="dataTablenew" class="table table-striped table-responsive"
                                                    width="100%">
                                                    <!--Table head-->
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">Sl no </th>
                                                            <th width="5%">Name</th>
                                                            <th width="5%">Designation</th>
                                                            <th width="5%">Phone</th>
                                                            <th width="5%">Email</th>
                                                        </tr>
                                                    </thead>
                                                    <!--Table head-->
                                                    <!--Table body-->
                                                    <tbody>
                                                        @foreach ($bod as $bods)
                                                            @foreach ($bods->bodsub as $bodsub)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $bodsub->name }}</td>
                                                                    <td>{{ $bodsub->desig_id }}</td>
                                                                    <td>{{ $bods->mobilenumber }}<br>{{ $bods->officenumber }}</td>
                                                                    <td>{{ $bods->email }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach

                                                        <!-- Repeat your rows as needed -->
                                                    </tbody>
                                                    <!--Table body-->
                                                </table>

                                            </div>
                                            <!--Table-->
                                        </div>
                                    </div>




                                </div>

                                <!-- </form>    -->

                            </div>
                        </section>

            </div>
        </div>
    </div>
@endsection
@section('page_scripts')
<script>
    $(document).ready(function() {
        $('.dt-search').hide();
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

    let table = $('#dataTablenew').DataTable({
        paging: true, // Enable paging
        searching: false, // Enable search functionality
        lengthChange: false, // Disable page size changing
        info: false, // Disable "Showing X of Y entries" info
        pagingType: 'full_numbers', // Use full number pagination controls
        pageLength: 10, // Initial page length (number of rows per page)
        language: {
            paginate: {
                first: '&laquo;', // First page button text
                previous: '&lsaquo;', // Previous page button text
                next: '&rsaquo;', // Next page button text
                last: '&raquo;' // Last page button text
            }
        }
    });
    $('.dt-search').hide();
    // Apply search functionality
    $('#searchInput').on('keyup', function () {
        table.search(this.value).draw();
    });

    $('.dt-search').hide();
    $('#dataTablenew td').css('word-wrap: break-word');
    });

</script>
@endsection
