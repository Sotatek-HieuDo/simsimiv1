<?php
require('cnf_data.php');
if ($_POST)
{
	if (isset($_POST['type']) && $_POST['type'] == "day")
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

		$result = mysqli_query($conn, "SELECT * FROM sim where ask = '$ask'");
		if (mysqli_num_rows($result)) {
			die('Câu Hỏi Đã Có. Vui Lòng Hỏi Câu Khác');
		} else {
			$query = "INSERT INTO sim (`ask`, `ans`, `by`, `time`) VALUES ('".addslashes($ask)."', '".addslashes($ans)."', 'user', 'default')";
			if(mysqli_query($conn, $query)) {
				die("Sim Đã Ghi Nhớ <br /> Hỏi: ".$ask." <br /> Đáp: ".$ans);
			}
			die("Co loi xay ra".mysqli_error($conn));
		}
	}
	else
	{
		$hoi = $_POST['hoi'];
		if (!$hoi)
		{
			die("Bạn Chưa Nhập Câu Hỏi");
		}
		//Get answer from datbase
		$result = mysqli_query($conn, "SELECT * FROM sim where ask = '$hoi'");
		//Call rebot api if dont have any matched answer
		if (!mysqli_num_rows($result))
		{
			$url = 'https://rebot.me/ask';
			$data = array('username' => 'simsimi', 'question' => $hoi);
			$options = array(
			    'http' => array(
			        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			        'method'  => 'POST',
			        'content' => http_build_query($data)
			    )
			);
			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);
			die($result);
		}

		die("<font color='#00FF00'>".mysqli_fetch_array($result, MYSQLI_ASSOC)["ans"]."</font>");
	}

}
else
{
	echo 'Welcome to VietNam, Server dang bao tri';
}
