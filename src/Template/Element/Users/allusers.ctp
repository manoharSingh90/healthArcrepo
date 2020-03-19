<?php
if(isset($allUsers) && !empty($allUsers)) {
foreach($allUsers as $key => $value) {
?>
<tr class="trClass" id="tr_<?php echo $value["hospital_user_id"]; ?>">
	<td><?php echo $value["fname"]." ".$value["lname"]; ?></td>
	<td><?php echo $value["email"]; ?></td>
	<td><?php echo $value["phone_code"]."-".$value["phone"]; ?></td>
	<td><?php echo isset($value["rolemaster"]["role_name"]) ? $value["rolemaster"]["role_name"] : ""; ?></td>
	<td><?php echo isset($value["hospitallocation"]["city"]) ? $value["hospitallocation"]["location_name"].", ".$value["hospitallocation"]["city"] : ""; ?></td>
	<td>
		<a href="javaScript:void(0)" id="<?php echo $value["hospital_user_id"]; ?>" class="mx-1 edit"><img src="<?php echo IMAGE_PATH."edit-icn.png"; ?>" alt="edit-icn"></a>
		<a href="javaScript:void(0)" id="<?php echo $value["hospital_user_id"]; ?>" class="mx-1 deletePopup" data-toggle="modal" data-target="#myModal"><img src="<?php echo IMAGE_PATH."delete-icn.png"; ?>" alt="delete-icn"></a>
	</td>
</tr>

<?php } }
else { ?>
<tr>
	<td>No Data Found</td>
</tr>
<?php } ?>