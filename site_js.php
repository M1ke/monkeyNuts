<?php
$jquery='1.7';
echo '<script src="http://ajax.googleapis.com/ajax/libs/jquery/'.$jquery.'/jquery.min.js"></script>';
echo '<script>!window.jQuery && document.write(\'<script src="scripts/jquery/jquery-'.$jquery.'.min.js"><\/script>\')</script>';
unset($jquery);
// echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>';

// include '_js_facebook.php';

echo '<script type="text/javascript" src="'.$s['core-abs'].'scripts/gadabouting.js"></script>';

// we define jquery plugins that could be needed by the main site JS file
// in the form array('script-name'=>true) (some scripts will be .min)
if ($s['tinymce'])
{
	$l['mceplugins']='safari,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template';
?>
<script type="text/javascript" src="<?php echo $s['core-abs']?>scripts/jquery/tinymce.js"></script>
<script type="text/javascript">
function tinyBrowser(field_name,url,type,win)
{
	var cmsURL='<?php echo $s['core-abs']?>scripts/tinybrowser/tinybrowser.php';
	if (cmsURL.indexOf('?')<0) cmsURL=cmsURL+'?type='+type;
	else cmsURL=cmsURL+'&type='+type;
	tinyMCE.activeEditor.windowManager.open({file:cmsURL,title:'Tiny Browser',width:770,height:480,resizable:'yes',scrollbars:'yes',inline:'yes',close_previous:'no'},{window:win,input:field_name});
	return false;
}
$.fn.makeTinyMce=function(){this.tinymce({
	script_url:'<?php echo $s['core-abs']?>scripts/tinymce/tiny_mce.js',
	disk_cache:true,
	debug:false,
	relative_urls:true,
	remove_script_host:false,
	document_base_url:'<?php echo $l['url']?>',
	plugins:'<?php echo $l['mceplugins']?>',
	mode:'exact',
	theme:'advanced',
	skin:'default',
	theme_advanced_buttons1: 'bold,italic,formatselect,|,bullist,numlist,outdent,indent,blockquote,|,justifyleft,justifycenter,justifyright,justifyfull,|,pastetext,pasteword,selectall,|,link,unlink,image,media,|,pagebreak,charmap,code',
	theme_advanced_buttons2:'',
	theme_advanced_buttons3:'',
	theme_advanced_toolbar_location:'top',
	theme_advanced_toolbar_align:'left',
	theme_advanced_statusbar_location:'bottom',
	theme_advanced_resizing:true,
	theme_advanced_resize_horizontal:false,
	theme_advanced_blockformats:'p,h2,h3,h4,h5',
	file_browser_callback:'tinyBrowser',
	content_css:'<?php echo $s['dir'].'themes/css.css?tinymce'?>',
	paste_remove_spans:true,
	paste_remove_styles:true,
	paste_strip_class_attributes:'mso',
	paste_auto_cleanup_on_paste:true,
	paste_convert_middot_lists:true
});
return this;};
<?php 
if ($s['tinymce']<2) echo '$(document).ready(function(){$("textarea.tinymce").makeTinyMce();});'?>
</script>
<?php
}
if (is_array($s['js'])) foreach ($s['js'] as $key => $script)
{
	// each script will have jquery dependencies - we add those here
	if ($script===true) $script=$key;
	switch ($script)
	{
		
	}
	$js['scripts'].='<script type="text/javascript" src="'.$s['core-abs'].'scripts/'.$script.'.js"></script>';
	if (file_exists($s['site'].'themes/'.$l['theme']['name'].'/'.$script.'.js')) $js['scripts'].='<script type="text/javascript" src="themes/'.$l['theme'].'/'.$script.'.js"></script>';
	unset($s['js'][$key]);
}
else $s['js']=array();
if (is_array($s['jq'])) foreach ($s['jq'] as $script => $val)
{
	echo '<script type="text/javascript" src="'.$s['core-abs'].'scripts/jquery/'.$script.'.js"></script>';
}
if (count($s['js'])>0) foreach ($s['js'] as $key => $script)
{
	// second round of scripts, if called by another script the dependency must already have been called
	if ($script===true) $script=$key;
	$js['scripts'].='<script type="text/javascript" src="'.$s['core-abs'].'scripts/'.$script.'.js"></script>';
}
echo $js['scripts'];
?>