<?php
if ($_POST) 
{
	require('cnf_data.php');
	if ($_POST['type'] == "day") 
	{
		$ask = $_POST['ask'];
		$ans = $_POST['ans'];
		if (!$ask) 
		{
			die("Bạn Đang Để Trống Câu Hỏi");
		}
		if (!$ans) 
		{
			die("Bạn Đang Để Trống Câu Trả Lời");
		}
		$result = @mysql_query("SELECT * FROM sim ");
		if ($result) 
		{
			while ($row = @mysql_fetch_array($result)) 
			{
				if ($row['ask'] == $ask) 
				{
					die('Câu Hỏi Đã Có. Vui Lòng Hỏi Câu Khác');
				}
			}
			@mysql_query("INSERT INTO sim SET ask = '".addslashes($ask)."', ans = '".addslashes($ans)."'");
			die("Sim Đã Ghi Nhớ <br /> Hỏi: ".$ask." <br /> Đáp: ".$ans);
		}
	}
	else
	{
		$hoi = $_POST['hoi'];
		if (!$hoi) 
		{
			die("Bạn Chưa Nhập Câu Hỏi");
		}
		$result = @mysql_query("SELECT * FROM sim ");
		if ($result) 
		{
			while ($row = @mysql_fetch_array($result)) 
			{
				if ($row['ask'] == $hoi) 
				{
					die("<font color='#00FF00'>".$row['ans']."</font>");
					$ok =1;
				}
			}
		} 
		if ($ok !=1) 
		{
			$data = file_get_contents('http://bot.copcute.xyz/api.php?text='.$hoi);
			die($data);
		}
	}

}
else
{
	echo 'Welcome to VietNam, Server dang bao tri';
}