 <?php
 echo "123";
  $url = $_GET['url'];
  //获取视频url
  $url = get_redirect_url($url);
  //获取视频ID
  $str = dirname($url);
  $id = substr($str,strripos($str,'video')+6);
  //调用抖音官方API
  $str = file_get_contents('https://www.douyin.com/web/api/v2/aweme/iteminfo/?item_ids='.$id);
 //将返回的json数据转为数组
 $data = json_decode($str,true);
 //获取有水印的视频地址
 $url = $data['item_list'][0]['video']['play_addr']['url_list'][0];
 //将playvm替换为play，从而获取无水印的视频地址
 $url = str_replace('playwm','play',$url);
 //获取重定向后的真实地址
 $video_url = get_redirect_url($url);
 echo $video_url;
 
 function get_redirect_url($url) {
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
 'Accept: */*',
 'Accept-Encoding: gzip',
 'Connection: Keep-Alive',
 'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)'
 ));
 curl_setopt($ch, CURLOPT_HEADER, true);
 curl_setopt($ch, CURLOPT_NOBODY, 1);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 $ret = curl_exec($ch);
 curl_close($ch);
 preg_match("/Location: (.*?)/r/n/iU",$ret,$location);
 return $location[1];
 }
