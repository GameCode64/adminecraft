@include('main/header')

<!-- BODY -->
<main class="col-md-9 ms-sm-auto col-lg-10 col-xxl-11 px-md-4 p-4">

    <div class="row g-3">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header  bg-dark text-light h1 text-center">Users</div>
                <div class="card-body bg-dark text-light table-responsive">
                    <table id="UserTable" class="table table-striped table-hover table-dark fluid w-100">
                        <thead>
                            <tr>
                                <th>
                                    Game Name
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    death counts
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr class="">
                                <td>assdfasdf</td>
                                <td>assdfasdf</td>
                                <td>assdfasdf</td>
                                <td>3</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary"><i
                                            data-feather="eye"></i></button>
                                    <button type="button" class="btn btn-sm btn-success"><i
                                            data-feather="edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger"><i
                                            data-feather="trash"></i></button>
                                </td>
                            </tr>

                            <tr>
                                <td>assdfasdf</td>
                                <td>assdfasdf</td>
                                <td>assdfasdf</td>
                                <td>2</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>assdfasdf</td>
                                <td>assdfasdf</td>
                                <td>assdfasdf</td>
                                <td>1</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>assdfasdf</td>
                                <td>assdfasdf</td>
                                <td>assdfasdf</td>
                                <td>4</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>assdfasdf</td>
                                <td>assdfasdf</td>
                                <td>assdfasdf</td>
                                <td>5</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>assdfasdf</td>
                                <td>assdfasdf</td>
                                <td>assdfasdf</td>
                                <td>7</td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</main>
</div>
</div>
<!-- BODY -->


<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#UserTable').DataTable();
    });
</script>

@include('main/footer')
