@include('main/header')

<!-- BODY -->
<main class="col-md-9 ms-sm-auto col-lg-10 col-xxl-11 px-md-4 p-4">

    <div class="row g-3">
      @isset($Message)
        {{!!$Message!!}}
      @endif
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header  bg-dark text-light h1 text-center">Control panel settings</div>
                <div class="card-body bg-dark text-light">
                    <form name="panel" action="?submit=panel" method="post">
                        @csrf
                        <table class="w-100  table table-dark  text-light">
                            <thead class="thead-dark">
                                <tr>
                                    <td class="settings text-bold h5 text-center" scope="col">Setting</td>
                                    <td class="settings text-bold h5 text-center" scope="col">Value</td>
                                </tr>
                            </thead>
                            @foreach ($CSettings as $Option)
                                <tr>
                                    <td class="settings col-6">
                                        {{ $Option->Key }}
                                    </td>
                                    <td class="settings col-6">
                                        <input type="text" class="form-control form-control-dark w-100"
                                            name="{{ $Option->Key }}" id="" value="{{ $Option->Value }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <button type="submit" class="btn btn-success col-12">Save</button>
                        <br>
                        <br>
                        <button type="reset" class="btn btn-danger col-12">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row g-3">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header  bg-dark text-light h1 text-center">Server settings</div>
                <div class="card-body bg-dark text-light">
                    @if($SSettings["Status"])
                    <form name="server" action="?submit=server" method="post">
                        @csrf
                        <table class="w-100  table table-dark  text-light">
                            <thead class="thead-dark">
                                <tr>
                                    <td class="settings text-bold h5 text-center" scope="col">Setting</td>
                                    <td class="settings text-bold h5 text-center" scope="col">Value</td>
                                </tr>
                            </thead>
                            @foreach ($SSettings["Contents"] as $Option)
                                @if ($Option == null)
                                    @continue
                                @endif
                                <tr>
                                    <td class="settings col-6">
                                        {{ $Option['Key'] }}
                                    </td>
                                    <td class="settings col-6">
                                        <input type="text" class="form-control form-control-dark w-100"
                                            name="{{ $Option['Key'] }}" id="" value="{{ $Option['Value'] }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <button type="submit" class="btn btn-success col-12">Save</button>
                        <br>
                        <br>
                        <button type="reset" class="btn btn-danger col-12">Reset</button>
                    </form>
                    @else
                    <div class="alert alert-danger">Couldn't load server.properties!<br>Please check Control panel settings.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</main>
</div>
</div>
<!-- BODY -->

@include('main/footer')
