<div class="absolute" style="top: 5%; left: 2%; z-index: 1000; width: 15%;">
    <?php
        foreach($_SESSION['msgs'] as $index => $msg){

            echo 
            "<div class='toast tn2' style='color: white'>
                <div>$msg</div>
                <div class='generic-link' style='cursor: pointer; margin: 0px 15px;' onclick=CloseToast($index)>X</div>
            </div>";
        }
    ?>
</div>
<script>
    function CloseToast(index){
        let toast = event.target.closest('.toast');
        if (toast) {
            toast.remove();
        }
        $.ajax({
            url: '/toasts/message-remove.php',
            type: 'POST',
            data: {
                'index': index
            },
            success: function(response) {
                console.log(response);
            }
        });
    }
</script>



