<?php
    session_start();
    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $_SESSION['name'] = $name;
    }
?>

<?php
if(!isset($_SESSION['name'])){
?>
<form method="POST">
    <input type="text" name="name" required>
    <input type="submit" name="submit" value="Submit">
</form>
<?php } else { ?>
<input type="text" id="msg">
<input type="button" id="btn" value="Click">

<div id="msg_box">

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function(e) {
        console.log("Connection established!");
    };

    conn.onmessage = function(e) {
        var getData = jQuery.parseJSON(e.data);
        var html = "<b>"+getData.name+"</b>: "+getData.msg+"<br/>";
        jQuery('#msg_box').append(html);
    };
    jQuery('#btn').click(function(){
        var msg=jQuery('#msg').val();
        var name = "<?php echo $_SESSION['name']?>";
        var content = {
            name:name,
            msg:msg
        };
        conn.send(JSON.stringify(content));
        var html="<b>"+name+"</b>: "+msg+"<br/>";
        jQuery('#msg_box').append(html);
        jQuery('#msg').val('');
    })
</script>
<?php } ?>