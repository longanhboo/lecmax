<table class="table table-bordered">
	<thead>
    <tr>
        <td colspan="6" class="text-left">1. Thông tin mua hàng:</td>
    </tr>
    </thead>
    <tr>
        <td colspan="2" class="text-left">Họ và tên:</td>
        <td colspan="4" class="text-left"><?php echo $booking['name'];?></td>
    </tr>
    <tr>
        <td colspan="2" class="text-left">Điện thoại:</td>
        <td colspan="4" class="text-left"><?php echo $booking['phone'];?></td>
    </tr>
    <tr>
        <td colspan="2" class="text-left">Địa chỉ:</td>
        <td colspan="4" class="text-left"><?php echo $booking['address'];?></td>
    </tr>
    <tr>
        <td colspan="2" class="text-left">Email:</td>
        <td colspan="4" class="text-left"><?php echo $booking['email'];?></td>
    </tr>
    <tr>
        <td colspan="2" class="text-left">Nội dung:</td>
        <td colspan="4" class="text-left"><?php echo $booking['comments'];?></td>
    </tr>
    <!--<thead>
    <tr>
        <td colspan="7" class="text-left">2. Thông tin xuất hóa đơn:</td>
    </tr>
    </thead>
    <tr>
        <td colspan="2" class="text-left">Tên công ty:</td>
        <td colspan="5" class="text-left"><?php echo $booking['congty'];?></td>
    </tr>
    <tr>
        <td colspan="2" class="text-left">Địa chỉ công ty:</td>
        <td colspan="5" class="text-left"><?php echo $booking['diachi'];?></td>
    </tr>
    <tr>
        <td colspan="2" class="text-left">Mã số thuế:</td>
        <td colspan="5" class="text-left"><?php echo $booking['masothue'];?></td>
    </tr>-->

<thead>
    <tr>
        <td colspan="6" class="text-left">2. Thông tin sản phẩm:</td>
    </tr>
    <tr>
        <td class="text-center">STT</td>
        <td class="text-center">Hình ảnh</td>
        <td class="text-center">Tên sản phẩm</td>
        <td class="text-center">Số lượng</td>
        <td class="text-center">Đơn giá</td>
        <td class="text-center">Thành tiền</td>
    </tr>
</thead>
<?php foreach($shopcart['products'] as $key=>$item){?>
    <tr>
        <td class="text-center"><?php echo $key+1;?></td>
        <td class="text-center"><?php if(!empty($item['image'])) echo '<img width="70" height="auto" src="' . $item['image'] . '" alt="' . $item['name'] . '">';?></td>
        <td class="text-center"><?php echo $item['name'];?></td>
        <td class="text-center"><?php echo $item['quantity'];?></td>
        <td class="text-right"><?php echo $item['price'];?> đ</td>
        <td class="text-right"><?php echo $item['total'];?> đ</td>
    </tr>
<?php }?>
	<thead>
    <tr>
    	<td colspan="5" class="text-right">Tổng cộng:</td>
    	<td class="text-right"><?php echo $shopcart['total'];?> <span style="text-transform:lowercase">đ</span></td>
    </tr>
    </thead>
</table>