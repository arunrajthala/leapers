<div class="col-md-12">
    <?php
    $obj = new Log();
    $data = $obj->get();
    ?>

    <table id="table-content" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Uin</th>
            <th>Tablename</th>
            <th>Action</th>
            <th>Value Before</th>
            <th>Value After</th>
            <th>Modified By</th>
            <th>Modified On</th>
        </tr>
        </thead>
        <tbody>
    <?php foreach ($data as $value) :?>
        <tr>
        <?php foreach ($value as $v) :?>

            <td>
                <?php echo $v ?>
            </td>
        <?php endforeach ?>
        </tr>
    <?php endforeach ?>
        </tbody>
        <tfoot>
        <tr>
            <th>Uin</th>
            <th>Tablename</th>
            <th>Action</th>
            <th>Value Before</th>
            <th>Value After</th>
            <th>Modified By</th>
            <th>Modified On</th>
        </tr>
        </tfoot>
    </table>

    <button class="reload">Reload</button>
</div>
<div class="clearfix">
<script>
    var myJsonString = (JSON.stringify(<?php echo json_encode($data); ?>));
    var url;
    var data;
    url = "ajax/ListLog.php";

    $( document ).ready(function() {
        $('#table-content').dataTable();

        $('.reload').on('click', function(e) {
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                        if(myJsonString != data) {
                            console.log('Log changed.');
                            flashTitle("Table changed in database.");
                        } else {
                            console.log('Log not changed.');
                        }

                },
                error: function(xhr, desc, err) {
                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);
                }
            });
        });


    });

    (function () {
        var original = document.title;
        var timeout;

        window.flashTitle = function (newMsg, howManyTimes) {
            function step() {
                console.log('step');
                document.title = (document.title == original) ? newMsg : original;

                if (--howManyTimes > 0) {
                    timeout = setTimeout(step, 1000);
                };
            };

            howManyTimes = parseInt(howManyTimes);

            if (isNaN(howManyTimes)) {
                howManyTimes = 5;
            };

            cancelFlashTitle(timeout);
            step();
        };

        window.cancelFlashTitle = function () {
            clearTimeout(timeout);
            document.title = original;
        };

    }());
</script>