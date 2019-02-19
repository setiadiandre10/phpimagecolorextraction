<?php

function colorextraction($image, $k)
{

$image = imagecreatefromjpeg($image); // imagecreatefromjpeg/png/

$width = imagesx($image);
$height = imagesy($image);
$arraypiksel = array();
$centroid = array();

$jumlah = 0;
$ct = 0;

for ($y = 0; $y < $height; $y++) {
//$array = array() ;
$temp = "";
for ($x = 0; $x < $width; $x++) 
{
    if($x % 100 == 0)
    {
    	$rgb = imagecolorat($image, $x, $y);
	    $r = ($rgb >> 16) & 0xFF;
	    $g = ($rgb >> 8) & 0xFF;
	    $b = $rgb & 0xFF;

	    $arraypiksel[$jumlah][0] = $r;
		$arraypiksel[$jumlah][1] = $g;
		$arraypiksel[$jumlah][2] = $b;
		$jumlah++;
    }

} 


}


$hitung = 0;
while($hitung < $k)
{
	$a = rand(0,sizeof($arraypiksel)-1);
	$statuscek = "true";

	foreach ($centroid as $key=>$value) 
	{
		$jumlaha = $arraypiksel[$key][0] + $arraypiksel[$key][1] + $arraypiksel[$key][2];
		$jumlahkey = $arraypiksel[$a][0] + $arraypiksel[$a][1] + $arraypiksel[$a][2];

		if(abs($jumlaha - $jumlahkey) <= 200)
		{
			$statuscek = "false";
			break;
		}
	}

	if($statuscek == "true")
	{
		$centroid[$hitung][0] = $arraypiksel[$a][0];
		$centroid[$hitung][1] = $arraypiksel[$a][1];
		$centroid[$hitung][2] = $arraypiksel[$a][2];
		$hitung++;
	}

}


$selesai = "false";
$arraypikseldancentroidnya = array();

$centroiddanindeksarraypiksel = array();
$jumlahpengikut = array();

while($selesai == "false")
{
	$centroiddanindeksarraypiksel = array();

	for($a=0; $a<sizeof($arraypiksel); $a++)
	{
		$jarakterkecil = 0;
		$indeksterkecil = 0;

		for($b=0; $b<sizeof($centroid); $b++)
		{
			$jumlah = ($arraypiksel[$a][0]-$centroid[$b][0])*($arraypiksel[$a][0]-$centroid[$b][0]) +
			($arraypiksel[$a][1]-$centroid[$b][1])*($arraypiksel[$a][1]-$centroid[$b][1]) + ($arraypiksel[$a][2]-$centroid[$b][2])*($arraypiksel[$a][2]-$centroid[$b][2]);

			$jarak = sqrt($jumlah);

			if($b == 0)
			{
				$jarakterkecil = $jarak;
				$indeksterkecil = $b;
			}

			else if($jarak < $jarakterkecil)
			{
				$jarakterkecil = $jarak;
				$indeksterkecil = $b;
			}
		}

		
		$centroiddanindeksarraypiksel[$indeksterkecil][] = $a;
		
	}

	//hitungcentroidbaru;
	$centroidlama = array();
	$centroidlama = $centroid;

	foreach ($centroiddanindeksarraypiksel as $key=>$value) {
		$r = 0;
		$g = 0;
		$b = 0;
		$count = 0;
		
		foreach ($value as $v) {
			$r = $r + $arraypiksel[$v][0];
			$g = $g + $arraypiksel[$v][1];
			$b = $b + $arraypiksel[$v][2];
			$count++;
		}



		$centroid[$key][0] = (int)($r/$count);
		$centroid[$key][1] = (int)($g/$count);
		$centroid[$key][2] = (int)($b/$count);
		$jumlahpengikut[$key] = $count;
	}

	if($centroid == $centroidlama)
	{	
		
		$selesai = "true";
		break;
	}

}



$color = array();

foreach ($jumlahpengikut as $key => $value) {
$a = $key;


$temp = sprintf("#%02x%02x%02x", $centroid[$key][0], $centroid[$key][1], $centroid[$key][2]);
$color[] = sprintf("#%02x%02x%02x", $centroid[$key][0], $centroid[$key][1], $centroid[$key][2]);


echo '<div style="background-color: '.$temp.'; width: 100px; height: 100px;"></div>';

}

//echo '<br>';

return $color;


}
?>
