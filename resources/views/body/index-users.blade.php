@include("main/header")

     <!-- BODY -->
     <main class="col-md-9 ms-sm-auto col-lg-10 col-xxl-11 px-md-4 p-4">
       
        <div class="row g-3">
          <div class="col-12">
            <div class="card bg-dark border-secondary">
              <div class="card-header  bg-dark text-light h1 text-center">Users</div>
              <div class="card-body bg-dark text-light">
                <table id="UserTable" style="w-100">
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
                    </tr>
                  </thead>
                  <tbody>

                    <tr>
                      <td>assdfasdf</td>
                      <td>assdfasdf</td>
                      <td>assdfasdf</td>
                      <td>3</td>
                  </tr>
                  
                    <tr>
                      <td>assdfasdf</td>
                      <td>assdfasdf</td>
                      <td>assdfasdf</td>
                      <td>3</td>
                  </tr>
                  
                    <tr>
                      <td>assdfasdf</td>
                      <td>assdfasdf</td>
                      <td>assdfasdf</td>
                      <td>3</td>
                  </tr>
                  
                    <tr>
                      <td>assdfasdf</td>
                      <td>assdfasdf</td>
                      <td>assdfasdf</td>
                      <td>3</td>
                  </tr>
                  
                    <tr>
                      <td>assdfasdf</td>
                      <td>assdfasdf</td>
                      <td>assdfasdf</td>
                      <td>3</td>
                  </tr>
                  
                    <tr>
                      <td>assdfasdf</td>
                      <td>assdfasdf</td>
                      <td>assdfasdf</td>
                      <td>3</td>
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


  <script>
    $(document).ready( function () {
    $('#UserTable').DataTable();
} );
  </script>

  @include("main/footer")