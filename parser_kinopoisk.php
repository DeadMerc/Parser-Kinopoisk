<?php
	header('Content-Type: text/html; charset=windows-1251');

	include "Snoopy.class.php";
	$snoopy = new Snoopy;
	$cache = true;
	
	if ( !isset($cache) || !$cache ){
		$snoopy->maxredirs = 2;
		
		//�����������, ����� �� ������
		
		$post_array = array(
			'shop_user[login]' => 'dimmduh',
			'shop_user[pass]' => 'gfhjkm03',
			'shop_user[mem]' => 'on',
			'auth' => 'go',
		);
		
		$snoopy -> agent = "Mozilla/5.0 (Windows; U; Windows NT 6.1; uk; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13 Some plugins";
		
		//���������� ������ ��� �����������
		$snoopy->submit('http://www.kinopoisk.ru/level/30/', $post_array);
		//print $snoopy -> results;
		
		//�������� �������������
		$snoopy -> fetch('http://www.kinopoisk.ru/level/1/film/452899/');
		$result = $snoopy -> results;
		file_put_contents('temp', $result );
	} else {
		$result = file_get_contents('temp');
	}
	
	$parse = array(
		'name' =>         '#<h1 style=\"margin: 0; padding: 0\" class="moviename-big">(.*?)</h1>#si',
		'originalname'=>  '#13px">(.*?)</span>#si',
		'year' =>         '#<a href="/level/10/m_act%5Byear%5D/([0-9]+)/" title="">#si',
		'country_title' =>'#������.*?<a href="/level/10/m_act%5Bcountry%5D/[0-9]+/">(.*?)</a>#si',
		'country_id' =>   '#������.*?<a href="/level/10/m_act%5Bcountry%5D/([0-9]+)/">.*?</a>#si',
		'slogan' =>       '#������</td><td style="color: \#555">(.*?)</td></tr>#si',
		'director' =>     '#��������</td><td>(.*?)</td></tr>#si',
		'script' =>       '#��������</td><td>(.*?)</td></tr>#si',
		'producer' =>     '#��������</td><td>(.*?)</td></tr>#si',
		'operator' =>     '#��������</td><td>(.*?)</td></tr>#si',
		'composer' =>     '#����������</td><td>(.*?)</td></tr>#si',
		'genre' =>        '#����</td><td>(.*?)</td></tr>#si',
		'budget' =>       '#������</td>.*?<a href="/level/85/film/[0-9]+/" title="">(.*?)</a>#si',
		'usa_charges' =>  '#����� � ���</td>.*?<a href="/level/85/film/[0-9]+/" title="">(.*?)</a>#si',
		'world_charges' =>'#����� � ����</td>.*?<a href="/level/85/film/[0-9]+/" title="">(.*?)</a>#si',
		'rus_charges' =>  '#����� � ������</td>.*?<div style="position: relative">(.*?)</div>#si',
		'world_premiere'=>'#�������� \(���\)</td>.*?<a href="/level/80/film/[0-9]+/" title="">(.*?)</a>#si',
		'rus_premiere' => '#�������� \(��\)</td>.*?<a href="/level/8/view/prem/year/[0-9]+/\#[0-9]+">(.*?)</a>#si',
		//'dvd' =>          '#dvd">(.*?)</td></tr>#is',
		//'bluray' =>       '#bluray">(.*?)</td></tr>#is',
		//'MPAA' =>         '#MPAA</td><td class=\"[\S]{1,100}\"><a href=\'[\S]{1,100}\'><img src=\'/[\S]{1,100}\' height=11 alt=\'(.*?)\' border=0#si',
		'time' =>         '#id="runtime">(.*?)</td></tr>#si',
		'description' =>  '#<span class=\"_reachbanner_\">(.*?)</span>#si',
		'imdb' =>         '#IMDB:\s(.*?)</div>#si',
		'kinopoisk' =>    '#text-decoration: none">(.*?)<span#si',
		'kp_votes' =>     '#<span style=\"font:100 14px tahoma, verdana\">(.*?)</span>#si',
	);
 
 
   $new=array();
   foreach($parse as $index => $value){
		preg_match($value,$result,$matches);
		$new[$index] = preg_replace("#<a.+?>(.+?)</a>#is","$1",$matches[1]);
   }
   print_r( $new );
	
?>