
<?php

$username='apikey';
$password='4767199b605749e9bb02e367c1441027030c8204';

$url='localhost/openproject/api/v3/work_packages';


$frl = 'http://apikey:'.$password.'@'.$url;

//$result=file_get_contents($frl);

$result=http_get_req($frl);

$data=json_decode($result);

$list_color = array ("AliceBlue","AntiqueWhite","Aqua","Aquamarine","Azure","Beige","Bisque","Black","BlanchedAlmond","Blue","BlueViolet","Brown","BurlyWood","CadetBlue","Chartreuse","Chocolate","Coral","CornflowerBlue","Cornsilk","Crimson","Cyan","DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen","Darkorange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey","DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite","ForestGreen","Fuchsia","Gainsboro","GhostWhite","Gold","GoldenRod","Gray","Grey","Green","GreenYellow","HoneyDew","HotPink","IndianRed","Indigo","Ivory","Khaki","Lavender","LavenderBlush","LawnGreen","LemonChiffon","LightBlue","LightCoral","LightCyan","LightGoldenRodYellow","LightGray","LightGrey","LightGreen","LightPink","LightSalmon","LightSeaGreen","LightSkyBlue","LightSlateGray","LightSlateGrey","LightSteelBlue","LightYellow","Lime","LimeGreen","Linen","Magenta","Maroon","MediumAquaMarine","MediumBlue","MediumOrchid","MediumPurple","MediumSeaGreen","MediumSlateBlue","MediumSpringGreen","MediumTurquoise","MediumVioletRed","MidnightBlue","MintCream","MistyRose","Moccasin","NavajoWhite","Navy","OldLace","Olive","OliveDrab","Orange","OrangeRed","Orchid","PaleGoldenRod","PaleGreen","PaleTurquoise","PaleVioletRed","PapayaWhip","PeachPuff","Peru","Pink","Plum","PowderBlue","Purple","Red","RosyBrown","RoyalBlue","SaddleBrown","Salmon","SandyBrown","SeaGreen","SeaShell","Sienna","Silver","SkyBlue","SlateBlue","SlateGray","SlateGrey","Snow","SpringGreen","SteelBlue","Tan","Teal","Thistle","Tomato","Turquoise","Violet","Wheat","White","WhiteSmoke","Yellow","YellowGreen");




//print_r($data);
//

$ele=$data->{'_embedded'}->{'elements'};

//var_dump($ele);
$op;


foreach ($ele as $v)
{


	if($v->{'_links'}->{'children'} && !$v->{'parentId'} )
	{
		//$cchild=get_child($v->{'_links'}->{'children'}->{'href'});
		//echo $v->{'_links'}->{'children'}->{'href'};

		foreach ($v->{'_links'}->{'children'} as $w )
		{
			$cchild[]=get_child($w->{'href'});
		}

		$op[] = array( "name" => $v->{'_links'}->{'self'}->{'title'}, "assignee" => $v->{'_links'}->{'assignee'}->{'title'} ,"color"=> get_color($cdata->{'_links'}->{'assignee'}->{'href'}), "children" => $cchild);
	}
	else if(!$v->{'parentId'} )
	{

		$op[] = array( "name" => $v->{'_links'}->{'self'}->{'title'},"assignee" => $v->{'_links'}->{'assignee'}->{'title'}  );
	}

}

$first=array("name"=>"work_packages","children" => $op);


//$first=array("name"=>"work_packages","children" => get_child($frl);






echo (json_encode($first,JSON_PRETTY_PRINT));


$password='4767199b605749e9bb02e367c1441027030c8204';



function get_child($curl)
{


		$ccurl = 'http://apikey:'.$GLOBALS['password'].'@'.'localhost'.$curl;
//
		//$cresult=file_get_contents($ccurl);

		$cresult=http_get_req($ccurl);

		$cdata=json_decode($cresult);

		//var_dump($cdata);




		if($cdata->{'_links'}->{'children'} )
		{
			//var_dump($cdata);
					foreach ($cdata->{'_links'}->{'children'} as $w )
					{

								$data[]				= get_child($w->{'href'});

								// /echo "exec for ".$w->{'href'}."\n";
						//	$GLOBALS['node_id'][]		=		get_node_id($w->{'href'});
							//var_dump($node_id);

					}

		}

		if($cdata->{'_links'}->{'children'}  )
		{
			$fdata = array( "name" => $cdata->{'_links'}->{'self'}->{'title'} ,"assignee" => $cdata->{'_links'}->{'assignee'}->{'title'},
				"color"=> get_color($cdata->{'_links'}->{'assignee'}->{'href'}), "children" => $data );

		}
		else
		{
			$fdata =array( "name" => $cdata->{'_links'}->{'self'}->{'title'} );

		}


		// /var_dump($cchild);
		//var_dump($cdata);
		//die();
		//$GLOBALS['node_id'][]		=		get_node_id($curl);

		return($fdata);

}


function get_color($path)
{
	$path = explode("/", $path);

	//echo end($path);
	if(end($path))
	{
		return ($GLOBALS['list_color'][end($path)]);
	}
	return($GLOBALS['list_color']['0']);
}


function get_assignee_no($url)
{
		$ccurl = 'http://apikey:'.$GLOBALS['password'].'@'.'localhost'.$url;

		$cresult=http_get_req($ccurl);

		$cdata=json_decode($cresult);
		//echo $ccurl;

		return($cdata->{'_links'}->{'assignee'}->{'title'});
}
function get_node_parent_id($url)
{
		$ccurl = 'http://apikey:'.$GLOBALS['password'].'@'.'localhost'.$url;

		$cresult=http_get_req($ccurl);

		$cdata=json_decode($cresult);
		//echo $ccurl;

		return($cdata->{'_links'}->{'parentId'});
}

function get_node_id($url)
{
		$ccurl = 'http://apikey:'.$GLOBALS['password'].'@'.'localhost'.$url;

		$cresult=http_get_req($ccurl);

		$cdata=json_decode($cresult);
		//echo $ccurl;

		//var_dump( $cdata->{'id'});

		return($cdata->{'id'});
}

function get_node_name($url)
{
		$ccurl = 'http://apikey:'.$GLOBALS['password'].'@'.'localhost'.$url;

		$cresult=http_get_req($ccurl);

		$cdata=json_decode($cresult);
		//echo $ccurl;

		return($cdata->{'_links'}->{'self'}->{'title'});
}


function http_get_req($url)
{
	// Get cURL resource
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL =>  $url ,
		    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);
		return($resp);
}

?>
