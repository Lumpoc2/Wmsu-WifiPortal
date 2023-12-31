<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Student Information</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="pb-3">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-add-user">
                  Activate all User
                </button>
              </div>
              <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                  <tr>
                    <th></th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Year-Level</th>
                    <th>Department</th>
                    <th>Phone.No</th>

                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($students as $student): ?>
                    
                    <tr>
                      <td>
                      <a href="<?= base_url('students/delete_student/' . $student->id) ?>"class="delete-link"><i class="fa fa-trash" style="color: red"></i></a>
                      </td>
                     
                      <td>
                        <?= $student->firstname ?>
                      </td>
                      <td>
                        <?= $student->lastname ?>
                      </td>
                      <td>
                        <?= $student->email ?>
                      </td>
                      <td>
                        <?= $student->yearLevel ?>
                      </td>
                      <td>
                        <?= $student->department ?>
                      </td>
                      <td>
                        <?= $student->phone ?>
                      </td>
                      <td>
                     <!-- Assuming this is in your view file -->
                     <button class="btn btn-success"><a href="<?= base_url('students/send_activation_emails/' .  $student->id) ?>" style="color: white" >Activate</a></button>
                        
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  <script>
    $(document).ready(function() {
        $('.delete-link').click(function(e) {
            e.preventDefault();

            var deleteUrl = $(this).attr('href');

            Swal.fire({
                title: 'Delete Student Information '  + '?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });
</script>
</div>