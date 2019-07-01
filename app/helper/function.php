<?php

function show_error($errors,$name)
{
    if($errors->has($name)){

        echo '  <p class="text-danger">'.$errors->first($name) .'</p>';
    }
}

function GetCategory($mang,$parent,$shift,$select)
{
	foreach($mang as $value)
		{
			if($value->parent==$parent)
			{
				if($value->id==$select)
				{
					//hiển thị thẻ tương ứng nếu id danh mục = id chọn
					echo "<option selected value='$value->id'>".$shift.$value->name."</option>";
				}
				else
				{
					echo "<option value='$value->id'>".$shift.$value->name."</option>";
				}
				GetCategory($mang,$value->id,$shift.'---|',$select);
			}
		}
}

function ShowCategory($mang,$parent,$shift)
{
	foreach($mang as $row)
	{
		if($row->parent==$parent)
		{

            echo"
                <div class='item-menu'><span>".$shift.$row->name."</span>
                <div class='category-fix'>
                <a class='btn-category btn-primary' href='/admin/category/edit/".$row->id."'><i class='fa fa-edit'></i></a>
                <a onclick='return del_cate(\"$row->name\")' class='btn-category btn-danger' href='/admin/category/del/".$row->id."'><i class='fas fa-times'></i></a>
                </div>
                </div>";
			ShowCategory($mang,$row->id,$shift.'---|');
		}
	}
}

function get($mang){

    $results = array();
foreach($mang as $value){
    $attr = $value->attribute->name;
    $results[$attr][] = $value->value;



}
return $results;
}
function get_cbn($array){
	$result = array(array());
	foreach ($array as $property => $property_values) {
		$tmp = array();
		foreach ($result as $result_item) {
			foreach ($property_values as $property_value ) {
				$tmp[] = array_merge($result_item,array($property =>$property_value));
			}
		}
		$result = $tmp;
	}
	return $result;
}
function check_value($product,$check){

    foreach ($product->values as $value) {
        if($value->id==$check){
            return true;

        }
    }
    return  false;
}
function check_variant($product,$array){
    foreach ($product->variant as  $row) {
        $mang =  array();
        foreach ($row->values as $value) {
            $mang[] = $value->id;

        }
        if(array_diff($array,$mang)==NULL){
            return false;

        }
    }
    return true;

}

 ?>
