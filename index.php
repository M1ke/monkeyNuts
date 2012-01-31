<?php
if (!function_exists('json_decode')){
function json_decode($json,$array=true)
{
    $comment=false;
    $out='$x=';
    for ($n=0;$n<strlen($json);$n++)
    {
        if (!$comment)
        {
            if ($json[$n]=='{' or $json[$n]=='[') $out.=' array(';
            else if ($json[$n]=='}' or $json[$n]==']') $out.=')';
            else if ($json[$n]==':') $out.='=>';
            else $out.=$json[$n];
        }
        else $out.=$json[$n];
        if ($json[$n]=='"') $comment=!$comment;
    }
    eval($out.';');
    return $x;
}}

$twitter_url='http://search.twitter.com/search.json';
$json=file_get_contents($twitter_url.'?q=from:@ben_nuttall%20wisemonkeyash'.(isset($_GET['page'])?'&page='.$_GET['page']:''));
$json=json_decode($json,true);
$tweets=$json['results'];
foreach ($tweets as $tweet)
{
	$tweet['created_at']=strtotime($tweet['created_at']);
	$tweet['created_at']=date('g:ia',$tweet['created_at']).' on '.date('l jS M',$tweet['created_at']);
	$tweet['text']=preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>',$tweet['text']);
	$html['tweet']='<h1>from '.$tweet['from_user_name'].' at <a href="http://twitter.com/'.$tweet['from_user'].'/status/'.$tweet['id_str'].'" target="_blank" rel="external">'.$tweet['created_at'].'</a></h1>';
	$html['tweet'].='<p>'.$tweet['text'].'</p>';
	$html['tweets'].='<article>'.$html['tweet'].'</article>';
}

if (isset($json['next_page'])) $html['nav']='<li><a href="?page='.($json['page']+1).'">Older</a></li>';
if (isset($json['previous_page'])) $html['nav'].='<li class="new"><a href="?page='.($json['page']-1).'">Newer</a></li>';
if (!empty($html['nav'])) $html['nav']='<nav role="pagination"><ul>'.$html['nav'].'</ul></nav>';

$html['tweets']='<section class="tweets">'.$html['tweets'].$html['nav'].'</section>';

$html=$html['tweets'];

$s['page']='home';

include 'site_top.php';
echo $html;
include 'site_bottom.php'?>