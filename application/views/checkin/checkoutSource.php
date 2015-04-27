<div id="childrenResults" class="row">
    <div class="col-md-4">
        <h4 class="result1 childResultstitle">Summary</h4>
        <table class="table ">
            <tbody>
                <tr> <td>No. of Children</td><td><?php print isset($no_checkedIn_children) ? $no_checkedIn_children : ''; ?></td> </tr>
                <tr> <td>Sibling Count</td><td><?php print isset($sibling_count) ? $sibling_count : ''; ?></td> </tr>
                <tr> <td>Check-In Time</td><td><?php print isset($checkinTime) ? $checkinTime : ''; ?></td></tr>
                <tr><td >Card Number</td> <td><b><?php print isset($cardNo) ? $cardNo : ''; ?></b></td>
                </tr>
            </tbody>
        </table> 
    </div>
    <div  class="col-md-4">
        <h4 class="result2 childResultstitle">Children </h4>
        <form id="tblForm">
            <?php
            foreach ($siblings as $sibling) {
                $sibling_id = isset($sibling[COL_CHILD_ID]) ? $sibling[COL_CHILD_ID] : '';
                ?>
                <table class="table ">
                    <tbody>
                        <tr> <td><span class="childName"><?php print isset($sibling[COL_CHILD_NAME]) ? $sibling[COL_CHILD_NAME] : ''; ?> </span></td> </tr>
                        <tr> <td>Gender</td><td><?php print isset($sibling[COL_SEX]) ? $sibling[COL_SEX] : ''; ?></td> </tr>
                        <tr> <td>Age</td><td><?php print isset($sibling[COL_DOB]) ? calculateAge($sibling[COL_DOB]) . ' years' : ''; ?></td></tr>
                        <tr class="checkDo" onClick="checkInOut(<?php print $checkin_id; ?>, 'c_<?php print $sibling_id; ?>');"><td>Check-Out</td> <td><input id="c_<?php print $sibling_id; ?>" type="checkbox" /></td>
                        </tr>
                    </tbody>
                </table>  
            </form>
<?php } ?>
    </div>
    <div class="col-md-4">
        <h4 class="result3 childResultstitle">Parents/Handlers</h4>
        <?php
        foreach ($handlers as $parent) {
            $handler_id = isset($parent[COL_HANDLER_ID]) ? $parent[COL_HANDLER_ID] : '';
            ?>
            <table class="table ">
                <tbody>
                    <tr> <td><span class="childName"><?php print isset($parent[COL_HANDLER_NAME]) ? $parent[COL_HANDLER_NAME] : ''; ?></span></td> </tr>
                    <tr> <td>Gender</td><td><?php print isset($parent[COL_SEX]) ? $parent[COL_SEX] : ''; ?></td> </tr>
                    <tr> <td>Relationship</td><td><?php print isset($parent[COL_RELATIONSHIP]) ? $parent[COL_RELATIONSHIP] : ''; ?></td></tr>
                </tbody>
            </table> 
            <?php
        }
        $handler_name = isset($handler_name) ? $handler_name : '';
        print (strlen($handler_name) > 1) ? 'Name :' . $handler_name : '';
        ?>
    </div>
</div>
<div class="row" style="margin-top:10px">
    <div class="col-md-3"> <button type="button" id="completeCheckin" class="btn btn-lg btn-blac">Check-Out</button></div>
    <div class="col-md-4"></div>
</div>

<script type="text/javascript">
                        var checkin_id = '<?php print isset($checkin_id) ? $checkin_id : ''; ?>';
                        $('#completeCheckin').click(function() {
                            //var selected= [];
                            var count = 0;
                            $("#tblForm input:checkbox:not(:checked)").each(function() {
                                count++;
                                console.log("jjj")
                            });
                            if (count > 0) {
                                alert("Please check-out all the children before completing checkout");
                                return;
                            } else
                                completeCheckOut();
                        });

                        function completeCheckOut() {
                            $.post('<?php print site_url('generic/checkout/completeCheckout'); ?>', {'checkin_id': checkin_id}, function(response) {
                                $('#selction-ajax').html(response);
                                location.reload();
                                
                            });
                        }

                        function checkInOut(checkinId, id) {
                            if (document.getElementById(id).checked)
                                document.getElementById(id).checked = false;
                            else {
                                document.getElementById(id).checked = true;
                                $.post('<?php print site_url('generic/checkout/checkoutSibling') ?>', {'checkin_id': checkinId, 'childId': id}, function(response) {
                                });
                            }
                        }
</script>