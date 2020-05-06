<?php
#-----------------------------------------------------#
# BOT SIMSIMI REPLY INbox
# Author : TrungHI
# Date: 11/09/2016
# FB.COM/WHITE.HAT.11
# Vui Lòng Kính Trọng Người Làm Ra Nó. Không Nên Xóa Dòng Này
#-----------------------------------------------------#
set_time_limit(0);
require ('funcEmo.php');
require ('cnf_data.php');
$token   = "########"; // Token fanpage => Cách lấy trong file hướng dẫn...
$getID   = json_decode(auto('https://graph.facebook.com/me?access_token=' . $token . '&fields=id'), true);
$getpage = json_decode(auto('https://graph.facebook.com/' . $getID[id] . '/conversations?fields=participants,unread_count&access_token=' . $token), true);
for ($i = 0; $i < count($getpage[data]); $i++) {
                if ($getpage[data][$i][unread_count] > 0) {
                                //echo $getpage[data][$i][id];
                                $getms  = json_decode(auto('https://graph.facebook.com/' . $getpage[data][$i][id] . '?fields=messages,message_count&access_token=' . $token), true);
                                $getnd  = json_decode(auto('https://graph.facebook.com/' . $getms[messages][data][0][id] . '?fields=message,from&access_token=' . $token), true);
                                //echo  $getnd[message];
                                //echo $getnd[from][name];
                                //echo $getnd[from][id];
                                $cmt    = $getnd[message];
                                $result = @mysql_query("SELECT * FROM sim ");
                                if ($result) {
                                                while ($row = @mysql_fetch_array($result)) {
                                                                if ($row['ask'] == $cmt) {
                                                                                $traloi .= $row['ans'];
                                                                                $ok = 1;
                                                                }
                                                }
                                                if ($ok != 1) {
                                                                $traloi .= file_get_contents('http://trunghi-tienich.rhcloud.com/api.php?text=' . $cmt);
                                                }
                                }
                                if ($getnd[from][id] !== $getID[id]) {
                                                auto('https://graph.fb.me/' . $getnd[from][id] . '/inbox?access_token=' . $token . '&message=' . urlencode(($traloi)) . '&method=post&subject=+'); // Nếu ko muốn dùng biểu tượng thì xoá hàm  Emo() phía trên đi nhá
                                }
                }
}
function auto($url)
{
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_URL, $url);
                $ch = curl_exec($curl);
                curl_close($curl);
                return $ch;
}

