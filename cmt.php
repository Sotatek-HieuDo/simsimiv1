<?php
#-----------------------------------------------------#

# BOT SIMSIMI REPLY COMMENT
# Author : TrungHi 
# FB.COM/WHITE.HAT.11
# Code share by Blogdongnai.com
#-----------------------------------------------------#
set_time_limit(0);
require ('funcEmo.php');
require ('cnf_data.php');
$iduser = "########"; // ID Người Sử Dụng Simsimi Cmt
$token = "########"; // Token Của Nick simsimi
$getID = json_decode(auto('https://graph.facebook.com/me?access_token='.$token.'&fields=id'),true);
$getStt = json_decode(auto('https://graph.facebook.com/'.$iduser.'/feed?limit=1&access_token='.$token),true);
$log = json_encode(file('log.txt'));
for($i=1;$i<=count($getStt[data]);$i++)
{
	$getcmt = json_decode(auto('https://graph.facebook.com/'.$getStt[data][$i-1][id].'/comments?access_token='.$token.'&limit=1000&fields=id,from,message'),true);
	if(count($getcmt[data]) > 0)
	{
		for($c=1;$c<=count($getcmt[data]);$c++)
		{
			$log_f = explode($getcmt[data][$c-1][id],$log);
			if(count($log_f) > 1)
			{
				echo'Done! ';
			}
			else
			{
				$log_x = $getcmt[data][$c-1][id].'_';
				$log_y = fopen('log.txt','a');
				fwrite($log_y,$log_x);
				fclose($log_y);
				$cmt = trim($getcmt[data][$c-1][message]);
				$a = 'add'; // từ khóa để sim gửi kết bạn
				if(strpos($cmt, $a)===false)
				{
					$str = $getcmt[data][$c-1][from][name];
					$traloi = '#'.str_replace( ' ', '_', $str).': '; // tag
					$result = @mysql_query("SELECT * FROM sim ");
					if ($result) 
					{
						while ($row = @mysql_fetch_array($result)) 
						{
							if ($row['ask'] == $cmt) 
							{
								$traloi .= $row['ans'];
								$ok=1;
							}
						}
						if($ok !=1)
						{
							$traloi .= file_get_contents('http://trunghi-tienich.rhcloud.com/api.php?text='.$cmt);
						}
					}
					if($getcmt[data][$c-1][from][id] !== $getID[id]) 
					{
						auto('https://graph.facebook.com/'.$getStt[data][$i-1][id].'/comments?access_token='.$token.'&message='.urlencode(Emo($traloi)).'&method=post');
					}
				}
				else
				{
					if($getcmt[data][$c-1][from][id] !== $getID[id]) 
					{
						auto('https://graph.facebook.com/me/friends?uid='.$getcmt[data][$c-1][from][id].'&access_token='.$token.'&method=post');
						$str = $getcmt[data][$c-1][from][name];
						$traloi = '#'.str_replace( ' ', '_', $str).': ';
						$traloi .= 'Gửi Lời Mời Kết Bạn Rồi Nha :D';
						auto('https://graph.facebook.com/'.$getStt[data][$i-1][id].'/comments?access_token='.$token.'&message='.urlencode(Emo($traloi)).'&method=post');
					}
				} 
			}

		}
	}
}
function auto($url){
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $url);
$ch = curl_exec($curl);
curl_close($curl);
return $ch;
}