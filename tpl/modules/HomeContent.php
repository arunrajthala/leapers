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
        <tbody id="table-body">
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
</div>
<div class="clearfix">
<script>
    var myJsonString = (JSON.stringify(<?php echo json_encode($data); ?>));

    var url;
    var data;
    url = "ajax/ListLog.php";

    $( document ).ready(function() {
        setInterval( function () {
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                        if(myJsonString != data) {
                            console.log('Log changed.');
                            flashTitle("Table changed in database.");
                            $('#table-content').html(loadTable(data));
                            compareObjects(myJsonString, data);

                        } else {
                            console.log('Log not changed.');
                        }
                },
                error: function(xhr, desc, err) {
                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);
                }
            });
        }, 5000);
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

    function loadTable(data)
    {
        var obj = JSON.parse(data);
        var table = '';

        table += "<table id='table-content' class='display' cellspacing='0' width='100%'>";
        table += "<thead><tr><th>Uin</th><th>Tablename</th><th>Action</th><th>Value Before</th><th>Value After</th><th>Modified By</th><th>Modified On</th></tr></thead><tbody id='table-body'>";

        $.each(obj, function(k, v) {
            table += "<tr>";

            $.each(v, function (kk, vv){
                table += "<td>" + vv + "</td>";
            });
            table += "</tr>";
        });
        table += "</tbody></table>";
        return table;
    }

    function compareObjects(myJsonString, data)
    {
        var formDataObj = JSON.parse(myJsonString);
        var dbDataObj = JSON.parse(data);

        var a = [];
        var b = [];

        for (var key in formDataObj) {
            if (formDataObj.hasOwnProperty(key)) {
                var obj = formDataObj[key];

                for (var prop in obj) {
                    if(obj.hasOwnProperty(prop)){
                        a.push(key + "," + prop + "," + obj[prop]);
                    }
                }
            }
        }

        for (var key in dbDataObj) {
            if (dbDataObj.hasOwnProperty(key)) {
                var obj = dbDataObj[key];

                for (var prop in obj) {
                    if(obj.hasOwnProperty(prop)){
                        var tmp = key + "," + prop + "," + obj[prop];
                        b.push(tmp);
                    }
                }
            }
        }

        for (var i = 0; i < a.length; i++) {
            if (a[i] != b[i]) {
                var formSplitString = a[i].split(",");
                var dbSplitString = b[i].split(",");
                console.log("Changed Column is \'" + formSplitString[1] + "\', before data \'" + formSplitString[2] + "\', after data is \'" + dbSplitString[2] + "\'.");
            } else {
                console.log('same data');
            }
        }
    }
</script>