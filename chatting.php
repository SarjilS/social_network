<?php
$con = mysql_connect('localhost','root','');
mysql_select_db('social_net', $con) or die('error in (application/view/chatting.php) at line 3');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="facivon.ico">

    <title>Facebook like chat</title>
    <link href="style.css" rel="stylesheet">
<style>
.chatbox-holder {
	position: fixed;
	right: 290px;
	bottom: 0;
	display: flex;
	align-items: flex-end;
	height: 0;
}
.chat_box{
	position:fixed;
	right:20px;
	bottom:0px;
	width:250px;
}
.chat_body{
	background:white;
	height:400px;
	overflow:auto;
	overflow-x: hidden;
	border-right: 1px solid rgba(0, 0, 0, 0.28);
	border-left: 1px solid rgba(0, 0, 0, 0.28);
	padding:5px 0px;
}
.chat_head,.msg_head{
	background:#f39c12;
	color:white;
	padding:5px 15px;
	-moz-user-select:none;
	user-select:none;
	font-weight:bold;
	cursor:pointer;
	border-radius:5px 5px 0px 0px;
}
.chat_head{
	padding:5px;
}
.msg_box{
	bottom:-5px;
	display:none;
	margin-right:5px;
	width:250px;
	background:white;
	border-radius:5px 5px 0px 0px;
}
.msg_head{
	font-weight: normal;
	background:#4080ff none repeat scroll 0% 0%;
	-moz-user-select:none;
	user-select:none;
	overflow:hidden;
}
.msg_body{
	border-right: 1px solid rgba(0, 0, 0, 0.28);
	border-left: 1px solid rgba(0, 0, 0, 0.28);
	height:220px;
	padding:8px;
	overflow:auto;
	overflow-x: hidden;
}
.msg_input{
	width:100%;
	border: 1px solid white;
	border-top:1px solid #DDDDDD;
	border-right: 1px solid rgba(0, 0, 0, 0.28);
	border-left: 1px solid rgba(0, 0, 0, 0.28);
	-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box; 
	resize:none;
}
.close{
	float:right;
	font-weight: bold;
	margin:-15px;
	border-radius:0px 5px 0px 0px;
	padding:15px;
	-moz-user-select:none;
	user-select:none;
	cursor:pointer;
}
.minimize{
	float:right;
	cursor:pointer;
	padding-right:5px;
	
}
.user{
	position:relative;
	padding:10px 30px;
}
.user:hover{
	background:#f8f8f8;
	cursor:pointer;

}
.user-0{
	content:'';
	position:absolute;
	background:#535a56;
	height:7px;
	width:7px;
	left:10px;
	top:18px;
	border-radius:4px;
}
.user-1{
	content:'';
	position:absolute;
	background:#2ecc71;
	height:7px;
	width:7px;
	left:10px;
	top:18px;
	border-radius:4px;
}
.msg_a, .msg_b{
	word-wrap: break-word;
	cursor:default;
	margin: 0 0 0.5em;
	border-radius: 1em;
	padding: 0.3em 1em;
	background: #e5e5ea;
	max-width: 75%;
	word-wrap: break-word;
	clear: both;
	position: relative;
	color:black;
	font: 14px "Helvetica Neue", Helvetica, Arial, sans-serif;
}
.msg_a{
	float:left;
}
.msg_b{ 
	background-color: #1289fe;
	float:right;
	color: white;
}
#finfrndslink
{
	display:block;
	padding:.6em;
	margin:0px auto;
	width:94%;
	margin-top: 10em;
	background: rgb(54, 42, 42) none repeat scroll 0% 0%;
	text-align: center;
	color: white;
	border-radius: 5px;
}
</style>
	<script src="<?=base_url().'assets/js/jquery-1.10.1.min.js'?>"></script>
    <script>
	$(document).ready(function(){
		$('.msg_box').hide();
		$('.chat_head').click(function(){
			$('.chat_body').slideToggle('fast');
		});
	});
	</script>
  </head>
  <body>
  <?php
	$user_name = $this->session->userdata('user');
	$sql1 = "SELECT * FROM users WHERE user_name='$user_name'";
	$query1 = mysql_query($sql1);
	$row1 = mysql_fetch_assoc($query1);
	$u_id = $row1['u_id'];
	
	$sql = "SELECT * FROM friends T1 JOIN users T2 ON T1.frnd_id=T2.u_id WHERE T1.u_id='$u_id' && T1.status='confirm' ORDER BY T2.logged_in  DESC";
	$query3 = mysql_query($sql);
	$query = mysql_query($sql);
	$count = mysql_num_rows($query);
  ?>
  <div class="chat_box">
	<div class="chat_head"><i class="fa fa-comments" aria-hidden="true"></i> Chat</div>
	<div style="display: none;" class="chat_body">  
	<?php
	if($count!=0)
	{
		$i=1;
		while($row = mysql_fetch_assoc($query))
		{
			?>
				<div class="user" id="u<?=$i?>" style="text-transform:capitalize"><span class="user-<?=$row['logged_in'];?>"></span><?=$row['f_name'].' '.$row['l_name']?></div>
			<?php
			$i++;
		}
	}
	else
	{
		?>
		<a href='<?=base_url()?>find_friends' id='finfrndslink'>Find Friends</a>
		<?php
	}
	?>
	</div>
	
  </div>
  <div class="chatbox-holder">
  <?php
	$i=1;
		while($row1 = mysql_fetch_assoc($query3))
		{
			?>
				<script>
				$(document).ready(function(){
					$('#mh<?=$i?>').click(function(){
						$('#mw<?=$i?>').slideToggle('fast');
					});
					
					$('#cl<?=$i?>').click(function(){
						$('#mb<?=$i?>').hide();
					});
					
					$('#u<?=$i?>').click(function(){
						$('#mw<?=$i?>').show();
						$('#mb<?=$i?>').show();
						$('#msg_body<?=$i?>').scrollTop($('#msg_body<?=$i?>')[0].scrollHeight);
						$('#ti<?=$i?>').focus();
					});
					
					$('#ti<?=$i?>').keypress(
					function(e){
						if (e.keyCode == 13) {
							e.preventDefault();
							var msg = $(this).val();
							$(this).val('');
							if(msg.trim()!='')
							{
								$.ajax({
									type: "POST",
									url: "<?=base_url().'chat/send_message/'?>",
									data : { receiver : '<?=$row1['u_id']?>', msg : msg },
									beforeSend: function(){
										$('#ti<?=$i?>').attr('readonly', 'readonly');
									},
									success: function(data){
										$('#ti<?=$i?>').removeAttr('readonly');
										$('<div class="msg_b">'+msg.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')+'</div>').insertBefore('#msg_push<?=$i?>');
										$('#msg_body<?=$i?>').scrollTop($('#msg_body<?=$i?>')[0].scrollHeight);
									}
								});
							}
						}
					});
					
					function getMsg<?=$i?>($fid, $mid)
					{
						$.ajax({
							type: 'post',
							url: '<?=base_url().'chat/get_message/'?>',
							dataType: 'json',
							data:  {fid: $fid, mid: $mid},
							success: function(data){
									if(parseInt(data.read) == 1){
										//alert(rsp.msg);
									}else if(parseInt(data.read) == 0){
										$('<div class="msg_a">'+data.message+'</div>').insertBefore('#msg_push<?=$i?>');
										$('#msg_body<?=$i?>').scrollTop($('#msg_body<?=$i?>')[0].scrollHeight);
									}
								}
						});
					}
					

					// Check for latest message
					setInterval(function(){getMsg<?=$i?>(<?=$u_id?>, <?=$row1['u_id']?>);}, 200);

				});
				</script>
				<div class="msg_box" id="mb<?=$i?>">
					<div class="msg_head" id="mh<?=$i?>">
					<font style="text-transform:capitalize"><?=$row1['f_name'].' '.$row1['l_name']?></font>
					<div class="close" id="cl<?=$i?>" title="Close">x</div>
					</div>
					<div class="msg_wrap" id="mw<?=$i?>">
						<div class="msg_body" id="msg_body<?=$i?>">	
							<?php
								$from = $row1['u_id'];
								$msql = "SELECT * FROM `chat` WHERE (`to`=$u_id && `from`=$from) or (`to`=$from && `from`=$u_id) order by id";
								$mqry = mysql_query($msql);
								while($mrow=mysql_fetch_assoc($mqry))
								{
									if($mrow['to']==$u_id)
									{
										?>
											<div class="msg_a"><?=$mrow['message']?></div>
										<?php
									}
									else
									{
										?>
											<div class="msg_b"><?=$mrow['message']?></div>
										<?php
									}
								}
							?>
							<div class="msg_push" id="msg_push<?=$i?>"></div>
						</div>
					<div class="msg_footer"><textarea class="msg_input" id="ti<?=$i?>" placeholder="write your message here" rows="2"></textarea></div>
					</div>
				</div>
			<?
			$i++;
		}
	?>
	</div>
</body>
</html>
