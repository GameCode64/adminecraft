@include('main/header')

<!-- BODY -->
<main class="col-md-9 ms-sm-auto col-lg-10 col-xxl-11 px-md-4 p-4">

    <div class="row g-3">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header  bg-dark text-light h1 text-center" style="display:inline-block"><div style="display: contents;">Console</div><div class="float-right"><button class="btn btn-primary" onclick="restartMC()">Restart</button></div></div>
                <div class="card-body bg-dark text-light card-console">
                    <div class="console" id="console">
                        <pre class="pb-2" id="console-content">{{ $Log }}</pre>
                    </div>
                </div>
                <input class="form-control form-control-dark hidden col-11" onkeypress="SendCommand(event)"
                    type="text" id="CommandBox" name="Command" placeholder="Enter command..." aria-label="command">
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


    function SendCommand(e) {
        CommandBox = document.getElementById("CommandBox").value;
        if (e.keyCode === 13) {

            $.ajax({
                type: "POST",
                url: "{{ route('console.send') }}",
                data: {
                    Command: CommandBox,
                },
                success: function(result) {
                    alert(result);
                    console.log(result);
                },
                error: function(error) {
                    alert(error);
                }
            });
            CommandBox.value = "";
            e.currentTarget.value = "";
        }
        return false;
    }
</script>

<script>
    setInterval(function() {
        fetchLogLines();
    }, 250);

    function restartMC(){
	if(confirm("Are you realy sure you want to restart the server?"))
	{
		$.ajax({
		    type: "PATCH",
		    url: "{{ route('service.control') }}",
		    data: {
		        server: "ghunsquad",
			action: "restart"
		    },
		    success: function(result) {
			alert(result);
			console.log(result);
		    },
		    error: function(error) {
			    alert(error)
		    }
	});
	}
	return false;
    }

    function fetchLogLines() {
        fetch("{{ route('console.log') }}")
            .then(response => response.text())
            .then(data => {
                document.getElementById("console-content").innerHTML = data;
            });
        var objDiv = document.getElementById("console");
        objDiv.scrollTop = objDiv.scrollHeight;
    }
</script>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.6.4.min.js"></script>


@include('main/footer')
