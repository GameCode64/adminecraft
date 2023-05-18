@include('main/header')

<!-- BODY -->
<main class="col-md-9 ms-sm-auto col-lg-10 col-xxl-11 px-md-4 p-4">

    <div class="row g-3">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header  bg-dark text-light h1 text-center">Logs</div>
                
                {{-- <input class="form-control form-control-dark hidden col-11" onkeypress="SendCommand(event)"
                    type="text" id="CommandBox" name="Command" placeholder="Enter command..." aria-label="command"> --}}
                    <select id="fileSelector" class="form-control form-control-dark hidden col-11" onchange="FetchSelectedLog()" name="" id="">
                        <option class="form-control form-control-dark bg-dark text-light" selected value="null">Select a log...</option>
                        @foreach ( $Logs as $Log )
                        <option class="form-control form-control-dark bg-dark text-light" value="{{$Log}}">{{$Log}}</option>
                        @endforeach
                    </select>
                <div class="card-body bg-dark text-light card-console">
                    <div class="console" id="console">
                        <pre class="pb-2" id="console-content">
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
</div>
<!-- BODY -->
 <script>
    var objDiv = document.getElementById("console");
    objDiv.scrollTop = objDiv.scrollHeight;

    function FetchSelectedLog() {
        SelectedFile = document.getElementById("fileSelector").value;
            $.ajax({
                type: "GET",
                url: "{{ route("log.fetch") }}",
                data: {
                    File: SelectedFile,
                },
                success: function(result) {
                    document.getElementById("console-content").innerHTML = result;
                },
                error: function(error) {
                    console.log(error);
                }
            }); 
        }
</script> 

<script>

</script>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.6.4.min.js"></script>


@include('main/footer')
