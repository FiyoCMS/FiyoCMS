<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = @new FQuery() or die;  
$sql = $db->select(FDBPrefix.'theme_layout','*',"id=$_REQUEST[id]"); 
$row = $sql[0];
?>

<form method="post">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo Layout_Edit; ?></div>
			<div class="app_link">
				<button type="submit" class="btn btn-success" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="apply_layout"><i class="icon-check"></i> <?php echo Save; ?></button>	
				<button type="submit" class="btn btn-metis-2 " title="<?php echo Save_and_Quit; ?>" name="edit_layout"><i class="icon-check-circle"></i> <?php echo Save_and_Quit; ?></button>				
				<a class="danger btn btn-default" href="?app=theme&view=layout" title="<?php echo Cancel; ?>"><i class="icon-remove-sign"></i> <?php echo Cancel; ?></a>
				<?php printAlert(); ?>
			</div>			
		</div>
	</div>	   	
	<div class="panel box"> 		
		<header>
			<h5>Umum</h5>
		</header>
		<div>
			<table>
				<tr>
					<td class="row-title"><?php echo Name; ?></td>
					<td><input type="hidden" name="id" value="<?php  echo $row['id'] ?>">
					<input type="text" name="name" size="30" <?php formRefill('name',$row['name']); ?> required></td>
				</tr>
				<tr>
					<td class="row-title"><?php echo Description; ?></td>
					<td><textarea name="desc" rows="4" cols="50"><?php formRefill('desc',$row['desc'],'textarea'); ?></textarea></td>
				</tr>
                                <tr>
                                    <td><?php echo Theme;?></td>
                                    <td><select name="theme">
                                        <?php
                                        $no = 0;
                                        $dir=opendir("../themes");  
                                        $thm = $act = '';
                                        while($folder=readdir($dir)){ 
                                                if($folder=="." or $folder=="..")continue; 
                                                if(is_dir("../themes/$folder") AND file_exists("../themes/$folder/index.php"))
                                                {				
                                                        $no++;
                                                        $theme_image = '';
                                                        $spot_file = "../themes/$folder/theme_details.php";
                                                        if(file_exists($spot_file)) 
                                                                include("$spot_file");
                                                        else {
                                                                $theme_version = "Error :: File <b>theme_details.php</b> not found in <b>$folder</b> ";
                                                                $theme_name =  $folder;
                                                        }
                                                        $active = '';
                                                        $selected = '';

                                                        $c = siteConfig('site_theme');
                                                        $ac = Activate;
                                                        if($c == $folder) { $active = "(".in_used.")"; }
                                                        if($row['theme'] == $folder) { $selected = "selected";}

                                                        $isi = "<option value='$folder' $selected>$theme_name $active</option>";
                                                        if($c == $folder)
                                                        $act = $isi;
                                                        else 
                                                        $thm .= $isi;

                                                }
                                        }
                                        echo $act.$thm;
                                                closedir($dir); 
                                                ?>	
                                        </select>
                                    </td>
                                </tr>
			</table>
		</div> 
    </div> 
</form>	

