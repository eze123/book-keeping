<html>
    <head>
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta content="utf-8" http-equiv="encoding">
         <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/jquery.dataTables.min.css">
        <!--<link rel="stylesheet" href="css/jquery-ui.min.css">-->
        <link rel="stylesheet" href="css/colReorder.dataTables.min.css">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/jquery.alerts.css">
		<link rel="stylesheet" href="css/disable_sort_icons.css">
        
        <script src="lib/jquery-3.2.1.min.js"></script>
        <script src="lib/jquery.dataTables.min.js"></script>
        <script src="lib/dataTables.colReorder.min.js"></script>
        <script src="lib/dataTables.buttons.min.js"></script>
        <script src="lib/dataTables.select.min.js"></script>
        <script src="lib/jquery.alerts.js"></script>
    </head>
    <body>
        <div id="tablezone">
            <input id="updateNote" type="button" value="Update Notes">
            <table id="bookTableId" class="display" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>author</th>
                    <th>publication date</th>
                    <th>description</th>
                    <th>rating</th>
                    <th>notes</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>author</th>
                    <th>publication date</th>
                    <th>description</th>
                    <th>rating</th>
                    <th>notes</th>
                </tr>
            </tfoot>
            </table>
        </div>
    </body>
    <script src="js/datatables_notes.js"></script>
</html>