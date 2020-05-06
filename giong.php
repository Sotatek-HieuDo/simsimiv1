<?php
error_reporting(0); //Dòng này để hạn chế hiện các lỗi tránh sai cấu trúc file mp3 dẫn đến ko thể load

//Dùng header để báo trình duyệt biết đây là file mp3, không phải là text
header('Content-Disposition: inline; filename="sieuleech.mp3"');
header('Pragma: no-cache');
header('Content-type: audio/mpeg');

//Get biến Text từ url mã hóa qua dạng url tránh lỗi khi dùng dấu tiếng Việt hoặc có các ký tự đặc biệt
$text = urlencode($_GET['text']);

// Curl đền trang của thằng responsivevoice
$c = curl_init("http://code.responsivevoice.org/getvoice.php?t=$text&tl=vi&sv=&vn=&pitch=0.5&rate=0.5&vol=1");
curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);
echo $page; // In nội dung file mp3 ra thôi


//bạn có thể thay đổi các tùy chọn sau
//tl ngôn ngữ
//pitch âm điệu
//rate tốc độ đọc
?>