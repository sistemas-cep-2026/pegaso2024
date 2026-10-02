<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table id="basic-datatable" class="table">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Date</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>id</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Date</td>
                            <td>Salary</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                        <tr>
                            <td>id</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Date</td>
                            <td>Salary</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                        <tr>
                            <td>id</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Date</td>
                            <td>Salary</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                        <tr>
                            <td>id</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Date</td>
                            <td>Salary</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                        <tr>
                            <td>id</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Date</td>
                            <td>Salary</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                        <tr>
                            <td>id</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Date</td>
                            <td>Salary</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                        <tr>
                            <td>id</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Date</td>
                            <td>Salary</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php $include_scripts = function () { //INCLUSION DE JS  
?>
    <script>
        $(function(){
            console.log("hola");
            fn_listaDataTable('basic-datatable');
        });
    </script>
<?php } ?>