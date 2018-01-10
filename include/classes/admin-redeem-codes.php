<?php

class paginate
{
	private $db;
	
	public function __construct()
	{
		global $host, $user, $password;
		$database = new Database();
		$db = $database->dbConnection("", "", "", "", "yes");
		$this->db = $db;
    }
	
	public function dataview($query, $md, $jd, $item, $delete)
	{
		global $site_url;
		
		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$rowCount = count($stmt->fetchAll());
		
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		
		$number=0;
		if(isset($_GET["page_no"]))
		{
			if(is_numeric($_GET["page_no"]))
			{
				if($_GET["page_no"]>1)
					$number = ($_GET["page_no"]-1)*10;
			}
		}
		if($rowCount>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{	$number++;
				
				?>
			<tr>
				<th scope="row"><?php print $number; ?></th>
				<td><?php print $row['code']; ?></td>
				<td><?php if($row['type']==1) print $md; else if($row['type']==2) print $jd; else print $item; ?></td>
				<td><?php print $row['value']; ?></td>
				<td><form action="" method="POST"><input type="hidden" name="id" value="<?php print $row['id']; ?>"><button type="submit" name="delete" class="btn btn-danger btn-sm"><?php print $delete; ?></button></form></td>
			</tr>
                <?php
			}
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
		
	}
	
	public function paging($query,$records_per_page)
	{
		$starting_position=0;
		if(isset($_GET["page_no"]))
		{
			if(is_numeric($_GET["page_no"]))
				if($_GET["page_no"]>1)
					$starting_position=($_GET["page_no"]-1)*$records_per_page;
		}
		$query2=$query." limit $starting_position,$records_per_page";
		return $query2;
	}
	
	public function paginglink($query,$records_per_page,$first,$last,$self)
	{		
		$self = $self.'admin/redeem/';
		
		$sql = "SELECT count(*) ".strstr($query, 'FROM');
		
		$stmt = $this->db->prepare($sql);
		$stmt->execute(); 
		
		$total_no_of_records = $stmt->fetchColumn();
		
		if($total_no_of_records > 0)
		{
			?><div class='wp-pagenavi'><?php
			$total_no_of_pages=ceil($total_no_of_records/$records_per_page);
			$current_page=1;

			if(isset($_GET["page_no"]))
			{
				if(is_numeric($_GET["page_no"]))
				{
					$current_page=$_GET["page_no"];
					
					if($_GET["page_no"]<1)
						print "<script>top.location='".$self."'</script>";
					else if($_GET["page_no"]>$total_no_of_pages)
						print "<script>top.location='".$self."'</script>";
				}
			}
			
			if($current_page!=1)
			{
				$previous = $current_page-1;
				print "<a class='last' href='".$self."1'>".$first."</a>&nbsp;&nbsp;";
				print "<a class='page larger' href='".$self.$previous."'>&laquo;</a>&nbsp;&nbsp;";
			}
			
			$x=$current_page;

			if($current_page+3>$total_no_of_pages)
				if($total_no_of_pages-3>0)
					$x=$total_no_of_pages-3;
				else if($total_no_of_pages-2>0)
					$x=$total_no_of_pages-2;
				else if($total_no_of_pages-1>0)
					$x=$total_no_of_pages-1;
			
			for($i=$x;$i<=$x+3;$i++)
				if($i==$current_page)
					print "<a class='current' href='".$self.$i."' style='color:red;text-decoration:none'>".$i."</a>&nbsp;&nbsp;";
				else if($i>$total_no_of_pages)
					break;
				else
					print "<a class='page larger' href='".$self.$i."'>".$i."</a>&nbsp;&nbsp;";
			
			if($current_page!=$total_no_of_pages)
			{
				$next=$current_page+1;
				print "<a class='nextpostslink' href='".$self.$next."'>&raquo;</a>&nbsp;&nbsp;";
				//print "<a class='last' href='".$self.$total_no_of_pages."'>".$last."</a>&nbsp;&nbsp;";
			}
			?></div><?php
		}
	}
}