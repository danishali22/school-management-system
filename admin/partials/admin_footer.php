    <!-- Main Footer -->
    <footer class="main-footer text-center">
        <strong>Copyright &copy; <?= date("Y"); ?> <a href="http://localhost/sms/admin/index.php?dashboard">School Management System</a>.</strong>
        All rights reserved.
    </footer>
    <!-- </div> -->
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- Bootstrap JS (optional, for certain components and features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swaet ALert  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <!-- Bootstrap -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="../dist/js/demo.js"></script>

    <!-- Multi Select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

    <!-- Datatables Jquery Link  -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        let table = new DataTable('#my-dataTable');
    </script>

    <script>
        (function() {
            let path = window.location.href;
            // console.log(path);
            $(".nav-link").each(function() {

                var href = $(this).attr('href');
                // console.log(href);
                if (path === decodeURIComponent(href)) {
                    $(this).addClass('active');
                    var parent = $(this).closest('.has-treeview');
                    parent.addClass('menu-open');
                    $(parent).find('.nav-link').first().addClass('active');
                    // console.log(parent);
                };
            });
        }());
    </script>
</body>

</html>