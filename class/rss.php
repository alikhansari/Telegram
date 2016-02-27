<?php //require_once('download.php');
function get_feed($feed_url,$count) {
     
    $content = download_url($feed_url);
	
		$doc = new DOMDocument();
		 @$doc->loadHTML('<?xml encoding="utf-8" ?>'.$content);//some dontcare errors for HTML tags may happen
		 
		 $xpath = new DOMXpath($doc);
		 $article = $xpath->query('//div[@class="entry"]');
		 	
		 $rssdata = array();echo 'hello1';
		 $i=0;
		 foreach($article as $container)
		 {
			 $i++;
			if ($i>$count)
        		break;
			 //fetch article title
			 $arr = $container->getElementsByTagName("a");
			 foreach($arr as $item) 
			 {
				array_push($rssdata,$item->getAttribute("href"));
				break;//first link is article link so not needs to check all links
			 }
		 }
		 
		

     /*s$i=0;
	 /*$rssdata=array();
    foreach($x->channel->item as $entry) {
		$i++;
		if ($i<=$count)
        {
			
			array_push($rssdata,$entry);
			
		}
		array_reverse($rssdata);
    }*/
    array_reverse($rssdata);
	if(count($rssdata))
		return $rssdata;
		
	return false;
	
}
function getfeed($url,$count){
		$content = download_url($url);
		//var_dump($content);
        //$feed =simplexml_load_file($url);
		$feed=simplexml_load_string(trim($content));
        $feed_array = array();
		$i=0;
        foreach($feed->channel->item as $story){
			$i++;
			if ($i>$count)
        		break;
            

            array_push($feed_array, $story);
        }

        
		array_reverse($feed_array);
		if(count($feed_array))
			return $feed_array;
		
		return false;
}

//iranclash_exclusive crawler!
function get_cat($cat_url,$count) {
     
    $content = download_url($cat_url);
	
		$doc = new DOMDocument();
		 @$doc->loadHTML('<?xml encoding="utf-8" ?>'.$content);//some dontcare errors for HTML tags may happen
		 
		 $xpath = new DOMXpath($doc);
		 $article = $xpath->query('//article[@class="item-list"]');
		 	
		 $rssdata = array();
		 $i=0;
		 foreach($article as $container)
		 {
			 $i++;
			if ($i>$count)
        		break;
			 //fetch article title
			 $arr = $container->getElementsByTagName("a");
			 foreach($arr as $item) 
			 {
				array_push($rssdata,$item->getAttribute("href"));
				break;//first link is article link so not needs to check all links
			 }
		 }
		 
		

   
    array_reverse($rssdata);
	if(count($rssdata))
		return $rssdata;
		
	return false;
	
}

?>